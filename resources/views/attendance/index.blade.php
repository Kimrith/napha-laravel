@extends('layouts.app')

@section('title', 'Attendance Tracking | EduPulse Pro Portal')

@section('content')
<div x-data="{
    selectedDate: '2026-10-06',
    selectedLecture: 'CS-101 (Programming)',
    attendees: [
        { id: 'STU-2026-001', name: 'Alexander Wright', major: 'Computer Science', timeIn: '08:54 AM', status: 'Present' },
        { id: 'STU-2026-002', name: 'Amara Okafor', major: 'Data Science & AI', timeIn: '08:58 AM', status: 'Present' },
        { id: 'STU-2026-003', name: 'Clara Lindqvist', major: 'Digital Design', timeIn: '09:05 AM', status: 'Late' },
        { id: 'STU-2026-004', name: 'Marcus Chen', major: 'Robotics & Automation', timeIn: '--:--', status: 'Excused' },
        { id: 'STU-2026-005', name: 'Sophia Martinez', major: 'Biotechnology', timeIn: '08:50 AM', status: 'Present' },
        { id: 'STU-2026-006', name: 'Liam Davies', major: 'International Finance', timeIn: '08:59 AM', status: 'Present' },
        { id: 'STU-2026-007', name: 'Fatima Al-Zahra', major: 'Cybersecurity', timeIn: '08:48 AM', status: 'Present' },
        { id: 'STU-2026-008', name: 'Ethan Taylor', major: 'Media Communications', timeIn: '--:--', status: 'Absent' }
    ],
    toggleStatus(attendee) {
        const order = ['Present', 'Late', 'Excused', 'Absent'];
        const nextIdx = (order.indexOf(attendee.status) + 1) % order.length;
        attendee.status = order[nextIdx];
        showToast(`Updated attendance for ${attendee.name} to ${attendee.status}`, 'info');
    }
}" class="space-y-6">

    <!-- Breadcrumbs -->
    <nav class="flex items-center text-xs font-medium text-slate-500 gap-2">
        <a href="{{ route('dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
        <svg class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        <span class="text-brand-600 font-semibold bg-brand-50 px-2 py-0.5 rounded-md border border-brand-100">Attendance Tracker</span>
    </nav>

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Attendance & Roll-Call Registry</h1>
            <p class="text-sm text-slate-500 mt-1">Live lecture hall check-ins, barcode verification, and absence audits.</p>
        </div>
        <div class="flex items-center gap-3">
            <button @click="showToast('Attendance report exported to registrar.', 'success')"
                    class="px-4 py-2.5 rounded-xl text-sm font-semibold bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 shadow-2xs">
                Export Daily Log
            </button>
            <button @click="showToast('Roll-call finalized for today.', 'success')"
                    class="px-4 py-2.5 rounded-xl text-sm font-semibold bg-brand-600 text-white hover:bg-brand-700 shadow-md shadow-brand-600/30">
                Submit Roll-Call
            </button>
        </div>
    </div>

    <!-- Attendance Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs">
            <span class="text-xs font-bold text-slate-400 uppercase">Today's Attendance Rate</span>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-slate-900">92.5%</span>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-md">High Compliance</span>
            </div>
            <p class="text-xs text-slate-500 mt-1">6 Present, 1 Late, 1 Absent</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs">
            <span class="text-xs font-bold text-slate-400 uppercase">Average Check-in Time</span>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-slate-900">08:56 AM</span>
                <span class="text-xs font-medium text-slate-500">4 min before lecture</span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Hall Alpha-2 Scanner 01</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs">
            <span class="text-xs font-bold text-slate-400 uppercase">Term Absence Alerts</span>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-slate-900">2 Alerts</span>
                <span class="text-xs font-semibold text-amber-700 bg-amber-50 px-1.5 py-0.5 rounded-md">Warning</span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Students below 80% threshold</p>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 bg-slate-50/50">
            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Class Roster (Click status badge to toggle)</span>
            <div class="flex items-center gap-2">
                <span class="text-xs font-medium text-slate-500">Lecture:</span>
                <span class="text-xs font-bold text-slate-800 bg-white px-2.5 py-1 rounded-lg border border-slate-200">CS-101 · Object-Oriented Systems</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/90 border-b border-slate-200/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-4 px-5">Student ID</th>
                        <th class="py-4 px-5">Student Name</th>
                        <th class="py-4 px-4">Academic Major</th>
                        <th class="py-4 px-4">Recorded Time</th>
                        <th class="py-4 px-5 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    <template x-for="att in attendees" :key="att.id">
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-5 font-mono text-xs font-bold text-slate-700" x-text="att.id"></td>
                            <td class="py-4 px-5 font-bold text-slate-900" x-text="att.name"></td>
                            <td class="py-4 px-4 text-xs text-slate-500" x-text="att.major"></td>
                            <td class="py-4 px-4 font-mono text-xs text-slate-600" x-text="att.timeIn"></td>
                            <td class="py-4 px-5 text-right">
                                <button @click="toggleStatus(att)" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold cursor-pointer transition-all hover:scale-105"
                                        :class="{
                                            'bg-emerald-50 text-emerald-700 border border-emerald-200': att.status === 'Present',
                                            'bg-amber-50 text-amber-700 border border-amber-200': att.status === 'Late',
                                            'bg-blue-50 text-brand-700 border border-brand-200': att.status === 'Excused',
                                            'bg-rose-50 text-rose-700 border border-rose-200': att.status === 'Absent'
                                        }">
                                    <span class="w-1.5 h-1.5 rounded-full"
                                          :class="{
                                              'bg-emerald-500': att.status === 'Present',
                                              'bg-amber-500': att.status === 'Late',
                                              'bg-brand-500': att.status === 'Excused',
                                              'bg-rose-500': att.status === 'Absent'
                                          }"></span>
                                    <span x-text="att.status"></span>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
