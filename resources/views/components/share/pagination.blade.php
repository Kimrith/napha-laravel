<div class="flex items-center gap-1.5 select-none" x-data="{ get pages() { return typeof visiblePageNumbers !== 'undefined' ? visiblePageNumbers : [1]; } }">
    <!-- Previous Button -->
    <button type="button" 
            @click="typeof prevPage === 'function' && prevPage()" 
            :disabled="typeof currentPage === 'undefined' || currentPage <= 1"
            :class="(typeof currentPage === 'undefined' || currentPage <= 1) 
                ? 'text-slate-400 dark:text-slate-600 bg-slate-100/70 dark:bg-slate-800/40 border-slate-200/70 dark:border-slate-800 cursor-not-allowed opacity-60' 
                : 'text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 border-slate-200 dark:border-slate-700 cursor-pointer hover:text-brand-600 dark:hover:text-white'"
            class="px-2.5 py-1.5 rounded-lg text-xs font-medium border transition-colors flex items-center gap-1 shadow-2xs">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        <span>Previous</span>
    </button>

    <!-- Dynamic Page Numbers -->
    <template x-for="(p, idx) in pages" :key="idx">
        <span>
            <template x-if="p === '...'">
                <span class="text-xs text-slate-400 dark:text-slate-500 px-1">...</span>
            </template>
            <template x-if="p !== '...'">
                <button type="button" 
                        @click="typeof goToPage === 'function' && goToPage(p)" 
                        :class="currentPage === p 
                            ? 'text-white bg-brand-600 dark:bg-brand-600 border-brand-600 dark:border-brand-500 shadow-2xs font-bold' 
                            : 'text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 border-slate-200 dark:border-slate-700 font-medium'"
                        class="px-3 py-1.5 rounded-lg text-xs border transition-colors cursor-pointer shadow-2xs" 
                        x-text="p">
                </button>
            </template>
        </span>
    </template>

    <!-- Next Button -->
    <button type="button" 
            @click="typeof nextPage === 'function' && nextPage()" 
            :disabled="typeof currentPage === 'undefined' || typeof totalPages === 'undefined' || currentPage >= totalPages"
            :class="(typeof currentPage === 'undefined' || typeof totalPages === 'undefined' || currentPage >= totalPages) 
                ? 'text-slate-400 dark:text-slate-600 bg-slate-100/70 dark:bg-slate-800/40 border-slate-200/70 dark:border-slate-800 cursor-not-allowed opacity-60' 
                : 'text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 border-slate-200 dark:border-slate-700 cursor-pointer hover:text-brand-600 dark:hover:text-white'"
            class="px-2.5 py-1.5 rounded-lg text-xs font-medium border transition-colors flex items-center gap-1 shadow-2xs">
        <span>Next</span>
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
</div>