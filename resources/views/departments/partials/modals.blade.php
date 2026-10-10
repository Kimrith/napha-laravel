<!-- resources/views/departments/partials/modals.blade.php -->

<!-- ======================= 1. ADD DEPARTMENT MODAL ======================= -->
<div x-cloak 
     x-show="addModalOpen" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     aria-labelledby="modal-dept-title" 
     role="dialog" 
     aria-modal="true"
     @keydown.escape.window="addModalOpen = false">
    
    <div x-show="addModalOpen" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs transition-opacity"
         @click="addModalOpen = false"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div x-show="addModalOpen" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
             class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl border border-slate-100">
            
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900" id="modal-dept-title">Create Academic Department</h3>
                        <p class="text-xs text-slate-500 font-medium">Add a new faculty collegiate division to the academic catalog.</p>
                    </div>
                </div>
                <button type="button" @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form @submit.prevent="saveNewDept()" class="p-6 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Division Code *</label>
                        <input type="text" x-model="newDept.code" required placeholder="e.g. SCI" 
                               class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden font-mono uppercase text-slate-800">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Annual Grant Budget</label>
                        <input type="text" x-model="newDept.budget" placeholder="e.g. $2.5M" 
                               class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden text-slate-800">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Department Name *</label>
                    <input type="text" x-model="newDept.name" required placeholder="e.g. School of Computing & Informatics" 
                           class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden text-slate-800 font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Department Head / Chairperson *</label>
                    <input type="text" x-model="newDept.head" required placeholder="e.g. Prof. Alan Turing" 
                           class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden text-slate-800">
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Students</label>
                        <input type="number" x-model.number="newDept.students_count" min="0" 
                               class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl font-mono text-slate-800">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Faculty</label>
                        <input type="number" x-model.number="newDept.faculty_count" min="0" 
                               class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl font-mono text-slate-800">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Programs</label>
                        <input type="number" x-model.number="newDept.programs_count" min="1" 
                               class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl font-mono text-slate-800">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Enrollment Status</label>
                    <select x-model="newDept.status" 
                            class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden text-slate-800 font-medium">
                        <option value="Active">Active (Operational & Enrolling)</option>
                        <option value="Inactive">Inactive / Suspended</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Description & Mission</label>
                    <textarea x-model="newDept.description" rows="2" placeholder="Brief summary of division focus and degree pathways..." 
                              class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden text-slate-800"></textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-md shadow-brand-600/30 transition-all cursor-pointer">
                        Create Division
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================= 2. EDIT DEPARTMENT MODAL ======================= -->
<div x-cloak 
     x-show="editModalOpen" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     aria-labelledby="modal-edit-dept-title" 
     role="dialog" 
     aria-modal="true"
     @keydown.escape.window="editModalOpen = false">
    
    <div x-show="editModalOpen" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs transition-opacity"
         @click="editModalOpen = false"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div x-show="editModalOpen" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
             class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl border border-slate-100">
            
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900" id="modal-edit-dept-title">Edit Department Record</h3>
                        <p class="text-xs text-slate-500 font-medium">Update academic details for <span class="font-mono font-bold text-slate-700" x-text="editDept.code"></span>.</p>
                    </div>
                </div>
                <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form @submit.prevent="updateDept()" class="p-6 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Division Code *</label>
                        <input type="text" x-model="editDept.code" required 
                               class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden font-mono uppercase text-slate-800">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Annual Grant Budget</label>
                        <input type="text" x-model="editDept.budget" 
                               class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden text-slate-800">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Department Name *</label>
                    <input type="text" x-model="editDept.name" required 
                           class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden text-slate-800 font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Department Head / Chairperson *</label>
                    <input type="text" x-model="editDept.head" required 
                           class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden text-slate-800">
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Students</label>
                        <input type="number" x-model.number="editDept.students" min="0" 
                               class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl font-mono text-slate-800">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Faculty</label>
                        <input type="number" x-model.number="editDept.faculty" min="0" 
                               class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl font-mono text-slate-800">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1">Programs</label>
                        <input type="number" x-model.number="editDept.programs" min="0" 
                               class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl font-mono text-slate-800">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Enrollment Status</label>
                    <select x-model="editDept.status" 
                            class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden text-slate-800 font-medium">
                        <option value="Active">Active (Operational & Enrolling)</option>
                        <option value="Inactive">Inactive / Suspended</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Description & Mission</label>
                    <textarea x-model="editDept.description" rows="2" 
                              class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 outline-hidden text-slate-800"></textarea>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 shadow-md shadow-amber-600/30 transition-all cursor-pointer">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================= 3. DELETE DEPARTMENT MODAL ======================= -->
