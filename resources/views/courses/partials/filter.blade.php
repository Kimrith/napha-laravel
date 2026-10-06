<!-- resources/views/courses/partials/filter.blade.php -->
<div class="space-y-4">
    <!-- Page Header & Action Buttons -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Active Courses</h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-50 text-brand-700 border border-brand-200" 
                      x-text="filteredCourses.length + ' Courses'"></span>
            </div>
            <p class="text-sm text-slate-500 mt-1">Curriculum schedules, enrolled student quotas, and faculty instruction assignments.</p>
        </div>

        <div class="flex items-center gap-3">
            <button type="button" 
                    @click="exportCourses()" 
                    class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 shadow-xs transition-all">
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span>Export CSV</span>
            </button>

            <button type="button" 
                    @click="openAddModal()" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-md shadow-brand-600/30 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M12 4v16m8-8H4"/>
                </svg>
                <span>+ Add New Course</span>
            </button>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" 
                   x-model="searchQuery" 
                   placeholder="Search by course code, title, or professor..." 
                   class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 focus:bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden text-slate-800 transition-colors">
        </div>

        <div class="w-full sm:w-60">
            <select x-model="selectedDepartment" 
                    class="w-full px-3.5 py-2.5 text-sm bg-slate-50 focus:bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden text-slate-800 font-medium transition-colors">
                <option value="All">All Departments</option>
                <option value="Computer Science">Computer Science</option>
                <option value="Informatics & AI">Informatics & AI</option>
                <option value="Digital Design">Digital Design</option>
                <option value="Mechatronics">Mechatronics</option>
                <option value="Life Sciences">Life Sciences</option>
                <option value="Business & Finance">Business & Finance</option>
                <option value="Cybersecurity">Cybersecurity</option>
            </select>
        </div>

        <div class="w-full sm:w-44">
            <select x-model="selectedStatus" 
                    class="w-full px-3.5 py-2.5 text-sm bg-slate-50 focus:bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden text-slate-800 font-medium transition-colors">
                <option value="All">All Statuses</option>
                <option value="Active">Active</option>
                <option value="Full">Full</option>
                <option value="Upcoming">Upcoming</option>
            </select>
        </div>
    </div>
</div>
