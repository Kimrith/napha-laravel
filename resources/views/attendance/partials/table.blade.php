<!-- resources/views/attendance/partials/table.blade.php -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
    <!-- Sub-header & Filter -->
    <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 bg-slate-50/50">
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Class Roster</span>
            <span class="text-[11px] text-slate-400 font-medium">(Click status badge to toggle)</span>
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
            <span class="text-xs font-medium text-slate-500">Lecture:</span>
            <span class="text-xs font-bold text-slate-800 bg-white px-2.5 py-1 rounded-lg border border-slate-200 shadow-2xs">
                CS-101 · Object-Oriented Systems
            </span>
        </div>
    </div>

    <!-- Table -->
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
                            <button type="button" 
                                    @click="toggleStatus(att)" 
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold cursor-pointer transition-all hover:scale-105 active:scale-95"
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

    <!-- Table Footer Summary -->
    <div class="p-4 sm:px-6 bg-slate-50/70 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500 font-medium">

        <div>
            Total Active Enrollees: <strong class="text-slate-800" x-text="attendees.length"></strong> students in session
        </div>
        <div class="flex items-center gap-4">
            <span class="inline-flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Present: <strong class="text-slate-800" x-text="counts.present"></strong>
            </span>
            <span class="inline-flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span> Late: <strong class="text-slate-800" x-text="counts.late"></strong>
            </span>
            <span class="inline-flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-rose-500"></span> Absent: <strong class="text-slate-800" x-text="counts.absent"></strong>
            </span>
        </div>

        @include('components.share.pagination')
    </div>
</div>
