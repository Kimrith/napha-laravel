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
                        Are you ready to submit today's roll-call log for <strong>CS-101</strong>? Official records will be forwarded to the academic registrar.
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
                <button type="button" @click="submitFinalized()" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-white bg-brand-600 hover:bg-brand-700 shadow-sm transition-all">
                    Submit to Registrar
                </button>
            </div>
        </div>
    </div>
</div>
