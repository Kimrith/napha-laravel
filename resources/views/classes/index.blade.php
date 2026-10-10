@extends('layouts.app')

@section('title', 'Academic Classes | EduPulse Pro Portal')

@section('content')
<div x-data="classManager()" class="space-y-6">

    <!-- ======================= MODULAR PARTIALS ======================= -->
    {{-- Breadcrumbs, Title, Actions, and Search Bar --}}
    @include('classes.partials.header')

    {{-- Classes Grid and Student Stats --}}
    @include('classes.partials.grid')

    {{-- Create, Edit, Delete, Assign and Roster Modals --}}
    @include('classes.partials.modals')

</div>
@endsection

@push('scripts')
<script>
    function classManager() {
        return {
            searchQuery: '',
            assignSearchQuery: '',
            addModalOpen: false,
            editModalOpen: false,
            deleteModalOpen: false,
            assignModalOpen: false,
            rosterModalOpen: false,

            activeClass: null,
            classToDelete: null,
            editClass: {},
            newClass: {
                code: '',
                name: '',
                status: 'Active'
            },
            selectedStudentIds: [],

            classes: @json($classes ?? []),
            allStudents: @json($allStudents ?? []),

            get filteredClasses() {
                const query = this.searchQuery.toLowerCase().trim();
                if (!query) return this.classes;
                return this.classes.filter(c => 
                    c.code.toLowerCase().includes(query) ||
                    c.name.toLowerCase().includes(query)
                );
            },

            get filteredAssignableStudents() {
                const query = this.assignSearchQuery.toLowerCase().trim();
                if (!query) return this.allStudents;
                return this.allStudents.filter(s => 
                    s.name.toLowerCase().includes(query) ||
                    (s.student_id && s.student_id.toLowerCase().includes(query)) ||
                    (s.major && s.major.toLowerCase().includes(query))
                );
            },

            openAddModal() {
                this.newClass = {
                    code: '',
                    name: '',
                    status: 'Active'
                };
                this.addModalOpen = true;
            },

            openEditModal(cls) {
                this.editClass = JSON.parse(JSON.stringify(cls));
                this.editModalOpen = true;
            },

            openDeleteModal(cls) {
                this.classToDelete = cls;
                this.deleteModalOpen = true;
            },

            openAssignModal(cls) {
                this.activeClass = cls;
                this.assignSearchQuery = '';
                // Preselect students already in this class
                this.selectedStudentIds = this.allStudents
                    .filter(s => s.class_id === cls.id)
                    .map(s => s.id);
                this.assignModalOpen = true;
            },

            openRosterModal(cls) {
                this.activeClass = cls;
                this.rosterModalOpen = true;
            },

            toggleStudentSelection(id) {
                if (this.selectedStudentIds.includes(id)) {
                    this.selectedStudentIds = this.selectedStudentIds.filter(item => item !== id);
                } else {
                    this.selectedStudentIds.push(id);
                }
            },

            selectAllAssignable() {
                const visibleIds = this.filteredAssignableStudents.map(s => s.id);
                const allSelected = visibleIds.every(id => this.selectedStudentIds.includes(id));
                if (allSelected) {
                    this.selectedStudentIds = this.selectedStudentIds.filter(id => !visibleIds.includes(id));
                } else {
                    this.selectedStudentIds = Array.from(new Set([...this.selectedStudentIds, ...visibleIds]));
                }
            }
        };
    }
</script>
@endpush
