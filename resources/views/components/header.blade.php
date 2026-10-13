<!-- ======================= TOP HEADER COMPONENT ======================= -->
<header class="h-20 bg-white dark:bg-slate-900 border-b border-slate-200/80 dark:border-slate-800 px-4 sm:px-8 flex items-center justify-between gap-4 flex-shrink-0 shadow-xs z-30 transition-colors">
    
    <!-- Left: Mobile Menu Toggle + Global Search Bar -->
    <div class="flex items-center gap-3 sm:gap-4 flex-1 max-w-2xl">
        <button @click="mobileSidebarOpen = true" 
                type="button"
                aria-label="Toggle navigation menu"
                class="lg:hidden p-2 rounded-xl text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-hidden transition-colors">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Global Search Bar & Live Command Palette -->
        <div class="relative w-full" x-data="headerSearch()" @click.outside="close()">
            <form action="{{ route('students.index') }}" method="GET" @submit="onFormSubmit($event)" class="relative w-full">
                <!-- Search Icon -->
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 dark:text-slate-500 transition-colors"
                     :class="open ? 'text-brand-600 dark:text-brand-400' : ''">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <!-- Search Input Field -->
                <input type="text" 
                       name="search"
                       x-ref="searchInput"
                       x-model="query"
                       @input.debounce.200ms="fetchData()"
                       @focus="open = true; if (!hasSearched) fetchData()"
                       @keydown.escape.prevent="close()"
                       @keydown.arrow-down.prevent="selectNext()"
                       @keydown.arrow-up.prevent="selectPrev()"
                       @keydown.enter="onEnter($event)"
                       placeholder="Search anything across portal (courses, ID, records)..." 
                       autocomplete="off"
                       spellcheck="false"
                       aria-label="Global search across portal"
                       class="w-full pl-10 pr-20 py-2.5 text-sm bg-slate-100/80 dark:bg-slate-800/80 hover:bg-slate-100 dark:hover:bg-slate-800 focus:bg-white dark:focus:bg-slate-800 border border-transparent dark:border-slate-700/60 focus:border-brand-500 dark:focus:border-brand-500 rounded-xl focus:ring-4 focus:ring-brand-500/10 focus:outline-hidden transition-all text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 font-normal">

                <!-- Right Elements: Loading Indicator, Clear Button, Keyboard Badge -->
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center gap-1.5">
                    <!-- Subtle Loading Spinner -->
                    <div x-cloak x-show="loading" class="text-brand-500 dark:text-brand-400 animate-spin flex items-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                    </div>

                    <!-- Clear Search Button -->
                    <button type="button"
                            x-cloak
                            x-show="query && !loading"
                            @click="clear()"
                            title="Clear search"
                            class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-200/60 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <!-- Shortcut Key Indicator (⌘K / Ctrl+K) -->
                    <kbd x-show="!query && !loading" 
                         @click="focusInput()"
                         class="hidden sm:inline-flex items-center px-1.5 py-0.5 text-[10px] font-mono font-medium text-slate-400 dark:text-slate-400 bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded shadow-2xs cursor-pointer hover:border-slate-300 dark:hover:border-slate-500 hover:text-slate-600 dark:hover:text-slate-200 transition-all select-none"
                         title="Press ⌘K or Ctrl+K to search">
                        ⌘K
                    </kbd>
                </div>
            </form>

            <!-- Modular Live Search Results Dropdown -->
            @include('components.header.search-dropdown')
        </div>
    </div>

    <!-- Right: Quick Actions, Theme Toggle & Profile -->
    <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
        
        <!-- Quick Theme Switcher Button -->
        <div x-data="{ 
                currentTheme: window.getTheme ? window.getTheme() : 'system', 
                isDark: document.documentElement.classList.contains('dark') 
             }"
             @theme-changed.window="currentTheme = $event.detail; isDark = document.documentElement.classList.contains('dark')">
            <button @click="window.applyTheme(isDark ? 'light' : 'dark')" 
                    type="button"
                    class="p-2.5 text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-100 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors focus:outline-hidden" 
                    :title="isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'">
                <!-- Sun Icon (shown in dark mode) -->
                <svg x-cloak x-show="isDark" class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <!-- Moon Icon (shown in light mode) -->
                <svg x-show="!isDark" class="w-5 h-5 text-slate-500 hover:text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </button>
        </div>

        <!-- Shortcut: 'New Student' Action Button -->
        <a href="{{ route('students.index', ['action' => 'add']) }}" 
           @click="if (window.location.pathname.includes('/students')) { $event.preventDefault(); $dispatch('open-add-student'); }"
           class="inline-flex items-center gap-1.5 px-3 sm:px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-brand-50 dark:bg-brand-950/60 text-brand-700 dark:text-brand-300 hover:bg-brand-100 dark:hover:bg-brand-900/50 border border-brand-200/80 dark:border-brand-800/80 transition-all shadow-2xs">
            <svg class="w-4 h-4 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M12 4v16m8-8H4"/>
            </svg>
            <span>New Student</span>
        </a>

        <div class="h-8 w-px bg-slate-200 dark:bg-slate-800 mx-1"></div>

        <!-- Administrator Profile Dropdown -->
        <div class="relative" x-data="{ profileMenuOpen: false }">
            <button @click="profileMenuOpen = !profileMenuOpen" 
                    type="button"
                    class="flex items-center gap-2.5 p-1 sm:p-1.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors focus:outline-hidden">
                <div class="relative">
                    <img class="w-9 h-9 rounded-xl object-cover ring-2 ring-brand-500/20" 
                         src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=6366f1&color=fff&bold=true" 
                         alt="{{ auth()->user()->name ?? 'User' }}">
                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white dark:border-slate-900 rounded-full"></span>
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-xs font-bold text-slate-800 dark:text-slate-100 leading-tight">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-[11px] font-medium text-slate-500 dark:text-slate-400 leading-tight">Faculty Member</p>
                </div>
                <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <!-- Profile Dropdown Content -->
            <div x-cloak x-show="profileMenuOpen" @click.away="profileMenuOpen = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-56 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-800 py-2 z-50 divide-y divide-slate-100 dark:divide-slate-800">
                <div class="px-4 py-2.5">
                    <p class="text-xs text-slate-400 dark:text-slate-500 font-medium">Signed in as</p>
                    <p class="text-xs font-bold text-slate-800 dark:text-slate-100 truncate">{{ auth()->user()->email ?? 'user@edupulse.edu' }}</p>
                </div>
                <div class="py-1">
                    <a href="{{ route('settings.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-brand-600 dark:hover:text-brand-400 transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Account Settings</span>
                    </a>
                </div>
                <div class="py-1">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors">
                            <svg class="w-4 h-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span>Sign Out</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</header>

<!-- Include Search Logic Script -->
@include('components.header.search-script')
