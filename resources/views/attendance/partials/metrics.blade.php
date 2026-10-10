<!-- resources/views/attendance/partials/metrics.blade.php -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <!-- Card 1: Today's Rate -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Today's Attendance Rate</span>
        <div class="mt-2 flex items-baseline gap-2">
            <span class="text-2xl font-extrabold text-slate-900" x-text="attendanceRate + '%'">92.5%</span>
            <span class="text-xs font-semibold px-1.5 py-0.5 rounded-md"
                  :class="attendanceRate >= 85 ? 'text-emerald-700 bg-emerald-50' : (attendanceRate >= 70 ? 'text-amber-700 bg-amber-50' : 'text-rose-700 bg-rose-50')"
                  x-text="attendanceRate >= 85 ? 'High Compliance' : (attendanceRate >= 70 ? 'Moderate' : 'Needs Review')">High Compliance</span>
        </div>
        <p class="text-xs text-slate-500 mt-1" x-text="`${counts.present} Present, ${counts.late} Late, ${counts.absent} Absent`"></p>
    </div>

    <!-- Card 2: Active Session -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Session Date & Course</span>
        <div class="mt-2 flex items-baseline gap-2">
            <span class="text-xl font-extrabold text-slate-900 font-mono" x-text="selectedDate"></span>
            <span class="text-xs font-semibold text-brand-700 bg-brand-50 px-2 py-0.5 rounded-md border border-brand-100 truncate max-w-[150px]"
                  x-text="selectedCourseId === 'All' ? 'All Courses' : (courses.find(c => c.id == selectedCourseId)?.code || 'Course #' + selectedCourseId)"></span>
        </div>
        <p class="text-xs text-slate-500 mt-1" x-text="`${attendees.length} students enrolled in session`"></p>
    </div>

    <!-- Card 3: Absence Alerts -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Session Absence Alerts</span>
        <div class="mt-2 flex items-baseline gap-2">
            <span class="text-2xl font-extrabold text-slate-900" x-text="counts.absent + ' Flagged'"></span>
            <span class="text-xs font-semibold px-1.5 py-0.5 rounded-md"
                  :class="counts.absent > 0 ? 'text-rose-700 bg-rose-50' : 'text-emerald-700 bg-emerald-50'"
                  x-text="counts.absent > 0 ? 'Warning' : 'All Clear'"></span>
        </div>
        <p class="text-xs text-slate-500 mt-1" x-text="`${counts.excused} excused, ${counts.late} late check-ins`"></p>
    </div>
</div>
