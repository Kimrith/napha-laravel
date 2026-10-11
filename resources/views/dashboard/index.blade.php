@extends('layouts.app')

@section('title', 'Executive Dashboard | EduPulse Pro Portal')

@section('content')
<div class="space-y-6 mx-auto">

    <!-- Breadcrumb Header -->
    <div class="flex items-center justify-between">
        <nav class="flex items-center text-xs font-medium text-slate-500 dark:text-slate-400 gap-2">
            <a href="{{ route('dashboard') }}" class="text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">Portal</a>
            <svg class="w-3 h-3 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-slate-700 dark:text-slate-200 font-semibold">Executive Dashboard</span>
        </nav>
        
        <div class="hidden sm:flex items-center gap-2 text-xs text-slate-400 dark:text-slate-500">
            <span>Last synchronized:</span>
            <span class="font-medium text-slate-600 dark:text-slate-300">{{ now()->format('h:i A') }}</span>
        </div>
    </div>

    <!-- Modular Partials -->
    {{-- Welcome Hero Greeting & Primary Actions --}}
    @include('dashboard.partials.hero')

    {{-- System-wide High Level Metric Cards --}}
    @include('dashboard.partials.stats')

    <!-- Main Content 2-Column Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left 2 Cols: Admissions & Activities Stream --}}
        <div class="lg:col-span-2 space-y-6">
            @include('dashboard.partials.breakdown')
        </div>

        {{-- Right 1 Col: Active Cohorts & Quick Shortcuts --}}
        <div class="space-y-6">
            @include('dashboard.partials.sidebar-cards')
        </div>
    </div>

</div>
@endsection
