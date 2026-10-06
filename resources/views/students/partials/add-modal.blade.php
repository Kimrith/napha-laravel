<!-- resources/views/students/partials/add-modal.blade.php -->
<div x-cloak x-show="addModalOpen" 
     class="fixed inset-0 z-50 overflow-y-auto"
     aria-labelledby="modal-title" role="dialog" aria-modal="true">
    
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Backdrop -->
        <div x-show="addModalOpen" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="addModalOpen = false"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal Panel -->
        <div x-show="addModalOpen" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full border border-slate-100">
            
            <!-- Modal Header -->
            <div class="px-6 pt-6 pb-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900" id="modal-title">Enroll New Student</h3>
                        <p class="text-xs text-slate-500 font-medium">Add a new student profile to the active Fall 2026 directory.</p>
                    </div>
                </div>
                <button @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Form -->
            <form @submit.prevent="saveNewStudent()" class="p-6 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    <!-- Full Name -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Full Name *</label>
                        <input type="text" x-model="newStudent.name" required placeholder="e.g. Maya Lin"
                               class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Official Email *</label>
                        <input type="email" x-model="newStudent.email" required placeholder="name@edupulse.edu"
                               class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800">
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Phone Number</label>
                        <input type="tel" x-model="newStudent.phone" placeholder="+1 (555) 000-0000"
                               class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800">
                    </div>

                    <!-- Major -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Academic Major</label>
                        <select x-model="newStudent.major"
                                class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800 font-medium">
                            <option value="Computer Science">Computer Science</option>
                            <option value="Data Science & AI">Data Science & AI</option>
                            <option value="Digital Design">Digital Design</option>
                            <option value="Robotics & Automation">Robotics & Automation</option>
                            <option value="Biotechnology">Biotechnology</option>
                            <option value="International Finance">International Finance</option>
                            <option value="Cybersecurity">Cybersecurity</option>
                            <option value="Media Communications">Media Communications</option>
                        </select>
                    </div>

                    <!-- Degree Program -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Degree Title</label>
                        <input type="text" x-model="newStudent.degree" placeholder="B.Sc. Computer Engineering"
                               class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800">
                    </div>

                    <!-- Gender / Pronouns -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Gender & Pronouns</label>
                        <div class="grid grid-cols-2 gap-2">
                            <select x-model="newStudent.gender" class="px-2.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl">
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                                <option value="Non-Binary">Non-Binary</option>
                            </select>
                            <input type="text" x-model="newStudent.pronouns" placeholder="e.g. She/Her" class="px-2.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl">
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Enrollment Status</label>
                        <select x-model="newStudent.status"
                                class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800 font-medium">
                            <option value="Active">Active Student</option>
                            <option value="Inactive">Inactive / On Leave</option>
                        </select>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" @click="addModalOpen = false" 
                            class="px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-md shadow-brand-600/30 transition-all">
                        Complete Enrolment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
