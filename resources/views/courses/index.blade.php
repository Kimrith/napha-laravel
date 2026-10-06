@extends('layouts.app')

@section('title', 'Active Courses | EduPulse Pro Portal')

@section('content')
<div x-data="{
    searchQuery: '',
    selectedDepartment: 'All',
    courses: [
        { code: 'CS-101', name: 'Object-Oriented Programming in C++ & Rust', dept: 'Computer Science', instructor: 'Prof. Alan Turing', credits: 4, enrolled: 88, capacity: 90, days: 'Mon, Wed 09:00 - 11:00 AM', room: 'Hall Alpha-2', status: 'Active' },
        { code: 'AI-402', name: 'Deep Learning & Neural Architectures', dept: 'Informatics & AI', instructor: 'Dr. Fei-Fei Li', credits: 4, enrolled: 64, capacity: 65, days: 'Tue, Thu 01:30 - 03:30 PM', room: 'Lab Turing-1', status: 'Active' },
        { code: 'DES-204', name: 'Human-Centered UI/UX Systems', dept: 'Digital Design', instructor: 'Prof. Jony Ive', credits: 3, enrolled: 52, capacity: 60, days: 'Wed, Fri 10:00 - 12:00 PM', room: 'Studio Beta', status: 'Active' },
        { code: 'ROB-310', name: 'Autonomous Robotics & Kinematics', dept: 'Mechatronics', instructor: 'Dr. Rodney Brooks', credits: 4, enrolled: 45, capacity: 50, days: 'Mon, Thu 02:00 - 04:00 PM', room: 'RoboLab 4', status: 'Active' },
        { code: 'BIO-215', name: 'Genomic Sequencing & CRISPR Protocols', dept: 'Life Sciences', instructor: 'Dr. Jennifer Doudna', credits: 4, enrolled: 72, capacity: 75, days: 'Tue, Fri 09:00 - 11:00 AM', room: 'BioLab 3', status: 'Active' },
        { code: 'FIN-350', name: 'Quantitative Global Financial Markets', dept: 'Business & Finance', instructor: 'Prof. Paul Krugman', credits: 3, enrolled: 80, capacity: 80, days: 'Mon, Wed 01:00 - 02:30 PM', room: 'Hall Gamma-1', status: 'Full' },
        { code: 'SEC-401', name: 'Applied Cryptography & Zero-Knowledge Proofs', dept: 'Cybersecurity', instructor: 'Dr. Whitfield Diffie', credits: 4, enrolled: 58, capacity: 60, days: 'Tue, Thu 11:00 - 01:00 PM', room: 'SecVault Lab', status: 'Active' }
    ],
    get filteredCourses() {
        return this.courses.filter(c => {
            const matchesQuery = this.searchQuery === '' || 
                c.code.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                c.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                c.instructor.toLowerCase().includes(this.searchQuery.toLowerCase());
            const matchesDept = this.selectedDepartment === 'All' || c.dept === this.selectedDepartment;
            return matchesQuery && matchesDept;
        });
    }
}" class="space-y-6">

    <!-- Breadcrumbs -->
    <nav class="flex items-center text-xs font-medium text-slate-500 gap-2">
        <a href="{{ route('dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
        <svg class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        <span class="text-brand-600 font-semibold bg-brand-50 px-2 py-0.5 rounded-md border border-brand-100">Active Courses</span>
    </nav>

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Active Courses</h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-brand-50 text-brand-700 border border-brand-200" x-text="filteredCourses.length + ' Courses'"></span>
            </div>
            <p class="text-sm text-slate-500 mt-1">Curriculum schedules, enrolled student quotas, and faculty instruction assignments.</p>
        </div>
        <button @click="showToast('Course creation modal opened', 'info')" 
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-md shadow-brand-600/30 transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M12 4v16m8-8H4"/></svg>
            <span>+ Add New Course</span>
        </button>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" x-model="searchQuery" placeholder="Search by course code, title, or professor..." 
                   class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 focus:bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden text-slate-800">
        </div>
        <div class="w-full sm:w-60">
            <select x-model="selectedDepartment" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 focus:bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden text-slate-800 font-medium">
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
    </div>

    <!-- Courses Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/90 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-4 px-5">Course Code</th>
                        <th class="py-4 px-5">Course Title & Department</th>
                        <th class="py-4 px-4">Instructor</th>
                        <th class="py-4 px-4">Credits</th>
                        <th class="py-4 px-4">Enrolled / Cap</th>
                        <th class="py-4 px-4">Schedule & Room</th>
                        <th class="py-4 px-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    <template x-for="course in filteredCourses" :key="course.code">
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-5">
                                <span class="px-2.5 py-1 rounded-lg bg-brand-50 text-brand-700 font-mono text-xs font-bold border border-brand-200/60" x-text="course.code"></span>
                            </td>
                            <td class="py-4 px-5">
                                <p class="font-bold text-slate-900" x-text="course.name"></p>
                                <p class="text-xs text-slate-400 mt-0.5" x-text="course.dept"></p>
                            </td>
                            <td class="py-4 px-4 text-xs font-semibold text-slate-700" x-text="course.instructor"></td>
                            <td class="py-4 px-4 text-xs font-bold text-slate-900" x-text="course.credits + ' ECTS'"></td>
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-semibold text-slate-800" x-text="course.enrolled + '/' + course.capacity"></span>
                                    <div class="w-16 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                        <div class="h-1.5 rounded-full" 
                                             :class="course.enrolled >= course.capacity ? 'bg-amber-500' : 'bg-brand-500'" 
                                             :style="'width: ' + Math.min(100, Math.round((course.enrolled/course.capacity)*100)) + '%'"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <p class="text-xs font-medium text-slate-700" x-text="course.days"></p>
                                <p class="text-[11px] text-slate-400 font-mono" x-text="course.room"></p>
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold"
                                      :class="course.status === 'Full' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200'">
                                    <span class="w-1.5 h-1.5 rounded-full" :class="course.status === 'Full' ? 'bg-amber-500' : 'bg-emerald-500'"></span>
                                    <span x-text="course.status"></span>
                                </span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
