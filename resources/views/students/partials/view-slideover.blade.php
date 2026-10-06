<!-- resources/views/students/partials/view-slideover.blade.php -->
<div x-cloak x-show="viewSlideOverOpen" 
     class="fixed inset-0 z-50 overflow-hidden" 
     aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
    <div class="absolute inset-0 overflow-hidden">
        <!-- Backdrop -->
        <div x-show="viewSlideOverOpen" 
             x-transition:enter="ease-in-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in-out duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="viewSlideOverOpen = false"
             class="absolute inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity"></div>

        <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
            <div x-show="viewSlideOverOpen" 
                 x-transition:enter="transform transition ease-in-out duration-300"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-300"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="pointer-events-auto w-screen max-w-md bg-white shadow-2xl flex flex-col">
                
                <template x-if="activeStudent">
                    <div class="h-full flex flex-col">
                        <!-- Dossier Header -->
                        <div class="p-6 bg-gradient-to-br from-slate-900 via-sidebar-base to-brand-950 text-white relative">
                            <button @click="viewSlideOverOpen = false" 
                                    class="absolute top-5 right-5 text-slate-400 hover:text-white p-1 rounded-lg">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                            
                            <div class="flex items-center gap-4">
                                <img :src="activeStudent.avatar" :alt="activeStudent.name" 
                                     class="w-16 h-16 rounded-2xl object-cover ring-4 ring-white/20 shadow-xl">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-lg font-extrabold text-white" x-text="activeStudent.name"></h3>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full"
                                              :class="activeStudent.status === 'Active' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40' : 'bg-slate-700 text-slate-300'"
                                              x-text="activeStudent.status">
                                        </span>
                                    </div>
                                    <p class="text-xs text-brand-300 font-mono mt-0.5" x-text="activeStudent.id"></p>
                                    <p class="text-xs text-slate-400 mt-1" x-text="activeStudent.degree"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Dossier Details -->
                        <div class="flex-1 overflow-y-auto p-6 space-y-6">
                            
                            <!-- Academic Status Bar -->
                            <div class="grid grid-cols-3 gap-3 p-3.5 bg-slate-50 rounded-2xl border border-slate-200/80 text-center">
                                <div>
                                    <span class="text-[10px] font-bold uppercase text-slate-400">Cumulative GPA</span>
                                    <p class="text-base font-extrabold text-slate-900 mt-0.5" x-text="activeStudent.gpa"></p>
                                </div>
                                <div class="border-x border-slate-200">
                                    <span class="text-[10px] font-bold uppercase text-slate-400">Credits</span>
                                    <p class="text-base font-extrabold text-slate-900 mt-0.5" x-text="activeStudent.credits + ' / 120'"></p>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold uppercase text-slate-400">Attendance</span>
                                    <p class="text-base font-extrabold text-emerald-600 mt-0.5">96.4%</p>
                                </div>
                            </div>

                            <!-- Identity & Demographics -->
                            <div>
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Identity & Demographics</h4>
                                <div class="space-y-2.5 text-xs">
                                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                                        <span class="text-slate-500">Gender & Pronouns</span>
                                        <span class="font-semibold text-slate-800" x-text="activeStudent.gender + ' (' + activeStudent.pronouns + ')'"></span>
                                    </div>
                                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                                        <span class="text-slate-500">Date of Birth</span>
                                        <span class="font-semibold text-slate-800" x-text="activeStudent.dob + ' (Age ' + activeStudent.age + ')'"></span>
                                    </div>
                                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                                        <span class="text-slate-500">Academic Advisor</span>
                                        <span class="font-semibold text-brand-600" x-text="activeStudent.advisor"></span>
                                    </div>
                                    <div class="flex justify-between py-1.5 border-b border-slate-100">
                                        <span class="text-slate-500">Department</span>
                                        <span class="font-semibold text-slate-800" x-text="activeStudent.department"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Details -->
                            <div>
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Contact Information</h4>
                                <div class="space-y-2.5 text-xs">
                                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                                        <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-600">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-slate-400 font-medium">Institution Email</p>
                                            <p class="font-semibold text-slate-800" x-text="activeStudent.email"></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                                        <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-600">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-slate-400 font-medium">Mobile Phone</p>
                                            <p class="font-semibold text-slate-800" x-text="activeStudent.phone"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Footer Actions -->
                        <div class="p-6 bg-slate-50 border-t border-slate-200 flex items-center gap-3">
                            <button @click="openEditModal(activeStudent); viewSlideOverOpen = false;" 
                                    class="flex-1 py-2.5 rounded-xl text-xs font-semibold text-slate-800 bg-white border border-slate-200 hover:bg-slate-100 transition-colors">
                                Edit Details
                            </button>
                            <button @click="viewSlideOverOpen = false" 
                                    class="flex-1 py-2.5 rounded-xl text-xs font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-sm transition-colors">
                                Close Dossier
                            </button>
                        </div>
                    </div>
                </template>

            </div>
        </div>
    </div>
</div>
