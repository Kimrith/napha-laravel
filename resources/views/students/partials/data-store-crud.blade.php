{{-- Avatar & Form Handlers --}}
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
    if (input) input.value = '';
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
    if (input) input.value = '';
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
