@extends('layouts.app')

@section('title', 'Student Records | EduPulse Pro Portal')

@section('content')
<div x-data="studentDirectory()" 
     x-init="$watch('filteredStudents', () => { selectedIds = selectedIds.filter(id => filteredStudents.some(s => s.id === id)); })"
     @open-add-student.window="addModalOpen = true"
     class="space-y-6">

    <!-- ======================= BREADCRUMBS ======================= -->
    <nav class="flex items-center text-xs font-medium text-slate-500 gap-2">
        <a href="{{ url('/dashboard') }}" class="hover:text-slate-900 transition-colors flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Dashboard</span>
        </a>
        <svg class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-brand-600 font-semibold bg-brand-50 px-2 py-0.5 rounded-md border border-brand-100">
            Student Directory
        </span>
    </nav>

    <!-- ======================= STATS OVERVIEW CARDS ======================= -->
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
                <span class="text-2xl font-extrabold text-slate-900 tracking-tight" x-text="students.length"></span>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-md flex items-center gap-0.5">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    +12%
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Across 8 active departments</p>
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
                <span class="text-2xl font-extrabold text-slate-900 tracking-tight" x-text="students.filter(s => s.status === 'Active').length"></span>
                <span class="text-xs font-medium text-slate-500">
                    (<span x-text="Math.round((students.filter(s => s.status === 'Active').length / students.length) * 100) + '%'"></span>)
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
                <span class="text-2xl font-extrabold text-slate-900 tracking-tight" x-text="students.filter(s => s.status === 'Inactive').length"></span>
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
                <span class="text-2xl font-extrabold text-slate-900 tracking-tight">3.83</span>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-md">Top Tier</span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Scale of 4.00 Grade Matrix</p>
        </div>
    </div>

    <!-- ======================= PAGE HEADER ======================= -->
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
            <button @click="exportCSV()" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200/90 shadow-2xs hover:border-slate-300 transition-all focus:outline-hidden">
                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span>Export CSV</span>
            </button>

            <button @click="addModalOpen = true" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-md shadow-brand-600/30 transition-all hover:translate-y-[-1px] focus:outline-hidden">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M12 4v16m8-8H4"/>
                </svg>
                <span>+ Add New Student</span>
            </button>
        </div>
    </div>

    <!-- ======================= FILTER AND SEARCH BAR ======================= -->
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
                       class="w-full pl-10 pr-9 py-2.5 text-sm bg-slate-50 hover:bg-slate-100/60 focus:bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800 placeholder-slate-400">
                <button x-show="searchQuery" 
                        @click="searchQuery = ''" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Major Dropdown Filter -->
            <div class="w-full sm:w-56">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <select x-model="selectedMajor" 
                            class="w-full pl-9 pr-8 py-2.5 text-sm bg-slate-50 hover:bg-slate-100/60 focus:bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800 font-medium appearance-none cursor-pointer">
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
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </div>

            <!-- Status Dropdown Filter -->
            <div class="w-full sm:w-44">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <select x-model="selectedStatus" 
                            class="w-full pl-9 pr-8 py-2.5 text-sm bg-slate-50 hover:bg-slate-100/60 focus:bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800 font-medium appearance-none cursor-pointer">
                        <option value="All">All Statuses</option>
                        <option value="Active">Active Only</option>
                        <option value="Inactive">Inactive Only</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </div>

            <!-- Reset Filters -->
            <button x-show="searchQuery !== '' || selectedMajor !== 'All' || selectedStatus !== 'All'" 
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
                <button @click="batchMarkStatus('Active')" class="px-2.5 py-1.5 bg-white hover:bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-xs font-semibold transition-colors">
                    Mark Active
                </button>
                <button @click="batchMarkStatus('Inactive')" class="px-2.5 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-lg text-xs font-semibold transition-colors">
                    Mark Inactive
                </button>
                <button @click="batchDelete()" class="px-2.5 py-1.5 bg-white hover:bg-rose-50 text-rose-700 border border-rose-200 rounded-lg text-xs font-semibold transition-colors">
                    Delete Selected
                </button>
                <button @click="selectedIds = []" class="text-xs font-medium text-slate-500 hover:text-slate-800 underline ml-2">
                    Deselect all
                </button>
            </div>
        </div>
    </div>

    <!-- ======================= STUDENT RECORDS DATA TABLE ======================= -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <!-- Table Header -->
                <thead>
                    <tr class="bg-slate-50/90 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider select-none">
                        <th class="py-4 px-4 w-12 text-center">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       :checked="allSelected" 
                                       @change="toggleSelectAll()" 
                                       class="w-4 h-4 rounded text-brand-600 border-slate-300 focus:ring-brand-500 focus:ring-offset-0 transition">
                            </label>
                        </th>
                        <th class="py-4 px-5 min-w-[260px]">Student Details</th>
                        <th class="py-4 px-4 min-w-[130px]">Student ID</th>
                        <th class="py-4 px-4 min-w-[220px]">Contact Info</th>
                        <th class="py-4 px-4 min-w-[200px]">Course / Major</th>
                        <th class="py-4 px-4 min-w-[110px]">Status</th>
                        <th class="py-4 px-5 text-right min-w-[120px]">Actions</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y divide-slate-100 text-sm">
                    <template x-for="student in filteredStudents" :key="student.id">
                        <tr :class="selectedIds.includes(student.id) ? 'bg-brand-50/30' : 'hover:bg-slate-50/70'" 
                            class="transition-colors group">
                            
                            <!-- Checkbox -->
                            <td class="py-4 px-4 text-center">
                                <input type="checkbox" 
                                       :checked="selectedIds.includes(student.id)" 
                                       @click="toggleRowSelect(student.id)" 
                                       class="w-4 h-4 rounded text-brand-600 border-slate-300 focus:ring-brand-500 focus:ring-offset-0 transition cursor-pointer">
                            </td>

                            <!-- Student Info Column -->
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-3.5">
                                    <div class="relative flex-shrink-0 cursor-pointer" @click="viewStudent(student)">
                                        <img :src="student.avatar" 
                                             :alt="student.name" 
                                             class="w-11 h-11 rounded-xl object-cover ring-2 ring-slate-100 group-hover:ring-brand-300 transition-all shadow-2xs">
                                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-white"
                                              :class="student.status === 'Active' ? 'bg-emerald-500' : 'bg-slate-400'">
                                        </span>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <button @click="viewStudent(student)" 
                                                    class="font-bold text-slate-900 group-hover:text-brand-600 transition-colors truncate text-sm text-left hover:underline">
                                                <span x-text="student.name"></span>
                                            </button>
                                            <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200"
                                                  x-text="student.pronouns">
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2 mt-0.5 text-xs text-slate-400">
                                            <span x-text="student.gender"></span>
                                            <span>•</span>
                                            <span x-text="'Born ' + student.dob + ' (' + student.age + 'y)'"></span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Student ID Column -->
                            <td class="py-4 px-4">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 font-mono text-xs font-semibold border border-slate-200/80 group/id">
                                    <span x-text="student.id"></span>
                                    <button @click="navigator.clipboard.writeText(student.id); showToast('Copied ID ' + student.id, 'info')" 
                                            class="text-slate-400 hover:text-brand-600 transition-colors p-0.5 rounded" title="Copy Student ID">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>

                            <!-- Contact Info Column -->
                            <td class="py-4 px-4">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-1.5 text-xs text-slate-700">
                                        <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        <a :href="'mailto:' + student.email" class="hover:text-brand-600 hover:underline truncate" x-text="student.email"></a>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                        <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        <span x-text="student.phone"></span>
                                    </div>
                                </div>
                            </td>

                            <!-- Course / Major Column -->
                            <td class="py-4 px-4">
                                <div>
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50/70 text-brand-700 border border-brand-100">
                                        <template x-if="student.major.includes('Computer') || student.major.includes('Data') || student.major.includes('Cyber')">
                                            <svg class="w-3.5 h-3.5 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                            </svg>
                                        </template>
                                        <template x-if="student.major.includes('Design') || student.major.includes('Media')">
                                            <svg class="w-3.5 h-3.5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4 4 4 0 014-4c.48 0 .93.08 1.35.24A4 4 0 0115 12a4 4 0 01-1.35 3.06A4 4 0 017 21z"/>
                                            </svg>
                                        </template>
                                        <template x-if="student.major.includes('Robotics') || student.major.includes('Bio') || student.major.includes('Finance')">
                                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                            </svg>
                                        </template>
                                        <span x-text="student.major"></span>
                                    </div>
                                    <p class="text-[11px] text-slate-400 mt-1 truncate" x-text="student.degree"></p>
                                </div>
                            </td>

                            <!-- Status Column -->
                            <td class="py-4 px-4">
                                <template x-if="student.status === 'Active'">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60 shadow-2xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 ring-4 ring-emerald-500/20"></span>
                                        <span>Active</span>
                                    </span>
                                </template>
                                <template x-if="student.status === 'Inactive'">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        <span>Inactive</span>
                                    </span>
                                </template>
                            </td>

                            <!-- Actions Column -->
                            <td class="py-4 px-5 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <button @click="viewStudent(student)" 
                                            class="p-2 text-slate-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-colors" 
                                            title="View Student Dossier">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>

                                    <button @click="openEditModal(student)" 
                                            class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" 
                                            title="Edit Records">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </button>

                                    <button @click="confirmDelete(student)" 
                                            class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" 
                                            title="Delete Record">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>

                        </tr>
                    </template>

                    <!-- Empty State -->
                    <tr x-show="filteredStudents.length === 0">
                        <td colspan="7" class="py-12 text-center">
                            <div class="max-w-sm mx-auto">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-bold text-slate-800">No student records found</h3>
                                <p class="text-xs text-slate-500 mt-1">Try adjusting your search queries or clearing active filters.</p>
                                <button @click="searchQuery = ''; selectedMajor = 'All'; selectedStatus = 'All'" 
                                        class="mt-3 px-3 py-1.5 rounded-lg text-xs font-semibold bg-brand-50 text-brand-600 hover:bg-brand-100 transition-colors">
                                    Clear all filters
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Table Footer / Pagination -->
        <div class="p-4 sm:px-6 bg-slate-50/70 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-xs text-slate-500 font-medium">
                Showing <span class="font-bold text-slate-800">1</span> to <span class="font-bold text-slate-800" x-text="filteredStudents.length"></span> of <span class="font-bold text-slate-800" x-text="students.length"></span> total student entries
            </div>

            <!-- Page Buttons -->
            <div class="flex items-center gap-1.5">
                <button class="px-2.5 py-1.5 rounded-lg text-xs font-medium text-slate-400 bg-white border border-slate-200 cursor-not-allowed" disabled>
                    Previous
                </button>
                <button class="px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-brand-600 shadow-2xs">1</button>
                <button class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 bg-white hover:bg-slate-100 border border-slate-200">2</button>
                <button class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 bg-white hover:bg-slate-100 border border-slate-200">3</button>
                <span class="text-xs text-slate-400 px-1">...</span>
                <button class="px-2.5 py-1.5 rounded-lg text-xs font-medium text-slate-600 bg-white hover:bg-slate-100 border border-slate-200">
                    Next
                </button>
            </div>
        </div>
    </div>

    <!-- ======================= MODULAR PARTIALS ======================= -->
    @include('students.partials.add-modal')
    @include('students.partials.view-slideover')
    @include('students.partials.edit-modal')
    @include('students.partials.delete-modal')

</div>
@endsection

@push('scripts')
    @include('students.partials.data-store')
@endpush
