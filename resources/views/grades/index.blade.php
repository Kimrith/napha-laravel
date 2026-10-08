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

            records: @json($records ?? []),

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
