<!-- resources/views/students/partials/table.blade.php -->
<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <!-- Table Header -->
            <thead>
                <tr
                    class="bg-slate-50/90 dark:bg-slate-800/80 border-b border-slate-200/80 dark:border-slate-800 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider select-none">
                    <th class="py-4 px-4 w-12 text-center">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" :checked="allSelected" @change="toggleSelectAll()"
                                class="w-4 h-4 rounded text-brand-600 border-slate-300 dark:border-slate-600 dark:bg-slate-800 focus:ring-brand-500 focus:ring-offset-0 transition">
                        </label>
                    </th>
                    <th class="py-4 px-5 min-w-[260px]">Student Details</th>
                    <th class="py-4 px-4 min-w-[170px]">Class / Room / Subject</th>
                    <th class="py-4 px-4 min-w-[130px]">Student ID</th>
                    <th class="py-4 px-4 min-w-[220px]">Contact Info</th>
                    <th class="py-4 px-4 min-w-[200px]">Department & Major</th>
                    <th class="py-4 px-4 min-w-[110px]">Status</th>
                    <th class="py-4 px-5 text-right min-w-[120px]">Actions</th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                <template x-for="student in paginatedStudents" :key="student.id">
                    <tr :class="selectedIds.includes(student.id) ? 'bg-brand-50/30 dark:bg-brand-950/30' : 'hover:bg-slate-50/70 dark:hover:bg-slate-800/50'"
                        class="transition-colors group">

                        <!-- Checkbox -->
                        <td class="py-4 px-4 text-center">
                            <input type="checkbox" :checked="selectedIds.includes(student.id)"
                                @click="toggleRowSelect(student.id)"
                                class="w-4 h-4 rounded text-brand-600 border-slate-300 dark:border-slate-600 dark:bg-slate-800 focus:ring-brand-500 focus:ring-offset-0 transition cursor-pointer">
                        </td>

                        <!-- Student Info Column -->
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-3.5">
                                <div class="relative flex-shrink-0 cursor-pointer" @click="viewStudent(student)">
                                    <img :src="student.avatar" :alt="student.name"
                                        class="w-11 h-11 rounded-xl object-cover ring-2 ring-slate-100 dark:ring-slate-800 group-hover:ring-brand-300 dark:group-hover:ring-brand-600 transition-all shadow-2xs">
                                    <span
                                        class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-white dark:border-slate-900"
                                        :class="student.status === 'Active' ? 'bg-emerald-500' : 'bg-slate-400'">
                                    </span>
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2">
                                        <button @click="viewStudent(student)"
                                            class="font-bold text-slate-900 dark:text-white group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors truncate text-sm text-left hover:underline">
                                            <span x-text="student.name"></span>
                                        </button>
                                        <span
                                            class="text-[10px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700"
                                            x-text="student.pronouns">
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2 mt-0.5 text-xs text-slate-400 dark:text-slate-500">
                                        <span x-text="student.gender"></span>
                                        <template x-if="student.dob">
                                            <span>•</span>
                                        </template>
                                        <template x-if="student.dob">
                                            <span x-text="'Born ' + student.dob + (student.age ? ' (' + student.age + 'y)' : '')"></span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Class Cohort Column -->
                        <td class="py-4 px-4">
                            <template x-if="student.class_code && student.class_code !== 'Unassigned'">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-xs font-bold bg-amber-50 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300 border border-amber-200/80 dark:border-amber-800/80 shadow-2xs">
                                            <svg class="w-3.5 h-3.5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                            <span x-text="student.class_code"></span>
                                        </span>
                                        <template x-if="student.room_number && student.room_number !== 'N/A'">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-[11px] font-semibold bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200/80 dark:border-purple-800/80" :title="'Room: ' + student.room_number">
                                                <svg class="w-3 h-3 text-purple-500 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                <span x-text="student.room_number"></span>
                                            </span>
                                        </template>
                                    </div>
                                    <template x-if="student.subject && student.subject !== 'N/A'">
                                        <div class="text-[11px] font-medium text-slate-600 dark:text-slate-400 flex items-center gap-1 truncate max-w-[190px]" :title="'Subject: ' + student.subject">
                                            <svg class="w-3 h-3 text-slate-400 dark:text-slate-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                            <span class="truncate" x-text="student.subject"></span>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="!student.class_code || student.class_code === 'Unassigned'">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    <span>Unassigned</span>
                                </span>
                            </template>
                        </td>

                        <!-- Student ID Column -->
                        <td class="py-4 px-4">
                            <div
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-mono text-xs font-semibold border border-slate-200/80 dark:border-slate-700 group/id">
                                <span x-text="student.id"></span>
                                <button type="button"
                                    @click="navigator.clipboard.writeText(student.id); showToast('Copied ID ' + student.id, 'info')"
                                    class="text-slate-400 dark:text-slate-500 hover:text-brand-600 dark:hover:text-brand-400 transition-colors p-0.5 rounded"
                                    title="Copy Student ID">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </td>

                        <!-- Contact Info Column -->
                        <td class="py-4 px-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-1.5 text-xs text-slate-700 dark:text-slate-300">
                                    <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500 flex-shrink-0" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <a :href="'mailto:' + student.email"
                                        class="hover:text-brand-600 dark:hover:text-brand-400 hover:underline truncate"
                                        x-text="student.email"></a>
                                </div>
                                <div class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400">
                                    <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500 flex-shrink-0" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span x-text="student.phone || 'N/A'"></span>
                                </div>
                            </div>
                        </td>

                        <!-- Department & Major Column -->
                        <td class="py-4 px-4">
                            <div>
                                <div
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50/70 dark:bg-indigo-950/60 text-brand-700 dark:text-brand-300 border border-brand-100 dark:border-brand-800/80">
                                    <span x-text="student.major"></span>
                                </div>
                                <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 truncate" x-text="student.department ? 'Dept: ' + student.department : (student.degree || '')"></div>
                                <template x-if="student.advisor && student.advisor !== 'Unassigned'">
                                    <div class="text-[10px] text-slate-400 dark:text-slate-500 mt-0.5 truncate" x-text="'Advisor: ' + student.advisor"></div>
                                </template>
                            </div>
                        </td>

                        <!-- Status Column -->
                        <td class="py-4 px-4">
                            <template x-if="student.status === 'Active'">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/80 shadow-2xs">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full bg-emerald-500 ring-4 ring-emerald-500/20"></span>
                                    <span>Active</span>
                                </span>
                            </template>
                            <template x-if="student.status === 'Inactive'">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    <span>Inactive</span>
                                </span>
                            </template>
                        </td>

                        <!-- Actions Column -->
                        <td class="py-4 px-5 text-right">
                            <div class="inline-flex items-center gap-1">
                                <button type="button" @click="viewStudent(student)"
                                    class="p-2 text-slate-400 dark:text-slate-500 hover:text-brand-600 dark:hover:text-brand-400 hover:bg-brand-50 dark:hover:bg-slate-800 rounded-lg transition-colors"
                                    title="View Student Dossier">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>

                                <button type="button" @click="openEditModal(student)"
                                    class="p-2 text-slate-400 dark:text-slate-500 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-amber-50 dark:hover:bg-slate-800 rounded-lg transition-colors"
                                    title="Edit Records">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>

                                <button type="button" @click="confirmDelete(student)"
                                    class="p-2 text-slate-400 dark:text-slate-500 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-slate-800 rounded-lg transition-colors"
                                    title="Delete Record">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>

                <!-- Empty State -->
                <tr x-show="filteredStudents.length === 0">
                    <td colspan="8" class="py-12 text-center">
                        <div class="max-w-sm mx-auto">
                            <div
                                class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800 dark:text-white">No student records found</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Try adjusting your search queries or clearing active
                                filters.</p>
                            <button type="button"
                                @click="searchQuery = ''; selectedClass = 'All'; selectedDepartment = 'All'; selectedMajor = 'All'; selectedStatus = 'All'"
                                class="mt-3 px-3 py-1.5 rounded-lg text-xs font-semibold bg-brand-50 dark:bg-brand-950/60 text-brand-600 dark:text-brand-400 hover:bg-brand-100 dark:hover:bg-brand-900/60 transition-colors">
                                Clear all filters
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Table Footer / Pagination -->
    <div
        class="p-4 sm:px-6 bg-slate-50/70 dark:bg-slate-900/70 border-t border-slate-200/80 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 dark:text-slate-400 font-medium">
            <div>
                Showing <span class="font-bold text-slate-800 dark:text-slate-200" x-text="filteredStudents.length > 0 ? (currentPage - 1) * perPage + 1 : 0"></span>
                to <span class="font-bold text-slate-800 dark:text-slate-200" x-text="Math.min(currentPage * perPage, filteredStudents.length)"></span>
                of <span class="font-bold text-slate-800 dark:text-slate-200" x-text="filteredStudents.length"></span> student entries
            </div>

            <div class="flex items-center gap-1.5 sm:border-l sm:border-slate-200 dark:sm:border-slate-800 sm:pl-4">
                <span class="text-slate-400 dark:text-slate-500">Per page:</span>
                <select x-model.number="perPage" @change="currentPage = 1" class="px-2 py-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md text-xs font-semibold text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-1 focus:ring-brand-500 cursor-pointer">
                    <option :value="5">5</option>
                    <option :value="10">10</option>
                    <option :value="25">25</option>
                    <option :value="50">50</option>
                </select>
            </div>
        </div>

        @include('components.share.pagination')
    </div>
</div>