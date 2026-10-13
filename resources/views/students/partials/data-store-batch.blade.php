{{-- Batch Actions & Utilities --}}
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
