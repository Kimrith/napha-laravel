<!-- resources/views/students/partials/add-modal.blade.php -->
<div x-cloak x-show="addModalOpen" 
     @if($errors->any()) x-init="addModalOpen = true" @endif
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
            <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf

                @if($errors->any())
                    <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-2xl text-xs text-rose-700">
                        <div class="font-bold mb-1">Please correct the following errors:</div>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <!-- Avatar Upload -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Avatar Photo</label>
                        <div class="flex items-center gap-4 p-3 bg-slate-50 border border-slate-200 rounded-2xl">
                            <div class="relative shrink-0">
                                <template x-if="newStudentAvatarPreview">
                                    <img :src="newStudentAvatarPreview" alt="Avatar preview"
                                         class="w-14 h-14 rounded-2xl object-cover ring-2 ring-brand-500/20 shadow-xs">
                                </template>
                                <template x-if="!newStudentAvatarPreview">
                                    <div class="w-14 h-14 rounded-2xl bg-white border border-slate-200/80 flex items-center justify-center text-slate-400 shadow-2xs">
                                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </template>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <label for="add-student-avatar-input"
                                           class="cursor-pointer inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 hover:border-brand-500 rounded-xl text-xs font-semibold text-slate-700 hover:text-brand-600 transition-all shadow-2xs">
                                        <svg class="w-4 h-4 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span x-text="newStudentAvatarPreview ? 'Change Photo' : 'Choose File'"></span>
                                    </label>
                                    <input id="add-student-avatar-input"
                                           type="file"
                                           name="avatar"
                                           accept="image/png,image/jpeg,image/jpg,image/webp,image/gif"
                                           @change="handleNewAvatarChange($event)"
                                           class="sr-only">
                                    <template x-if="newStudentAvatarPreview">
                                        <button type="button" @click="clearNewAvatar()"
                                                class="px-2.5 py-1.5 rounded-xl text-xs font-medium text-rose-500 hover:text-rose-600 hover:bg-rose-50 transition-colors">
                                            Remove
                                        </button>
                                    </template>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1">PNG, JPG, or WEBP up to 2MB</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Full Name -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Full Name *</label>
                        <input type="text" name="name" x-model="newStudent.name" required placeholder="e.g. Maya Lin"
                               class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Official Email *</label>
                        <input type="email" name="email" x-model="newStudent.email" required placeholder="name@edupulse.edu"
                               class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800">
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Phone Number</label>
                        <input type="tel" name="phone" x-model="newStudent.phone" placeholder="+1 (555) 000-0000"
                               class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800">
                    </div>

                    <!-- Major -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Academic Major</label>
                        <select name="major" x-model="newStudent.major"
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
                        <input type="text" name="degree" x-model="newStudent.degree" placeholder="B.Sc. Computer Engineering"
                               class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800">
                    </div>

                    <!-- Gender / Pronouns -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Gender & Pronouns</label>
                        <div class="grid grid-cols-2 gap-2">
                            <select name="gender" x-model="newStudent.gender" class="px-2.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl">
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                                <option value="Non-Binary">Non-Binary</option>
                            </select>
                            <input type="text" name="pronouns" x-model="newStudent.pronouns" placeholder="e.g. She/Her" class="px-2.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl">
                        </div>
                    </div>

                    <!-- Date of Birth & Age -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Date of Birth</label>
                        <input type="date" name="dob" x-model="newStudent.dob" @change="onDobChange('new')"
                               class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Age</label>
                        <input type="number" name="age" x-model="newStudent.age" min="10" max="100" placeholder="Auto from DOB"
                               class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800">
                    </div>

                    <!-- Department & Class -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Department</label>
                        <select name="department_id" x-model="newStudent.department_id"
                                class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800 font-medium">
                            <option value="">Unassigned Department</option>
                            @foreach($departments ?? [] as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Assigned Class</label>
                        <select name="class_id" x-model="newStudent.class_id"
                                class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800 font-medium">
                            <option value="">Unassigned Class</option>
                            @foreach($classes ?? [] as $cls)
                                <option value="{{ $cls->id }}">{{ $cls->code }} - {{ $cls->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Academic Advisor -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Academic Advisor</label>
                        <input type="text" name="advisor" x-model="newStudent.advisor" placeholder="e.g. Dr. Sarah Vance"
                               class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800">
                    </div>

                    <!-- GPA & Credits -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Cumulative GPA (0.00 - 4.00)</label>
                        <input type="number" step="0.01" min="0" max="4.00" name="gpa" x-model="newStudent.gpa" placeholder="3.80"
                               class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800 font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Earned Credits</label>
                        <input type="number" min="0" max="250" name="credits" x-model="newStudent.credits" placeholder="0"
                               class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-brand-500/10 focus:border-brand-500 focus:outline-hidden transition-all text-slate-800 font-mono">
                    </div>

                    <!-- Status -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Enrollment Status</label>
                        <select name="status" x-model="newStudent.status"
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
