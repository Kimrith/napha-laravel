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

            departments: @json($departments ?? null) || [
                { name: 'School of Computing & Informatics', code: 'SCI', head: 'Prof. Alan Turing', students: 894, faculty: 34, programs: 6, budget: '$2.4M', status: 'Active' },
                { name: 'School of Business & Global Finance', code: 'SBGF', head: 'Prof. Paul Krugman', students: 642, faculty: 26, programs: 5, budget: '$1.8M', status: 'Active' },
                { name: 'Faculty of Life Sciences & Biotech', code: 'FLSB', head: 'Dr. Jennifer Doudna', students: 520, faculty: 22, programs: 4, budget: '$3.1M', status: 'Active' },
                { name: 'Design, Arts & Human Experience', code: 'DAHE', head: 'Prof. Jony Ive', students: 410, faculty: 18, programs: 4, budget: '$1.2M', status: 'Active' },
                { name: 'Mechatronics & Robotics Engineering', code: 'MRE', head: 'Dr. Rodney Brooks', students: 379, faculty: 15, programs: 3, budget: '$2.8M', status: 'Active' }
            ],

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
