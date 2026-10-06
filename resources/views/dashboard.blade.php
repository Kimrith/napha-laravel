@extends('layouts.app')

@section('title', 'Executive Dashboard | EduPulse Pro Portal')

@section('content')
<div class="space-y-6">

    <!-- ======================= BREADCRUMBS ======================= -->
    <nav class="flex items-center text-xs font-medium text-slate-500 gap-2">
        <span class="text-slate-400">Home</span>
        <svg class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-brand-600 font-semibold bg-brand-50 px-2 py-0.5 rounded-md border border-brand-100">
            Executive Dashboard Overview
        </span>
    </nav>

    <!-- ======================= MODULAR PARTIALS ======================= -->
    {{-- Welcome Hero Greeting & Primary Actions --}}
    @include('dashboard.partials.hero')

    {{-- System-wide High Level Metric Cards --}}
    @include('dashboard.partials.stats')

    <!-- Main Content 2-Column Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left 2 Cols: Department Progress & Live Activity Stream --}}
        <div class="lg:col-span-2 space-y-6">
            @include('dashboard.partials.breakdown')
        </div>

        {{-- Right 1 Col: Academic Deadlines & Admin Shortcuts --}}
        <div>
            @include('dashboard.partials.sidebar-cards')
        </div>
    </div>

</div>
@endsection
