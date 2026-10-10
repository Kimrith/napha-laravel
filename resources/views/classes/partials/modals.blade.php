<!-- resources/views/classes/partials/modals.blade.php -->

<!-- ======================= 1. ADD CLASS MODAL ======================= -->
<div x-cloak x-show="addModalOpen" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="addModalOpen" @click="addModalOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div x-show="addModalOpen" 
             class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Add New Class Cohort</h3>
                </div>
                <button @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form action="{{ route('classes.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Class Code *</label>
                    <input type="text" name="code" x-model="newClass.code" required placeholder="e.g. SV1, SV7, CS-401"
                           class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 text-slate-800 font-mono font-semibold uppercase">
                    <p class="text-[11px] text-slate-400 mt-1">Short identifier like SV1, SV2, SV7.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Class Title / Description *</label>
                    <input type="text" name="name" x-model="newClass.name" required placeholder="e.g. Year 4 Web & Cloud SV7"
                           class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 text-slate-800 font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Status</label>
                    <select name="status" x-model="newClass.status" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-800">
                        <option value="Active">Active</option>
                        <option value="Archived">Archived / Completed</option>
                    </select>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-brand-600 hover:bg-brand-700 shadow-sm">Save Class</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================= 2. EDIT CLASS MODAL ======================= -->
<div x-cloak x-show="editModalOpen" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="editModalOpen" @click="editModalOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div x-show="editModalOpen" 
             class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900">Edit Class Cohort</h3>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form :action="'/classes/' + (editClass.id || '')" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Class Code *</label>
                    <input type="text" name="code" x-model="editClass.code" required
                           class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white text-slate-800 font-mono font-semibold uppercase">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Class Title *</label>
                    <input type="text" name="name" x-model="editClass.name" required
                           class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white text-slate-800 font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1.5">Status</label>
                    <select name="status" x-model="editClass.status" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-800">
                        <option value="Active">Active</option>
                        <option value="Archived">Archived / Completed</option>
                    </select>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-brand-600 hover:bg-brand-700 shadow-sm">Update Class</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================= 3. DELETE CLASS MODAL ======================= -->
<div x-cloak x-show="deleteModalOpen" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 text-center sm:block sm:p-0">
        <div x-show="deleteModalOpen" @click="deleteModalOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div x-show="deleteModalOpen" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full p-6 border border-slate-100">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Delete Class</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Students will become unassigned.</p>
                </div>
            </div>

            <p class="text-sm text-slate-600 mb-6">
                Are you sure you want to delete class <strong class="text-slate-900 font-mono" x-text="classToDelete?.code"></strong>?
            </p>

            <form :action="'/classes/' + (classToDelete?.id || '')" method="POST" class="flex justify-end gap-3">
                @csrf
                @method('DELETE')
                <button type="button" @click="deleteModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">Cancel</button>
                <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-sm">Confirm Delete</button>
            </form>
        </div>
    </div>
</div>

