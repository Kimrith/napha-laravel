@extends('layouts.app')

@section('title', 'Academic Departments | EduPulse Pro Portal')

@section('content')
<div x-data="{
    departments: [
        { name: 'School of Computing & Informatics', code: 'SCI', head: 'Prof. Alan Turing', students: 894, faculty: 34, programs: 6, budget: '$2.4M', status: 'Active' },
        { name: 'School of Business & Global Finance', code: 'SBGF', head: 'Prof. Paul Krugman', students: 642, faculty: 26, programs: 5, budget: '$1.8M', status: 'Active' },
        { name: 'Faculty of Life Sciences & Biotech', code: 'FLSB', head: 'Dr. Jennifer Doudna', students: 520, faculty: 22, programs: 4, budget: '$3.1M', status: 'Active' },
        { name: 'Design, Arts & Human Experience', code: 'DAHE', head: 'Prof. Jony Ive', students: 410, faculty: 18, programs: 4, budget: '$1.2M', status: 'Active' },
        { name: 'Mechatronics & Robotics Engineering', code: 'MRE', head: 'Dr. Rodney Brooks', students: 379, faculty: 15, programs: 3, budget: '$2.8M', status: 'Active' }
    ]
}" class="space-y-6">

    <!-- Breadcrumbs -->
    <nav class="flex items-center text-xs font-medium text-slate-500 gap-2">
        <a href="{{ route('dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
        <svg class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        <span class="text-brand-600 font-semibold bg-brand-50 px-2 py-0.5 rounded-md border border-brand-100">Departments</span>
    </nav>

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Academic Departments</h1>
            <p class="text-sm text-slate-500 mt-1">Collegiate divisions, chairpersons, faculty staffing ratios, and research budget allocations.</p>
        </div>
        <button @click="showToast('Department setup wizard opened.', 'info')" 
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-md shadow-brand-600/30">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M12 4v16m8-8H4"/></svg>
            <span>+ Add Department</span>
        </button>
    </div>

    <!-- Departments Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <template x-for="dept in departments" :key="dept.code">
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-2.5 py-1 rounded-lg bg-brand-50 text-brand-700 font-mono text-xs font-bold border border-brand-200/60" x-text="dept.code"></span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span>Active</span>
                        </span>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 leading-snug" x-text="dept.name"></h3>
                    <p class="text-xs text-slate-500 mt-1">Head: <span class="font-semibold text-slate-700" x-text="dept.head"></span></p>

                    <div class="grid grid-cols-3 gap-2 mt-5 py-3 border-y border-slate-100 text-center">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Students</span>
                            <p class="text-sm font-bold text-slate-900 mt-0.5" x-text="dept.students"></p>
                        </div>
                        <div class="border-x border-slate-100">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Faculty</span>
                            <p class="text-sm font-bold text-slate-900 mt-0.5" x-text="dept.faculty"></p>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Programs</span>
                            <p class="text-sm font-bold text-slate-900 mt-0.5" x-text="dept.programs"></p>
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-3 flex items-center justify-between text-xs">
                    <span class="text-slate-400 font-medium">Annual Grant: <strong class="text-slate-700" x-text="dept.budget"></strong></span>
                    <button @click="showToast('Loading faculty directory for ' + dept.code, 'info')" 
                            class="font-semibold text-brand-600 hover:text-brand-700">
                        Manage Dept &rarr;
                    </button>
                </div>
            </div>
        </template>
    </div>

</div>
@endsection
