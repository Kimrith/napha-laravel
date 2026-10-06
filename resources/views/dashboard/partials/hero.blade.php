<!-- resources/views/dashboard/partials/hero.blade.php -->
<div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-sidebar-base via-slate-900 to-brand-950 p-6 sm:p-8 text-white shadow-xl border border-slate-800">
    <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-brand-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-2 max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/20 text-brand-300 text-xs font-bold border border-brand-500/30">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Fall Semester 2026 · Week 8 in Session</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                Welcome back, <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-300 to-indigo-200">Dr. Sarah Vance</span>
            </h1>
            <p class="text-sm text-slate-300 leading-relaxed font-normal">
                Student enrollment is operating at 94.6% capacity across 8 academic schools. 14 student registrations require dean approval before Friday 5:00 PM.
            </p>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            <a href="{{ route('students.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold bg-brand-600 hover:bg-brand-500 text-white shadow-lg shadow-brand-600/30 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span>Manage Students</span>
            </a>
            <a href="{{ route('grades.index') }}" 
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold bg-white/10 hover:bg-white/20 text-white border border-white/10 backdrop-blur-sm transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span>Grade Audits</span>
            </a>
        </div>
    </div>
</div>
