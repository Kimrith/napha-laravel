<!-- resources/views/components/sidebar.blade.php -->
<aside :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       class="fixed lg:static inset-y-0 left-0 z-50 w-72 flex-shrink-0 bg-sidebar-base text-slate-300 transition-transform duration-300 ease-in-out flex flex-col border-r border-sidebar-border select-none">
    
    <!-- Brand / Logo Header -->
    <div class="h-20 flex items-center justify-between px-6 border-b border-sidebar-border/80 bg-sidebar-base">
        <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 to-indigo-400 flex items-center justify-center shadow-lg shadow-brand-600/30 ring-1 ring-white/10 group-hover:scale-105 transition-transform">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.3" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5"/>
                </svg>
            </div>
            <div>
                <div class="flex items-center gap-1.5">
                    <span class="font-extrabold text-white text-base tracking-tight font-sans">EduPulse</span>
                    <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-brand-500/20 text-brand-300 border border-brand-500/30 uppercase tracking-widest">PRO</span>
                </div>
                <p class="text-[11px] text-slate-400 font-medium">Management Portal</p>
            </div>
        </a>

        <!-- Mobile Close Button -->
        <button @click="mobileSidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1 rounded-lg">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Navigation Links Scroll Area -->
    <div class="flex-1 overflow-y-auto sidebar-scroll px-4 py-5 space-y-6">
        
        <!-- Main Navigation -->
        <div>
            <div class="px-3 mb-2 flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Main Navigation</span>
            </div>
            <nav class="space-y-1">
                <!-- Dashboard -->
                <a href="{{ url('/dashboard') }}" 
                   class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->is('dashboard') || request()->is('/') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/25 font-semibold' : 'text-slate-400 hover:text-slate-100 hover:bg-sidebar-hover' }}">
                    <svg class="w-5 h-5 {{ request()->is('dashboard') || request()->is('/') ? 'text-white' : 'text-slate-400 group-hover:text-brand-400' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Students (with active badge counter) -->
                <a href="{{ url('/students') }}" 
                   class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->is('students*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/25 font-semibold' : 'text-slate-400 hover:text-slate-100 hover:bg-sidebar-hover' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ request()->is('students*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-400' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Students</span>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold {{ request()->is('students*') ? 'bg-white/20 text-white' : 'bg-sidebar-card text-brand-300 border border-sidebar-border' }}">
                        2,845
                    </span>
                </a>

                <!-- Active Courses -->
                <a href="{{ url('/courses') }}" 
                   class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->is('courses*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/25 font-semibold' : 'text-slate-400 hover:text-slate-100 hover:bg-sidebar-hover' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ request()->is('courses*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-400' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span>Active Courses</span>
                    </div>
                    <span class="text-[11px] font-semibold {{ request()->is('courses*') ? 'text-white' : 'text-slate-400 group-hover:text-slate-300' }}">64</span>
                </a>

                <!-- Attendance -->
                <a href="{{ url('/attendance') }}" 
                   class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->is('attendance*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/25 font-semibold' : 'text-slate-400 hover:text-slate-100 hover:bg-sidebar-hover' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ request()->is('attendance*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-400' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        <span>Attendance</span>
                    </div>
                    <span class="w-2 h-2 rounded-full bg-emerald-400 ring-4 ring-emerald-400/20"></span>
                </a>

                <!-- Grades & Records -->
                <a href="{{ url('/grades') }}" 
                   class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->is('grades*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/25 font-semibold' : 'text-slate-400 hover:text-slate-100 hover:bg-sidebar-hover' }}">
                    <svg class="w-5 h-5 {{ request()->is('grades*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-400' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span>Grades & Records</span>
                </a>
            </nav>
        </div>

        <!-- Administration Section -->
        <div>
            <div class="px-3 mb-2 flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Administration</span>
            </div>
            <nav class="space-y-1">
                <!-- Departments -->
                <a href="{{ url('/departments') }}" 
                   class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->is('departments*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/25 font-semibold' : 'text-slate-400 hover:text-slate-100 hover:bg-sidebar-hover' }}">
                    <svg class="w-5 h-5 {{ request()->is('departments*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-400' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Departments</span>
                </a>

                <!-- System Settings -->
                <a href="{{ url('/settings') }}" 
                   class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->is('settings*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/25 font-semibold' : 'text-slate-400 hover:text-slate-100 hover:bg-sidebar-hover' }}">
                    <svg class="w-5 h-5 {{ request()->is('settings*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-400' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>System Settings</span>
                </a>
            </nav>
        </div>

        <!-- Academic Info Widget in Sidebar -->
        <div class="p-3.5 rounded-2xl bg-sidebar-card border border-sidebar-border">
            <div class="flex items-center justify-between text-xs font-semibold text-slate-300">
                <span class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Academic Term
                </span>
                <span class="text-[10px] font-bold uppercase tracking-wider px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Active</span>
            </div>
            <div class="mt-2.5">
                <h4 class="text-xs font-bold text-white tracking-tight">Fall Semester 2026</h4>
                <div class="flex items-center justify-between mt-1 text-[11px] text-slate-400 font-medium">
                    <span>Week 8 of 16</span>
                    <span class="text-brand-300 font-semibold">50%</span>
                </div>
                <div class="w-full bg-slate-800 rounded-full h-1.5 mt-1.5 overflow-hidden">
                    <div class="bg-gradient-to-r from-brand-500 to-indigo-400 h-1.5 rounded-full w-1/2"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- Sidebar Footer: User Profile Widget -->
    <div class="p-4 border-t border-sidebar-border bg-sidebar-base/95">
        <div class="flex items-center gap-3 p-2 rounded-xl bg-sidebar-card/80 border border-sidebar-border hover:border-slate-700 transition-colors cursor-pointer group">
            <div class="relative flex-shrink-0">
                <img class="w-10 h-10 rounded-xl object-cover ring-2 ring-brand-500/30" 
                     src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=200&auto=format&fit=crop" 
                     alt="Dr. Sarah Vance">
                <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 border-2 border-sidebar-card rounded-full"></span>
            </div>
            <div class="flex-1 min-w-0">
                <h5 class="text-xs font-bold text-white truncate group-hover:text-brand-300 transition-colors">Dr. Sarah Vance</h5>
                <p class="text-[11px] text-slate-400 truncate font-medium">Chief Dean of Records</p>
            </div>
            <button class="text-slate-400 group-hover:text-white p-1 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                </svg>
            </button>
        </div>
    </div>

</aside>
