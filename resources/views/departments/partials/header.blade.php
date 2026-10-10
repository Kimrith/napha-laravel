<!-- resources/views/departments/partials/header.blade.php -->
<div class="space-y-5">
    <!-- Breadcrumbs -->
    <nav class="flex items-center text-xs font-medium text-slate-500 gap-2">
        <a href="{{ route('dashboard') }}" class="hover:text-slate-900 transition-colors flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Dashboard</span>
        </a>
        <svg class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-brand-600 font-semibold bg-brand-50 px-2 py-0.5 rounded-md border border-brand-100">
            Departments
        </span>
    </nav>

    <!-- Page Header & Action Controls -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Academic Departments</h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-50 text-brand-700 border border-brand-200"
                      x-text="filteredDepartments.length + ' Divisions'">
                    {{ count($departments ?? []) }} Divisions
                </span>
            </div>
            <p class="text-sm text-slate-500 mt-1">Collegiate divisions, chairpersons, faculty staffing ratios, and research budget allocations.</p>
        </div>
        <button type="button" 
                @click="openAddModal()" 
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-md shadow-brand-600/30 transition-all cursor-pointer">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M12 4v16m8-8H4"/>
            </svg>
            <span>+ Add Department</span>
        </button>
    </div>

    <!-- Live KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Divisions -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Divisions</span>
                <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-slate-900 tracking-tight" x-text="departments.length">{{ $kpis['total'] ?? 0 }}</span>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-md">Real-Time</span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Colleges & Academic Schools</p>
        </div>

        <!-- Card 2: Active Status -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Active Divisions</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-slate-900 tracking-tight" x-text="departments.filter(d => d.status === 'Active').length">{{ $kpis['active'] ?? 0 }}</span>
                <span class="text-xs font-medium text-slate-500">
                    (<span x-text="departments.length ? Math.round((departments.filter(d => d.status === 'Active').length / departments.length) * 100) + '%' : '100%'"></span>)
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Operational & Enrolling</p>
        </div>

        <!-- Card 3: Academic Programs -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Programs</span>
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-slate-900 tracking-tight" x-text="departments.reduce((acc, d) => acc + (parseInt(d.programs) || 0), 0)">{{ $kpis['total_programs'] ?? 0 }}</span>
                <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-1.5 py-0.5 rounded-md">Degrees Offered</span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Undergraduate & Graduate</p>
        </div>

        <!-- Card 4: Enrolled Students -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Enrolled Students</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-slate-900 tracking-tight" x-text="departments.reduce((acc, d) => acc + (parseInt(d.students) || 0), 0)">{{ $kpis['total_students'] ?? 0 }}</span>
                <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded-md">Across Divisions</span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Active student roster</p>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex flex-col sm:flex-row items-center gap-3">
        <div class="relative flex-1 w-full">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" 
                   x-model="searchQuery" 
                   placeholder="Search department name, code, or chairperson..." 
                   class="w-full pl-10 pr-9 py-2.5 text-sm bg-slate-50 focus:bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden text-slate-800 placeholder-slate-400 transition-all">
            <button type="button" 
                    x-show="searchQuery" 
                    @click="searchQuery = ''" 
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="w-full sm:w-48">
            <select x-model="selectedStatus" 
                    class="w-full px-3.5 py-2.5 text-sm bg-slate-50 hover:bg-slate-100/60 focus:bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden transition-all text-slate-800 font-medium cursor-pointer">
                <option value="All">All Statuses</option>
                <option value="Active">Active Only</option>
                <option value="Inactive">Inactive Only</option>
            </select>
        </div>

        <button type="button" 
                x-show="searchQuery !== '' || selectedStatus !== 'All'" 
                @click="searchQuery = ''; selectedStatus = 'All'" 
                class="px-3.5 py-2.5 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 transition-colors flex items-center gap-1.5 whitespace-nowrap cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            <span>Reset Filters</span>
        </button>
    </div>
</div>
