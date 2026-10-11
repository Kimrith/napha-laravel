@extends('layouts.app')

@section('title', 'Attendance Tracking | EduPulse Pro Portal')

@section('content')
<div x-data="attendanceManager()" class="space-y-6">

    <!-- ======================= MODULAR PARTIALS ======================= -->
    {{-- Breadcrumbs, Title, and Action Controls --}}
    @include('attendance.partials.header')

    {{-- Rate, Check-In Time, and Absence Alerts --}}
    @include('attendance.partials.metrics')

    {{-- Interactive Roster Table and Status Toggles --}}
    @include('attendance.partials.table')

    {{-- Roll-call Submission Confirmation Modal --}}
    @include('attendance.partials.modals')

</div>
@endsection

@push('scripts')
<script>
    function attendanceManager() {
        return {
            selectedDate: '{{ $selectedDate }}',
            selectedClassId: '{{ $selectedClassId ?? 'All' }}',
            selectedCourseId: '{{ $selectedCourseId ?? 'All' }}',
            selectedStatus: '{{ $selectedStatus }}',
            searchQuery: '',
            confirmModalOpen: false,
            logModalOpen: false,
            isSubmitting: false,

            attendees: @json($attendees ?? []),
            courses: @json($courses ?? []),
            classes: @json($classes ?? []),

            get filteredAttendees() {
                if (!this.searchQuery.trim()) {
                    return this.attendees;
                }
                const q = this.searchQuery.toLowerCase();
                return this.attendees.filter(a => 
                    (a.name && a.name.toLowerCase().includes(q)) ||
                    (a.id && a.id.toLowerCase().includes(q)) ||
                    (a.major && a.major.toLowerCase().includes(q)) ||
                    (a.class_code && a.class_code.toLowerCase().includes(q)) ||
                    (a.class_name && a.class_name.toLowerCase().includes(q)) ||
                    (a.room_number && a.room_number.toLowerCase().includes(q)) ||
                    (a.subject && a.subject.toLowerCase().includes(q))
                );
            },

            get counts() {
                return {
                    present: this.attendees.filter(a => a.status === 'Present').length,
                    late: this.attendees.filter(a => a.status === 'Late').length,
                    excused: this.attendees.filter(a => a.status === 'Excused').length,
                    absent: this.attendees.filter(a => a.status === 'Absent').length
                };
            },

            get attendanceRate() {
                const total = this.attendees.length;
                if (!total) return 0;
                const attended = this.counts.present + this.counts.late;
                return Math.round((attended / total) * 1000) / 10;
            },

            applyFilters() {
                const params = new URLSearchParams();
                if (this.selectedDate) params.set('date', this.selectedDate);
                if (this.selectedClassId && this.selectedClassId !== 'All') params.set('class_id', this.selectedClassId);
                if (this.selectedCourseId && this.selectedCourseId !== 'All') params.set('course_id', this.selectedCourseId);
                if (this.selectedStatus && this.selectedStatus !== 'All') params.set('status', this.selectedStatus);
                window.location.href = `{{ route('attendance.index') }}?` + params.toString();
            },

            async toggleStatus(attendee) {
                const order = ['Present', 'Late', 'Excused', 'Absent'];
                const nextIdx = (order.indexOf(attendee.status) + 1) % order.length;
                const nextStatus = order[nextIdx];
                
                try {
                    const response = await fetch("{{ route('attendance.toggle-status') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            student_id: attendee.student_db_id,
                            date: this.selectedDate,
                            status: nextStatus
                        })
                    });
                    const result = await response.json();
                    if (response.ok && result.success) {
                        attendee.status = result.data.status;
                        attendee.timeIn = result.data.timeIn;
                        attendee.record_id = result.data.record_id;
                        if (typeof showToast === 'function') {
                            showToast(result.message || `Updated attendance for ${attendee.name} to ${attendee.status}`, 'info');
                        }
                    } else {
                        if (typeof showToast === 'function') {
                            showToast(result.message || 'Error updating status', 'error');
                        }
                    }
                } catch (err) {
                    console.error(err);
                    if (typeof showToast === 'function') {
                        showToast('Network error while updating attendance', 'error');
                    }
                }
            },

            async initializeSession() {
                this.isSubmitting = true;
                try {
                    const response = await fetch("{{ route('attendance.initialize-session') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            date: this.selectedDate,
                            class_id: this.selectedClassId,
                            course_id: this.selectedCourseId
                        })
                    });
                    const result = await response.json();
                    if (response.ok && result.success) {
                        if (typeof showToast === 'function') {
                            showToast(result.message, 'success');
                        }
                        setTimeout(() => window.location.reload(), 500);
                    } else {
                        if (typeof showToast === 'function') {
                            showToast(result.message || 'Error initializing session', 'error');
                        }
                    }
                } catch (err) {
                    console.error(err);
                } finally {
                    this.isSubmitting = false;
                }
            },

            confirmFinalize() {
                this.confirmModalOpen = true;
            },

            async submitFinalized() {
                this.isSubmitting = true;
                try {
                    const response = await fetch("{{ route('attendance.finalize') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            date: this.selectedDate,
                            class_id: this.selectedClassId,
                            course_id: this.selectedCourseId,
                            attendees: this.attendees
                        })
                    });
                    const result = await response.json();
                    this.confirmModalOpen = false;
                    if (response.ok && result.success) {
                        if (typeof showToast === 'function') {
                            showToast(result.message || 'Roll-call finalized and forwarded to registrar.', 'success');
                        }
                    } else {
                        if (typeof showToast === 'function') {
                            showToast(result.message || 'Error finalizing roll-call', 'error');
                        }
                    }
                } catch (err) {
                    console.error(err);
                    this.confirmModalOpen = false;
                    if (typeof showToast === 'function') {
                        showToast('Network error while finalizing', 'error');
                    }
                } finally {
                    this.isSubmitting = false;
                }
            },

            async deleteRecord(attendee) {
                if (!confirm(`Are you sure you want to remove attendance log for ${attendee.name}?`)) return;
                try {
                    const response = await fetch(`/attendance/${attendee.record_id}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    const result = await response.json();
                    if (response.ok && result.success) {
                        this.attendees = this.attendees.filter(a => a.record_id !== attendee.record_id);
                        if (typeof showToast === 'function') {
                            showToast(result.message, 'success');
                        }
                    } else {
                        if (typeof showToast === 'function') {
                            showToast(result.message || 'Failed to remove record', 'error');
                        }
                    }
                } catch (err) {
                    console.error(err);
                }
            },

            exportLog() {
                const params = new URLSearchParams();
                if (this.selectedDate) params.set('date', this.selectedDate);
                if (this.selectedClassId && this.selectedClassId !== 'All') params.set('class_id', this.selectedClassId);
                if (this.selectedCourseId && this.selectedCourseId !== 'All') params.set('course_id', this.selectedCourseId);
                window.location.href = `{{ route('attendance.export') }}?` + params.toString();
            }
        };
    }
</script>
@endpush
