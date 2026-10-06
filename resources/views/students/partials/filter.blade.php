<!-- resources/views/students/partials/filter.blade.php -->
<div class="space-y-4">
    <!-- Page Header & Action Buttons -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pt-2">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Student Records</h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-50 text-brand-700 border border-brand-200"
                      x-text="filteredStudents.length + ' Enrolled'">
                </span>
            </div>
            <p class="text-sm text-slate-500 mt-1 max-w-2xl font-normal">
                Manage enrolled students, academic tracking, personal contact details, and department registrations.
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-3 flex-wrap">
            <button type="button" 
                    @click="exportCSV()" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200/90 shadow-2xs transition-all">
                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span>Export CSV</span>
            </button>

            <button type="button" 
                    @click="addModalOpen = true" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-md shadow-brand-600/30 transition-all">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M12 4v16m8-8H4"/>
                </svg>
                <span>+ Add New Student</span>
            </button>
        </div>
    </div>

    <!-- Filter and Search Bar -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs space-y-3">
        <div class="flex flex-col lg:flex-row lg:items-center gap-3">
            <!-- Search Input -->
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" 
                       x-model="searchQuery" 
                       placeholder="Search by name, student ID, or email..." 
                       class="w-full pl-10 pr-9 py-2.5 text-sm bg-slate-50 hover:bg-slate-100/60 focus:bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden transition-all text-slate-800 placeholder-slate-400">
                <button type="button" 
                        x-show="searchQuery" 
                        @click="searchQuery = ''" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Major Dropdown Filter -->
            <div class="w-full sm:w-56">
                <select x-model="selectedMajor" 
                        class="w-full px-3.5 py-2.5 text-sm bg-slate-50 hover:bg-slate-100/60 focus:bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden transition-all text-slate-800 font-medium cursor-pointer">
                    <option value="All">All Majors</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Data Science & AI">Data Science & AI</option>
                    <option value="Digital Design">Digital Design</option>
                    <option value="Robotics & Automation">Robotics & Automation</option>
                    <option value="Biotechnology">Biotechnology</option>
                    <option value="International Finance">International Finance</option>
                    <option value="Cybersecurity">Cybersecurity</option>
                    <option value="Media Communications">Media Communications</option>
                </select>
            </div>

            <!-- Status Dropdown Filter -->
            <div class="w-full sm:w-44">
                <select x-model="selectedStatus" 
                        class="w-full px-3.5 py-2.5 text-sm bg-slate-50 hover:bg-slate-100/60 focus:bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden transition-all text-slate-800 font-medium cursor-pointer">
                    <option value="All">All Statuses</option>
                    <option value="Active">Active Only</option>
                    <option value="Inactive">Inactive Only</option>
                </select>
            </div>

            <!-- Reset Filters -->
            <button type="button" 
                    x-show="searchQuery !== '' || selectedMajor !== 'All' || selectedStatus !== 'All'" 
                    @click="searchQuery = ''; selectedMajor = 'All'; selectedStatus = 'All'" 
                    class="px-3 py-2.5 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 transition-colors flex items-center gap-1.5 whitespace-nowrap">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                <span>Reset Filters</span>
            </button>
        </div>

        <!-- Batch Selection Action Bar -->
        <div x-cloak x-show="selectedIds.length > 0" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="flex flex-wrap items-center justify-between gap-3 p-3 bg-brand-50/70 border border-brand-200/80 rounded-xl">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-brand-600 animate-pulse"></span>
                <span class="text-xs font-bold text-brand-900" x-text="selectedIds.length + ' student' + (selectedIds.length > 1 ? 's' : '') + ' selected'"></span>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" @click="batchMarkStatus('Active')" class="px-2.5 py-1.5 bg-white hover:bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-xs font-semibold transition-colors">
                    Mark Active
                </button>
                <button type="button" @click="batchMarkStatus('Inactive')" class="px-2.5 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-lg text-xs font-semibold transition-colors">
                    Mark Inactive
                </button>
                <button type="button" @click="batchDelete()" class="px-2.5 py-1.5 bg-white hover:bg-rose-50 text-rose-700 border border-rose-200 rounded-lg text-xs font-semibold transition-colors">
                    Delete Selected
                </button>
                <button type="button" @click="selectedIds = []" class="text-xs font-medium text-slate-500 hover:text-slate-800 underline ml-2">
                    Deselect all
                </button>
            </div>
        </div>
    </div>
</div>
