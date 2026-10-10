<!-- resources/views/courses/partials/filter.blade.php -->
<div class="space-y-5">
    <!-- Page Header & Action Buttons -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Active Courses</h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-50 text-brand-700 border border-brand-200" 
                      x-text="filteredCourses.length + ' Courses'">
                    {{ count($courses ?? []) }} Courses
                </span>
            </div>
            <p class="text-sm text-slate-500 mt-1">Curriculum schedules, enrolled student quotas, and faculty instruction assignments.</p>
        </div>

        <div class="flex items-center gap-3">
            <button type="button" 
                    @click="exportCourses()" 
                    class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 shadow-xs transition-all cursor-pointer">
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span>Export CSV</span>
            </button>

            <button type="button" 
                    @click="openAddModal()" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-md shadow-brand-600/30 transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M12 4v16m8-8H4"/>
                </svg>
                <span>+ Add New Course</span>
            </button>
        </div>
    </div>

    <!-- Live KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Courses -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Courses</span>
                <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-slate-900 tracking-tight" x-text="courses.length">{{ $kpis['total'] ?? 0 }}</span>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-md">Catalogued</span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Fall Semester 2026</p>
        </div>

        <!-- Card 2: Active Sections -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Active Sections</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-slate-900 tracking-tight" x-text="courses.filter(c => c.status === 'Active').length">{{ $kpis['active'] ?? 0 }}</span>
                <span class="text-xs font-medium text-slate-500">
                    (<span x-text="courses.length ? Math.round((courses.filter(c => c.status === 'Active').length / courses.length) * 100) + '%' : '0%'"></span>)
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Open for registration</p>
        </div>

        <!-- Card 3: Full Quotas -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Full Capacity</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-slate-900 tracking-tight" x-text="courses.filter(c => c.status === 'Full').length">{{ $kpis['full'] ?? 0 }}</span>
                <span class="text-xs font-medium text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded-md">At Max Quota</span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Waitlist active</p>
        </div>

        <!-- Card 4: Total Student Seats -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Enrolled Seats</span>
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-slate-900 tracking-tight" x-text="courses.reduce((acc, c) => acc + (parseInt(c.enrolled) || 0), 0)">{{ $kpis['total_enrolled'] ?? 0 }}</span>
                <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-1.5 py-0.5 rounded-md">
                    / <span x-text="courses.reduce((acc, c) => acc + (parseInt(c.capacity) || 0), 0)">{{ $kpis['total_capacity'] ?? 0 }}</span> Seats
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Classroom occupancy</p>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex flex-col sm:flex-row items-center gap-3">
        <div class="relative flex-1 w-full">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" 
                   x-model="searchQuery" 
                   placeholder="Search by course code, title, or professor..." 
                   class="w-full pl-10 pr-9 py-2.5 text-sm bg-slate-50 focus:bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden text-slate-800 placeholder-slate-400 transition-all">
            <button type="button" 
                    x-show="searchQuery" 
                    @click="searchQuery = ''" 
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="w-full sm:w-60">
            <select x-model="selectedDepartment" 
                    class="w-full px-3.5 py-2.5 text-sm bg-slate-50 hover:bg-slate-100/60 focus:bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden text-slate-800 font-medium transition-all cursor-pointer">
                <option value="All">All Departments</option>
                @foreach($departments ?? [] as $dept)
                    <option value="{{ $dept->name }}">{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="w-full sm:w-44">
            <select x-model="selectedStatus" 
                    class="w-full px-3.5 py-2.5 text-sm bg-slate-50 hover:bg-slate-100/60 focus:bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden text-slate-800 font-medium transition-all cursor-pointer">
                <option value="All">All Statuses</option>
                <option value="Active">Active</option>
                <option value="Full">Full</option>
                <option value="Upcoming">Upcoming</option>
            </select>
        </div>

        <button type="button" 
                x-show="searchQuery !== '' || selectedDepartment !== 'All' || selectedStatus !== 'All'" 
                @click="searchQuery = ''; selectedDepartment = 'All'; selectedStatus = 'All'" 
                class="px-3 py-2.5 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 transition-colors flex items-center gap-1.5 whitespace-nowrap cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            <span>Reset</span>
        </button>
    </div>
</div>
