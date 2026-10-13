<!-- ======================= LIVE SEARCH DROPDOWN ======================= -->
<div x-cloak 
     x-show="open" 
     x-ref="dropdown"
     x-transition:enter="transition ease-out duration-150"
     x-transition:enter-start="opacity-0 translate-y-1 scale-[0.99]"
     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
     x-transition:leave="transition ease-in duration-100"
     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
     x-transition:leave-end="opacity-0 translate-y-1 scale-[0.99]"
     class="absolute left-0 right-0 top-full mt-2 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md rounded-2xl shadow-2xl border border-slate-200/90 dark:border-slate-800 overflow-hidden z-50 divide-y divide-slate-100 dark:divide-slate-800/80">

    <!-- Results Scroll Container -->
    <div class="max-h-[26rem] overflow-y-auto p-2 space-y-3">

        <!-- Section: Quick Actions / Suggested Pages -->
        <template x-if="results.actions && results.actions.length > 0">
            <div class="space-y-1">
                <div class="px-3 py-1.5 flex items-center justify-between text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span x-text="query ? 'Matching Actions' : 'Quick Navigation & Shortcuts'"></span>
                    </span>
                </div>

                <template x-for="item in results.actions" :key="'action_' + item.title">
                    <div @click="navigate(item.url)"
                         @mouseenter="selectedIndex = getItemIndex('action_' + item.title)"
                         :data-selected="selectedIndex === getItemIndex('action_' + item.title)"
                         :class="selectedIndex === getItemIndex('action_' + item.title) ? 'bg-brand-50 dark:bg-brand-950/70 border-brand-200 dark:border-brand-800/80' : 'hover:bg-slate-50 dark:hover:bg-slate-800/60 border-transparent'"
                         class="flex items-center justify-between gap-3 px-3 py-2 rounded-xl border cursor-pointer transition-all group">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 rounded-lg bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                <template x-if="item.icon === 'dashboard'"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg></template>
                                <template x-if="item.icon === 'students'"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg></template>
                                <template x-if="item.icon === 'classes'"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg></template>
                                <template x-if="item.icon === 'attendance'"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg></template>
                                <template x-if="item.icon === 'departments'"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></template>
                                <template x-if="item.icon === 'settings'"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></template>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-800 dark:text-slate-100 truncate" x-text="item.title"></p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate" x-text="item.description"></p>
                            </div>
                        </div>
                        <span class="text-[10px] font-semibold text-slate-400 dark:text-slate-500 px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 flex-shrink-0" x-text="item.category"></span>
                    </div>
                </template>
            </div>
        </template>

        <!-- Section: Students -->
        <template x-if="results.students && results.students.length > 0">
            <div class="space-y-1">
                <div class="px-3 py-1.5 flex items-center justify-between text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5"/>
                        </svg>
                        <span>Students</span>
                    </span>
                    <span class="text-[10px] lowercase" x-text="results.students.length + ' found'"></span>
                </div>

                <template x-for="item in results.students" :key="'student_' + item.id">
                    <div @click="navigate(item.url)"
                         @mouseenter="selectedIndex = getItemIndex('student_' + item.id)"
                         :data-selected="selectedIndex === getItemIndex('student_' + item.id)"
                         :class="selectedIndex === getItemIndex('student_' + item.id) ? 'bg-brand-50 dark:bg-brand-950/70 border-brand-200 dark:border-brand-800/80' : 'hover:bg-slate-50 dark:hover:bg-slate-800/60 border-transparent'"
                         class="flex items-center justify-between gap-3 px-3 py-2 rounded-xl border cursor-pointer transition-all group">
                        <div class="flex items-center gap-3 min-w-0">
                            <img :src="item.avatar" :alt="item.title" class="w-8 h-8 rounded-lg object-cover ring-1 ring-slate-200 dark:ring-slate-700 flex-shrink-0">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <p class="text-xs font-bold text-slate-800 dark:text-slate-100 truncate" x-text="item.title"></p>
                                    <span class="text-[10px] font-mono font-medium px-1.5 py-0.2 rounded bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300" x-text="item.code"></span>
                                </div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate" x-text="item.subtitle"></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <span class="text-[10px] font-semibold text-slate-500 dark:text-slate-400 hidden sm:inline" x-text="item.meta"></span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full"
                                  :class="item.badge_type === 'emerald' ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/80' : (item.badge_type === 'rose' ? 'bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800/80' : (item.badge_type === 'brand' ? 'bg-brand-50 dark:bg-brand-950/60 text-brand-700 dark:text-brand-300 border border-brand-200 dark:border-brand-800/80' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400'))"
                                  x-text="item.badge">
                            </span>
                        </div>
                    </div>
                </template>
            </div>
        </template>

        <!-- Section: Academic Classes -->
        <template x-if="results.classes && results.classes.length > 0">
            <div class="space-y-1">
                <div class="px-3 py-1.5 flex items-center justify-between text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span>Academic Classes</span>
                    </span>
                    <span class="text-[10px] lowercase" x-text="results.classes.length + ' found'"></span>
                </div>

                <template x-for="item in results.classes" :key="'class_' + item.id">
                    <div @click="navigate(item.url)"
                         @mouseenter="selectedIndex = getItemIndex('class_' + item.id)"
                         :data-selected="selectedIndex === getItemIndex('class_' + item.id)"
                         :class="selectedIndex === getItemIndex('class_' + item.id) ? 'bg-brand-50 dark:bg-brand-950/70 border-brand-200 dark:border-brand-800/80' : 'hover:bg-slate-50 dark:hover:bg-slate-800/60 border-transparent'"
                         class="flex items-center justify-between gap-3 px-3 py-2 rounded-xl border cursor-pointer transition-all group">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 font-extrabold text-xs flex items-center justify-center flex-shrink-0 border border-indigo-200/80 dark:border-indigo-800/80" x-text="item.code"></div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-800 dark:text-slate-100 truncate" x-text="item.title"></p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate" x-text="item.subtitle"></p>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-brand-50 dark:bg-brand-950/60 text-brand-700 dark:text-brand-300 border border-brand-200 dark:border-brand-800/80 flex-shrink-0" x-text="item.badge"></span>
                    </div>
                </template>
            </div>
        </template>

        <!-- Section: Academic Departments -->
        <template x-if="results.departments && results.departments.length > 0">
            <div class="space-y-1">
                <div class="px-3 py-1.5 flex items-center justify-between text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Departments</span>
                    </span>
                    <span class="text-[10px] lowercase" x-text="results.departments.length + ' found'"></span>
                </div>

                <template x-for="item in results.departments" :key="'dept_' + item.id">
                    <div @click="navigate(item.url)"
                         @mouseenter="selectedIndex = getItemIndex('dept_' + item.id)"
                         :data-selected="selectedIndex === getItemIndex('dept_' + item.id)"
                         :class="selectedIndex === getItemIndex('dept_' + item.id) ? 'bg-brand-50 dark:bg-brand-950/70 border-brand-200 dark:border-brand-800/80' : 'hover:bg-slate-50 dark:hover:bg-slate-800/60 border-transparent'"
                         class="flex items-center justify-between gap-3 px-3 py-2 rounded-xl border cursor-pointer transition-all group">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 font-extrabold text-xs flex items-center justify-center flex-shrink-0 border border-emerald-200/80 dark:border-emerald-800/80" x-text="item.code"></div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-800 dark:text-slate-100 truncate" x-text="item.title"></p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate" x-text="item.subtitle"></p>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/80 flex-shrink-0" x-text="item.badge"></span>
                    </div>
                </template>
            </div>
        </template>

        <!-- Section: Courses -->
        <template x-if="results.courses && results.courses.length > 0">
            <div class="space-y-1">
                <div class="px-3 py-1.5 flex items-center justify-between text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span>Courses</span>
                    </span>
                    <span class="text-[10px] lowercase" x-text="results.courses.length + ' found'"></span>
                </div>

                <template x-for="item in results.courses" :key="'course_' + item.id">
                    <div @click="navigate(item.url)"
                         @mouseenter="selectedIndex = getItemIndex('course_' + item.id)"
                         :data-selected="selectedIndex === getItemIndex('course_' + item.id)"
                         :class="selectedIndex === getItemIndex('course_' + item.id) ? 'bg-brand-50 dark:bg-brand-950/70 border-brand-200 dark:border-brand-800/80' : 'hover:bg-slate-50 dark:hover:bg-slate-800/60 border-transparent'"
                         class="flex items-center justify-between gap-3 px-3 py-2 rounded-xl border cursor-pointer transition-all group">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 rounded-lg bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 font-extrabold text-xs flex items-center justify-center flex-shrink-0 border border-purple-200/80 dark:border-purple-800/80" x-text="item.code"></div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-800 dark:text-slate-100 truncate" x-text="item.title"></p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate" x-text="item.subtitle"></p>
                            </div>
                        </div>
                        <span class="text-[10px] font-semibold text-slate-500 dark:text-slate-400 flex-shrink-0" x-text="item.meta"></span>
                    </div>
                </template>
            </div>
        </template>

        <!-- Empty State -->
        <div x-cloak x-show="hasSearched && query.trim() && totalItems === 0 && !loading" class="py-8 px-4 text-center">
            <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 mx-auto flex items-center justify-center mb-3">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <p class="text-sm font-bold text-slate-800 dark:text-slate-200">No matching records found</p>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-xs mx-auto">
                No students, classes, or departments match "<span class="font-semibold text-slate-700 dark:text-slate-300" x-text="query"></span>".
            </p>
            <button type="button" 
                    @click="navigate('{{ route('students.index') }}?search=' + encodeURIComponent(query.trim()))"
                    class="mt-4 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-brand-50 dark:bg-brand-950/60 text-brand-600 dark:text-brand-400 hover:bg-brand-100 dark:hover:bg-brand-900/40 border border-brand-200 dark:border-brand-800/80 transition-colors">
                <span>Search in Student Directory</span>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </div>

    </div>

    <!-- Footer Bar with Keyboard Navigation Hints -->
    <div class="px-3.5 py-2 bg-slate-50/80 dark:bg-slate-900/90 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between text-[11px] text-slate-400 dark:text-slate-500">
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-1">
                <kbd class="px-1 py-0.2 rounded bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-[10px] font-mono">↑</kbd>
                <kbd class="px-1 py-0.2 rounded bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-[10px] font-mono">↓</kbd>
                <span>navigate</span>
            </span>
            <span class="inline-flex items-center gap-1">
                <kbd class="px-1.5 py-0.2 rounded bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-[10px] font-mono">↵</kbd>
                <span>select</span>
            </span>
            <span class="inline-flex items-center gap-1">
                <kbd class="px-1 py-0.2 rounded bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-[10px] font-mono">esc</kbd>
                <span>close</span>
            </span>
        </div>

        <template x-if="query.trim()">
            <button type="button" 
                    @click="navigate('{{ route('students.index') }}?search=' + encodeURIComponent(query.trim()))"
                    class="font-semibold text-brand-600 dark:text-brand-400 hover:underline flex items-center gap-1">
                <span>Full Search</span>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </template>
    </div>

</div>
