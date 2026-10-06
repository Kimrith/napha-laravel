@extends('layouts.app')

@section('title', 'System Settings | EduPulse Pro Portal')

@section('content')
<div x-data="settingsManager()" class="space-y-6 max-w-4xl">

    <!-- ======================= MODULAR PARTIALS ======================= -->
    {{-- Breadcrumbs and Page Heading --}}
    @include('settings.partials.header')

    {{-- Academic Term Dates and Window Configuration --}}
    @include('settings.partials.term-config')

    {{-- Security, 2FA Policies, and Governance Alerts --}}
    @include('settings.partials.security-config')

</div>
@endsection

@push('scripts')
<script>
    function settingsManager() {
        return {
            term: @json($term ?? null) || {
                name: 'Fall Semester 2026',
                week: 'Week 8',
                startDate: '2026-08-25',
                endDate: '2026-12-18',
                gradingDeadline: '2026-12-24'
            },

            notifications: @json($notifications ?? null) || {
                emailAlerts: true,
                auditLogs: true,
                twoFactor: true
            },

            saveSettings() {
                if (typeof showToast === 'function') {
                    showToast('System preferences saved successfully.', 'success');
                }
            }
        };
    }
</script>
@endpush
