<!-- resources/views/settings/partials/term-config.blade.php -->
<div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-5 transition-colors">
    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800/80 pb-4">
        <div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Academic Term Window Configuration</h3>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Defines the active registration trimester, week timeline, and institution schedules.</p>
        </div>
        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
            Active Term
        </span>
    </div>

    <form action="{{ route('settings.term.update') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="term_name" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Term Name</label>
                <input type="text" 
                       id="term_name" 
                       name="term_name" 
                       value="{{ old('term_name', $term['name'] ?? 'Fall Semester 2026') }}" 
                       required
                       class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 focus:outline-hidden text-slate-800 dark:text-slate-100 font-medium">
            </div>
            <div>
                <label for="term_week" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Current Academic Week</label>
                <input type="text" 
                       id="term_week" 
                       name="term_week" 
                       value="{{ old('term_week', $term['week'] ?? 'Week 8') }}" 
                       required
                       class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 focus:outline-hidden text-slate-800 dark:text-slate-100 font-medium">
            </div>
            <div>
                <label for="term_start_date" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Semester Start Date</label>
                <input type="date" 
                       id="term_start_date" 
                       name="term_start_date" 
                       value="{{ old('term_start_date', $term['startDate'] ?? '2026-08-25') }}" 
                       class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 focus:outline-hidden text-slate-800 dark:text-slate-100">
            </div>
            <div>
                <label for="term_end_date" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Semester End Date</label>
                <input type="date" 
                       id="term_end_date" 
                       name="term_end_date" 
                       value="{{ old('term_end_date', $term['endDate'] ?? '2026-12-18') }}" 
                       class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 focus:outline-hidden text-slate-800 dark:text-slate-100">
            </div>
        </div>

        <div class="pt-3 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-end">
            <button type="submit" 
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 transition-colors shadow-2xs">
                <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                <span>Save Term Window</span>
            </button>
        </div>
    </form>
</div>
