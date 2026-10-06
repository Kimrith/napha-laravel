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
