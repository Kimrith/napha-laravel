@extends('layouts.app')

@section('title', 'Active Courses | EduPulse Pro Portal')

@section('content')
<div x-data="courseDirectory()" class="space-y-6">

    <!-- ======================= BREADCRUMBS ======================= -->
    <nav class="flex items-center text-xs font-medium text-slate-500 gap-2">
        <a href="{{ route('dashboard') }}" class="hover:text-slate-900 transition-colors flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Dashboard</span>
        </a>
        <svg class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-brand-600 font-semibold bg-brand-50 px-2 py-0.5 rounded-md border border-brand-100">
            Active Courses
        </span>
    </nav>

    <!-- ======================= MODULAR PARTIALS ======================= -->
    {{-- Search, Filters, Stats Counter, and Action Buttons --}}
    @include('courses.partials.filter')

    {{-- Interactive Data Table, Loops, Rows, and Pagination --}}
    @include('courses.partials.table')

    {{-- Create, Edit, and Delete Modals --}}
    @include('courses.partials.modals')

</div>
@endsection

@push('scripts')
<script>
    function courseDirectory() {
        return {
            // Initial Course Records & Departments from controller
            courses: @json($courses ?? []),
            departments: @json($departments ?? []),

            // Search and filter state
            searchQuery: '{{ $appliedFilters['search'] ?? '' }}',
            selectedDepartment: '{{ $appliedFilters['department'] ?? 'All' }}',
            selectedStatus: '{{ $appliedFilters['status'] ?? 'All' }}',

            // Pagination state
            currentPage: 1,
            perPage: 6,

            // Modal dialog visibility states
            addModalOpen: false,
            editModalOpen: false,
            deleteModalOpen: false,

            // Selected items for modal operations
            editCourseForm: {},
            courseToDelete: null,

            // New course template
            newCourse: {
                code: '',
                name: '',
                dept: 'School of Computing & Informatics',
                instructor: '',
                credits: 4,
                enrolled: 0,
                capacity: 60,
                days: 'Mon, Wed 10:00 - 12:00 PM',
                room: 'Hall Alpha-1',
                status: 'Active'
            },

            // Filtered courses getter
            get filteredCourses() {
                return this.courses.filter(c => {
                    const query = this.searchQuery.toLowerCase().trim();
                    const matchesQuery = query === '' || 
                        (c.code && c.code.toLowerCase().includes(query)) || 
                        (c.name && c.name.toLowerCase().includes(query)) ||
                        (c.instructor && c.instructor.toLowerCase().includes(query)) ||
                        (c.room && c.room.toLowerCase().includes(query));

                    const matchesDept = this.selectedDepartment === 'All' || c.dept === this.selectedDepartment;
                    const matchesStatus = this.selectedStatus === 'All' || c.status === this.selectedStatus;
                    return matchesQuery && matchesDept && matchesStatus;
                });
            },

            // Pagination getters
            get totalPages() {
                return Math.max(1, Math.ceil(this.filteredCourses.length / this.perPage));
            },

            get paginatedCourses() {
                if (this.currentPage > this.totalPages) {
                    this.currentPage = this.totalPages;
                }
                const start = (this.currentPage - 1) * this.perPage;
                return this.filteredCourses.slice(start, start + this.perPage);
            },

            get visiblePageNumbers() {
                const total = this.totalPages;
                const current = this.currentPage;
                if (total <= 7) {
                    return Array.from({ length: total }, (_, i) => i + 1);
                }
                const pages = [1];
                if (current > 3) pages.push('...');
                const start = Math.max(2, current - 1);
                const end = Math.min(total - 1, current + 1);
                for (let i = start; i <= end; i++) pages.push(i);
                if (current < total - 2) pages.push('...');
                pages.push(total);
                return pages;
            },

            goToPage(p) {
                if (typeof p === 'number' && p >= 1 && p <= this.totalPages) {
                    this.currentPage = p;
                }
            },

            prevPage() {
                if (this.currentPage > 1) {
                    this.currentPage--;
                }
            },

            nextPage() {
                if (this.currentPage < this.totalPages) {
                    this.currentPage++;
                }
            },

            // Modal and Action Handlers
            openAddModal() {
                const defaultDept = this.departments.length > 0 ? this.departments[0].name : 'School of Computing & Informatics';
                this.newCourse = {
                    code: '',
                    name: '',
                    dept: this.selectedDepartment !== 'All' ? this.selectedDepartment : defaultDept,
                    instructor: '',
                    credits: 4,
                    enrolled: 0,
                    capacity: 60,
                    days: 'Mon, Wed 10:00 - 12:00 PM',
                    room: 'Hall Alpha-1',
                    status: 'Active'
                };
                this.addModalOpen = true;
            },

            async saveNewCourse() {
                if (!this.newCourse.code || !this.newCourse.name || !this.newCourse.instructor) {
                    alert('Please fill in Course Code, Name, and Instructor.');
                    return;
                }

                try {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const res = await fetch('{{ route("courses.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token || ''
                        },
                        body: JSON.stringify(this.newCourse)
                    });

                    const json = await res.json();
                    if (res.ok) {
                        this.courses.unshift(json.data);
                        this.addModalOpen = false;
                        this.showToast(json.message || `Course ${json.data.code} created successfully`, 'success');
                    } else {
                        const errMsg = json.errors ? Object.values(json.errors).flat().join('\n') : (json.message || 'Failed to create course.');
                        alert(errMsg);
                    }
                } catch (e) {
                    console.error(e);
                    alert('An error occurred while creating the course.');
                }
            },

            openEditModal(course) {
                this.editCourseForm = JSON.parse(JSON.stringify(course));
                this.editModalOpen = true;
            },

            async saveEditedCourse() {
                const targetId = this.editCourseForm.id || this.editCourseForm.code;
                try {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const res = await fetch(`/courses/${targetId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token || ''
                        },
                        body: JSON.stringify(this.editCourseForm)
                    });

                    const json = await res.json();
                    if (res.ok) {
                        const index = this.courses.findIndex(c => c.id === this.editCourseForm.id || c.code === this.editCourseForm.code);
                        if (index !== -1) {
                            this.courses[index] = { ...json.data };
                        }
                        this.editModalOpen = false;
                        this.showToast(json.message || `Course ${this.editCourseForm.code} updated`, 'success');
                    } else {
                        const errMsg = json.errors ? Object.values(json.errors).flat().join('\n') : (json.message || 'Failed to update course.');
                        alert(errMsg);
                    }
                } catch (e) {
                    console.error(e);
                    alert('An error occurred while updating the course.');
                }
            },

            confirmDelete(course) {
                this.courseToDelete = course;
                this.deleteModalOpen = true;
            },

            async deleteConfirmed() {
                if (!this.courseToDelete) return;
                const targetId = this.courseToDelete.id || this.courseToDelete.code;
                const code = this.courseToDelete.code;

                try {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const res = await fetch(`/courses/${targetId}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token || ''
                        }
                    });

                    const json = await res.json();
                    if (res.ok) {
                        this.courses = this.courses.filter(c => c.id !== this.courseToDelete.id && c.code !== code);
                        this.deleteModalOpen = false;
                        this.courseToDelete = null;
                        this.showToast(json.message || `Course ${code} removed`, 'danger');
                    } else {
                        alert(json.message || 'Failed to delete course.');
                    }
                } catch (e) {
                    console.error(e);
                    alert('An error occurred while deleting the course.');
                }
            },

            exportCourses() {
                const header = ['Course Code', 'Course Name', 'Department', 'Instructor', 'Credits', 'Enrolled', 'Capacity', 'Schedule', 'Room', 'Status'];
                const rows = this.filteredCourses.map(c => [
                    `"${c.code}"`,
                    `"${c.name}"`,
                    `"${c.dept}"`,
                    `"${c.instructor}"`,
                    c.credits,
                    c.enrolled,
                    c.capacity,
                    `"${c.days}"`,
                    `"${c.room}"`,
                    `"${c.status}"`
                ]);
                const csvContent = 'data:text/csv;charset=utf-8,' + [header.join(','), ...rows.map(e => e.join(','))].join('\n');
                const encodedUri = encodeURI(csvContent);
                const link = document.createElement('a');
                link.setAttribute('href', encodedUri);
                link.setAttribute('download', `EduPulse_Courses_Export_${new Date().toISOString().slice(0, 10)}.csv`);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                this.showToast('Courses exported to CSV', 'info');
            },

            showToast(msg, type = 'success') {
                const bodyData = window.Alpine ? window.Alpine.$data(document.body) : null;
                if (bodyData && typeof bodyData.showToast === 'function') {
                    bodyData.showToast(msg, type);
                }
            }
        };
    }
</script>
@endpush
