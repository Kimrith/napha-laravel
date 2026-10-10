<!-- resources/views/attendance/partials/modals.blade.php -->
<!-- Submit Roll-Call Confirmation Modal -->
<div x-cloak 
     x-show="confirmModalOpen" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     aria-labelledby="modal-finalize-title" 
     role="dialog" 
     aria-modal="true"
     @keydown.escape.window="confirmModalOpen = false">
    
    <div x-show="confirmModalOpen" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs transition-opacity"
         @click="confirmModalOpen = false"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div x-show="confirmModalOpen" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative transform overflow-hidden rounded-2xl bg-white p-6 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-200"
             @click.away="confirmModalOpen = false">
            
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex-shrink-0 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900" id="modal-finalize-title">Finalize Roll-Call?</h3>
                    <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                        Are you ready to submit roll-call log for session <strong x-text="selectedDate"></strong> (<span class="font-medium text-slate-700" x-text="courses.find(c => c.id == selectedCourseId)?.code || 'All Courses'"></span>)? Official records will be forwarded to the academic registrar.
                    </p>
                    <div class="mt-3 p-3 rounded-xl bg-slate-50 border border-slate-100 text-xs text-slate-600 space-y-1">
                        <div class="flex justify-between">
                            <span>Compliance Rate:</span>
                            <strong class="text-slate-800" x-text="attendanceRate + '%'"></strong>
                        </div>
                        <div class="flex justify-between">
                            <span>Unexcused Absences:</span>
                            <strong class="text-rose-600" x-text="counts.absent + ' student(s)'"></strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <button type="button" @click="confirmModalOpen = false" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 transition-colors">
                    Cancel
                </button>
                <button type="button" @click="submitFinalized()" :disabled="isSubmitting" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-sm transition-all inline-flex items-center gap-1.5">
                    <span x-show="!isSubmitting">Submit to Registrar</span>
                    <span x-show="isSubmitting" class="flex items-center gap-1.5">
                        <svg class="animate-spin h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span>Submitting...</span>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Manual Attendance Entry Modal -->
<div x-cloak 
     x-show="logModalOpen" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     aria-labelledby="modal-log-title" 
     role="dialog" 
     aria-modal="true"
     @keydown.escape.window="logModalOpen = false">
    
    <div x-show="logModalOpen" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs transition-opacity"
         @click="logModalOpen = false"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div x-show="logModalOpen" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative transform overflow-hidden rounded-2xl bg-white p-6 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200"
             @click.away="logModalOpen = false">
            
            <form method="POST" action="{{ route('attendance.store') }}">
                @csrf
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900" id="modal-log-title">Log Student Attendance</h3>
                    </div>
                    <button type="button" @click="logModalOpen = false" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="mt-4 space-y-4 text-xs">
                    <!-- Student Selection -->
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Student <span class="text-rose-500">*</span></label>
                        <select name="student_id" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:ring-brand-500 focus:border-brand-500 bg-white shadow-2xs">
                            <option value="">Select Student...</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->student_id }} — {{ $student->name }} ({{ $student->major }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Course Selection -->
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Course Session</label>
                        <select name="course_id" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:ring-brand-500 focus:border-brand-500 bg-white shadow-2xs">
                            <option value="">No specific course / General</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ (string)$selectedCourseId === (string)$course->id ? 'selected' : '' }}>
                                    {{ $course->code }} — {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date & Check-in Time -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Date <span class="text-rose-500">*</span></label>
                            <input type="date" name="date" :value="selectedDate" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:ring-brand-500 focus:border-brand-500 bg-white shadow-2xs">
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Recorded Time</label>
                            <input type="text" name="time_in" placeholder="e.g. 09:00 AM" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:ring-brand-500 focus:border-brand-500 bg-white shadow-2xs">
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Attendance Status <span class="text-rose-500">*</span></label>
                        <select name="status" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:ring-brand-500 focus:border-brand-500 bg-white shadow-2xs">
                            <option value="Present">Present</option>
                            <option value="Late">Late</option>
                            <option value="Excused">Excused</option>
                            <option value="Absent">Absent</option>
                        </select>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Notes / Reason (Optional)</label>
                        <textarea name="notes" rows="2" placeholder="e.g. Verified by hall scanner or medical notice" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-xs focus:ring-brand-500 focus:border-brand-500 bg-white shadow-2xs"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" @click="logModalOpen = false" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-sm transition-all">
                        Save Attendance Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
