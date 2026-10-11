<!-- resources/views/dashboard/partials/hero.blade.php -->
<div class="bg-white dark:bg-slate-900 rounded-2xl p-6 sm:p-7 border border-slate-200/80 dark:border-slate-800 shadow-xs relative overflow-hidden transition-colors">
    <!-- Clean Accent Stripe -->
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-brand-600 via-indigo-600 to-sky-500"></div>

    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 pt-1">
        <!-- Greeting & Context -->
        <div class="space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-50 dark:bg-slate-800/80 text-slate-600 dark:text-slate-300 text-xs font-semibold border border-slate-200/80 dark:border-slate-700/80">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>{{ now()->format('l, F j, Y') }}</span>
                <span class="text-slate-300 dark:text-slate-600">•</span>
                <span class="text-brand-700 dark:text-brand-400 font-bold">{{ $termName ?? 'Fall Semester 2026' }}</span>
                <span class="text-slate-400 dark:text-slate-400 font-mono text-[11px]">({{ $termWeek ?? 'Week 8' }})</span>
            </div>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Welcome back, <span class="text-brand-600 dark:text-brand-400">{{ auth()->user()->name ?? ($userName ?? 'Administrator') }}</span>
            </h1>

            <p class="text-sm text-slate-500 dark:text-slate-400 max-w-2xl font-normal leading-relaxed">
                Campus overview: <span class="font-semibold text-slate-800 dark:text-slate-200">{{ number_format($studentsCount ?? 0) }} students</span> enrolled across <span class="font-semibold text-slate-800 dark:text-slate-200">{{ number_format($classesCount ?? 0) }} active cohorts</span> with <span class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $attendanceRate ?? '95.0' }}% recorded attendance</span>.
            </p>
        </div>

        <!-- Quick Primary Actions -->
        <div class="flex items-center gap-2.5 flex-wrap shrink-0">
            <a href="{{ route('attendance.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold bg-brand-600 hover:bg-brand-700 dark:bg-brand-600 dark:hover:bg-brand-500 text-white shadow-xs hover:shadow-md transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <span>Take Roll Call</span>
            </a>

            <a href="{{ route('students.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 transition-colors shadow-2xs">
                <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                <span>Add Student</span>
            </a>

            <a href="{{ route('classes.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 transition-colors shadow-2xs">
                <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <span>Class Cohorts</span>
            </a>
        </div>
    </div>
</div>
