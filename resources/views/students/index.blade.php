@extends('layouts.app')

@section('title', 'Student Records | EduPulse Pro Portal')

@section('content')
<div x-data="studentDirectory()" 
     x-init="$watch('filteredStudents', () => { selectedIds = selectedIds.filter(id => filteredStudents.some(s => s.id === id)); })"
     @open-add-student.window="addModalOpen = true"
     class="space-y-6">

    <!-- ======================= BREADCRUMBS ======================= -->
    <nav class="flex items-center text-xs font-medium text-slate-500 gap-2">
        <a href="{{ url('/dashboard') }}" class="hover:text-slate-900 transition-colors flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Dashboard</span>
        </a>
        <svg class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-brand-600 font-semibold bg-brand-50 px-2 py-0.5 rounded-md border border-brand-100">
            Student Directory
        </span>
    </nav>

    <!-- ======================= UNASSIGNED STUDENTS ALERT ======================= -->
    @if(($kpis['unassigned'] ?? 0) > 0)
        <div class="p-4 rounded-2xl bg-amber-50/90 border border-amber-200/80 flex items-center justify-between gap-4 shadow-2xs">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-amber-900 uppercase tracking-wider">Unassigned Cohort Alert</h4>
                    <p class="text-xs text-amber-800 mt-0.5 font-medium">
                        There are <strong>{{ $kpis['unassigned'] }}</strong> students not yet assigned to an academic class (e.g. SV1, SV7).
                    </p>
                </div>
            </div>
            <button type="button" 
                    @click="selectedClass = 'unassigned'; selectedMajor = 'All'; selectedStatus = 'All'" 
                    class="px-3.5 py-2 rounded-xl text-xs font-bold bg-amber-600 hover:bg-amber-700 text-white transition-colors shadow-2xs whitespace-nowrap">
                Filter Unassigned
            </button>
        </div>
    @endif

    <!-- ======================= MODULAR PARTIALS ======================= -->
    {{-- Metric Stat Summary Cards --}}
    @include('students.partials.stats')

    {{-- Search, Filters, and Batch Operations --}}
    @include('students.partials.filter')

    {{-- Interactive Roster Table and Pagination --}}
    @include('students.partials.table')

    {{-- Modal and Slideover Overlays --}}
    @include('students.partials.add-modal')
    @include('students.partials.view-slideover')
    @include('students.partials.edit-modal')
    @include('students.partials.delete-modal')

</div>
@endsection

@push('scripts')
    @include('students.partials.data-store')
@endpush
