<!-- resources/views/dashboard/partials/breakdown.blade.php -->
<div class="space-y-6">
    <!-- Department Enrolment Progress -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-5">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Enrolment by Academic Department</h3>
                <p class="text-xs text-slate-500 mt-0.5">Distribution of enrolled undergraduates and postgraduates.</p>
            </div>
            <a href="{{ route('departments.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700">
                View All Departments &rarr;
            </a>
        </div>

        <div class="space-y-4">
            <div>
                <div class="flex justify-between text-xs font-semibold text-slate-700 mb-1">
                    <span class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-brand-500"></span>
                        School of Computing & Informatics
                    </span>
                    <span class="text-slate-900 font-bold">894 Students (31.4%)</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="bg-brand-500 h-2 rounded-full" style="width: 78%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-xs font-semibold text-slate-700 mb-1">
                    <span class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        School of Business & Global Finance
                    </span>
                    <span class="text-slate-900 font-bold">642 Students (22.5%)</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="bg-emerald-500 h-2 rounded-full" style="width: 65%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-xs font-semibold text-slate-700 mb-1">
                    <span class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                        Faculty of Life Sciences & Biotech
                    </span>
                    <span class="text-slate-900 font-bold">520 Students (18.2%)</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="bg-purple-500 h-2 rounded-full" style="width: 58%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-xs font-semibold text-slate-700 mb-1">
                    <span class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        Design, Arts & Human-Computer Interaction
                    </span>
                    <span class="text-slate-900 font-bold">410 Students (14.4%)</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="bg-amber-500 h-2 rounded-full" style="width: 48%"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between text-xs font-semibold text-slate-700 mb-1">
                    <span class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-cyan-500"></span>
                        Mechatronics & Robotics Engineering
                    </span>
                    <span class="text-slate-900 font-bold">379 Students (13.5%)</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="bg-cyan-500 h-2 rounded-full" style="width: 42%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Student Activities -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">Recent Student Admissions & Activities</h3>
                <p class="text-xs text-slate-500 mt-0.5">Real-time enrollment stream for Fall 2026.</p>
            </div>
            <a href="{{ route('students.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700">
                View Directory &rarr;
            </a>
        </div>

        <div class="divide-y divide-slate-100">
            <div class="py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img class="w-9 h-9 rounded-xl object-cover ring-2 ring-slate-100" 
                         src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200&auto=format&fit=crop" alt="Alexander">
                    <div>
                        <p class="text-xs font-bold text-slate-900">Alexander Wright enrolled in B.Sc. Software Engineering</p>
                        <p class="text-[11px] text-slate-400">ID: STU-2026-001 · Assigned to Prof. Alan Turing</p>
                    </div>
                </div>
                <span class="text-[11px] font-medium text-slate-400">12 min ago</span>
            </div>

            <div class="py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img class="w-9 h-9 rounded-xl object-cover ring-2 ring-slate-100" 
                         src="https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?q=80&w=200&auto=format&fit=crop" alt="Amara">
                    <div>
                        <p class="text-xs font-bold text-slate-900">Amara Okafor submitted AI Thesis Proposal</p>
                        <p class="text-[11px] text-slate-400">ID: STU-2026-002 · Faculty of Informatics</p>
                    </div>
                </div>
                <span class="text-[11px] font-medium text-slate-400">45 min ago</span>
            </div>

            <div class="py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img class="w-9 h-9 rounded-xl object-cover ring-2 ring-slate-100" 
                         src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200&auto=format&fit=crop" alt="Fatima">
                    <div>
                        <p class="text-xs font-bold text-slate-900">Fatima Al-Zahra received 4.00 Grade Matrix Certification</p>
                        <p class="text-[11px] text-slate-400">ID: STU-2026-007 · Cryptographic Systems</p>
                    </div>
                </div>
                <span class="text-[11px] font-medium text-slate-400">2 hours ago</span>
            </div>
        </div>
    </div>
</div>
