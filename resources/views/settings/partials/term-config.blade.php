<!-- resources/views/settings/partials/term-config.blade.php -->
<div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-5">
    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
        <div>
            <h3 class="text-base font-bold text-slate-900">Current Academic Term Window</h3>
            <p class="text-xs text-slate-500 mt-0.5">Defines the active registration trimester and examination schedules.</p>
        </div>
        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Active Term</span>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Term Name</label>
            <input type="text" x-model="term.name" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white text-slate-800 font-medium">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Current Academic Week</label>
            <input type="text" x-model="term.week" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white text-slate-800 font-medium">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Semester Start Date</label>
            <input type="date" x-model="term.startDate" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white text-slate-800">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Semester End Date</label>
            <input type="date" x-model="term.endDate" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white text-slate-800">
        </div>
    </div>
</div>
