<!-- resources/views/dashboard/partials/sidebar-cards.blade.php -->
<div class="space-y-6">
    <!-- Active Cohorts Quick View -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs overflow-hidden transition-colors">
        <div class="p-5 border-b border-slate-100 dark:border-slate-800/80 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">Active Cohorts & Rooms</h3>
                @if(isset($recentClasses) && count($recentClasses) > 0)
                    <span class="text-[11px] font-semibold text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-950/60 px-2 py-0.5 rounded-full border border-indigo-100 dark:border-indigo-800/80">
                        {{ count($recentClasses) }}
                    </span>
                @endif
            </div>
            <a href="{{ route('classes.index') }}" class="text-xs font-semibold text-brand-600 dark:text-brand-400 hover:text-brand-700 dark:hover:text-brand-300 inline-flex items-center gap-1 group">
                <span>View All</span>
                <span class="group-hover:translate-x-0.5 transition-transform">&rarr;</span>
            </a>
        </div>

        <div class="p-4 space-y-2.5">
            @forelse($recentClasses ?? [] as $cls)
                <div class="p-3 rounded-xl bg-slate-50/70 dark:bg-slate-800/60 hover:bg-slate-50 dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-700/60 flex items-center justify-between gap-3 transition-colors">
                    <div class="min-w-0">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <span class="font-extrabold text-xs text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-950/60 px-2 py-0.5 rounded-md border border-indigo-100 dark:border-indigo-800/80">
                                {{ $cls->code }}
                            </span>
                            @if($cls->room_number)
                                <span class="text-[11px] font-semibold text-purple-700 dark:text-purple-300 bg-purple-50 dark:bg-purple-950/60 px-1.5 py-0.5 rounded border border-purple-100 dark:border-purple-800/80 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-purple-500 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    Rm. {{ $cls->room_number }}
                                </span>
                            @endif
                        </div>
                        <p class="text-xs font-medium text-slate-700 dark:text-slate-200 truncate mt-1">
                            {{ $cls->subject ?: $cls->name }}
                        </p>
                    </div>

                    <div class="shrink-0 text-right">
                        <span class="inline-flex items-center px-2 py-1 rounded-lg text-[11px] font-bold bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-600 shadow-2xs">
                            {{ $cls->students_count }} {{ Str::plural('Student', $cls->students_count) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="py-6 text-center text-xs text-slate-400 dark:text-slate-500">
                    No active cohorts configured.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Admin Shortcuts -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs overflow-hidden transition-colors">
        <div class="p-5 border-b border-slate-100 dark:border-slate-800/80">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Admin Quick Actions</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Frequent administrative tasks and tools.</p>
        </div>

        <div class="p-4 grid grid-cols-2 gap-2.5">
            <a href="{{ route('students.create') }}" 
               class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 hover:bg-brand-50/50 dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-700/60 hover:border-brand-200 dark:hover:border-slate-600 flex flex-col items-center justify-center text-center transition-all group">
                <div class="w-9 h-9 rounded-xl bg-brand-50 dark:bg-brand-950/60 text-brand-600 dark:text-brand-400 flex items-center justify-center mb-2 group-hover:scale-105 transition-transform">
                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-brand-700 dark:group-hover:text-brand-300">Enroll Student</span>
                <span class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">New admission</span>
            </a>

            <a href="{{ route('classes.index') }}" 
               class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 hover:bg-indigo-50/50 dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-700/60 hover:border-indigo-200 dark:hover:border-slate-600 flex flex-col items-center justify-center text-center transition-all group">
                <div class="w-9 h-9 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mb-2 group-hover:scale-105 transition-transform">
                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-indigo-700 dark:group-hover:text-indigo-300">Cohorts & Rooms</span>
                <span class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">Manage classes</span>
            </a>

            <a href="{{ route('attendance.index') }}" 
               class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 hover:bg-emerald-50/50 dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-700/60 hover:border-emerald-200 dark:hover:border-slate-600 flex flex-col items-center justify-center text-center transition-all group">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mb-2 group-hover:scale-105 transition-transform">
                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-emerald-700 dark:group-hover:text-emerald-300">Roll Call</span>
                <span class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">Record attendance</span>
            </a>

            <a href="{{ route('settings.index') }}" 
               class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-700/60 hover:border-slate-300 dark:hover:border-slate-600 flex flex-col items-center justify-center text-center transition-all group">
                <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-700/80 text-slate-600 dark:text-slate-300 flex items-center justify-center mb-2 group-hover:scale-105 transition-transform">
                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-slate-900 dark:group-hover:text-white">Settings</span>
                <span class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">Configuration</span>
            </a>
        </div>
    </div>
</div>
