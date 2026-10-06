<!-- resources/views/departments/partials/grid.blade.php -->
<div>
    <!-- Departments Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <template x-for="dept in filteredDepartments" :key="dept.code">
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-2.5 py-1 rounded-lg bg-brand-50 text-brand-700 font-mono text-xs font-bold border border-brand-200/60" x-text="dept.code"></span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span x-text="dept.status"></span>
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
                    <button type="button" 
                            @click="manageDepartment(dept)" 
                            class="font-semibold text-brand-600 hover:text-brand-700 flex items-center gap-1 transition-colors">
                        <span>Manage Dept</span>
                        <span>&rarr;</span>
                    </button>
                </div>
            </div>
        </template>
    </div>

    <!-- Empty State -->
    <div x-show="filteredDepartments.length === 0" class="bg-white rounded-2xl p-12 text-center border border-slate-200">
        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
        <h3 class="text-sm font-bold text-slate-800">No departments match your search</h3>
        <p class="text-xs text-slate-500 mt-1">Try clearing your search query to see all academic divisions.</p>
        <button type="button" 
                @click="searchQuery = ''" 
                class="mt-3 px-3 py-1.5 rounded-lg text-xs font-semibold bg-brand-50 text-brand-600 hover:bg-brand-100 transition-colors">
            Reset search
        </button>
    </div>

    <div class="px-6 py-4 sm:px-8 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
        <div class="text-xs text-slate-500">
            Displaying <strong class="text-slate-800" x-text="pagination.to"></strong> of <strong class="text-slate-800" x-text="pagination.total"></strong> departments
        </div>
        <div class="flex items-center gap-2">
            @include('components.share.pagination')
        </div>
    </div>
</div>
