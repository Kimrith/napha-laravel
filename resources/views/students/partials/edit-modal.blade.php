<!-- resources/views/students/partials/edit-modal.blade.php -->
<div x-cloak x-show="editModalOpen" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-6 text-center sm:p-0">
        <div x-show="editModalOpen" @click="editModalOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div x-show="editModalOpen" 
             class="inline-block align-bottom sm:align-middle bg-white dark:bg-slate-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-xl w-full border border-slate-100 dark:border-slate-800 flex flex-col max-h-[90vh]">
            
            <!-- Header (Fixed at top) -->
            <div class="px-6 pt-5 pb-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between shrink-0 bg-white dark:bg-slate-900">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Edit Student Record</h3>
                </div>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Form with Scrollable Interior -->
            <form :action="'/students/' + (editForm.student_id || editForm.id)" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 min-h-0 overflow-hidden">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-4 overflow-y-auto flex-1">
                    <!-- Avatar Upload -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Avatar Photo</label>
                        <div class="flex items-center gap-4 p-3 bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-2xl">
                            <div class="relative shrink-0">
                                <template x-if="editFormAvatarPreview || editForm.avatar">
                                    <img :src="editFormAvatarPreview || editForm.avatar" alt="Avatar preview"
                                         class="w-14 h-14 rounded-2xl object-cover ring-2 ring-brand-500/20 shadow-xs">
                                </template>
                                <template x-if="!editFormAvatarPreview && !editForm.avatar">
                                    <div class="w-14 h-14 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 flex items-center justify-center text-slate-400 dark:text-slate-500 shadow-2xs">
                                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </template>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <label for="edit-student-avatar-input"
                                           class="cursor-pointer inline-flex items-center gap-1.5 px-3 py-1.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-brand-500 dark:hover:border-brand-500 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 hover:text-brand-600 dark:hover:text-brand-400 transition-all shadow-2xs">
                                        <svg class="w-4 h-4 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span x-text="editFormAvatarPreview ? 'Change Photo' : 'Upload New Photo'"></span>
                                    </label>
                                    <input id="edit-student-avatar-input"
                                           type="file"
                                           name="avatar"
                                           accept="image/png,image/jpeg,image/jpg,image/webp,image/gif"
                                           @change="handleEditAvatarChange($event)"
                                           class="sr-only">
                                    <template x-if="editFormAvatarPreview">
                                        <button type="button" @click="clearEditAvatar()"
                                                class="px-2.5 py-1.5 rounded-xl text-xs font-medium text-rose-500 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors">
                                            Revert
                                        </button>
                                    </template>
                                </div>
                                <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">PNG, JPG, or WEBP up to 2MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Full Name & Email -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Full Name</label>
                            <input type="text" name="name" x-model="editForm.name" required class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:bg-white dark:focus:bg-slate-800 text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Email</label>
                            <input type="email" name="email" x-model="editForm.email" required class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:bg-white dark:focus:bg-slate-800 text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500">
                        </div>
                    </div>

                    <!-- Phone & Major -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Phone</label>
                            <input type="text" name="phone" x-model="editForm.phone" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:bg-white dark:focus:bg-slate-800 text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Major</label>
                            <select name="major" x-model="editForm.major" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl font-medium text-slate-800 dark:text-slate-100">
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
                    </div>

                    <!-- Gender & Pronouns -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Gender</label>
                            <select name="gender" x-model="editForm.gender" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl font-medium text-slate-800 dark:text-slate-100">
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                                <option value="Non-Binary">Non-Binary</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Pronouns</label>
                            <input type="text" name="pronouns" x-model="editForm.pronouns" placeholder="She/Her" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:bg-white dark:focus:bg-slate-800 text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500">
                        </div>
                    </div>

                    <!-- DOB & Age -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Date of Birth</label>
                            <input type="date" name="dob" x-model="editForm.dob" @change="onDobChange('edit')" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:bg-white dark:focus:bg-slate-800 text-slate-800 dark:text-slate-100">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Age</label>
                            <input type="number" name="age" x-model="editForm.age" min="10" max="100" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:bg-white dark:focus:bg-slate-800 text-slate-800 dark:text-slate-100">
                        </div>
                    </div>

                    <!-- Department & Class -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Department</label>
                            <select name="department_id" x-model="editForm.department_id" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl font-medium text-slate-800 dark:text-slate-100">
                                <option value="">Unassigned</option>
                                @foreach($departments ?? [] as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Assigned Class</label>
                            <select name="class_id" x-model="editForm.class_id" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl font-medium text-slate-800 dark:text-slate-100">
                                <option value="">Unassigned</option>
                                @foreach($classes ?? [] as $cls)
                                    <option value="{{ $cls->id }}">{{ $cls->code }} - {{ $cls->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Academic Advisor -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Advisor</label>
                        <input type="text" name="advisor" x-model="editForm.advisor" placeholder="Dr. Sarah Vance" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:bg-white dark:focus:bg-slate-800 text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500">
                    </div>

                    <!-- GPA, Credits & Status -->
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">GPA</label>
                            <input type="number" step="0.01" min="0" max="4.00" name="gpa" x-model="editForm.gpa" placeholder="3.80" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:bg-white dark:focus:bg-slate-800 text-slate-800 dark:text-slate-100 font-mono">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Credits</label>
                            <input type="number" min="0" max="250" name="credits" x-model="editForm.credits" placeholder="0" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:bg-white dark:focus:bg-slate-800 text-slate-800 dark:text-slate-100 font-mono">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">Status</label>
                            <select name="status" x-model="editForm.status" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl font-medium text-slate-800 dark:text-slate-100">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Footer (Pinned at Bottom) -->
                <div class="pt-4 px-6 pb-5 bg-slate-50/80 dark:bg-slate-900/90 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3 shrink-0">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-sm transition-all">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
