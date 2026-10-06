<!-- resources/views/grades/partials/table.blade.php -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/90 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                    <th class="py-4 px-5">Student</th>
                    <th class="py-4 px-4">Course Module</th>
                    <th class="py-4 px-4">Mid-Term</th>
                    <th class="py-4 px-4">Final Exam</th>
                    <th class="py-4 px-4">Letter Grade</th>
                    <th class="py-4 px-4">Course GPA</th>
                    <th class="py-4 px-4 text-center">Academic Standing</th>
                    <th class="py-4 px-5 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                <template x-for="rec in filteredRecords" :key="rec.id">
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="py-4 px-5">
                            <p class="font-bold text-slate-900" x-text="rec.name"></p>
                            <p class="text-xs text-slate-400 font-mono" x-text="rec.id"></p>
                        </td>
                        <td class="py-4 px-4 text-xs font-semibold text-slate-700" x-text="rec.course"></td>
                        <td class="py-4 px-4 text-xs font-mono font-medium text-slate-800" x-text="rec.midScore + ' / 100'"></td>
                        <td class="py-4 px-4 text-xs font-mono font-medium text-slate-800" x-text="rec.finalScore + ' / 100'"></td>
                        <td class="py-4 px-4">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold font-mono"
                                  :class="{
                                      'bg-emerald-50 text-emerald-700 border border-emerald-200': rec.grade.startsWith('A'),
                                      'bg-blue-50 text-brand-700 border border-brand-200': rec.grade.startsWith('B'),
                                      'bg-amber-50 text-amber-700 border border-amber-200': rec.grade.startsWith('C')
                                  }" x-text="rec.grade"></span>
                        </td>
                        <td class="py-4 px-4 font-mono font-bold text-xs text-slate-900" x-text="rec.gpa"></td>
                        <td class="py-4 px-4 text-center">
                            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full"
                                  :class="rec.standing === 'Dean\'s Honors' ? 'bg-purple-50 text-purple-700 border border-purple-200' : (rec.standing === 'Good Standing' ? 'bg-slate-100 text-slate-700' : 'bg-rose-50 text-rose-700 border border-rose-200')"
                                  x-text="rec.standing"></span>
                        </td>
                        <td class="py-4 px-5 text-right">
                            <button type="button" 
                                    @click="auditRecord(rec)" 
                                    class="p-1.5 text-slate-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-colors"
                                    title="Audit Marks">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                </template>

                <!-- Empty State -->
                <tr x-show="filteredRecords.length === 0">
                    <td colspan="8" class="py-12 text-center">
                        <div class="max-w-sm mx-auto">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-sm font-bold text-slate-800">No student records match</h3>
                            <p class="text-xs text-slate-500 mt-1">Try searching by student name, ID number, or course title.</p>
                            <button type="button" 
                                    @click="searchQuery = ''; selectedStanding = 'All'" 
                                    class="mt-3 px-3 py-1.5 rounded-lg text-xs font-semibold bg-brand-50 text-brand-600 hover:bg-brand-100 transition-colors">
                                Reset Filters
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Table Footer Summary -->
    <div class="p-4 sm:px-6 bg-slate-50/70 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500 font-medium">
        <div>
            Showing <strong class="text-slate-800" x-text="filteredRecords.length"></strong> recorded examination grades
        </div>
        <div class="flex items-center gap-3">
            <span>Average Module GPA: <strong class="text-slate-800">3.67</strong></span>
        </div>

        @include('components.share.pagination')
    </div>
</div>
