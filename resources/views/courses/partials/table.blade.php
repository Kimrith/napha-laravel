<!-- resources/views/courses/partials/table.blade.php -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/90 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                    <th class="py-4 px-5">Course Code</th>
                    <th class="py-4 px-5">Course Title & Department</th>
                    <th class="py-4 px-4">Instructor</th>
                    <th class="py-4 px-4">Credits</th>
                    <th class="py-4 px-4">Enrolled / Cap</th>
                    <th class="py-4 px-4">Schedule & Room</th>
                    <th class="py-4 px-4">Status</th>
                    <th class="py-4 px-5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                <template x-for="course in paginatedCourses" :key="course.code">
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <!-- Course Code -->
                        <td class="py-4 px-5">
                            <span class="px-2.5 py-1 rounded-lg bg-brand-50 text-brand-700 font-mono text-xs font-bold border border-brand-200/60" 
                                  x-text="course.code"></span>
                        </td>

                        <!-- Course Title & Department -->
                        <td class="py-4 px-5">
                            <p class="font-bold text-slate-900" x-text="course.name"></p>
                            <p class="text-xs text-slate-400 mt-0.5" x-text="course.dept"></p>
                        </td>

                        <!-- Instructor -->
                        <td class="py-4 px-4 text-xs font-semibold text-slate-700" x-text="course.instructor"></td>

                        <!-- Credits -->
                        <td class="py-4 px-4 text-xs font-bold text-slate-900" x-text="course.credits + ' ECTS'"></td>

                        <!-- Capacity & Progress Bar -->
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold text-slate-800" x-text="course.enrolled + '/' + course.capacity"></span>
                                <div class="w-16 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="h-1.5 rounded-full" 
                                         :class="course.enrolled >= course.capacity ? 'bg-amber-500' : 'bg-brand-500'" 
                                         :style="'width: ' + Math.min(100, Math.round((course.enrolled / course.capacity) * 100)) + '%'"></div>
                                </div>
                            </div>
                        </td>

                        <!-- Schedule & Room -->
                        <td class="py-4 px-4">
                            <p class="text-xs font-medium text-slate-700" x-text="course.days"></p>
                            <p class="text-[11px] text-slate-400 font-mono" x-text="course.room"></p>
                        </td>

                        <!-- Status Badge -->
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold"
                                  :class="{
                                      'bg-amber-50 text-amber-700 border border-amber-200': course.status === 'Full',
                                      'bg-emerald-50 text-emerald-700 border border-emerald-200': course.status === 'Active',
                                      'bg-indigo-50 text-indigo-700 border border-indigo-200': course.status === 'Upcoming'
                                  }">
                                <span class="w-1.5 h-1.5 rounded-full" 
                                      :class="{
                                          'bg-amber-500': course.status === 'Full',
                                          'bg-emerald-500': course.status === 'Active',
                                          'bg-indigo-500': course.status === 'Upcoming'
                                      }"></span>
                                <span x-text="course.status"></span>
                            </span>
                        </td>

                        <!-- Action Buttons -->
                        <td class="py-4 px-5 text-right">
                            <div class="inline-flex items-center gap-1">
                                <button type="button" 
                                        @click="openEditModal(course)" 
                                        class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" 
                                        title="Edit Course">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>
                                <button type="button" 
                                        @click="confirmDelete(course)" 
                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" 
                                        title="Delete Course">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>

                <!-- Empty State -->
                <tr x-show="filteredCourses.length === 0">
                    <td colspan="8" class="py-12 text-center">
                        <div class="max-w-sm mx-auto">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800">No courses found</h3>
                            <p class="text-xs text-slate-500 mt-1">Try adjusting your search queries or clearing active filters.</p>
                            <button type="button" 
                                    @click="searchQuery = ''; selectedDepartment = 'All'; selectedStatus = 'All'" 
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
            Showing 
            <span class="font-bold text-slate-800" x-text="filteredCourses.length > 0 ? (currentPage - 1) * perPage + 1 : 0"></span> 
            to 
            <span class="font-bold text-slate-800" x-text="Math.min(currentPage * perPage, filteredCourses.length)"></span> 
            of 
            <span class="font-bold text-slate-800" x-text="filteredCourses.length"></span> 
            course entries
        </div>

        @include('components.share.pagination')
    </div>
</div>
