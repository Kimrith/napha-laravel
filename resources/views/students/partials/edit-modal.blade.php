<!-- resources/views/students/partials/edit-modal.blade.php -->
<div x-cloak x-show="editModalOpen" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="editModalOpen" @click="editModalOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div x-show="editModalOpen" 
             class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-slate-100">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900">Edit Student Record</h3>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form :action="'/students/' + (editForm.student_id || editForm.id)" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-4">
                    <!-- Avatar Upload -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Avatar Photo</label>
                        <div class="flex items-center gap-4 p-3 bg-slate-50 border border-slate-200 rounded-2xl">
                            <div class="relative shrink-0">
                                <template x-if="editFormAvatarPreview || editForm.avatar">
                                    <img :src="editFormAvatarPreview || editForm.avatar" alt="Avatar preview"
                                         class="w-14 h-14 rounded-2xl object-cover ring-2 ring-brand-500/20 shadow-xs">
                                </template>
                                <template x-if="!editFormAvatarPreview && !editForm.avatar">
                                    <div class="w-14 h-14 rounded-2xl bg-white border border-slate-200/80 flex items-center justify-center text-slate-400 shadow-2xs">
                                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </template>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <label for="edit-student-avatar-input"
                                           class="cursor-pointer inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 hover:border-brand-500 rounded-xl text-xs font-semibold text-slate-700 hover:text-brand-600 transition-all shadow-2xs">
                                        <svg class="w-4 h-4 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                                class="px-2.5 py-1.5 rounded-xl text-xs font-medium text-rose-500 hover:text-rose-600 hover:bg-rose-50 transition-colors">
                                            Revert
                                        </button>
                                    </template>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1">PNG, JPG, or WEBP up to 2MB</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Student Name</label>
                        <input type="text" name="name" x-model="editForm.name" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white text-slate-800">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email</label>
                            <input type="email" name="email" x-model="editForm.email" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white text-slate-800">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Phone</label>
                            <input type="text" name="phone" x-model="editForm.phone" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:bg-white text-slate-800">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Major</label>
                            <select name="major" x-model="editForm.major" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl font-medium">
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
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status</label>
                            <select name="status" x-model="editForm.status" class="w-full px-3.5 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl font-medium">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-200">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-sm">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
