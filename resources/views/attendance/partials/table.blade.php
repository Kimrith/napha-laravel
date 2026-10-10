<!-- resources/views/attendance/partials/table.blade.php -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
    <!-- Sub-header & Live Filter Bar -->
    <div class="p-4 border-b border-slate-100 flex flex-col lg:flex-row items-center justify-between gap-4 bg-slate-50/50">
        <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
            <!-- Date Filter -->
            <div class="flex items-center gap-1.5">
                <span class="text-xs font-semibold text-slate-500">Date:</span>
                <input type="date" 
                       x-model="selectedDate" 
                       @change="applyFilters()" 
                       class="text-xs font-medium border border-slate-200 rounded-lg px-2.5 py-1.5 focus:ring-brand-500 focus:border-brand-500 bg-white shadow-2xs">
            </div>

            <!-- Course Filter -->
            <div class="flex items-center gap-1.5">
                <span class="text-xs font-semibold text-slate-500">Course:</span>
                <select x-model="selectedCourseId" 
                        @change="applyFilters()" 
                        class="text-xs font-medium border border-slate-200 rounded-lg px-2.5 py-1.5 focus:ring-brand-500 focus:border-brand-500 bg-white shadow-2xs max-w-[220px]">
                    <option value="All">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ (string)$selectedCourseId === (string)$course->id ? 'selected' : '' }}>
                            {{ $course->code }} · {{ $course->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div class="flex items-center gap-1.5">
                <span class="text-xs font-semibold text-slate-500">Status:</span>
                <select x-model="selectedStatus" 
                        @change="applyFilters()" 
                        class="text-xs font-medium border border-slate-200 rounded-lg px-2.5 py-1.5 focus:ring-brand-500 focus:border-brand-500 bg-white shadow-2xs">
                    <option value="All">All Statuses</option>
                    <option value="Present">Present</option>
                    <option value="Late">Late</option>
                    <option value="Excused">Excused</option>
                    <option value="Absent">Absent</option>
                </select>
            </div>
        </div>

        <div class="flex items-center gap-3 w-full lg:w-auto justify-end">
            <!-- Quick search filter -->
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" 
                       x-model="searchQuery" 
                       placeholder="Filter roster students..." 
                       class="w-full text-xs border border-slate-200 rounded-lg pl-8 pr-3 py-1.5 focus:ring-brand-500 focus:border-brand-500 bg-white shadow-2xs">
            </div>
            <span class="text-[11px] text-slate-400 font-medium hidden sm:inline whitespace-nowrap">(Click badge to cycle status)</span>
        </div>
    </div>

    <!-- Table Roster -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/90 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                    <th class="py-4 px-5">Student</th>
                    <th class="py-4 px-4">Academic Program</th>
                    <th class="py-4 px-4">Course Session</th>
                    <th class="py-4 px-4">Recorded Time</th>
                    <th class="py-4 px-5 text-center">Status</th>
                    <th class="py-4 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                <template x-for="att in filteredAttendees" :key="att.record_id">
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <!-- Student Column -->
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-3">
                                <img :src="att.avatar" :alt="att.name" class="w-9 h-9 rounded-xl object-cover border border-slate-200 shadow-2xs shrink-0">
                                <div>
                                    <div class="font-bold text-slate-900" x-text="att.name"></div>
                                    <div class="font-mono text-xs text-slate-400" x-text="att.id"></div>
                                </div>
                            </div>
                        </td>

                        <!-- Program Column -->
                        <td class="py-4 px-4">
                            <div class="font-medium text-slate-800 text-xs" x-text="att.major"></div>
                            <div class="text-[11px] text-slate-400" x-text="att.department"></div>
                        </td>

                        <!-- Course Column -->
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200" x-text="att.course_code"></span>
                            <div class="text-[11px] text-slate-400 mt-0.5 truncate max-w-[140px]" x-text="att.course_name"></div>
                        </td>

                        <!-- Time In Column -->
                        <td class="py-4 px-4 font-mono text-xs text-slate-600">
                            <span class="inline-flex items-center gap-1.5" :class="att.timeIn === '--:--' ? 'text-slate-400 italic' : 'text-slate-700 font-medium'">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span x-text="att.timeIn"></span>
                            </span>
                        </td>

                        <!-- Status Badge (Interactive Toggle) -->
                        <td class="py-4 px-5 text-center">
                            <button type="button" 
                                    @click="toggleStatus(att)" 
                                    title="Click to toggle: Present -> Late -> Excused -> Absent"
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold cursor-pointer transition-all hover:scale-105 active:scale-95 shadow-2xs"
                                    :class="{
                                        'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100': att.status === 'Present',
                                        'bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100': att.status === 'Late',
                                        'bg-brand-50 text-brand-700 border border-brand-200 hover:bg-brand-100': att.status === 'Excused',
                                        'bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100': att.status === 'Absent'
                                    }">
                                <span class="w-1.5 h-1.5 rounded-full"
                                      :class="{
                                          'bg-emerald-500': att.status === 'Present',
                                          'bg-amber-500': att.status === 'Late',
                                          'bg-brand-500': att.status === 'Excused',
                                          'bg-rose-500': att.status === 'Absent'
                                      }"></span>
                                <span x-text="att.status"></span>
                            </button>
                        </td>

                        <!-- Delete Record Column -->
                        <td class="py-4 px-4 text-right">
                            <button type="button" 
                                    @click="deleteRecord(att)" 
                                    title="Delete attendance log"
                                    class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                </template>

                <!-- Empty State -->
                <tr x-show="filteredAttendees.length === 0">
                    <td colspan="6" class="py-12 text-center">
                        <div class="max-w-md mx-auto space-y-3">
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-slate-800">No attendance entries recorded</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                No roll-call entries were found for date <strong class="text-slate-700" x-text="selectedDate"></strong>. You can initialize roll-call for all enrolled students or log a single entry manually.
                            </p>
                            <div class="pt-2 flex items-center justify-center gap-3">
                                <button type="button" 
                                        @click="initializeSession()" 
                                        :disabled="isSubmitting"
                                        class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-brand-600 hover:bg-brand-700 shadow-sm transition-all inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    <span>Initialize Session Roll-Call</span>
                                </button>
                                <button type="button" 
                                        @click="logModalOpen = true" 
                                        class="px-4 py-2 rounded-xl text-xs font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition-all">
                                    + Add Single Entry
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Table Footer Summary -->
    <div class="p-4 sm:px-6 bg-slate-50/70 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500 font-medium">
        <div>
            Active Roster Size: <strong class="text-slate-800" x-text="filteredAttendees.length"></strong> students
        </div>
        <div class="flex items-center gap-4">
            <span class="inline-flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Present: <strong class="text-slate-800" x-text="counts.present"></strong>
            </span>
            <span class="inline-flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span> Late: <strong class="text-slate-800" x-text="counts.late"></strong>
            </span>
            <span class="inline-flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-brand-500"></span> Excused: <strong class="text-slate-800" x-text="counts.excused"></strong>
            </span>
            <span class="inline-flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-rose-500"></span> Absent: <strong class="text-slate-800" x-text="counts.absent"></strong>
            </span>
        </div>
        <div class="text-slate-400 text-[11px]">
            Real-time SQLite Sync
        </div>
    </div>
</div>
