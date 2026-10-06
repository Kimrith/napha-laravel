@extends('layouts.app')

@section('title', 'System Settings | EduPulse Pro Portal')

@section('content')
<div x-data="{
    term: {
        name: 'Fall Semester 2026',
        week: 'Week 8',
        startDate: '2026-08-25',
        endDate: '2026-12-18',
        gradingDeadline: '2026-12-24'
    },
    notifications: {
        emailAlerts: true,
        auditLogs: true,
        twoFactor: true
    },
    saveSettings() {
        showToast('System preferences saved successfully.', 'success');
    }
}" class="space-y-6 max-w-4xl">

    <!-- Breadcrumbs -->
    <nav class="flex items-center text-xs font-medium text-slate-500 gap-2">
        <a href="{{ route('dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
        <svg class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        <span class="text-brand-600 font-semibold bg-brand-50 px-2 py-0.5 rounded-md border border-brand-100">System Settings</span>
    </nav>

    <!-- Page Header -->
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">System Settings & Governance</h1>
        <p class="text-sm text-slate-500 mt-1">Configure academic term windows, grading policy guidelines, and institution security parameters.</p>
    </div>

    <!-- Academic Term Configuration -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-5">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Current Academic Term Window</h3>
                <p class="text-xs text-slate-500 mt-0.5">Defines the active registration trimester and examination schedules.</p>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Active Term</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Term Name</label>
                <input type="text" x-model="term.name" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white text-slate-800 font-medium">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Current Academic Week</label>
                <input type="text" x-model="term.week" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white text-slate-800 font-medium">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Semester Start Date</label>
                <input type="date" x-model="term.startDate" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white text-slate-800">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Semester End Date</label>
                <input type="date" x-model="term.endDate" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white text-slate-800">
            </div>
        </div>
    </div>

    <!-- Security & Institutional Governance -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-5">
        <div>
            <h3 class="text-base font-bold text-slate-900">Security & Portal Audit Access</h3>
            <p class="text-xs text-slate-500 mt-0.5">Control administrative multi-factor protocols and student ledger locks.</p>
        </div>

        <div class="space-y-4 pt-2">
            <div class="flex items-center justify-between p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                <div>
                    <h4 class="text-xs font-bold text-slate-900">Enforce Two-Factor Authentication (2FA)</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">Requires all faculty deans and registrars to provide an authenticator OTP code on sign-in.</p>
                </div>
                <input type="checkbox" x-model="notifications.twoFactor" class="w-4 h-4 rounded text-brand-600 border-slate-300 focus:ring-brand-500">
            </div>

            <div class="flex items-center justify-between p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                <div>
                    <h4 class="text-xs font-bold text-slate-900">Automated Grade Audit Alerts</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">Notify the Chief Dean when a professor modifies letter marks post-examination.</p>
                </div>
                <input type="checkbox" x-model="notifications.auditLogs" class="w-4 h-4 rounded text-brand-600 border-slate-300 focus:ring-brand-500">
            </div>

            <div class="flex items-center justify-between p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                <div>
                    <h4 class="text-xs font-bold text-slate-900">Real-time Email Notifications</h4>
                    <p class="text-[11px] text-slate-500 mt-0.5">Receive student enrollment and absence alerts on sarah.vance@edupulse.edu.</p>
                </div>
                <input type="checkbox" x-model="notifications.emailAlerts" class="w-4 h-4 rounded text-brand-600 border-slate-300 focus:ring-brand-500">
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end">
            <button @click="saveSettings()" 
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-md shadow-brand-600/30 transition-all">
                Save System Configurations
            </button>
        </div>
    </div>

</div>
@endsection
