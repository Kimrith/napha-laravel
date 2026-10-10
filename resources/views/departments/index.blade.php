@extends('layouts.app')

@section('title', 'Academic Departments | EduPulse Pro Portal')

@section('content')
<div x-data="departmentManager()" class="space-y-6">

    <!-- ======================= MODULAR PARTIALS ======================= -->
    {{-- Breadcrumbs, Title, Live KPIs, and Search Filter Bar --}}
    @include('departments.partials.header')

    {{-- Academic Division Cards Grid and Pagination --}}
    @include('departments.partials.grid')

    {{-- Create, Edit, Delete, and Dossier Modals --}}
    @include('departments.partials.modals')

</div>
@endsection

@push('scripts')
<script>
    function departmentManager() {
        return {
            departments: @json($departments ?? []),
            searchQuery: '{{ $appliedFilters['search'] ?? '' }}',
            selectedStatus: '{{ $appliedFilters['status'] ?? 'All' }}',

            // Pagination state
            currentPage: 1,
            perPage: 6,

            // Modal visibility toggles
            addModalOpen: false,
            editModalOpen: false,
            deleteModalOpen: false,
            viewModalOpen: false,

            activeDept: null,
            deptToDelete: null,

            newDept: {
                name: '',
                code: '',
                head: '',
                budget: '$1.5M',
                students_count: 0,
                faculty_count: 10,
                programs_count: 2,
                status: 'Active',
                description: ''
            },

            editDept: {
                id: null,
                name: '',
                code: '',
                head: '',
                budget: '',
                students: 0,
                faculty: 0,
                programs: 1,
                status: 'Active',
                description: ''
            },

            get filteredDepartments() {
                const query = (this.searchQuery || '').toLowerCase().trim();
                return this.departments.filter(dept => {
                    const matchesSearch = !query ||
                        (dept.name && dept.name.toLowerCase().includes(query)) ||
                        (dept.code && dept.code.toLowerCase().includes(query)) ||
                        (dept.head && dept.head.toLowerCase().includes(query)) ||
                        (dept.description && dept.description.toLowerCase().includes(query));

                    const matchesStatus = this.selectedStatus === 'All' || dept.status === this.selectedStatus;

                    return matchesSearch && matchesStatus;
                });
            },

            get totalPages() {
                return Math.max(1, Math.ceil(this.filteredDepartments.length / this.perPage));
            },

            get paginatedDepartments() {
                if (this.currentPage > this.totalPages) {
                    this.currentPage = this.totalPages;
                }
                const start = (this.currentPage - 1) * this.perPage;
                return this.filteredDepartments.slice(start, start + this.perPage);
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

            openAddModal() {
                this.newDept = {
                    name: '',
                    code: '',
                    head: '',
                    budget: '$1.5M',
                    students_count: 0,
                    faculty_count: 12,
                    programs_count: 2,
                    status: 'Active',
                    description: ''
                };
                this.addModalOpen = true;
            },

            async saveNewDept() {
                if (!this.newDept.name || !this.newDept.code || !this.newDept.head) {
                    alert('Please provide Department Name, Code, and Chairperson.');
                    return;
                }

                try {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const res = await fetch('{{ route("departments.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token || ''
                        },
                        body: JSON.stringify(this.newDept)
                    });

                    const json = await res.json();
                    if (res.ok) {
                        this.departments.unshift(json.data);
                        this.addModalOpen = false;
                        this.showToast(json.message || `Department ${json.data.code} created successfully`, 'success');
                    } else {
                        const errMsg = json.errors ? Object.values(json.errors).flat().join('\n') : (json.message || 'Failed to create department.');
                        alert(errMsg);
                    }
                } catch (e) {
                    console.error(e);
                    alert('An error occurred while creating the department.');
                }
            },

            openEditModal(dept) {
                this.editDept = {
                    id: dept.id,
                    name: dept.name,
                    code: dept.code,
                    head: dept.head,
                    budget: dept.budget,
                    students: dept.students,
                    faculty: dept.faculty,
                    programs: dept.programs,
                    status: dept.status,
                    description: dept.description || ''
                };
                this.editModalOpen = true;
            },

            async updateDept() {
                if (!this.editDept.id) return;
                try {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const res = await fetch(`/departments/${this.editDept.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token || ''
                        },
                        body: JSON.stringify({
                            name: this.editDept.name,
                            code: this.editDept.code,
                            head: this.editDept.head,
                            budget: this.editDept.budget,
                            students_count: this.editDept.students,
                            faculty_count: this.editDept.faculty,
                            programs_count: this.editDept.programs,
                            status: this.editDept.status,
                            description: this.editDept.description
                        })
                    });

                    const json = await res.json();
                    if (res.ok) {
                        const idx = this.departments.findIndex(d => d.id === this.editDept.id);
                        if (idx !== -1) {
                            this.departments[idx] = { ...json.data };
                        }
                        if (this.activeDept && this.activeDept.id === this.editDept.id) {
                            this.activeDept = { ...json.data };
                        }
                        this.editModalOpen = false;
                        this.showToast(json.message || `Department ${this.editDept.code} updated`, 'success');
                    } else {
                        const errMsg = json.errors ? Object.values(json.errors).flat().join('\n') : (json.message || 'Failed to update department.');
                        alert(errMsg);
                    }
                } catch (e) {
                    console.error(e);
                    alert('An error occurred while updating the department.');
                }
            },

            confirmDelete(dept) {
                this.deptToDelete = dept;
                this.deleteModalOpen = true;
            },

            async executeDeleteDept() {
                if (!this.deptToDelete) return;
                const id = this.deptToDelete.id;
                const code = this.deptToDelete.code;

                try {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const res = await fetch(`/departments/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token || ''
                        }
                    });

                    const json = await res.json();
                    if (res.ok) {
                        this.departments = this.departments.filter(d => d.id !== id);
                        this.deleteModalOpen = false;
                        this.deptToDelete = null;
                        this.showToast(json.message || `Department ${code} deleted`, 'danger');
                    } else {
                        alert(json.message || 'Failed to delete department.');
                    }
                } catch (e) {
                    console.error(e);
                    alert('An error occurred while deleting the department.');
                }
            },

            viewDepartment(dept) {
                this.activeDept = dept;
                this.viewModalOpen = true;
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
