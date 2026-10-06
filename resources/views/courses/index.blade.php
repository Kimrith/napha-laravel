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
            // Search and filter state
            searchQuery: '',
            selectedDepartment: 'All',
            selectedStatus: 'All',

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
                dept: 'Computer Science',
                instructor: '',
                credits: 4,
                enrolled: 0,
                capacity: 60,
                days: 'Mon, Wed 10:00 - 12:00 PM',
                room: 'Hall Alpha-1',
                status: 'Active'
            },

            // Initial Course Records (seeded from controller if provided or default mock)
            courses: @json($courses ?? null) || [
                { code: 'CS-101', name: 'Object-Oriented Programming in C++ & Rust', dept: 'Computer Science', instructor: 'Prof. Alan Turing', credits: 4, enrolled: 88, capacity: 90, days: 'Mon, Wed 09:00 - 11:00 AM', room: 'Hall Alpha-2', status: 'Active' },
                { code: 'AI-402', name: 'Deep Learning & Neural Architectures', dept: 'Informatics & AI', instructor: 'Dr. Fei-Fei Li', credits: 4, enrolled: 64, capacity: 65, days: 'Tue, Thu 01:30 - 03:30 PM', room: 'Lab Turing-1', status: 'Active' },
                { code: 'DES-204', name: 'Human-Centered UI/UX Systems', dept: 'Digital Design', instructor: 'Prof. Jony Ive', credits: 3, enrolled: 52, capacity: 60, days: 'Wed, Fri 10:00 - 12:00 PM', room: 'Studio Beta', status: 'Active' },
                { code: 'ROB-310', name: 'Autonomous Robotics & Kinematics', dept: 'Mechatronics', instructor: 'Dr. Rodney Brooks', credits: 4, enrolled: 45, capacity: 50, days: 'Mon, Thu 02:00 - 04:00 PM', room: 'RoboLab 4', status: 'Active' },
                { code: 'BIO-215', name: 'Genomic Sequencing & CRISPR Protocols', dept: 'Life Sciences', instructor: 'Dr. Jennifer Doudna', credits: 4, enrolled: 72, capacity: 75, days: 'Tue, Fri 09:00 - 11:00 AM', room: 'BioLab 3', status: 'Active' },
                { code: 'FIN-350', name: 'Quantitative Global Financial Markets', dept: 'Business & Finance', instructor: 'Prof. Paul Krugman', credits: 3, enrolled: 80, capacity: 80, days: 'Mon, Wed 01:00 - 02:30 PM', room: 'Hall Gamma-1', status: 'Full' },
                { code: 'SEC-401', name: 'Applied Cryptography & Zero-Knowledge Proofs', dept: 'Cybersecurity', instructor: 'Dr. Whitfield Diffie', credits: 4, enrolled: 58, capacity: 60, days: 'Tue, Thu 11:00 - 01:00 PM', room: 'SecVault Lab', status: 'Active' }
            ],

            // Filtered courses getter
            get filteredCourses() {
                return this.courses.filter(c => {
                    const query = this.searchQuery.toLowerCase().trim();
                    const matchesQuery = query === '' || 
                        c.code.toLowerCase().includes(query) || 
                        c.name.toLowerCase().includes(query) ||
                        c.instructor.toLowerCase().includes(query);
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
                const start = (this.currentPage - 1) * this.perPage;
                return this.filteredCourses.slice(start, start + this.perPage);
            },

            // Modal and Action Handlers
            openAddModal() {
                this.newCourse = {
                    code: '',
                    name: '',
                    dept: this.selectedDepartment !== 'All' ? this.selectedDepartment : 'Computer Science',
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

            saveNewCourse() {
                if (!this.newCourse.code || !this.newCourse.name) {
                    return;
                }
                this.courses.unshift({ ...this.newCourse });
                this.addModalOpen = false;
                if (typeof showToast === 'function') {
                    showToast(`Course ${this.newCourse.code} created successfully`, 'success');
                }
            },

            openEditModal(course) {
                this.editCourseForm = JSON.parse(JSON.stringify(course));
                this.editModalOpen = true;
            },

            saveEditedCourse() {
                const index = this.courses.findIndex(c => c.code === this.editCourseForm.code);
                if (index !== -1) {
                    this.courses[index] = { ...this.editCourseForm };
                    this.editModalOpen = false;
                    if (typeof showToast === 'function') {
                        showToast(`Course ${this.editCourseForm.code} updated`, 'success');
                    }
                }
            },

            confirmDelete(course) {
                this.courseToDelete = course;
                this.deleteModalOpen = true;
            },

            deleteConfirmed() {
                if (this.courseToDelete) {
                    const code = this.courseToDelete.code;
                    this.courses = this.courses.filter(c => c.code !== code);
                    this.deleteModalOpen = false;
                    this.courseToDelete = null;
                    if (typeof showToast === 'function') {
                        showToast(`Course ${code} removed`, 'info');
                    }
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
                link.setAttribute('download', `courses_export_${new Date().toISOString().slice(0, 10)}.csv`);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                if (typeof showToast === 'function') {
                    showToast('Courses exported to CSV', 'success');
                }
            }
        };
    }
</script>
@endpush
