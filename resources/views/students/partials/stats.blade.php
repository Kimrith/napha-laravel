<!-- resources/views/students/partials/stats.blade.php -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Card 1: Total Enrolled -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Enrolled</span>
            <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>
        <div class="mt-2 flex items-baseline gap-2">
            <span class="text-2xl font-extrabold text-slate-900 tracking-tight" x-text="students.length">{{ $kpis['total'] ?? 0 }}</span>
            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-md flex items-center gap-0.5">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                Active
            </span>
        </div>
        <p class="text-xs text-slate-500 mt-1">Across {{ count($departments ?? []) }} active departments</p>
    </div>

    <!-- Card 2: Active Students -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Active Students</span>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div class="mt-2 flex items-baseline gap-2">
            <span class="text-2xl font-extrabold text-slate-900 tracking-tight" x-text="students.filter(s => s.status === 'Active').length">{{ $kpis['active'] ?? 0 }}</span>
            <span class="text-xs font-medium text-slate-500">
                (<span x-text="students.length ? Math.round((students.filter(s => s.status === 'Active').length / students.length) * 100) + '%' : '0%'"></span>)
            </span>
        </div>
        <p class="text-xs text-slate-500 mt-1">Good academic standing</p>
    </div>

    <!-- Card 3: Inactive / On Leave -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Inactive / On Leave</span>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div class="mt-2 flex items-baseline gap-2">
            <span class="text-2xl font-extrabold text-slate-900 tracking-tight" x-text="students.filter(s => s.status === 'Inactive').length">{{ $kpis['inactive'] ?? 0 }}</span>
            <span class="text-xs font-medium text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded-md">Review required</span>
        </div>
        <p class="text-xs text-slate-500 mt-1">Leave of absence or deferral</p>
    </div>

    <!-- Card 4: Average GPA -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Avg. Cumulative GPA</span>
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
        </div>
        <div class="mt-2 flex items-baseline gap-2">
            <span class="text-2xl font-extrabold text-slate-900 tracking-tight" x-text="students.length ? (students.reduce((acc, s) => acc + (parseFloat(s.gpa) || 0), 0) / students.length).toFixed(2) : '{{ $kpis['avg_gpa'] ?? '0.00' }}'">{{ $kpis['avg_gpa'] ?? '0.00' }}</span>
            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-md">Scale 4.00</span>
        </div>
        <p class="text-xs text-slate-500 mt-1">Real-time Grade Matrix</p>
    </div>
</div>
