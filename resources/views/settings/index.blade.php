@extends('layouts.app')

@section('title', 'System Settings & Security | EduPulse Pro Portal')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto pb-12">

    <!-- Breadcrumbs and Page Heading -->
    @include('settings.partials.header')

    <!-- User Account Summary Strip -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-colors">
        <div class="flex items-center gap-3.5">
            <div class="relative">
                <img class="w-12 h-12 rounded-xl object-cover ring-2 ring-brand-500/20" 
                     src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'User') }}&background=6366f1&color=fff&bold=true" 
                     alt="{{ $user->name ?? 'User' }}">
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-white dark:border-slate-900 rounded-full"></span>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white">{{ $user->name ?? 'Administrator' }}</h2>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-brand-50 dark:bg-brand-950/60 text-brand-700 dark:text-brand-300 border border-brand-200/70 dark:border-brand-800/70 uppercase tracking-wider">
                        Active Account
                    </span>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $user->email ?? 'admin@edupulse.edu' }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 font-medium">
            <span>Member since:</span>
            <span class="font-bold text-slate-800 dark:text-slate-200">{{ $user?->created_at?->format('M Y') ?? 'Recent' }}</span>
        </div>
    </div>

    <!-- 1: Interface Appearance & Theme Switching (Light / Dark / System) -->
    @include('settings.partials.appearance')

    <!-- 2: User Security & Password Change -->
    @include('settings.partials.password')

    <!-- 3: Academic Term Dates and Governance -->
    @include('settings.partials.term-config')

</div>
@endsection

