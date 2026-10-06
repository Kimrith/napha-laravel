@extends('layouts.app')

@section('title', 'Grades & Academic Records | EduPulse Pro Portal')

@section('content')
<div x-data="{
    searchQuery: '',
    records: [
        { id: 'STU-2026-001', name: 'Alexander Wright', major: 'Computer Science', course: 'CS-101 Programming', midScore: 94, finalScore: 96, grade: 'A+', gpa: '4.00', standing: 'Dean\'s Honors' },
        { id: 'STU-2026-002', name: 'Amara Okafor', major: 'Data Science & AI', course: 'AI-402 Deep Learning', midScore: 98, finalScore: 97, grade: 'A+', gpa: '4.00', standing: 'Dean\'s Honors' },
        { id: 'STU-2026-003', name: 'Clara Lindqvist', major: 'Digital Design', course: 'DES-204 UX Systems', midScore: 88, finalScore: 89, grade: 'A-', gpa: '3.70', standing: 'Good Standing' },
        { id: 'STU-2026-004', name: 'Marcus Chen', major: 'Robotics & Automation', course: 'ROB-310 Kinematics', midScore: 78, finalScore: 82, grade: 'B', gpa: '3.00', standing: 'Good Standing' },
        { id: 'STU-2026-005', name: 'Sophia Martinez', major: 'Biotechnology', course: 'BIO-215 CRISPR Protocols', midScore: 92, finalScore: 94, grade: 'A', gpa: '3.90', standing: 'Dean\'s Honors' },
        { id: 'STU-2026-006', name: 'Liam Davies', major: 'International Finance', course: 'FIN-350 Global Finance', midScore: 84, finalScore: 86, grade: 'B+', gpa: '3.30', standing: 'Good Standing' },
        { id: 'STU-2026-007', name: 'Fatima Al-Zahra', major: 'Cybersecurity', course: 'SEC-401 Cryptography', midScore: 100, finalScore: 99, grade: 'A+', gpa: '4.00', standing: 'Dean\'s Honors' },
        { id: 'STU-2026-008', name: 'Ethan Taylor', major: 'Media Communications', course: 'MED-110 Media Ethics', midScore: 75, finalScore: 79, grade: 'C+', gpa: '2.70', standing: 'Academic Review' }
    ],
    get filteredRecords() {
        return this.records.filter(r => 
            this.searchQuery === '' ||
            r.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
            r.id.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
            r.course.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
    }
}" class="space-y-6">

    <!-- Breadcrumbs -->
    <nav class="flex items-center text-xs font-medium text-slate-500 gap-2">
        <a href="{{ route('dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
        <svg class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        <span class="text-brand-600 font-semibold bg-brand-50 px-2 py-0.5 rounded-md border border-brand-100">Grades & Records</span>
    </nav>

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Grades & Academic Transcripts</h1>
            <p class="text-sm text-slate-500 mt-1">Official GPA calculations, examination score audits, and semester honors records.</p>
        </div>
        <div class="flex items-center gap-3">
            <button @click="showToast('Official transcript zip file compiling...', 'info')"
                    class="px-4 py-2.5 rounded-xl text-sm font-semibold bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 shadow-2xs">
                Export Grade Ledger
            </button>
            <button @click="showToast('Grade certification verified by Dean of Records.', 'success')"
                    class="px-4 py-2.5 rounded-xl text-sm font-semibold bg-brand-600 text-white hover:bg-brand-700 shadow-md shadow-brand-600/30">
                Certify Semester Grades
            </button>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" x-model="searchQuery" placeholder="Search student name, ID, or course module..." 
                   class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 focus:bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden text-slate-800">
        </div>
    </div>

    <!-- Grades Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/90 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-4 px-5">Student</th>
                        <th class="py-4 px-4">Course Module</th>
                        <th class="py-4 px-4">Mid-Term</th>
                        <th class="py-4 px-4">Final Exam</th>
                        <th class="py-4 px-4">Letter Grade</th>
                        <th class="py-4 px-4">Course GPA</th>
                        <th class="py-4 px-5 text-right">Academic Standing</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    <template x-for="rec in filteredRecords" :key="rec.id">
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-5">
                                <p class="font-bold text-slate-900" x-text="rec.name"></p>
                                <p class="text-xs text-slate-400 font-mono" x-text="rec.id"></p>
                            </td>
                            <td class="py-4 px-4 text-xs font-semibold text-slate-700" x-text="rec.course"></td>
                            <td class="py-4 px-4 text-xs font-mono font-medium text-slate-800" x-text="rec.midScore + ' / 100'"></td>
                            <td class="py-4 px-4 text-xs font-mono font-medium text-slate-800" x-text="rec.finalScore + ' / 100'"></td>
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold font-mono"
                                      :class="{
                                          'bg-emerald-50 text-emerald-700 border border-emerald-200': rec.grade.startsWith('A'),
                                          'bg-blue-50 text-brand-700 border border-brand-200': rec.grade.startsWith('B'),
                                          'bg-amber-50 text-amber-700 border border-amber-200': rec.grade.startsWith('C')
                                      }" x-text="rec.grade"></span>
                            </td>
                            <td class="py-4 px-4 font-mono font-bold text-xs text-slate-900" x-text="rec.gpa"></td>
                            <td class="py-4 px-5 text-right">
                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full"
                                      :class="rec.standing === 'Dean\'s Honors' ? 'bg-purple-50 text-purple-700 border border-purple-200' : 'bg-slate-100 text-slate-700'"
                                      x-text="rec.standing"></span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
