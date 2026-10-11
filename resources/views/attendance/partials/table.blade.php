<!-- resources/views/attendance/partials/table.blade.php -->
<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs overflow-hidden">
    <!-- Sub-header & Live Filter Bar -->
    <div class="p-4 border-b border-slate-100 dark:border-slate-800 flex flex-col lg:flex-row items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900/60">
        <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
            <!-- Date Filter -->
            <div class="flex items-center gap-1.5">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Date:</span>
                <input type="date" 
                       x-model="selectedDate" 
                       @change="applyFilters()" 
                       class="text-xs font-medium border border-slate-200 dark:border-slate-700 rounded-lg px-2.5 py-1.5 focus:ring-brand-500 focus:border-brand-500 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 shadow-2xs">
            </div>

            <!-- Class Filter -->
            <div class="flex items-center gap-1.5">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Class:</span>
                <select x-model="selectedClassId" 
                        @change="applyFilters()" 
                        class="text-xs font-medium border border-slate-200 dark:border-slate-700 rounded-lg px-2.5 py-1.5 focus:ring-brand-500 focus:border-brand-500 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 shadow-2xs max-w-[220px]">
                    <option value="All">All Classes</option>
                    @foreach($classes ?? [] as $class)
                        <option value="{{ $class->id }}" {{ (string)($selectedClassId ?? 'All') === (string)$class->id ? 'selected' : '' }}>
                            {{ $class->code }} · {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div class="flex items-center gap-1.5">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Status:</span>
                <select x-model="selectedStatus" 
                        @change="applyFilters()" 
                        class="text-xs font-medium border border-slate-200 dark:border-slate-700 rounded-lg px-2.5 py-1.5 focus:ring-brand-500 focus:border-brand-500 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 shadow-2xs">
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
                <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" 
                       x-model="searchQuery" 
                       placeholder="Filter roster students..." 
                       class="w-full text-xs border border-slate-200 dark:border-slate-700 rounded-lg pl-8 pr-3 py-1.5 focus:ring-brand-500 focus:border-brand-500 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 shadow-2xs placeholder-slate-400 dark:placeholder-slate-500">
            </div>
            <span class="text-[11px] text-slate-400 dark:text-slate-500 font-medium hidden sm:inline whitespace-nowrap">(Click badge to cycle status)</span>
        </div>
    </div>

    <!-- Table Roster -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/90 dark:bg-slate-850 dark:bg-slate-800/80 border-b border-slate-200/80 dark:border-slate-800 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                    <th class="py-4 px-5">Student</th>
                    <th class="py-4 px-4">Academic Program</th>
                    <th class="py-4 px-4 min-w-[180px]">Class / Room / Subject</th>
                    <th class="py-4 px-4">Recorded Time</th>
                    <th class="py-4 px-5 text-center">Status</th>
                    <th class="py-4 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                <template x-for="att in filteredAttendees" :key="att.record_id">
                    <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/50 transition-colors">
                        <!-- Student Column -->
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-3">
                                <img :src="att.avatar" :alt="att.name" class="w-9 h-9 rounded-xl object-cover border border-slate-200 dark:border-slate-700 shadow-2xs shrink-0">
                                <div>
                                    <div class="font-bold text-slate-900 dark:text-white" x-text="att.name"></div>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <span class="font-mono text-xs text-slate-400 dark:text-slate-500" x-text="att.id"></span>
                                        <template x-if="att.class_code && att.class_code !== 'N/A'">
                                            <span class="text-[10px] font-semibold px-1.5 py-0.2 rounded bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800/80" x-text="att.class_code"></span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Program Column -->
                        <td class="py-4 px-4">
                            <div class="font-medium text-slate-800 dark:text-slate-200 text-xs" x-text="att.major"></div>
                            <div class="text-[11px] text-slate-400 dark:text-slate-500" x-text="att.department"></div>
                        </td>

                        <!-- Class, Subject & Room Column -->
                        <td class="py-4 px-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800/80 shadow-2xs" x-text="att.class_code"></span>
                                    <template x-if="att.room_number && att.room_number !== 'N/A'">
                                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-1.5 py-0.5 rounded-md bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200/80 dark:border-purple-800/80" :title="'Room: ' + att.room_number">
                                            <svg class="w-3 h-3 text-purple-500 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                            <span x-text="att.room_number"></span>
                                        </span>
                                    </template>
                                </div>
                                <template x-if="att.subject && att.subject !== 'N/A'">
                                    <div class="text-[11px] font-medium text-slate-600 dark:text-slate-400 flex items-center gap-1 truncate max-w-[190px]" :title="'Subject: ' + att.subject">
                                        <svg class="w-3 h-3 text-slate-400 dark:text-slate-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        <span class="truncate" x-text="att.subject"></span>
                                    </div>
                                </template>
                            </div>
                        </td>

                        <!-- Time In Column -->
                        <td class="py-4 px-4 font-mono text-xs text-slate-600 dark:text-slate-400">
                            <span class="inline-flex items-center gap-1.5" :class="att.timeIn === '--:--' ? 'text-slate-400 dark:text-slate-500 italic' : 'text-slate-700 dark:text-slate-300 font-medium'">
                                <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                        'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/80 hover:bg-emerald-100': att.status === 'Present',
                                        'bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800/80 hover:bg-amber-100': att.status === 'Late',
                                        'bg-brand-50 dark:bg-brand-950/60 text-brand-700 dark:text-brand-400 border border-brand-200 dark:border-brand-800/80 hover:bg-brand-100': att.status === 'Excused',
                                        'bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800/80 hover:bg-rose-100': att.status === 'Absent'
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
                                    class="p-1.5 text-slate-400 dark:text-slate-500 hover:text-rose-600 dark:hover:text-rose-400 rounded-lg hover:bg-rose-50 dark:hover:bg-slate-800 transition-colors">
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
                            <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 mx-auto flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h3 class="text-base font-bold text-slate-800 dark:text-white">No students found</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                No student records matched the selected date or class filter.
                            </p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Table Footer Summary -->
    <div class="p-4 sm:px-6 bg-slate-50/70 dark:bg-slate-900/70 border-t border-slate-200/80 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500 dark:text-slate-400 font-medium">
        <div>
            Active Roster Size: <strong class="text-slate-800 dark:text-slate-200" x-text="filteredAttendees.length"></strong> students
        </div>
        <div class="flex items-center gap-4">
            <span class="inline-flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Present: <strong class="text-slate-800 dark:text-slate-200" x-text="counts.present"></strong>
            </span>
            <span class="inline-flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span> Late: <strong class="text-slate-800 dark:text-slate-200" x-text="counts.late"></strong>
            </span>
            <span class="inline-flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-brand-500"></span> Excused: <strong class="text-slate-800 dark:text-slate-200" x-text="counts.excused"></strong>
            </span>
            <span class="inline-flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-rose-500"></span> Absent: <strong class="text-slate-800 dark:text-slate-200" x-text="counts.absent"></strong>
            </span>
        </div>
        <div class="text-slate-400 dark:text-slate-500 text-[11px]">
            Real-time SQLite Sync
        </div>
    </div>
</div>

