<!-- resources/views/classes/partials/grid.blade.php -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    <template x-for="cls in filteredClasses" :key="cls.id">
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200/90 dark:border-slate-800 shadow-xs hover:shadow-md transition-all flex flex-col justify-between group">
            
            <!-- Card Header -->
            <div>
                <div class="flex items-start justify-between gap-3 mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-brand-50 dark:bg-brand-950/60 text-brand-600 dark:text-brand-400 font-extrabold text-base flex items-center justify-center border border-brand-100/80 dark:border-brand-800/80 shadow-2xs group-hover:scale-105 group-hover:bg-brand-600 group-hover:text-white transition-all">
                            <span x-text="cls.code"></span>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-bold text-slate-900 dark:text-white text-base group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors" x-text="cls.name"></h3>
                            </div>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full inline-block"
                                      :class="cls.status === 'Active' ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200/80 dark:border-emerald-800/80' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700'"
                                      x-text="cls.status">
                                </span>
                            </div>

                            <!-- Assigned Room & Subject Badges -->
                            <div class="mt-2 flex flex-wrap items-center gap-1.5">
                                <template x-if="cls.room_number">
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-0.5 rounded-lg bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200/80 dark:border-purple-800/80" :title="'Room: ' + cls.room_number">
                                        <svg class="w-3 h-3 text-purple-500 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        <span x-text="cls.room_number"></span>
                                    </span>
                                </template>
                                <template x-if="cls.subject">
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-0.5 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200/80 dark:border-blue-800/80 truncate max-w-[190px]" :title="'Subject: ' + cls.subject">
                                        <svg class="w-3 h-3 text-blue-500 dark:text-blue-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        <span class="truncate" x-text="cls.subject"></span>
                                    </span>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Actions dropdown / buttons -->
                    <div class="flex items-center gap-1 text-slate-400 dark:text-slate-500">
                        <button type="button" @click="openEditModal(cls)" class="p-1.5 rounded-lg hover:text-brand-600 dark:hover:text-brand-400 hover:bg-brand-50 dark:hover:bg-slate-800 transition-colors" title="Edit Class">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </button>
                        <button type="button" @click="openDeleteModal(cls)" class="p-1.5 rounded-lg hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-slate-800 transition-colors" title="Delete Class">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Enrollment Summary Metric -->
                <div class="p-3.5 bg-slate-50/80 dark:bg-slate-800/60 rounded-2xl border border-slate-100 dark:border-slate-800 space-y-2 mb-4">
                    <div class="flex items-center justify-between text-xs font-semibold">
                        <span class="text-slate-500 dark:text-slate-400">Enrolled Students:</span>
                        <span class="text-slate-900 dark:text-white font-extrabold text-sm" x-text="(cls.students_count || (cls.students ? cls.students.length : 0)) + ' Students'"></span>
                    </div>

                    <!-- Mini avatar stack if students present -->
                    <div class="flex items-center gap-1.5 pt-1">
                        <template x-if="cls.students && cls.students.length > 0">
                            <div class="flex -space-x-2 overflow-hidden">
                                <template x-for="(st, idx) in cls.students.slice(0, 5)" :key="st.id">
                                    <img :src="st.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(st.name)" 
                                         :alt="st.name" 
                                         :title="st.name"
                                         class="inline-block w-7 h-7 rounded-full ring-2 ring-white dark:ring-slate-900 object-cover shadow-2xs">
                                </template>
                                <template x-if="cls.students.length > 5">
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full ring-2 ring-white dark:ring-slate-900 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-[10px] font-bold"
                                          x-text="'+' + (cls.students.length - 5)">
                                    </span>
                                </template>
                            </div>
                        </template>
                        <template x-if="!cls.students || cls.students.length === 0">
                            <span class="text-[11px] text-slate-400 dark:text-slate-500 italic">No students assigned yet</span>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Card Bottom Buttons -->
            <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center gap-2">
                <button type="button" 
                        @click="openAssignModal(cls)"
                        class="flex-1 py-2 px-3 rounded-xl text-xs font-bold bg-brand-50 dark:bg-brand-950/60 hover:bg-brand-100 dark:hover:bg-brand-900/60 text-brand-700 dark:text-brand-300 border border-brand-200/80 dark:border-brand-800/80 transition-colors flex items-center justify-center gap-1.5 shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    <span>Assign Students</span>
                </button>
                <button type="button" 
                        @click="openRosterModal(cls)"
                        class="py-2 px-3 rounded-xl text-xs font-semibold bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 transition-colors flex items-center justify-center gap-1 shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-slate-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span>Roster</span>
                </button>
            </div>
        </div>
    </template>

    <!-- Empty State -->
    <template x-if="filteredClasses.length === 0">
        <div class="col-span-full py-16 text-center bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-8 shadow-xs">
            <div class="w-14 h-14 rounded-2xl bg-brand-50 dark:bg-brand-950/60 text-brand-500 dark:text-brand-400 flex items-center justify-center mx-auto mb-3">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <h3 class="text-base font-bold text-slate-900 dark:text-white">No classes found</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-sm mx-auto">Create cohorts like SV1, SV7 or clear your search query to see active academic classes.</p>
            <button type="button" @click="openAddModal()" class="mt-4 px-4 py-2 rounded-xl text-xs font-bold text-white bg-brand-600 hover:bg-brand-700 shadow-md transition-all">
                + Create First Class
            </button>
        </div>
    </template>
</div>
