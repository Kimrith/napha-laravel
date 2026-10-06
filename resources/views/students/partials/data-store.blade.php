<!-- resources/views/students/partials/data-store.blade.php -->
<script>
    function studentDirectory() {
        return {
            // Mock Data Store
            students: [
                {
                    id: 'STU-2026-001',
                    name: 'Alexander Wright',
                    gender: 'Male',
                    pronouns: 'He/Him',
                    dob: 'Sep 12, 2004',
                    age: 22,
                    email: 'alexander.wright@edupulse.edu',
                    phone: '+1 (555) 234-5678',
                    major: 'Computer Science',
                    degree: 'B.Sc. Software Engineering',
                    department: 'School of Computing',
                    gpa: '3.92',
                    status: 'Active',
                    avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=250&auto=format&fit=crop',
                    credits: 84,
                    advisor: 'Prof. Alan Turing'
                },
                {
                    id: 'STU-2026-002',
                    name: 'Amara Okafor',
                    gender: 'Female',
                    pronouns: 'She/Her',
                    dob: 'Nov 28, 2003',
                    age: 23,
                    email: 'amara.okafor@edupulse.edu',
                    phone: '+1 (555) 876-5432',
                    major: 'Data Science & AI',
                    degree: 'M.Sc. Artificial Intelligence',
                    department: 'Faculty of Informatics',
                    gpa: '3.98',
                    status: 'Active',
                    avatar: 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?q=80&w=250&auto=format&fit=crop',
                    credits: 92,
                    advisor: 'Dr. Fei-Fei Li'
                },
                {
                    id: 'STU-2026-003',
                    name: 'Clara Lindqvist',
                    gender: 'Female',
                    pronouns: 'She/Her',
                    dob: 'Jan 15, 2005',
                    age: 21,
                    email: 'clara.lindqvist@edupulse.edu',
                    phone: '+1 (555) 345-6789',
                    major: 'Digital Design',
                    degree: 'B.A. UI/UX Interaction Design',
                    department: 'Design & Visual Arts',
                    gpa: '3.85',
                    status: 'Active',
                    avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=250&auto=format&fit=crop',
                    credits: 64,
                    advisor: 'Prof. Jony Ive'
                },
                {
                    id: 'STU-2026-004',
                    name: 'Marcus Chen',
                    gender: 'Male',
                    pronouns: 'He/Him',
                    dob: 'Mar 22, 2004',
                    age: 22,
                    email: 'marcus.chen@edupulse.edu',
                    phone: '+1 (555) 654-3210',
                    major: 'Robotics & Automation',
                    degree: 'B.Eng. Mechatronics Engineering',
                    department: 'School of Engineering',
                    gpa: '3.67',
                    status: 'Inactive',
                    avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=250&auto=format&fit=crop',
                    credits: 70,
                    advisor: 'Dr. Rodney Brooks'
                },
                {
                    id: 'STU-2026-005',
                    name: 'Sophia Martinez',
                    gender: 'Female',
                    pronouns: 'She/Her',
                    dob: 'Jul 09, 2004',
                    age: 22,
                    email: 'sophia.martinez@edupulse.edu',
                    phone: '+1 (555) 789-0123',
                    major: 'Biotechnology',
                    degree: 'B.Sc. Genomic Medicine',
                    department: 'Life Sciences',
                    gpa: '3.91',
                    status: 'Active',
                    avatar: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=250&auto=format&fit=crop',
                    credits: 78,
                    advisor: 'Dr. Jennifer Doudna'
                },
                {
                    id: 'STU-2026-006',
                    name: 'Liam Davies',
                    gender: 'Male',
                    pronouns: 'He/Him',
                    dob: 'Dec 04, 2003',
                    age: 23,
                    email: 'liam.davies@edupulse.edu',
                    phone: '+1 (555) 901-2345',
                    major: 'International Finance',
                    degree: 'B.B.A. Global Financial Markets',
                    department: 'School of Business',
                    gpa: '3.74',
                    status: 'Active',
                    avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=250&auto=format&fit=crop',
                    credits: 80,
                    advisor: 'Prof. Paul Krugman'
                },
                {
                    id: 'STU-2026-007',
                    name: 'Fatima Al-Zahra',
                    gender: 'Female',
                    pronouns: 'She/Her',
                    dob: 'May 18, 2002',
                    age: 24,
                    email: 'fatima.alzahra@edupulse.edu',
                    phone: '+1 (555) 432-1098',
                    major: 'Cybersecurity',
                    degree: 'M.Sc. Cryptographic Systems',
                    department: 'School of Computing',
                    gpa: '4.00',
                    status: 'Active',
                    avatar: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=250&auto=format&fit=crop',
                    credits: 96,
                    advisor: 'Dr. Whitfield Diffie'
                },
                {
                    id: 'STU-2026-008',
                    name: 'Ethan Taylor',
                    gender: 'Non-Binary',
                    pronouns: 'They/Them',
                    dob: 'Aug 30, 2005',
                    age: 21,
                    email: 'ethan.taylor@edupulse.edu',
                    phone: '+1 (555) 321-7654',
                    major: 'Media Communications',
                    degree: 'B.A. Digital Journalism & Media',
                    department: 'Faculty of Arts',
                    gpa: '3.62',
                    status: 'Inactive',
                    avatar: 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?q=80&w=250&auto=format&fit=crop',
                    credits: 52,
                    advisor: 'Prof. Marshall McLuhan'
                }
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
                        student.id.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
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

            saveEditedStudent() {
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

            executeDelete() {
                if (this.studentToDelete) {
                    const name = this.studentToDelete.name;
                    this.students = this.students.filter(s => s.id !== this.studentToDelete.id);
                    this.selectedIds = this.selectedIds.filter(id => id !== this.studentToDelete.id);
                    this.deleteModalOpen = false;
                    this.studentToDelete = null;
                    this.showToast(`Record for ${name} deleted successfully`, 'danger');
                }
            },

            saveNewStudent() {
                if (!this.newStudent.name || !this.newStudent.email) {
                    alert('Please fill in Student Name and Email.');
                    return;
                }

                const autoId = 'STU-2026-0' + (this.students.length + 1).toString().padStart(2, '0');
                const studentObj = {
                    id: this.newStudent.id || autoId,
                    name: this.newStudent.name,
                    gender: this.newStudent.gender,
                    pronouns: this.newStudent.pronouns,
                    dob: 'May 15, 2004',
                    age: 22,
                    email: this.newStudent.email,
                    phone: this.newStudent.phone || '+1 (555) 000-1122',
                    major: this.newStudent.major,
                    degree: this.newStudent.degree || `B.Sc. ${this.newStudent.major}`,
                    department: 'School of Advanced Studies',
                    gpa: this.newStudent.gpa || '3.75',
                    status: this.newStudent.status,
                    avatar: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=250&auto=format&fit=crop',
                    credits: 60,
                    advisor: 'Dr. Sarah Vance'
                };

                this.students.unshift(studentObj);
                this.addModalOpen = false;
                
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

                this.showToast(`Enrolled student ${studentObj.name} with ID ${studentObj.id}`, 'success');
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
