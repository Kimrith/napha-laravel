<!-- resources/views/settings/partials/appearance.blade.php -->
<div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800 shadow-xs space-y-5 transition-colors"
     x-data="{
         theme: window.getTheme ? window.getTheme() : 'system',
         selectTheme(newTheme) {
             this.theme = newTheme;
             if (typeof window.applyTheme === 'function') {
                 window.applyTheme(newTheme);
             }
             if (typeof showToast === 'function') {
                 const label = newTheme === 'dark' ? 'Dark Mode' : (newTheme === 'light' ? 'Light Mode' : 'System Theme');
                 showToast('Interface appearance switched to ' + label, 'info');
             }
         }
     }"
     @theme-changed.window="theme = $event.detail">

    <!-- Card Header -->
    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800/80 pb-4">
        <div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-950/60 text-brand-600 dark:text-brand-400 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                </div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Appearance & Interface Theme</h3>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Personalize your portal workspace. Changes take effect instantly without restarting your session.</p>
        </div>

        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
            Realtime Live
        </span>
    </div>

    <!-- Theme Selection Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        
        <!-- Light Mode Option -->
        <button type="button" 
                @click="selectTheme('light')"
                :class="theme === 'light' 
                    ? 'ring-2 ring-brand-600 border-brand-500 bg-brand-50/20 dark:bg-brand-950/30' 
                    : 'border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900/60'"
                class="p-4 rounded-xl border text-left transition-all relative flex flex-col justify-between group focus:outline-hidden">
            
            <div>
                <!-- Mockup Preview Box -->
                <div class="w-full h-24 rounded-lg bg-slate-100 border border-slate-200/90 p-2 flex flex-col justify-between mb-3.5 overflow-hidden shadow-2xs group-hover:scale-[1.02] transition-transform">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-red-400"></span>
                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        </div>
                        <div class="w-10 h-2 bg-slate-300 rounded-sm"></div>
                    </div>
                    <div class="space-y-1.5 bg-white p-2 rounded shadow-2xs">
                        <div class="w-2/3 h-2 bg-slate-800 rounded-sm"></div>
                        <div class="w-1/2 h-1.5 bg-slate-300 rounded-xs"></div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="w-8 h-2 bg-brand-600 rounded-xs"></div>
                        <div class="w-6 h-2 bg-slate-300 rounded-xs"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="text-sm font-bold text-slate-900 dark:text-white">Light Mode</span>
                    </div>

                    <!-- Selected Indicator Radio -->
                    <span class="w-4 h-4 rounded-full border flex items-center justify-center transition-all"
                          :class="theme === 'light' ? 'border-brand-600 bg-brand-600 text-white' : 'border-slate-300 dark:border-slate-700'">
                        <svg x-show="theme === 'light'" class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                </div>

                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5 leading-relaxed">
                    High contrast daylight theme optimized for clarity in bright environments.
                </p>
            </div>
        </button>

        <!-- Dark Mode Option -->
        <button type="button" 
                @click="selectTheme('dark')"
                :class="theme === 'dark' 
                    ? 'ring-2 ring-brand-600 border-brand-500 bg-brand-50/20 dark:bg-brand-950/30' 
                    : 'border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900/60'"
                class="p-4 rounded-xl border text-left transition-all relative flex flex-col justify-between group focus:outline-hidden">
            
            <div>
                <!-- Mockup Preview Box -->
                <div class="w-full h-24 rounded-lg bg-slate-950 border border-slate-800 p-2 flex flex-col justify-between mb-3.5 overflow-hidden shadow-2xs group-hover:scale-[1.02] transition-transform">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-red-400"></span>
                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        </div>
                        <div class="w-10 h-2 bg-slate-700 rounded-sm"></div>
                    </div>
                    <div class="space-y-1.5 bg-slate-900 p-2 rounded border border-slate-800 shadow-2xs">
                        <div class="w-2/3 h-2 bg-white rounded-sm"></div>
                        <div class="w-1/2 h-1.5 bg-slate-600 rounded-xs"></div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="w-8 h-2 bg-brand-500 rounded-xs"></div>
                        <div class="w-6 h-2 bg-slate-700 rounded-xs"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <span class="text-sm font-bold text-slate-900 dark:text-white">Dark Mode</span>
                    </div>

                    <!-- Selected Indicator Radio -->
                    <span class="w-4 h-4 rounded-full border flex items-center justify-center transition-all"
                          :class="theme === 'dark' ? 'border-brand-600 bg-brand-600 text-white' : 'border-slate-300 dark:border-slate-700'">
                        <svg x-show="theme === 'dark'" class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                </div>

                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5 leading-relaxed">
                    Sleek dark obsidian palette designed to reduce glare and late-night eye strain.
                </p>
            </div>
        </button>

        <!-- System Default Option -->
        <button type="button" 
                @click="selectTheme('system')"
                :class="theme === 'system' 
                    ? 'ring-2 ring-brand-600 border-brand-500 bg-brand-50/20 dark:bg-brand-950/30' 
                    : 'border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-white dark:bg-slate-900/60'"
                class="p-4 rounded-xl border text-left transition-all relative flex flex-col justify-between group focus:outline-hidden">
            
            <div>
                <!-- Mockup Preview Box: Split Half & Half -->
                <div class="w-full h-24 rounded-lg overflow-hidden border border-slate-200 dark:border-slate-800 flex mb-3.5 group-hover:scale-[1.02] transition-transform shadow-2xs">
                    <!-- Light half -->
                    <div class="w-1/2 bg-slate-100 p-2 flex flex-col justify-between">
                        <div class="w-2 h-2 rounded-full bg-slate-400"></div>
                        <div class="space-y-1 bg-white p-1.5 rounded shadow-2xs">
                            <div class="w-full h-1.5 bg-slate-800 rounded-xs"></div>
                            <div class="w-2/3 h-1 bg-slate-300 rounded-xs"></div>
                        </div>
                        <div class="w-6 h-1.5 bg-brand-600 rounded-xs"></div>
                    </div>
                    <!-- Dark half -->
                    <div class="w-1/2 bg-slate-950 p-2 flex flex-col justify-between border-l border-slate-300 dark:border-slate-800">
                        <div class="w-2 h-2 rounded-full bg-indigo-400 ml-auto"></div>
                        <div class="space-y-1 bg-slate-900 p-1.5 rounded shadow-2xs border border-slate-800">
                            <div class="w-full h-1.5 bg-white rounded-xs"></div>
                            <div class="w-2/3 h-1 bg-slate-600 rounded-xs"></div>
                        </div>
                        <div class="w-6 h-1.5 bg-brand-500 rounded-xs ml-auto"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-600 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm font-bold text-slate-900 dark:text-white">System Sync</span>
                    </div>

                    <!-- Selected Indicator Radio -->
                    <span class="w-4 h-4 rounded-full border flex items-center justify-center transition-all"
                          :class="theme === 'system' ? 'border-brand-600 bg-brand-600 text-white' : 'border-slate-300 dark:border-slate-700'">
                        <svg x-show="theme === 'system'" class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                </div>

                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5 leading-relaxed">
                    Dynamically mirrors your operating system appearance preference automatically.
                </p>
            </div>
        </button>

    </div>
</div>