<div x-cloak 
     x-show="deleteModalOpen" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     role="dialog" 
     aria-modal="true"
     @keydown.escape.window="deleteModalOpen = false">
    
    <div x-show="deleteModalOpen" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs transition-opacity"
         @click="deleteModalOpen = false"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div x-show="deleteModalOpen" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
             class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-100 p-6">
            
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>

            <div class="text-center">
                <h3 class="text-lg font-bold text-slate-900">Delete Department</h3>
                <p class="text-xs text-slate-500 mt-2">
                    Are you sure you want to delete <strong class="text-slate-800" x-text="deptToDelete?.name"></strong> (<span class="font-mono text-slate-700" x-text="deptToDelete?.code"></span>)?
                </p>
                <div class="mt-3 p-3 bg-amber-50 rounded-xl border border-amber-200/80 text-left">
                    <p class="text-[11px] text-amber-800 font-medium">
                        ⚠️ Any students currently assigned to this department will be safely set to <strong>Unassigned Department</strong>.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-center gap-3">
                <button type="button" @click="deleteModalOpen = false" class="px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer">
                    Cancel
                </button>
                <button type="button" @click="executeDeleteDept()" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 shadow-md shadow-rose-600/30 transition-all cursor-pointer">
                    Delete Department
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ======================= 4. VIEW DEPARTMENT SLIDEOVER ======================= -->
<div x-cloak 
     x-show="viewModalOpen" 
     class="fixed inset-0 z-50 overflow-hidden" 
     role="dialog" 
     aria-modal="true"
     @keydown.escape.window="viewModalOpen = false">
    
    <div class="absolute inset-0 overflow-hidden">
        <div x-show="viewModalOpen" 
             x-transition:enter="ease-in-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in-out duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="viewModalOpen = false"
             class="absolute inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity"></div>

        <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
            <div x-show="viewModalOpen" 
                 x-transition:enter="transform transition ease-in-out duration-300"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-300"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="pointer-events-auto w-screen max-w-md bg-white shadow-2xl flex flex-col">
                
                <template x-if="activeDept">
                    <div class="h-full flex flex-col">
                        <!-- Dossier Header -->
                        <div class="p-6 bg-gradient-to-br from-slate-900 via-sidebar-base to-brand-950 text-white relative">
                            <button @click="viewModalOpen = false" 
                                    class="absolute top-5 right-5 text-slate-400 hover:text-white p-1 rounded-lg cursor-pointer">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                            
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-2.5 py-1 rounded-lg bg-brand-500/20 text-brand-300 border border-brand-500/30 font-mono text-xs font-bold" x-text="activeDept.code"></span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full"
                                      :class="activeDept.status === 'Active' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40' : 'bg-slate-700 text-slate-300'"
                                      x-text="activeDept.status">
                                </span>
                            </div>
                            <h3 class="text-lg font-extrabold text-white" x-text="activeDept.name"></h3>
                            <p class="text-xs text-brand-200 mt-1">Chair: <span class="font-semibold text-white" x-text="activeDept.head"></span></p>
                        </div>

                        <!-- Dossier Details -->
                        <div class="flex-1 overflow-y-auto p-6 space-y-6">
                            <!-- Metrics Bar -->
                            <div class="grid grid-cols-3 gap-3 p-3.5 bg-slate-50 rounded-2xl border border-slate-200/80 text-center">
                                <div>
                                    <span class="text-[10px] font-bold uppercase text-slate-400">Students</span>
                                    <p class="text-base font-extrabold text-slate-900 mt-0.5" x-text="activeDept.students"></p>
                                </div>
                                <div class="border-x border-slate-200">
                                    <span class="text-[10px] font-bold uppercase text-slate-400">Faculty</span>
                                    <p class="text-base font-extrabold text-slate-900 mt-0.5" x-text="activeDept.faculty"></p>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold uppercase text-slate-400">Programs</span>
                                    <p class="text-base font-extrabold text-brand-600 mt-0.5" x-text="activeDept.programs"></p>
                                </div>
                            </div>

                            <!-- Academic Overview -->
                            <div>
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Division Information</h4>
                                <div class="space-y-2.5 text-xs">
                                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                                        <span class="text-slate-500">Official Code</span>
                                        <span class="font-mono font-bold text-slate-800" x-text="activeDept.code"></span>
                                    </div>
                                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                                        <span class="text-slate-500">Chairperson</span>
                                        <span class="font-semibold text-slate-800" x-text="activeDept.head"></span>
                                    </div>
                                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                                        <span class="text-slate-500">Annual Research Budget</span>
                                        <span class="font-semibold text-emerald-600" x-text="activeDept.budget"></span>
                                    </div>
                                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                                        <span class="text-slate-500">Active Courses</span>
                                        <span class="font-semibold text-slate-800" x-text="(activeDept.courses_count || 0) + ' Catalogued'"></span>
                                    </div>
                                </div>
                            </div>

                            <template x-if="activeDept.description">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Division Mission</h4>
                                    <p class="text-xs text-slate-600 leading-relaxed bg-slate-50 p-3.5 rounded-xl border border-slate-200/80" x-text="activeDept.description"></p>
                                </div>
                            </template>
                        </div>

                        <!-- Slideover Footer -->
                        <div class="p-4 border-t border-slate-100 bg-slate-50 flex items-center justify-end gap-2">
                            <button type="button" @click="openEditModal(activeDept); viewModalOpen = false" 
                                    class="px-4 py-2 bg-white hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 transition-colors cursor-pointer">
                                Edit Division
                            </button>
                            <button type="button" @click="viewModalOpen = false" 
                                    class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-xs font-semibold transition-colors cursor-pointer">
                                Done
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
