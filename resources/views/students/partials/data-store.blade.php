<!-- resources/views/students/partials/data-store.blade.php -->
<script>
    function studentDirectory() {
        return {
            // Data Store from Controller
            students: @json($students ?? []),
            classesList: @json($classes ?? []),
            departmentsList: @json($departments ?? []),

            searchQuery: '{{ $appliedFilters['search'] ?? '' }}',
            selectedMajor: '{{ $appliedFilters['major'] ?? 'All' }}',
            selectedDepartment: '{{ $appliedFilters['department_id'] ?? 'All' }}',
            selectedClass: '{{ $appliedFilters['class_id'] ?? 'All' }}',
            selectedStatus: '{{ $appliedFilters['status'] ?? 'All' }}',
            selectedIds: [],
            batchClassId: '',

            // Pagination state
            currentPage: 1,
            perPage: 5,

            addModalOpen: {{ request('action') === 'add' ? 'true' : 'false' }},
            viewSlideOverOpen: false,
            editModalOpen: false,
            deleteModalOpen: false,

            activeStudent: null,
            studentToDelete: null,

            newStudent: {
                name: '',
                id: '',
                email: '',
                phone: '',
                department_id: '',
                class_id: '',
                major: 'Computer Science',
                degree: 'B.Sc. Software Systems',
                advisor: '',
                gender: 'Female',
                pronouns: 'She/Her',
                dob: '',
                age: '',
                gpa: '',
                credits: 0,
                status: 'Active'
            },
            newStudentAvatarFile: null,
            newStudentAvatarPreview: null,

            editForm: {},
            editFormAvatarFile: null,
            editFormAvatarPreview: null,

            get filteredStudents() {
                return this.students.filter(student => {
                    const query = (this.searchQuery || '').toLowerCase().trim();
                    const matchesSearch = query === '' ||
                        (student.name && student.name.toLowerCase().includes(query)) ||
                        (student.id && student.id.toLowerCase().includes(query)) ||
                        (student.email && student.email.toLowerCase().includes(query)) ||
                        (student.phone && student.phone.toLowerCase().includes(query)) ||
                        (student.advisor && student.advisor.toLowerCase().includes(query)) ||
                        (student.class_code && student.class_code.toLowerCase().includes(query)) ||
                        (student.class_name && student.class_name.toLowerCase().includes(query)) ||
                        (student.room_number && student.room_number.toLowerCase().includes(query)) ||
                        (student.subject && student.subject.toLowerCase().includes(query)) ||
                        (student.major && student.major.toLowerCase().includes(query));

                    const matchesMajor = this.selectedMajor === 'All' || student.major === this.selectedMajor;
                    const matchesDepartment = this.selectedDepartment === 'All' || String(student.department_id) === String(this.selectedDepartment);
                    const matchesClass = this.selectedClass === 'All' || 
                        (this.selectedClass === 'unassigned' ? (!student.class_id) : (String(student.class_id) === String(this.selectedClass)));
                    const matchesStatus = this.selectedStatus === 'All' || student.status === this.selectedStatus;

                    return matchesSearch && matchesMajor && matchesDepartment && matchesClass && matchesStatus;
                });
            },

            get totalPages() {
                return Math.max(1, Math.ceil(this.filteredStudents.length / this.perPage));
            },

            get paginatedStudents() {
                if (this.currentPage > this.totalPages) {
                    this.currentPage = this.totalPages;
                }
                const start = (this.currentPage - 1) * this.perPage;
                return this.filteredStudents.slice(start, start + this.perPage);
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

            get allSelected() {
                return this.paginatedStudents.length > 0 && this.paginatedStudents.every(s => this.selectedIds.includes(s.id));
            },

            toggleSelectAll() {
                const pageIds = this.paginatedStudents.map(s => s.id);
                if (this.allSelected) {
                    this.selectedIds = this.selectedIds.filter(id => !pageIds.includes(id));
                } else {
                    this.selectedIds = Array.from(new Set([...this.selectedIds, ...pageIds]));
                }
            },

            toggleRowSelect(id) {
                if (this.selectedIds.includes(id)) {
                    this.selectedIds = this.selectedIds.filter(item => item !== id);
                } else {
                    this.selectedIds.push(id);
                }
            },

            viewStudent(student) {
                this.activeStudent = student;
                this.viewSlideOverOpen = true;
            },

            // Modular CRUD & Avatar Operations
            @include('students.partials.data-store-crud')

            // Modular Batch Operations & Alerts
            @include('students.partials.data-store-batch')
        };
    }
</script>