<!-- resources/views/attendance/partials/metrics.blade.php -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <!-- Card 1: Today's Rate -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-xs hover:shadow-md transition-shadow">
        <span class="text-xs font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Today's Attendance Rate</span>
        <div class="mt-2 flex items-baseline gap-2">
            <span class="text-2xl font-extrabold text-slate-900 dark:text-white" x-text="attendanceRate + '%'">92.5%</span>
            <span class="text-xs font-semibold px-2 py-0.5 rounded-md border"
                  :class="attendanceRate >= 85 
                    ? 'text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/60 border-emerald-200 dark:border-emerald-800/80' 
                    : (attendanceRate >= 70 
                        ? 'text-amber-700 dark:text-amber-300 bg-amber-50 dark:bg-amber-950/60 border-amber-200 dark:border-amber-800/80' 
                        : 'text-rose-700 dark:text-rose-300 bg-rose-50 dark:bg-rose-950/60 border-rose-200 dark:border-rose-800/80')"
                  x-text="attendanceRate >= 85 ? 'High Compliance' : (attendanceRate >= 70 ? 'Moderate' : 'Needs Review')">High Compliance</span>
        </div>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1" x-text="`${counts.present} Present, ${counts.late} Late, ${counts.absent} Absent`"></p>
    </div>

    <!-- Card 2: Active Session -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-xs hover:shadow-md transition-shadow">
        <span class="text-xs font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Session Date & Class</span>
        <div class="mt-2 flex items-baseline gap-2">
            <span class="text-xl font-extrabold text-slate-900 dark:text-white font-mono" x-text="selectedDate"></span>
            <span class="text-xs font-semibold text-brand-700 dark:text-brand-300 bg-brand-50 dark:bg-brand-950/60 px-2 py-0.5 rounded-md border border-brand-100 dark:border-brand-800/80 truncate max-w-[150px]"
                  x-text="selectedClassId === 'All' ? 'All Classes' : (classes.find(c => c.id == selectedClassId)?.code || 'Class #' + selectedClassId)"></span>
        </div>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1" x-text="`${attendees.length} students enrolled in session`"></p>
    </div>

    <!-- Card 3: Absence Alerts -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200/80 dark:border-slate-800 shadow-xs hover:shadow-md transition-shadow">
        <span class="text-xs font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Session Absence Alerts</span>
        <div class="mt-2 flex items-baseline gap-2">
            <span class="text-2xl font-extrabold text-slate-900 dark:text-white" x-text="counts.absent + ' Flagged'"></span>
            <span class="text-xs font-semibold px-2 py-0.5 rounded-md border"
                  :class="counts.absent > 0 
                    ? 'text-rose-700 dark:text-rose-300 bg-rose-50 dark:bg-rose-950/60 border-rose-200 dark:border-rose-800/80' 
                    : 'text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/60 border-emerald-200 dark:border-emerald-800/80'"
                  x-text="counts.absent > 0 ? 'Warning' : 'All Clear'"></span>
        </div>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1" x-text="`${counts.excused} excused, ${counts.late} late check-ins`"></p>
    </div>
</div>
