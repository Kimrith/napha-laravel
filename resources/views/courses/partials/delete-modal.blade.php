<!-- resources/views/courses/partials/delete-modal.blade.php -->
<div x-cloak 
     x-show="deleteModalOpen" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     aria-labelledby="modal-delete-title" 
     role="dialog" 
     aria-modal="true"
     @keydown.escape.window="deleteModalOpen = false">
    
    <!-- Backdrop -->
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
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative transform overflow-hidden rounded-2xl bg-white p-6 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-200"
             @click.away="deleteModalOpen = false">
            
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex-shrink-0 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900" id="modal-delete-title">Delete Course Record?</h3>
                    <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                        Are you sure you want to remove <strong class="text-slate-800" x-text="courseToDelete ? courseToDelete.name + ' (' + courseToDelete.code + ')' : ''"></strong>? This action cannot be undone.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <button type="button" @click="deleteModalOpen = false" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 transition-colors">
                    Cancel
                </button>
                <button type="button" @click="deleteConfirmed()" class="px-4 py-2 rounded-xl text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 shadow-sm transition-all">
                    Delete Course
                </button>
            </div>
        </div>
    </div>
</div>
