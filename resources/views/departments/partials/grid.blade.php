<!-- resources/views/departments/partials/grid.blade.php -->
<div class="space-y-6">
    <!-- Departments Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <template x-for="dept in paginatedDepartments" :key="dept.id || dept.code">
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex flex-col justify-between group">
                <div>
                    <!-- Card Top Header -->
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-2.5 py-1 rounded-lg bg-brand-50 text-brand-700 font-mono text-xs font-bold border border-brand-200/60" x-text="dept.code"></span>
                        <template x-if="dept.status === 'Active'">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 ring-4 ring-emerald-500/20"></span>
                                <span>Active</span>
                            </span>
                        </template>
                        <template x-if="dept.status !== 'Active'">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                <span>Inactive</span>
                            </span>
                        </template>
                    </div>

                    <!-- Department Title & Chairperson -->
                    <h3 class="text-base font-bold text-slate-900 group-hover:text-brand-600 transition-colors leading-snug cursor-pointer"
                        @click="viewDepartment(dept)"
                        x-text="dept.name">
                    </h3>
                    <div class="flex items-center gap-1.5 text-xs text-slate-500 mt-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Chair: <strong class="text-slate-700 font-semibold" x-text="dept.head"></strong></span>
                    </div>

                    <template x-if="dept.description">
                        <p class="text-xs text-slate-400 mt-2 line-clamp-2" x-text="dept.description"></p>
                    </template>

                    <!-- Metrics Grid -->
                    <div class="grid grid-cols-4 gap-2 mt-5 py-3 border-y border-slate-100 text-center bg-slate-50/50 rounded-xl">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Students</span>
                            <p class="text-sm font-extrabold text-slate-900 mt-0.5" x-text="dept.students"></p>
                        </div>
                        <div class="border-l border-slate-200/60">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Faculty</span>
                            <p class="text-sm font-extrabold text-slate-900 mt-0.5" x-text="dept.faculty"></p>
                        </div>
                        <div class="border-l border-slate-200/60">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Programs</span>
                            <p class="text-sm font-extrabold text-slate-900 mt-0.5" x-text="dept.programs"></p>
                        </div>
                        <div class="border-l border-slate-200/60">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Courses</span>
                            <p class="text-sm font-extrabold text-brand-600 mt-0.5" x-text="dept.courses_count || 0"></p>
                        </div>
                    </div>
                </div>

                <!-- Card Bottom Actions -->
                <div class="mt-5 pt-3.5 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-400 font-medium">Grant: <strong class="text-slate-800 font-semibold" x-text="dept.budget"></strong></span>
                    <div class="flex items-center gap-1">
                        <button type="button" 
                                @click="viewDepartment(dept)" 
                                class="p-1.5 text-slate-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-colors cursor-pointer"
                                title="View Division Dossier">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                        <button type="button" 
                                @click="openEditModal(dept)" 
                                class="p-1.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors cursor-pointer"
                                title="Edit Department">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </button>
                        <button type="button" 
                                @click="confirmDelete(dept)" 
                                class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer"
                                title="Delete Department">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
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
        <h3 class="text-sm font-bold text-slate-800">No departments match your filter</h3>
        <p class="text-xs text-slate-500 mt-1">Try clearing your search query or adjusting active filters.</p>
        <button type="button" 
                @click="searchQuery = ''; selectedStatus = 'All'" 
                class="mt-3 px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-brand-50 text-brand-600 hover:bg-brand-100 transition-colors cursor-pointer">
            Reset search
        </button>
    </div>

    <!-- Pagination Footer -->
    <div class="p-4 sm:px-6 bg-white rounded-2xl border border-slate-200/80 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4 text-xs text-slate-500 font-medium">
            <div>
                Showing <span class="font-bold text-slate-800" x-text="filteredDepartments.length > 0 ? (currentPage - 1) * perPage + 1 : 0"></span>
                to <span class="font-bold text-slate-800" x-text="Math.min(currentPage * perPage, filteredDepartments.length)"></span>
                of <span class="font-bold text-slate-800" x-text="filteredDepartments.length"></span> divisions
            </div>

            <div class="flex items-center gap-1.5 border-l border-slate-200 pl-4">
                <span class="text-slate-400">Per page:</span>
                <select x-model.number="perPage" @change="currentPage = 1" class="px-2 py-1 bg-white border border-slate-200 rounded-md text-xs font-semibold text-slate-700 focus:outline-none focus:ring-1 focus:ring-brand-500 cursor-pointer">
                    <option :value="6">6</option>
                    <option :value="9">9</option>
                    <option :value="12">12</option>
                    <option :value="24">24</option>
                </select>
            </div>
        </div>

        @include('components.share.pagination')
    </div>
</div>
