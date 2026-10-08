@extends('layouts.app')

@section('title', 'Academic Departments | EduPulse Pro Portal')

@section('content')
<div x-data="departmentManager()" class="space-y-6">

    <!-- ======================= MODULAR PARTIALS ======================= -->
    {{-- Breadcrumbs, Title, Actions, and Search Bar --}}
    @include('departments.partials.header')

    {{-- Academic Division Cards Grid and Statistics --}}
    @include('departments.partials.grid')

    {{-- Create and Manage Department Modals --}}
    @include('departments.partials.modals')

</div>
@endsection

@push('scripts')
<script>
    function departmentManager() {
        return {
            searchQuery: '',
            addModalOpen: false,

            newDept: {
                name: '',
                code: '',
                head: '',
                students: 0,
                faculty: 0,
                programs: 1,
                budget: '$1.0M',
                status: 'Active'
            },

            departments: @json($departments ?? []),

            get filteredDepartments() {
                const query = this.searchQuery.toLowerCase().trim();
                if (!query) return this.departments;
                return this.departments.filter(d => 
                    d.name.toLowerCase().includes(query) ||
                    d.code.toLowerCase().includes(query) ||
                    d.head.toLowerCase().includes(query)
                );
            },

            openAddModal() {
                this.newDept = {
                    name: '',
                    code: '',
                    head: '',
                    students: 120,
                    faculty: 10,
                    programs: 2,
                    budget: '$1.0M',
                    status: 'Active'
                };
                this.addModalOpen = true;
            },

            saveNewDept() {
                if (!this.newDept.name || !this.newDept.code) return;
                this.departments.push({ ...this.newDept });
                this.addModalOpen = false;
                if (typeof showToast === 'function') {
                    showToast(`Department ${this.newDept.code} created successfully`, 'success');
                }
            },

            manageDepartment(dept) {
                if (typeof showToast === 'function') {
                    showToast(`Opening division workspace for ${dept.code}`, 'info');
                }
            }
        };
    }
</script>
@endpush
