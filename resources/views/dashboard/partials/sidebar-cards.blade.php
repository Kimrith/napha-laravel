<!-- resources/views/dashboard/partials/sidebar-cards.blade.php -->
<div class="space-y-6">
    <!-- Term Milestone Card -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Academic Deadlines</h3>
            <span class="text-[10px] font-bold text-brand-700 bg-brand-50 px-2 py-0.5 rounded-full border border-brand-200">October 2026</span>
        </div>

        <div class="space-y-3">
            <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                    <span>Mid-Term Examination Week</span>
                    <span class="text-rose-600">In 4 Days</span>
                </div>
                <p class="text-[11px] text-slate-500">Hall seating plan generation starts Friday 10:00 AM.</p>
            </div>

            <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                    <span>Course Drop / Add Final Cutoff</span>
                    <span class="text-amber-600">Oct 16</span>
                </div>
                <p class="text-[11px] text-slate-500">Registrar registry lock for Autumn trimester.</p>
            </div>

            <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                    <span>Faculty Academic Council</span>
                    <span class="text-slate-500">Oct 24</span>
                </div>
                <p class="text-[11px] text-slate-500">Quarterly review on curriculum updates and AI research grants.</p>
            </div>
        </div>
    </div>

    <!-- Quick Management Shortcuts -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-3">
        <h3 class="text-sm font-bold text-slate-900">Admin Shortcuts</h3>
        <div class="grid grid-cols-2 gap-2 text-xs font-semibold">
            <a href="{{ route('students.index') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-brand-50 hover:text-brand-700 border border-slate-200/70 text-slate-700 flex flex-col items-center justify-center gap-1.5 text-center transition-colors">
                <svg class="w-5 h-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                <span>New Student</span>
            </a>
            <a href="{{ route('courses.index') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-brand-50 hover:text-brand-700 border border-slate-200/70 text-slate-700 flex flex-col items-center justify-center gap-1.5 text-center transition-colors">
                <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <span>Course Catalog</span>
            </a>
            <a href="{{ route('attendance.index') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-brand-50 hover:text-brand-700 border border-slate-200/70 text-slate-700 flex flex-col items-center justify-center gap-1.5 text-center transition-colors">
                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                <span>Roll Call</span>
            </a>
            <a href="{{ route('settings.index') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-brand-50 hover:text-brand-700 border border-slate-200/70 text-slate-700 flex flex-col items-center justify-center gap-1.5 text-center transition-colors">
                <svg class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                <span>System Config</span>
            </a>
        </div>
    </div>
</div>
