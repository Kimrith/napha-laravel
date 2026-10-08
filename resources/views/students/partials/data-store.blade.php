<!-- resources/views/students/partials/data-store.blade.php -->
<script>
    function studentDirectory() {
        return {
            // Data Store from Controller
            students: @json($students ?? []),

            searchQuery: '',
            selectedMajor: 'All',
            selectedStatus: 'All',
            selectedIds: [],

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
                major: 'Computer Science',
                degree: 'B.Sc. Software Systems',
                gender: 'Female',
                pronouns: 'She/Her',
                dob: '2004-05-15',
                status: 'Active',
                gpa: '3.80'
            },
            newStudentAvatarFile: null,
            newStudentAvatarPreview: null,

            editForm: {},
            editFormAvatarFile: null,
            editFormAvatarPreview: null,

            get filteredStudents() {
                return this.students.filter(student => {
                    const matchesSearch = this.searchQuery === '' ||
                        student.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        (student.id && student.id.toLowerCase().includes(this.searchQuery.toLowerCase())) ||
                        student.email.toLowerCase().includes(this.searchQuery.toLowerCase());

                    const matchesMajor = this.selectedMajor === 'All' || student.major === this.selectedMajor;
                    const matchesStatus = this.selectedStatus === 'All' || student.status === this.selectedStatus;

                    return matchesSearch && matchesMajor && matchesStatus;
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

            resetNewStudent() {
                this.newStudent = {
                    name: '',
                    id: '',
                    email: '',
                    phone: '',
                    major: 'Computer Science',
                    degree: 'B.Sc. Software Systems',
                    gender: 'Female',
                    pronouns: 'She/Her',
                    dob: '2004-05-15',
                    status: 'Active',
                    gpa: '3.80'
                };
                this.clearNewAvatar();
            },

            exportCSV() {
                const rows = this.filteredStudents;
                let csvContent = 'data:text/csv;charset=utf-8,Student ID,Name,Gender,Pronouns,Email,Phone,Major,Degree,GPA,Status\n';

                rows.forEach(s => {
                    csvContent += `"${s.id}","${s.name}","${s.gender}","${s.pronouns}","${s.email}","${s.phone}","${s.major}","${s.degree}","${s.gpa}","${s.status}"\n`;
                });

                const link = document.createElement('a');
                link.setAttribute('href', encodeURI(csvContent));
                link.setAttribute('download', `EduPulse_Students_Export_${new Date().toISOString().slice(0, 10)}.csv`);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                this.showToast(`Exported ${rows.length} student records to CSV file.`, 'info');
            },

            batchMarkStatus(status) {
                this.students.forEach(s => {
                    if (this.selectedIds.includes(s.id)) {
                        s.status = status;
                    }
                });
                this.showToast(`Updated status to ${status} for ${this.selectedIds.length} students`, 'success');
                this.selectedIds = [];
            },

            batchDelete() {
                if (confirm(`Are you sure you want to delete ${this.selectedIds.length} selected students?`)) {
                    this.students = this.students.filter(s => !this.selectedIds.includes(s.id));
                    this.showToast(`Deleted ${this.selectedIds.length} student records`, 'danger');
                    this.selectedIds = [];
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