<!-- ======================= 4. ASSIGN STUDENTS MODAL ======================= -->
<div x-cloak x-show="assignModalOpen" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="assignModalOpen" @click="assignModalOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div x-show="assignModalOpen" 
             class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full border border-slate-100">
            
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span>Assign Students to</span>
                        <span class="px-2.5 py-0.5 rounded-lg bg-brand-50 text-brand-700 border border-brand-200 text-xs font-mono font-bold" x-text="activeClass?.code"></span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5" x-text="activeClass?.name"></p>
                </div>
                <button @click="assignModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Student Search & Selection Form -->
            <form :action="'/classes/' + (activeClass?.id || '') + '/assign'" method="POST" class="p-6 space-y-4">
                @csrf
                
                <div class="flex items-center justify-between gap-3">
                    <div class="relative flex-1">
                        <input type="text" 
                               x-model="assignSearchQuery" 
                               placeholder="Search students to assign..." 
                               class="w-full pl-9 pr-3 py-2 text-xs bg-slate-50 focus:bg-white border border-slate-200 rounded-xl outline-hidden focus:border-brand-500">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <button type="button" @click="selectAllAssignable()" class="px-3 py-2 rounded-xl text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 whitespace-nowrap">
                        Select All
                    </button>
                </div>

                <!-- Students List with Checkboxes -->
                <div class="max-h-64 overflow-y-auto space-y-2 border border-slate-100 rounded-2xl p-2 bg-slate-50/50">
                    <template x-for="st in filteredAssignableStudents" :key="st.id">
                        <label class="flex items-center justify-between p-2.5 rounded-xl bg-white border border-slate-200/70 hover:border-brand-300 cursor-pointer transition-all shadow-2xs">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" 
                                       name="student_ids[]" 
                                       :value="st.id" 
                                       :checked="selectedStudentIds.includes(st.id)"
                                       @change="toggleStudentSelection(st.id)"
                                       class="w-4 h-4 rounded text-brand-600 focus:ring-brand-500 border-slate-300">
                                <img :src="st.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(st.name)" class="w-8 h-8 rounded-full object-cover">
                                <div>
                                    <div class="font-bold text-xs text-slate-900" x-text="st.name"></div>
                                    <div class="text-[10px] text-slate-400 font-mono" x-text="st.student_id + ' • ' + st.major"></div>
                                </div>
                            </div>
                            <span class="text-[10px] px-2 py-0.5 rounded-full font-semibold"
                                  :class="st.class_id === activeClass?.id ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : (st.class_id ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-slate-100 text-slate-600')"
                                  x-text="st.class_id === activeClass?.id ? 'Currently in this class' : (st.class_id ? 'In other class' : 'Unassigned')">
                            </span>
                        </label>
                    </template>
                    <template x-if="filteredAssignableStudents.length === 0">
                        <div class="p-4 text-center text-xs text-slate-400">No students found matching search.</div>
                    </template>
                </div>

                <!-- Footer Summary & Actions -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500" x-text="selectedStudentIds.length + ' students selected'"></span>
                    <div class="flex gap-2">
                        <button type="button" @click="assignModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">Cancel</button>
                        <button type="submit" :disabled="selectedStudentIds.length === 0" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-brand-600 hover:bg-brand-700 disabled:opacity-50 shadow-sm">
                            Assign to <span x-text="activeClass?.code"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================= 5. VIEW ROSTER MODAL ======================= -->
<div x-cloak x-show="rosterModalOpen" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="rosterModalOpen" @click="rosterModalOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div x-show="rosterModalOpen" 
             class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full border border-slate-100">
            
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span>Class Roster</span>
                        <span class="px-2.5 py-0.5 rounded-lg bg-brand-50 text-brand-700 border border-brand-200 text-xs font-mono font-bold" x-text="activeClass?.code"></span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5" x-text="activeClass?.name"></p>
                </div>
                <button @click="rosterModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="p-6 space-y-3">
                <div class="max-h-80 overflow-y-auto space-y-2">
                    <template x-for="st in (activeClass?.students || [])" :key="st.id">
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <div class="flex items-center gap-3">
                                <img :src="st.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(st.name)" class="w-9 h-9 rounded-full object-cover">
                                <div>
                                    <div class="font-bold text-xs text-slate-900" x-text="st.name"></div>
                                    <div class="text-[11px] text-slate-400 font-mono" x-text="st.student_id + ' • ' + (st.major || 'Computer Science')"></div>
                                </div>
                            </div>

                            <form :action="'/classes/' + activeClass.id + '/students/' + st.id" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Remove this student from the class?')"
                                        class="text-xs text-rose-600 hover:text-rose-700 font-semibold px-2.5 py-1 rounded-lg hover:bg-rose-50 transition-colors">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </template>
                    <template x-if="!activeClass?.students || activeClass.students.length === 0">
                        <div class="py-12 text-center text-xs text-slate-400">
                            No students currently enrolled in this cohort.
                        </div>
                    </template>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-between items-center">
                    <span class="text-xs font-semibold text-slate-500" x-text="(activeClass?.students?.length || 0) + ' Students Total'"></span>
                    <button type="button" @click="rosterModalOpen = false; openAssignModal(activeClass)" class="px-4 py-2 rounded-xl text-xs font-bold text-brand-600 bg-brand-50 hover:bg-brand-100 transition-colors">
                        + Assign More Students
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
