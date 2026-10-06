<!-- resources/views/attendance/partials/metrics.blade.php -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <!-- Card 1: Today's Rate -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Today's Attendance Rate</span>
        <div class="mt-2 flex items-baseline gap-2">
            <span class="text-2xl font-extrabold text-slate-900" x-text="attendanceRate + '%'">92.5%</span>
            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-md">High Compliance</span>
        </div>
        <p class="text-xs text-slate-500 mt-1" x-text="`${counts.present} Present, ${counts.late} Late, ${counts.absent} Absent`"></p>
    </div>

    <!-- Card 2: Average Check-in -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Average Check-in Time</span>
        <div class="mt-2 flex items-baseline gap-2">
            <span class="text-2xl font-extrabold text-slate-900">08:56 AM</span>
            <span class="text-xs font-medium text-slate-500">4 min before lecture</span>
        </div>
        <p class="text-xs text-slate-500 mt-1">Hall Alpha-2 Scanner 01</p>
    </div>

    <!-- Card 3: Absence Alerts -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Term Absence Alerts</span>
        <div class="mt-2 flex items-baseline gap-2">
            <span class="text-2xl font-extrabold text-slate-900" x-text="counts.absent + ' Alerts'"></span>
            <span class="text-xs font-semibold text-amber-700 bg-amber-50 px-1.5 py-0.5 rounded-md">Warning</span>
        </div>
        <p class="text-xs text-slate-500 mt-1">Students below 80% threshold</p>
    </div>
</div>
