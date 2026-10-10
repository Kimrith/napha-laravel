<!-- resources/views/courses/partials/add-modal.blade.php -->
<div x-cloak 
     x-show="addModalOpen" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     aria-labelledby="modal-title" 
     role="dialog" 
     aria-modal="true"
     @keydown.escape.window="addModalOpen = false">
    
    <!-- Backdrop -->
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
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200"
             @click.away="addModalOpen = false">
            
            <!-- Header -->
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900" id="modal-title">Create New Course</h3>
                </div>
                <button type="button" @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Form Body -->
            <form @submit.prevent="saveNewCourse()" class="p-6 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Course Code *</label>
                        <input type="text" x-model="newCourse.code" required placeholder="e.g. CS-204" 
                               class="w-full px-3 py-2 text-sm bg-slate-50 focus:bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-hidden font-mono uppercase">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Department *</label>
                        <select x-model="newCourse.dept" required class="w-full px-3 py-2 text-sm bg-slate-50 focus:bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-hidden">
                            @foreach($departments ?? [] as $d)
                                <option value="{{ $d->name }}">{{ $d->name }} ({{ $d->code }})</option>
                            @endforeach
                            @if(empty($departments) || count($departments) === 0)
                                <option value="School of Computing & Informatics">School of Computing & Informatics</option>
                                <option value="School of Business & Global Finance">School of Business & Global Finance</option>
                                <option value="Faculty of Life Sciences & Biotech">Faculty of Life Sciences & Biotech</option>
                                <option value="Design, Arts & Human Experience">Design, Arts & Human Experience</option>
                                <option value="Mechatronics & Robotics Engineering">Mechatronics & Robotics Engineering</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Course Name *</label>
                    <input type="text" x-model="newCourse.name" required placeholder="e.g. Distributed Systems Engineering" 
                           class="w-full px-3 py-2 text-sm bg-slate-50 focus:bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-hidden">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Instructor *</label>
                        <input type="text" x-model="newCourse.instructor" required placeholder="e.g. Prof. Grace Hopper" 
                               class="w-full px-3 py-2 text-sm bg-slate-50 focus:bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-hidden">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Credits (ECTS) *</label>
                        <input type="number" x-model="newCourse.credits" min="1" max="10" required 
                               class="w-full px-3 py-2 text-sm bg-slate-50 focus:bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-hidden">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Capacity Quota *</label>
                        <input type="number" x-model="newCourse.capacity" min="5" max="300" required 
                               class="w-full px-3 py-2 text-sm bg-slate-50 focus:bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-hidden">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status</label>
                        <select x-model="newCourse.status" class="w-full px-3 py-2 text-sm bg-slate-50 focus:bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-hidden">
                            <option value="Active">Active</option>
                            <option value="Full">Full</option>
                            <option value="Upcoming">Upcoming</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Schedule & Days</label>
                        <input type="text" x-model="newCourse.days" placeholder="e.g. Mon, Wed 10:00 - 12:00 PM" 
                               class="w-full px-3 py-2 text-sm bg-slate-50 focus:bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-hidden">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Classroom / Lab</label>
                        <input type="text" x-model="newCourse.room" placeholder="e.g. Hall Theta-1" 
                               class="w-full px-3 py-2 text-sm bg-slate-50 focus:bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 outline-hidden">
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-sm transition-all">
                        Create Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
