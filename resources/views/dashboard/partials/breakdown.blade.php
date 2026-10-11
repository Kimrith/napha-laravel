<!-- resources/views/dashboard/partials/breakdown.blade.php -->
<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs overflow-hidden transition-colors">
    <!-- Header -->
    <div class="p-5 sm:px-6 border-b border-slate-100 dark:border-slate-800/80 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2">
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Recent Student Admissions</h3>
                @if(isset($recentStudents) && count($recentStudents) > 0)
                    <span class="text-[11px] font-semibold text-brand-700 dark:text-brand-300 bg-brand-50 dark:bg-brand-950/60 px-2 py-0.5 rounded-full border border-brand-100 dark:border-brand-800/80">
                        {{ count($recentStudents) }} Latest
                    </span>
                @endif
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Real-time enrollment stream and cohort assignments.</p>
        </div>
        <a href="{{ route('students.index') }}" class="text-xs font-semibold text-brand-600 dark:text-brand-400 hover:text-brand-700 dark:hover:text-brand-300 inline-flex items-center gap-1 group">
            <span>View All</span>
            <span class="group-hover:translate-x-0.5 transition-transform">&rarr;</span>
        </a>
    </div>

    <!-- Student List -->
    <div class="divide-y divide-slate-100 dark:divide-slate-800/80">
        @forelse($recentStudents ?? [] as $recent)
            <div class="p-4 sm:px-6 flex items-center justify-between gap-4 hover:bg-slate-50/70 dark:hover:bg-slate-800/50 transition-colors">
                <!-- Avatar & Core Info -->
                <div class="flex items-center gap-3.5 min-w-0">
                    <img class="w-10 h-10 rounded-xl object-cover ring-2 ring-slate-100 dark:ring-slate-800 shrink-0 bg-slate-100 dark:bg-slate-800" 
                         src="{{ $recent->avatar ?: 'https://ui-avatars.com/api/?name=' . urlencode($recent->name) . '&background=6366f1&color=fff' }}" 
                         alt="{{ $recent->name }}">
                    
                    <div class="min-w-0 space-y-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white truncate">{{ $recent->name }}</span>
                            @if($recent->degree || $recent->major)
                                <span class="text-xs text-slate-500 dark:text-slate-400 hidden sm:inline">({{ $recent->degree ?: $recent->major }})</span>
                            @endif
                        </div>

                        <div class="flex items-center gap-1.5 flex-wrap text-xs">
                            <span class="font-mono text-[11px] text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded">
                                {{ $recent->student_id }}
                            </span>

                            @if($recent->schoolClass)
                                <span class="font-bold text-[11px] text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-950/60 px-2 py-0.5 rounded border border-indigo-100 dark:border-indigo-800/80">
                                    {{ $recent->schoolClass->code }}
                                </span>
                                @if($recent->schoolClass->room_number)
                                    <span class="text-[11px] font-semibold text-purple-700 dark:text-purple-300 bg-purple-50 dark:bg-purple-950/60 px-2 py-0.5 rounded border border-purple-100 dark:border-purple-800/80">
                                        Rm. {{ $recent->schoolClass->room_number }}
                                    </span>
                                @endif
                            @else
                                <span class="text-[11px] font-semibold text-amber-700 dark:text-amber-300 bg-amber-50 dark:bg-amber-950/60 px-2 py-0.5 rounded border border-amber-200 dark:border-amber-800/80">
                                    No Cohort
                                </span>
                            @endif

                            @if($recent->department)
                                <span class="text-slate-300 dark:text-slate-700 hidden md:inline">•</span>
                                <span class="text-slate-500 dark:text-slate-400 text-[11px] hidden md:inline">{{ $recent->department->name }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Metadata & Actions -->
                <div class="flex items-center gap-3 shrink-0">
                    <span class="text-[11px] font-medium text-slate-400 dark:text-slate-500 hidden sm:inline">
                        {{ $recent->created_at?->diffForHumans() ?? 'Recently' }}
                    </span>
                    <a href="{{ route('students.edit', $recent) }}" 
                       title="Edit student"
                       class="p-2 text-slate-400 dark:text-slate-500 hover:text-brand-600 dark:hover:text-brand-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="py-12 px-4 text-center">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 mx-auto flex items-center justify-center mb-3">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white">No student admissions recorded</h4>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1 max-w-sm mx-auto">Get started by enrolling new students into their academic cohorts.</p>
                <a href="{{ route('students.create') }}" class="mt-4 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-brand-600 text-white hover:bg-brand-700 transition-colors">
                    <span>+ Enroll Student</span>
                </a>
            </div>
        @endforelse
    </div>
</div>
