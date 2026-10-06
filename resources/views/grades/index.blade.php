@extends('layouts.app')

@section('title', 'Grades & Academic Records | EduPulse Pro Portal')

@section('content')
<div x-data="gradeLedgerManager()" class="space-y-6">

    <!-- ======================= MODULAR PARTIALS ======================= -->
    {{-- Breadcrumbs, Header, Action Controls, and Search --}}
    @include('grades.partials.filter')

    {{-- Comprehensive Examination Ledger and GPA Table --}}
    @include('grades.partials.table')

    {{-- Official Certification and Audit Dialogs --}}
    @include('grades.partials.modals')

</div>
@endsection

@push('scripts')
<script>
    function gradeLedgerManager() {
        return {
            searchQuery: '',
            selectedStanding: 'All',
            certifyModalOpen: false,

            records: @json($records ?? null) || [
                { id: 'STU-2026-001', name: 'Alexander Wright', major: 'Computer Science', course: 'CS-101 Programming', midScore: 94, finalScore: 96, grade: 'A+', gpa: '4.00', standing: 'Dean\'s Honors' },
                { id: 'STU-2026-002', name: 'Amara Okafor', major: 'Data Science & AI', course: 'AI-402 Deep Learning', midScore: 98, finalScore: 97, grade: 'A+', gpa: '4.00', standing: 'Dean\'s Honors' },
                { id: 'STU-2026-003', name: 'Clara Lindqvist', major: 'Digital Design', course: 'DES-204 UX Systems', midScore: 88, finalScore: 89, grade: 'A-', gpa: '3.70', standing: 'Good Standing' },
                { id: 'STU-2026-004', name: 'Marcus Chen', major: 'Robotics & Automation', course: 'ROB-310 Kinematics', midScore: 78, finalScore: 82, grade: 'B', gpa: '3.00', standing: 'Good Standing' },
                { id: 'STU-2026-005', name: 'Sophia Martinez', major: 'Biotechnology', course: 'BIO-215 CRISPR Protocols', midScore: 92, finalScore: 94, grade: 'A', gpa: '3.90', standing: 'Dean\'s Honors' },
                { id: 'STU-2026-006', name: 'Liam Davies', major: 'International Finance', course: 'FIN-350 Global Finance', midScore: 84, finalScore: 86, grade: 'B+', gpa: '3.30', standing: 'Good Standing' },
                { id: 'STU-2026-007', name: 'Fatima Al-Zahra', major: 'Cybersecurity', course: 'SEC-401 Cryptography', midScore: 100, finalScore: 99, grade: 'A+', gpa: '4.00', standing: 'Dean\'s Honors' },
                { id: 'STU-2026-008', name: 'Ethan Taylor', major: 'Media Communications', course: 'MED-110 Media Ethics', midScore: 75, finalScore: 79, grade: 'C+', gpa: '2.70', standing: 'Academic Review' }
            ],

            get filteredRecords() {
                const query = this.searchQuery.toLowerCase().trim();
                return this.records.filter(r => {
                    const matchesQuery = !query ||
                        r.name.toLowerCase().includes(query) ||
                        r.id.toLowerCase().includes(query) ||
                        r.course.toLowerCase().includes(query);
                    const matchesStanding = this.selectedStanding === 'All' || r.standing === this.selectedStanding;
                    return matchesQuery && matchesStanding;
                });
            },

            openCertifyModal() {
                this.certifyModalOpen = true;
            },

            executeCertification() {
                this.certifyModalOpen = false;
                if (typeof showToast === 'function') {
                    showToast('Grade certification verified by Dean of Records.', 'success');
                }
            },

            auditRecord(rec) {
                if (typeof showToast === 'function') {
                    showToast(`Audit log opened for ${rec.name} (${rec.course})`, 'info');
                }
            },

            exportLedger() {
                const header = ['Student ID', 'Student Name', 'Course Module', 'Midterm', 'Final', 'Grade', 'GPA', 'Standing'];
                const rows = this.filteredRecords.map(r => [`"${r.id}"`, `"${r.name}"`, `"${r.course}"`, r.midScore, r.finalScore, `"${r.grade}"`, r.gpa, `"${r.standing}"`]);
                const csvContent = 'data:text/csv;charset=utf-8,' + [header.join(','), ...rows.map(e => e.join(','))].join('\n');
                const link = document.createElement('a');
                link.setAttribute('href', encodeURI(csvContent));
                link.setAttribute('download', `grades_ledger_${new Date().toISOString().slice(0, 10)}.csv`);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                if (typeof showToast === 'function') {
                    showToast('Grade ledger exported to CSV.', 'success');
                }
            }
        };
    }
</script>
@endpush
