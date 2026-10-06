<!-- resources/views/students/partials/table.blade.php -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <!-- Table Header -->
            <thead>
                <tr class="bg-slate-50/90 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider select-none">
                    <th class="py-4 px-4 w-12 text-center">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   :checked="allSelected" 
                                   @change="toggleSelectAll()" 
                                   class="w-4 h-4 rounded text-brand-600 border-slate-300 focus:ring-brand-500 focus:ring-offset-0 transition">
                        </label>
                    </th>
                    <th class="py-4 px-5 min-w-[260px]">Student Details</th>
                    <th class="py-4 px-4 min-w-[130px]">Student ID</th>
                    <th class="py-4 px-4 min-w-[220px]">Contact Info</th>
                    <th class="py-4 px-4 min-w-[200px]">Course / Major</th>
                    <th class="py-4 px-4 min-w-[110px]">Status</th>
                    <th class="py-4 px-5 text-right min-w-[120px]">Actions</th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="divide-y divide-slate-100 text-sm">
                <template x-for="student in filteredStudents" :key="student.id">
                    <tr :class="selectedIds.includes(student.id) ? 'bg-brand-50/30' : 'hover:bg-slate-50/70'" 
                        class="transition-colors group">
                        
                        <!-- Checkbox -->
                        <td class="py-4 px-4 text-center">
                            <input type="checkbox" 
                                   :checked="selectedIds.includes(student.id)" 
                                   @click="toggleRowSelect(student.id)" 
                                   class="w-4 h-4 rounded text-brand-600 border-slate-300 focus:ring-brand-500 focus:ring-offset-0 transition cursor-pointer">
                        </td>

                        <!-- Student Info Column -->
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-3.5">
                                <div class="relative flex-shrink-0 cursor-pointer" @click="viewStudent(student)">
                                    <img :src="student.avatar" 
                                         :alt="student.name" 
                                         class="w-11 h-11 rounded-xl object-cover ring-2 ring-slate-100 group-hover:ring-brand-300 transition-all shadow-2xs">
                                    <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-white"
                                          :class="student.status === 'Active' ? 'bg-emerald-500' : 'bg-slate-400'">
                                    </span>
                                </div>
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2">
                                        <button @click="viewStudent(student)" 
                                                class="font-bold text-slate-900 group-hover:text-brand-600 transition-colors truncate text-sm text-left hover:underline">
                                            <span x-text="student.name"></span>
                                        </button>
                                        <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200"
                                              x-text="student.pronouns">
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2 mt-0.5 text-xs text-slate-400">
                                        <span x-text="student.gender"></span>
                                        <span>•</span>
                                        <span x-text="'Born ' + student.dob + ' (' + student.age + 'y)'"></span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Student ID Column -->
                        <td class="py-4 px-4">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-mono text-xs font-semibold border border-slate-200/80 group/id">
                                <span x-text="student.id"></span>
                                <button type="button" @click="navigator.clipboard.writeText(student.id); showToast('Copied ID ' + student.id, 'info')" 
                                        class="text-slate-400 hover:text-brand-600 transition-colors p-0.5 rounded" title="Copy Student ID">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                            </div>
                        </td>

                        <!-- Contact Info Column -->
                        <td class="py-4 px-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-1.5 text-xs text-slate-700">
                                    <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <a :href="'mailto:' + student.email" class="hover:text-brand-600 hover:underline truncate" x-text="student.email"></a>
                                </div>
                                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                    <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span x-text="student.phone"></span>
                                </div>
                            </div>
                        </td>

                        <!-- Course / Major Column -->
                        <td class="py-4 px-4">
                            <div>
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50/70 text-brand-700 border border-brand-100">
                                    <span x-text="student.major"></span>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1 truncate" x-text="student.degree"></p>
                            </div>
                        </td>

                        <!-- Status Column -->
                        <td class="py-4 px-4">
                            <template x-if="student.status === 'Active'">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60 shadow-2xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 ring-4 ring-emerald-500/20"></span>
                                    <span>Active</span>
                                </span>
                            </template>
                            <template x-if="student.status === 'Inactive'">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    <span>Inactive</span>
                                </span>
                            </template>
                        </td>

                        <!-- Actions Column -->
                        <td class="py-4 px-5 text-right">
                            <div class="inline-flex items-center gap-1">
                                <button type="button" @click="viewStudent(student)" 
                                        class="p-2 text-slate-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-colors" 
                                        title="View Student Dossier">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>

                                <button type="button" @click="openEditModal(student)" 
                                        class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" 
                                        title="Edit Records">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>

                                <button type="button" @click="confirmDelete(student)" 
                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" 
                                        title="Delete Record">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>

                <!-- Empty State -->
                <tr x-show="filteredStudents.length === 0">
                    <td colspan="7" class="py-12 text-center">
                        <div class="max-w-sm mx-auto">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800">No student records found</h3>
                            <p class="text-xs text-slate-500 mt-1">Try adjusting your search queries or clearing active filters.</p>
                            <button type="button" 
                                    @click="searchQuery = ''; selectedMajor = 'All'; selectedStatus = 'All'" 
                                    class="mt-3 px-3 py-1.5 rounded-lg text-xs font-semibold bg-brand-50 text-brand-600 hover:bg-brand-100 transition-colors">
                                Clear all filters
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Table Footer / Pagination -->
    <div class="p-4 sm:px-6 bg-slate-50/70 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-xs text-slate-500 font-medium">
            Showing <span class="font-bold text-slate-800">1</span> to <span class="font-bold text-slate-800" x-text="filteredStudents.length"></span> of <span class="font-bold text-slate-800" x-text="students.length"></span> total student entries
        </div>

        @include('components.share.pagination')
    </div>
</div>
