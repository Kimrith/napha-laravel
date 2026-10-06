<!-- resources/views/students/partials/data-store.blade.php -->
<script>
    function studentDirectory() {
        return {
            // Data Store from Controller or Fallback
            students: @json($students ?? null) || [
                { id: 'STU-2026-001', name: 'Alexander Wright', gender: 'Male', pronouns: 'He/Him', dob: 'Sep 12, 2004', age: 22, email: 'alexander.wright@edupulse.edu', phone: '+1 (555) 234-5678', major: 'Computer Science', degree: 'B.Sc. Software Engineering', department: 'School of Computing & Informatics', gpa: '3.92', status: 'Active', avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=250&auto=format&fit=crop', credits: 84, advisor: 'Prof. Alan Turing' },
                { id: 'STU-2026-002', name: 'Amara Okafor', gender: 'Female', pronouns: 'She/Her', dob: 'Nov 28, 2003', age: 23, email: 'amara.okafor@edupulse.edu', phone: '+1 (555) 876-5432', major: 'Data Science & AI', degree: 'M.Sc. Artificial Intelligence', department: 'Faculty of Informatics', gpa: '3.98', status: 'Active', avatar: 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?q=80&w=250&auto=format&fit=crop', credits: 92, advisor: 'Dr. Fei-Fei Li' },
                { id: 'STU-2026-003', name: 'Clara Lindqvist', gender: 'Female', pronouns: 'She/Her', dob: 'Jan 15, 2005', age: 21, email: 'clara.lindqvist@edupulse.edu', phone: '+1 (555) 345-6789', major: 'Digital Design', degree: 'B.A. UI/UX Interaction Design', department: 'Design, Arts & Human Experience', gpa: '3.85', status: 'Active', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=250&auto=format&fit=crop', credits: 64, advisor: 'Prof. Jony Ive' },
                { id: 'STU-2026-004', name: 'Marcus Chen', gender: 'Male', pronouns: 'He/Him', dob: 'Mar 04, 2004', age: 22, email: 'marcus.chen@edupulse.edu', phone: '+1 (555) 456-7890', major: 'Robotics & Automation', degree: 'B.Sc. Mechatronics Engineering', department: 'Mechatronics & Robotics Engineering', gpa: '3.71', status: 'Active', avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=250&auto=format&fit=crop', credits: 78, advisor: 'Dr. Rodney Brooks' },
                { id: 'STU-2026-005', name: 'Sophia Martinez', gender: 'Female', pronouns: 'She/Her', dob: 'Jul 22, 2005', age: 21, email: 'sophia.martinez@edupulse.edu', phone: '+1 (555) 567-8901', major: 'Biotechnology', degree: 'B.Sc. Molecular Biology & Genetics', department: 'Faculty of Life Sciences & Biotech', gpa: '3.95', status: 'Active', avatar: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=250&auto=format&fit=crop', credits: 88, advisor: 'Dr. Jennifer Doudna' },
                { id: 'STU-2026-006', name: 'Liam Davies', gender: 'Male', pronouns: 'He/Him', dob: 'Oct 30, 2003', age: 23, email: 'liam.davies@edupulse.edu', phone: '+1 (555) 678-9012', major: 'International Finance', degree: 'B.Sc. Financial Economics', department: 'School of Business & Global Finance', gpa: '3.68', status: 'Active', avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=250&auto=format&fit=crop', credits: 70, advisor: 'Prof. Paul Krugman' },
                { id: 'STU-2026-007', name: 'Fatima Al-Zahra', gender: 'Female', pronouns: 'She/Her', dob: 'Dec 05, 2004', age: 22, email: 'fatima.alzahra@edupulse.edu', phone: '+1 (555) 789-0123', major: 'Cybersecurity', degree: 'B.Sc. Information Assurance', department: 'School of Computing & Informatics', gpa: '4.00', status: 'Active', avatar: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=250&auto=format&fit=crop', credits: 96, advisor: 'Dr. Whitfield Diffie' },
                { id: 'STU-2026-008', name: 'Ethan Taylor', gender: 'Male', pronouns: 'He/Him', dob: 'Apr 18, 2004', age: 22, email: 'ethan.taylor@edupulse.edu', phone: '+1 (555) 321-7654', major: 'Media Communications', degree: 'B.A. Digital Journalism & Media', department: 'Design, Arts & Human Experience', gpa: '3.62', status: 'Inactive', avatar: 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?q=80&w=250&auto=format&fit=crop', credits: 52, advisor: 'Prof. Marshall McLuhan' }
            ],

            searchQuery: '',
            selectedMajor: 'All',
            selectedStatus: 'All',
            selectedIds: [],

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

            editForm: {},

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

            get allSelected() {
                return this.filteredStudents.length > 0 && this.selectedIds.length === this.filteredStudents.length;
            },

            toggleSelectAll() {
                this.selectedIds = this.allSelected ? [] : this.filteredStudents.map(s => s.id);
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

            openEditModal(student) {
                this.editForm = JSON.parse(JSON.stringify(student));
                this.editModalOpen = true;
            },

            async saveEditedStudent() {
                const targetId = this.editForm.student_id || this.editForm.id;
                try {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const res = await fetch(`/students/${targetId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token || ''
                        },
                        body: JSON.stringify(this.editForm)
                    });

                    if (res.ok) {
                        const json = await res.json();
                        const index = this.students.findIndex(s => s.id === this.editForm.id || s.student_id === targetId);
                        if (index !== -1) {
                            this.students[index] = { ...json.data };
                        }
                        this.editModalOpen = false;
                        this.showToast(json.message || `Student records updated for ${this.editForm.name}`, 'success');
                        return;
                    }
                } catch (e) {
                    console.error(e);
                }

                const index = this.students.findIndex(s => s.id === this.editForm.id);
                if (index !== -1) {
                    this.students[index] = { ...this.editForm };
                    this.editModalOpen = false;
                    this.showToast(`Student records updated for ${this.editForm.name}`, 'success');
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

                    if (res.ok) {
                        const json = await res.json();
                        this.students = this.students.filter(s => s.id !== this.studentToDelete.id && s.student_id !== targetId);
                        this.selectedIds = this.selectedIds.filter(id => id !== this.studentToDelete.id);
                        this.deleteModalOpen = false;
                        this.studentToDelete = null;
                        this.showToast(json.message || `Record for ${name} deleted successfully`, 'danger');
                        return;
                    }
                } catch (e) {
                    console.error(e);
                }

                this.students = this.students.filter(s => s.id !== this.studentToDelete.id);
                this.selectedIds = this.selectedIds.filter(id => id !== this.studentToDelete.id);
                this.deleteModalOpen = false;
                this.studentToDelete = null;
                this.showToast(`Record for ${name} deleted successfully`, 'danger');
            },

            async saveNewStudent() {
                if (!this.newStudent.name || !this.newStudent.email) {
                    alert('Please fill in Student Name and Email.');
                    return;
                }

                try {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    const res = await fetch('/students', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token || ''
                        },
                        body: JSON.stringify(this.newStudent)
                    });

                    if (res.ok) {
                        const json = await res.json();
                        this.students.unshift(json.data);
                        this.addModalOpen = false;
                        this.showToast(json.message || `Enrolled student ${json.data.name}`, 'success');
                        this.resetNewStudent();
                        return;
                    }
                } catch (e) {
                    console.error(e);
                }

                const autoId = 'STU-2026-0' + (this.students.length + 1).toString().padStart(2, '0');
                const studentObj = {
                    id: this.newStudent.id || autoId,
                    student_id: this.newStudent.id || autoId,
                    name: this.newStudent.name,
                    gender: this.newStudent.gender || 'Female',
                    pronouns: this.newStudent.pronouns || 'She/Her',
                    dob: 'May 15, 2004',
                    age: 22,
                    email: this.newStudent.email,
                    phone: this.newStudent.phone || '+1 (555) 000-1122',
                    major: this.newStudent.major || 'Computer Science',
                    degree: this.newStudent.degree || `B.Sc. ${this.newStudent.major || 'Computer Science'}`,
                    department: 'School of Computing & Informatics',
                    gpa: this.newStudent.gpa || '3.75',
                    status: this.newStudent.status || 'Active',
                    avatar: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=250&auto=format&fit=crop',
                    credits: 60,
                    advisor: 'Prof. Alan Turing'
                };

                this.students.unshift(studentObj);
                this.addModalOpen = false;
                this.showToast(`Enrolled student ${studentObj.name} with ID ${studentObj.id}`, 'success');
                this.resetNewStudent();
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
            },

            exportCSV() {
                const rows = this.filteredStudents;
                let csvContent = 'data:text/csv;charset=utf-8,Student ID,Name,Gender,Pronouns,Email,Phone,Major,Degree,GPA,Status\n';

                rows.forEach(s => {
                    csvContent += `"${s.id}","${s.name}","${s.gender}","${s.pronouns}","${s.email}","${s.phone}","${s.major}","${s.degree}","${s.gpa}","${s.status}"\n`;
                });

                const link = document.createElement('a');
                link.setAttribute('href', encodeURI(csvContent));
                link.setAttribute('download', `EduPulse_Students_Export_${new Date().toISOString().slice(0,10)}.csv`);
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
            }
        };
    }
</script>
