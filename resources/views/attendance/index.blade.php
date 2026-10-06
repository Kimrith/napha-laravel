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
            selectedDate: '2026-10-06',
            selectedLecture: 'CS-101 (Programming)',
            confirmModalOpen: false,

            attendees: @json($attendees ?? null) || [
                { id: 'STU-2026-001', name: 'Alexander Wright', major: 'Computer Science', timeIn: '08:54 AM', status: 'Present' },
                { id: 'STU-2026-002', name: 'Amara Okafor', major: 'Data Science & AI', timeIn: '08:58 AM', status: 'Present' },
                { id: 'STU-2026-003', name: 'Clara Lindqvist', major: 'Digital Design', timeIn: '09:05 AM', status: 'Late' },
                { id: 'STU-2026-004', name: 'Marcus Chen', major: 'Robotics & Automation', timeIn: '--:--', status: 'Excused' },
                { id: 'STU-2026-005', name: 'Sophia Martinez', major: 'Biotechnology', timeIn: '08:50 AM', status: 'Present' },
                { id: 'STU-2026-006', name: 'Liam Davies', major: 'International Finance', timeIn: '08:59 AM', status: 'Present' },
                { id: 'STU-2026-007', name: 'Fatima Al-Zahra', major: 'Cybersecurity', timeIn: '08:48 AM', status: 'Present' },
                { id: 'STU-2026-008', name: 'Ethan Taylor', major: 'Media Communications', timeIn: '--:--', status: 'Absent' }
            ],

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

            toggleStatus(attendee) {
                const order = ['Present', 'Late', 'Excused', 'Absent'];
                const nextIdx = (order.indexOf(attendee.status) + 1) % order.length;
                attendee.status = order[nextIdx];
                if (typeof showToast === 'function') {
                    showToast(`Updated attendance for ${attendee.name} to ${attendee.status}`, 'info');
                }
            },

            confirmFinalize() {
                this.confirmModalOpen = true;
            },

            submitFinalized() {
                this.confirmModalOpen = false;
                if (typeof showToast === 'function') {
                    showToast('Roll-call finalized and forwarded to registrar.', 'success');
                }
            },

            exportLog() {
                const header = ['Student ID', 'Student Name', 'Academic Major', 'Check-In Time', 'Status'];
                const rows = this.attendees.map(a => [`"${a.id}"`, `"${a.name}"`, `"${a.major}"`, `"${a.timeIn}"`, `"${a.status}"`]);
                const csvContent = 'data:text/csv;charset=utf-8,' + [header.join(','), ...rows.map(e => e.join(','))].join('\n');
                const link = document.createElement('a');
                link.setAttribute('href', encodeURI(csvContent));
                link.setAttribute('download', `attendance_${this.selectedDate}.csv`);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                if (typeof showToast === 'function') {
                    showToast('Attendance report exported to CSV.', 'success');
                }
            }
        };
    }
</script>
@endpush
