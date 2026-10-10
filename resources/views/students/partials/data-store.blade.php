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

            addModalOpen: false,
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
                if (this.allSelected) {
                    const pageIds = this.paginatedStudents.map(s => s.id);
                    this.selectedIds = this.selectedIds.filter(id => !pageIds.includes(id));
                } else {
                    const pageIds = this.paginatedStudents.map(s => s.id);
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

            handleNewAvatarChange(event) {
                const file = event.target.files?.[0];
                if (!file) return;
                if (file.size > 2 * 1024 * 1024) {
                    alert('Avatar file size must be less than 2MB.');
                    event.target.value = '';
                    return;
                }
                this.newStudentAvatarFile = file;
                this.newStudentAvatarPreview = URL.createObjectURL(file);
            },

            clearNewAvatar() {
                this.newStudentAvatarFile = null;
                this.newStudentAvatarPreview = null;
                const input = document.getElementById('add-student-avatar-input');
                if (input) {
                    input.value = '';
                }
            },

            handleEditAvatarChange(event) {
                const file = event.target.files?.[0];
                if (!file) return;
                if (file.size > 2 * 1024 * 1024) {
                    alert('Avatar file size must be less than 2MB.');
                    event.target.value = '';
                    return;
                }
                this.editFormAvatarFile = file;
                this.editFormAvatarPreview = URL.createObjectURL(file);
            },

            clearEditAvatar() {
                this.editFormAvatarFile = null;
                this.editFormAvatarPreview = null;
                const input = document.getElementById('edit-student-avatar-input');
                if (input) {
                    input.value = '';
                }
            },

            openEditModal(student) {
                this.editForm = JSON.parse(JSON.stringify(student));
                this.clearEditAvatar();
                this.editModalOpen = true;
            },

            async saveEditedStudent() {
                const targetId = this.editForm.student_id || this.editForm.id;
                try {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const formData = new FormData();
                    formData.append('_method', 'PUT');

                    for (const [key, value] of Object.entries(this.editForm)) {
                        if (key !== 'avatar' && value !== null && value !== undefined) {
                            formData.append(key, value);
                        }
                    }

                    if (this.editFormAvatarFile) {
                        formData.append('avatar', this.editFormAvatarFile);
                    }

                    const res = await fetch(`/students/${targetId}`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token || ''
                        },
                        body: formData
                    });

                    const json = await res.json();
                    if (res.ok) {
                        const index = this.students.findIndex(s => s.id === this.editForm.id || s.student_id === targetId);
                        if (index !== -1) {
                            this.students[index] = { ...json.data };
                        }
                        if (this.activeStudent && (this.activeStudent.id === this.editForm.id || this.activeStudent.student_id === targetId)) {
                            this.activeStudent = { ...json.data };
                        }
                        this.editModalOpen = false;
                        this.clearEditAvatar();
                        this.showToast(json.message || `Student records updated for ${this.editForm.name}`, 'success');
                    } else {
                        const errMsg = json.errors ? Object.values(json.errors).flat().join('\n') : (json.message || 'Failed to update student records.');
                        alert(errMsg);
                    }
                } catch (e) {
                    console.error(e);
                    alert('An error occurred while updating student records.');
                }
            },

            confirmDelete(student) {
                this.studentToDelete = student;
                this.deleteModalOpen = true;
            },

            async executeDelete() {
                if (!this.studentToDelete) return;
                const targetId = this.studentToDelete.student_id || this.studentToDelete.id;
                const name = this.studentToDelete.name;

                try {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const res = await fetch(`/students/${targetId}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token || ''
                        }
                    });

                    const json = await res.json();
                    if (res.ok) {
                        this.students = this.students.filter(s => s.id !== this.studentToDelete.id && s.student_id !== targetId);
                        this.selectedIds = this.selectedIds.filter(id => id !== this.studentToDelete.id);
                        this.deleteModalOpen = false;
                        this.studentToDelete = null;
                        this.showToast(json.message || `Record for ${name} deleted successfully`, 'danger');
                    } else {
                        alert(json.message || 'Failed to delete student.');
                    }
                } catch (e) {
                    console.error(e);
                    alert('An error occurred while deleting student.');
                }
            },

            async saveNewStudent() {
                if (!this.newStudent.name || !this.newStudent.email) {
                    alert('Please fill in Student Name and Email.');
                    return;
                }

                try {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const formData = new FormData();

                    for (const [key, value] of Object.entries(this.newStudent)) {
                        if (value !== null && value !== undefined) {
                            formData.append(key, value);
                        }
                    }

                    if (this.newStudentAvatarFile) {
                        formData.append('avatar', this.newStudentAvatarFile);
                    }

                    const res = await fetch('/students', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token || ''
                        },
                        body: formData
                    });

                    const json = await res.json();
                    if (res.ok) {
                        this.students.unshift(json.data);
                        this.addModalOpen = false;
                        this.showToast(json.message || `Enrolled student ${json.data.name}`, 'success');
                        this.resetNewStudent();
                    } else {
                        const errMsg = json.errors ? Object.values(json.errors).flat().join('\n') : (json.message || 'Failed to save student.');
                        alert(errMsg);
                    }
                } catch (e) {
                    console.error(e);
                    alert('An error occurred while saving the student.');
                }
            },

            calculateAge(dobString) {
                if (!dobString) return '';
                const birthDate = new Date(dobString);
                if (isNaN(birthDate.getTime())) return '';
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                return age >= 0 ? age : '';
            },

            onDobChange(target) {
                if (target === 'new') {
                    this.newStudent.age = this.calculateAge(this.newStudent.dob);
                } else if (target === 'edit') {
                    this.editForm.age = this.calculateAge(this.editForm.dob);
                }
            },

            resetNewStudent() {
                this.newStudent = {
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
                };
                this.clearNewAvatar();
            },

            exportCSV() {
                const params = new URLSearchParams();
                if (this.searchQuery && this.searchQuery.trim()) {
                    params.append('search', this.searchQuery.trim());
                }
                if (this.selectedMajor && this.selectedMajor !== 'All') {
                    params.append('major', this.selectedMajor);
                }
                if (this.selectedDepartment && this.selectedDepartment !== 'All') {
                    params.append('department_id', this.selectedDepartment);
                }
                if (this.selectedClass && this.selectedClass !== 'All') {
                    params.append('class_id', this.selectedClass);
                }
                if (this.selectedStatus && this.selectedStatus !== 'All') {
                    params.append('status', this.selectedStatus);
                }

                const url = '{{ route("students.export") }}' + (params.toString() ? ('?' + params.toString()) : '');
                window.location.href = url;
                this.showToast('Generating official student records CSV...', 'info');
            },

            async batchAssignClass() {
                if (!this.batchClassId || this.selectedIds.length === 0) return;
                try {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const res = await fetch('{{ route("students.batch-assign") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token || ''
                        },
                        body: JSON.stringify({
                            student_ids: this.selectedIds,
                            class_id: this.batchClassId === 'unassigned' ? null : this.batchClassId
                        })
                    });

                    const json = await res.json();
                    if (res.ok) {
                        const targetClassId = this.batchClassId === 'unassigned' ? null : Number(this.batchClassId);
                        const matchedClass = targetClassId ? this.classesList.find(c => c.id === targetClassId) : null;

                        this.students.forEach(s => {
                            if (this.selectedIds.includes(s.id) || this.selectedIds.includes(s.student_id)) {
                                s.class_id = targetClassId;
                                if (matchedClass) {
                                    s.class_code = matchedClass.code;
                                    s.class_name = `${matchedClass.code} - ${matchedClass.name}`;
                                } else {
                                    s.class_code = 'Unassigned';
                                    s.class_name = 'Unassigned';
                                }
                            }
                        });
                        this.showToast(json.message || 'Assigned students successfully', 'success');
                        this.batchClassId = '';
                        this.selectedIds = [];
                    } else {
                        alert(json.message || 'Failed to assign class.');
                    }
                } catch (e) {
                    console.error(e);
                    alert('An error occurred while assigning class.');
                }
            },

            async batchMarkStatus(status) {
                if (this.selectedIds.length === 0) return;
                try {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const res = await fetch('{{ route("students.batch-status") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token || ''
                        },
                        body: JSON.stringify({
                            student_ids: this.selectedIds,
                            status: status
                        })
                    });

                    const json = await res.json();
                    if (res.ok) {
                        this.students.forEach(s => {
                            if (this.selectedIds.includes(s.id) || this.selectedIds.includes(s.student_id)) {
                                s.status = status;
                            }
                        });
                        this.showToast(json.message || `Updated status to ${status}`, 'success');
                        this.selectedIds = [];
                    } else {
                        alert(json.message || 'Failed to update student status.');
                    }
                } catch (e) {
                    console.error(e);
                    alert('An error occurred while updating status.');
                }
            },

            async batchDelete() {
                if (this.selectedIds.length === 0) return;
                if (!confirm(`Are you sure you want to delete ${this.selectedIds.length} selected students? This cannot be undone.`)) {
                    return;
                }

                try {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const res = await fetch('{{ route("students.batch-delete") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token || ''
                        },
                        body: JSON.stringify({
                            student_ids: this.selectedIds
                        })
                    });

                    const json = await res.json();
                    if (res.ok) {
                        const count = this.selectedIds.length;
                        this.students = this.students.filter(s => !this.selectedIds.includes(s.id) && !this.selectedIds.includes(s.student_id));
                        this.selectedIds = [];
                        this.showToast(json.message || `Deleted ${count} student records`, 'danger');
                    } else {
                        alert(json.message || 'Failed to delete students.');
                    }
                } catch (e) {
                    console.error(e);
                    alert('An error occurred while deleting students.');
                }
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