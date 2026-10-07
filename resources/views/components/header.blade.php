<!-- ======================= TOP HEADER COMPONENT ======================= -->
<header class="h-20 bg-white border-b border-slate-200/80 px-4 sm:px-8 flex items-center justify-between gap-4 flex-shrink-0 shadow-xs z-30">
    
    <!-- Left: Mobile Menu Toggle + Global Search -->
    <div class="flex items-center gap-3 sm:gap-4 flex-1 max-w-xl">
        <button @click="mobileSidebarOpen = true" class="lg:hidden p-2 rounded-xl text-slate-500 hover:text-slate-700 hover:bg-slate-100 focus:outline-hidden">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Global Search Bar -->
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" 
                   placeholder="Search anything across portal (courses, ID, records)..." 
                   class="w-full pl-10 pr-16 py-2.5 text-sm bg-slate-100/80 hover:bg-slate-100 focus:bg-white border border-transparent focus:border-brand-500 rounded-xl focus:ring-4 focus:ring-brand-500/10 focus:outline-hidden transition-all text-slate-800 placeholder-slate-400 font-normal">
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <kbd class="hidden sm:inline-block px-1.5 py-0.5 text-[10px] font-mono font-medium text-slate-400 bg-white border border-slate-200 rounded shadow-2xs">⌘K</kbd>
            </div>
        </div>
    </div>

    <!-- Right Header Actions & Profile -->
    <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
        
        <!-- Quick Actions / Notifications Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" 
                    class="relative p-2.5 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition-colors focus:outline-hidden">
                <span class="sr-only">Notifications</span>
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="absolute top-2 right-2 w-2 h-2 bg-brand-600 rounded-full ring-2 ring-white"></span>
            </button>

            <!-- Notification Dropdown Menu -->
            <div x-cloak x-show="open" @click.away="open = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 py-3 z-50">
                <div class="px-4 pb-2 border-b border-slate-100 flex items-center justify-between">
                    <h6 class="text-xs font-bold text-slate-800 uppercase tracking-wider">System Alerts</h6>
                    <span class="text-[11px] font-semibold text-brand-600 bg-brand-50 px-2 py-0.5 rounded-full">3 New</span>
                </div>
                <div class="divide-y divide-slate-50 max-h-64 overflow-y-auto">
                    <a href="#" class="flex gap-3 px-4 py-3 hover:bg-slate-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-800">Enrollment completed</p>
                            <p class="text-[11px] text-slate-500">New student registration processed for semester.</p>
                            <span class="text-[10px] text-slate-400">12 min ago</span>
                        </div>
                    </a>
                    <a href="#" class="flex gap-3 px-4 py-3 hover:bg-slate-50 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-800">Pending grade review</p>
                            <p class="text-[11px] text-slate-500">CS-301 mid-term grade audit scheduled.</p>
                            <span class="text-[10px] text-slate-400">1 hour ago</span>
                        </div>
                    </a>
                </div>
                <div class="px-4 pt-2 border-t border-slate-100 text-center">
                    <a href="#" class="text-xs font-semibold text-brand-600 hover:text-brand-700">View all notifications</a>
                </div>
            </div>
        </div>

        <!-- Shortcut: Calendar / Schedule -->
        <button @click="showToast('Academic schedule: Week 8 examinations scheduled for Friday.', 'info')" 
                class="hidden sm:inline-flex p-2.5 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition-colors focus:outline-hidden" title="Academic Schedule">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </button>

        <!-- Shortcut: 'New Student' Action Button -->
        <a href="{{ route('students.index') }}" 
           @click="$dispatch('open-add-student')"
           class="inline-flex items-center gap-1.5 px-3 sm:px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-brand-50 text-brand-700 hover:bg-brand-100 border border-brand-200/80 transition-all shadow-2xs">
            <svg class="w-4 h-4 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M12 4v16m8-8H4"/>
            </svg>
            <span>New Student</span>
        </a>

        <div class="h-8 w-px bg-slate-200 mx-1"></div>

        <!-- Administrator Profile Dropdown ('Dr. Sarah Vance') -->
        <div class="relative" x-data="{ profileMenuOpen: false }">
            <button @click="profileMenuOpen = !profileMenuOpen" 
                    class="flex items-center gap-2.5 p-1 sm:p-1.5 rounded-xl hover:bg-slate-100 transition-colors focus:outline-hidden">
                <div class="relative">
                    <img class="w-9 h-9 rounded-xl object-cover ring-2 ring-brand-500/20" 
                         src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=200&auto=format&fit=crop" 
                         alt="Dr. Sarah Vance">
                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></span>
                </div>
                <div class="hidden md:block text-left">
                    <p class="text-xs font-bold text-slate-800 leading-tight">Dr. Sarah Vance</p>
                    <p class="text-[11px] font-medium text-slate-500 leading-tight">Admin Director</p>
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
                 class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 divide-y divide-slate-100">
                <div class="px-4 py-2.5">
                    <p class="text-xs text-slate-400 font-medium">Signed in as</p>
                    <p class="text-xs font-bold text-slate-800 truncate">sarah.vance@edupulse.edu</p>
                </div>
                <div class="py-1">
                    <a href="{{ route('settings.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7 7z"/></svg>
                        <span>Administrator Profile</span>
                    </a>
                    <a href="{{ route('settings.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition-colors">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Account Settings</span>
                    </a>
                </div>
                <div class="py-1">
                    <a href="#" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition-colors">
                        <svg class="w-4 h-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Sign Out</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</header>
