@extends('layouts.app')

@section('title', 'Executive Dashboard | EduPulse Pro Portal')

@section('content')
<div class="space-y-6">

    <!-- Breadcrumbs -->
    <nav class="flex items-center text-xs font-medium text-slate-500 gap-2">
        <span class="text-slate-400">Home</span>
        <svg class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-brand-600 font-semibold bg-brand-50 px-2 py-0.5 rounded-md border border-brand-100">
            Executive Dashboard Overview
        </span>
    </nav>

    <!-- Welcome Hero Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-sidebar-base via-slate-900 to-brand-950 p-6 sm:p-8 text-white shadow-xl border border-slate-800">
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-brand-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/20 text-brand-300 text-xs font-bold border border-brand-500/30">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Fall Semester 2026 · Week 8 in Session</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Welcome back, <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-300 to-indigo-200">Dr. Sarah Vance</span>
                </h1>
                <p class="text-sm text-slate-300 leading-relaxed font-normal">
                    Student enrollment is operating at 94.6% capacity across 8 academic schools. 14 student registrations require dean approval before Friday 5:00 PM.
                </p>
            </div>
            <div class="flex items-center gap-3 flex-wrap">
                <a href="{{ route('students.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold bg-brand-600 hover:bg-brand-500 text-white shadow-lg shadow-brand-600/30 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>Manage Students</span>
                </a>
                <a href="{{ route('grades.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold bg-white/10 hover:bg-white/20 text-white border border-white/10 backdrop-blur-sm transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span>Grade Audits</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1: Total Enrolled -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Enrolled</span>
                <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-slate-900 tracking-tight">2,845</span>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-md flex items-center gap-0.5">
                    +12.4%
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Active full-time equivalents</p>
        </div>

        <!-- 2: Active Courses -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Active Courses</span>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-slate-900 tracking-tight">64 Courses</span>
                <span class="text-xs font-medium text-slate-500">18 Departments</span>
            </div>
            <p class="text-xs text-slate-500 mt-1">112 faculty members</p>
        </div>

        <!-- 3: Campus Attendance -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Attendance Rate</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-slate-900 tracking-tight">94.6%</span>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-md">Optimal</span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Today across all lectures</p>
        </div>

        <!-- 4: Approvals Required -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Pending Actions</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-slate-900 tracking-tight">14 Items</span>
                <span class="text-xs font-semibold text-amber-700 bg-amber-50 px-1.5 py-0.5 rounded-md">Action Required</span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Registrations & Grade Audits</p>
        </div>
    </div>

    <!-- Main Content 2-Column Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left 2 Cols: Department Enrolment Breakdown -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Department Enrolment Progress -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Enrolment by Academic Department</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Distribution of enrolled undergraduates and postgraduates.</p>
                    </div>
                    <a href="{{ route('departments.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700">
                        View All Departments &rarr;
                    </a>
                </div>

                <div class="space-y-4">
                    <!-- Dept 1 -->
                    <div>
                        <div class="flex justify-between text-xs font-semibold text-slate-700 mb-1">
                            <span class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>
                                School of Computing & Informatics
                            </span>
                            <span class="text-slate-900 font-bold">894 Students (31.4%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-brand-500 h-2 rounded-full" style="width: 78%"></div>
                        </div>
                    </div>

                    <!-- Dept 2 -->
                    <div>
                        <div class="flex justify-between text-xs font-semibold text-slate-700 mb-1">
                            <span class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                School of Business & Global Finance
                            </span>
                            <span class="text-slate-900 font-bold">642 Students (22.5%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-emerald-500 h-2 rounded-full" style="width: 65%"></div>
                        </div>
                    </div>

                    <!-- Dept 3 -->
                    <div>
                        <div class="flex justify-between text-xs font-semibold text-slate-700 mb-1">
                            <span class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                                Faculty of Life Sciences & Biotech
                            </span>
                            <span class="text-slate-900 font-bold">520 Students (18.2%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-purple-500 h-2 rounded-full" style="width: 58%"></div>
                        </div>
                    </div>

                    <!-- Dept 4 -->
                    <div>
                        <div class="flex justify-between text-xs font-semibold text-slate-700 mb-1">
                            <span class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                                Design, Arts & Human-Computer Interaction
                            </span>
                            <span class="text-slate-900 font-bold">410 Students (14.4%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-amber-500 h-2 rounded-full" style="width: 48%"></div>
                        </div>
                    </div>

                    <!-- Dept 5 -->
                    <div>
                        <div class="flex justify-between text-xs font-semibold text-slate-700 mb-1">
                            <span class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-cyan-500"></span>
                                Mechatronics & Robotics Engineering
                            </span>
                            <span class="text-slate-900 font-bold">379 Students (13.5%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2">
                            <div class="bg-cyan-500 h-2 rounded-full" style="width: 42%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Student Activities -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Recent Student Admissions & Activities</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Real-time enrollment stream for Fall 2026.</p>
                    </div>
                    <a href="{{ route('students.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700">
                        View Directory &rarr;
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    <div class="py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img class="w-9 h-9 rounded-xl object-cover ring-2 ring-slate-100" 
                                 src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200&auto=format&fit=crop" alt="Alexander">
                            <div>
                                <p class="text-xs font-bold text-slate-900">Alexander Wright enrolled in B.Sc. Software Engineering</p>
                                <p class="text-[11px] text-slate-400">ID: STU-2026-001 · Assigned to Prof. Alan Turing</p>
                            </div>
                        </div>
                        <span class="text-[11px] font-medium text-slate-400">12 min ago</span>
                    </div>

                    <div class="py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img class="w-9 h-9 rounded-xl object-cover ring-2 ring-slate-100" 
                                 src="https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?q=80&w=200&auto=format&fit=crop" alt="Amara">
                            <div>
                                <p class="text-xs font-bold text-slate-900">Amara Okafor submitted AI Thesis Proposal</p>
                                <p class="text-[11px] text-slate-400">ID: STU-2026-002 · Faculty of Informatics</p>
                            </div>
                        </div>
                        <span class="text-[11px] font-medium text-slate-400">45 min ago</span>
                    </div>

                    <div class="py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img class="w-9 h-9 rounded-xl object-cover ring-2 ring-slate-100" 
                                 src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop" alt="Fatima">
                            <div>
                                <p class="text-xs font-bold text-slate-900">Fatima Al-Zahra received 4.00 Grade Matrix Certification</p>
                                <p class="text-[11px] text-slate-400">ID: STU-2026-007 · Cryptographic Systems</p>
                            </div>
                        </div>
                        <span class="text-[11px] font-medium text-slate-400">2 hours ago</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right 1 Col: Calendar & Upcoming Academic Milestones -->
        <div class="space-y-6">
            
            <!-- Term Milestone Card -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-900">Academic Deadlines</h3>
                    <span class="text-[10px] font-bold text-brand-700 bg-brand-50 px-2 py-0.5 rounded-full border border-brand-200">October 2026</span>
                </div>

                <div class="space-y-3">
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                            <span>Mid-Term Examination Week</span>
                            <span class="text-rose-600">In 4 Days</span>
                        </div>
                        <p class="text-[11px] text-slate-500">Hall seating plan generation starts Friday 10:00 AM.</p>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                            <span>Course Drop / Add Final Cutoff</span>
                            <span class="text-amber-600">Oct 16</span>
                        </div>
                        <p class="text-[11px] text-slate-500">Registrar registry lock for Autumn trimester.</p>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 space-y-1">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-800">
                            <span>Faculty Academic Council</span>
                            <span class="text-slate-500">Oct 24</span>
                        </div>
                        <p class="text-[11px] text-slate-500">Quarterly review on curriculum updates and AI research grants.</p>
                    </div>
                </div>
            </div>

            <!-- Quick Management Shortcuts -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-3">
                <h3 class="text-sm font-bold text-slate-900">Admin Shortcuts</h3>
                <div class="grid grid-cols-2 gap-2 text-xs font-semibold">
                    <a href="{{ route('students.index') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-brand-50 hover:text-brand-700 border border-slate-200/70 text-slate-700 flex flex-col items-center justify-center gap-1.5 text-center transition-colors">
                        <svg class="w-5 h-5 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        <span>New Student</span>
                    </a>
                    <a href="{{ route('courses.index') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-brand-50 hover:text-brand-700 border border-slate-200/70 text-slate-700 flex flex-col items-center justify-center gap-1.5 text-center transition-colors">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Course Catalog</span>
                    </a>
                    <a href="{{ route('attendance.index') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-brand-50 hover:text-brand-700 border border-slate-200/70 text-slate-700 flex flex-col items-center justify-center gap-1.5 text-center transition-colors">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        <span>Roll Call</span>
                    </a>
                    <a href="{{ route('settings.index') }}" class="p-3 rounded-xl bg-slate-50 hover:bg-brand-50 hover:text-brand-700 border border-slate-200/70 text-slate-700 flex flex-col items-center justify-center gap-1.5 text-center transition-colors">
                        <svg class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                        <span>System Config</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
