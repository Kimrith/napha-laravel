<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    /**
     * Display a listing of academic departments with live KPI aggregations.
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = Department::withCount(['students', 'courses'])->orderBy('name');

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('head', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->input('status') !== 'All') {
            $query->where('status', $request->input('status'));
        }

        $departmentsList = $query->get()->map(fn (Department $d): array => $this->formatDepartmentForView($d));

        $kpis = [
            'total' => Department::count(),
            'active' => Department::where('status', 'Active')->count(),
            'inactive' => Department::where('status', '!=', 'Active')->count(),
            'total_programs' => (int) Department::sum('programs_count'),
            'total_students' => Student::whereNotNull('department_id')->count(),
            'total_faculty' => (int) Department::sum('faculty_count'),
        ];

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $departmentsList,
                'kpis' => $kpis,
            ]);
        }

        return view('departments.index', [
            'departments' => $departmentsList,
            'kpis' => $kpis,
            'appliedFilters' => [
                'search' => $request->input('search', ''),
                'status' => $request->input('status', 'All'),
            ],
        ]);
    }

    /**
     * Store a newly created academic department.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:20', 'unique:departments,code'],
            'head' => ['required', 'string', 'max:255'],
            'budget' => ['nullable', 'string', 'max:50'],
            'faculty_count' => ['nullable', 'integer', 'min:0'],
            'programs_count' => ['nullable', 'integer', 'min:0'],
            'students_count' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'string', 'in:Active,Inactive'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));
        $validated['budget'] = $validated['budget'] ?: '$1.0M';
        $validated['status'] = $validated['status'] ?: 'Active';
        $validated['faculty_count'] = (int) ($validated['faculty_count'] ?? 0);
        $validated['programs_count'] = (int) ($validated['programs_count'] ?? 1);
        $validated['students_count'] = (int) ($validated['students_count'] ?? 0);

        $department = Department::create($validated);
        $department->loadCount(['students', 'courses']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Department {$department->name} ({$department->code}) created successfully.",
                'data' => $this->formatDepartmentForView($department),
            ], 201);
        }

        return redirect()->route('departments.index')->with('success', "Department {$department->name} created successfully.");
    }

    /**
     * Display the specified department with its faculty and enrolled students.
     */
    public function show(Request $request, Department $department): View|JsonResponse
    {
        $department->loadCount(['students', 'courses']);
        $department->load(['students' => function ($q): void {
            $q->latest()->limit(20);
        }, 'courses']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $this->formatDepartmentForView($department),
            ]);
        }

        return view('departments.index', [
            'activeDepartment' => $department,
        ]);
    }

    /**
     * Update the specified department in database.
     */
    public function update(Request $request, Department $department): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:20', "unique:departments,code,{$department->id}"],
            'head' => ['required', 'string', 'max:255'],
            'budget' => ['nullable', 'string', 'max:50'],
            'faculty_count' => ['nullable', 'integer', 'min:0'],
            'programs_count' => ['nullable', 'integer', 'min:0'],
            'students_count' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'string', 'in:Active,Inactive'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));
        if (empty($validated['budget'])) {
            $validated['budget'] = $department->budget ?: '$1.0M';
        }
        if (empty($validated['status'])) {
            $validated['status'] = $department->status ?: 'Active';
        }

        $department->update($validated);
        $department->loadCount(['students', 'courses']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Department {$department->name} ({$department->code}) updated successfully.",
                'data' => $this->formatDepartmentForView($department),
            ]);
        }

        return redirect()->route('departments.index')->with('success', "Department {$department->name} updated successfully.");
    }

    /**
     * Remove the specified department from database.
     */
    public function destroy(Request $request, Department $department): RedirectResponse|JsonResponse
    {
        $name = $department->name;
        $code = $department->code;

        // Disassociate related students and courses safely
        Student::where('department_id', $department->id)->update(['department_id' => null]);
        $department->courses()->update(['department_id' => null]);

        $department->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Department {$name} ({$code}) removed successfully.",
            ]);
        }

        return redirect()->route('departments.index')->with('success', "Department {$name} removed successfully.");
    }

    /**
     * Transform a department model into view-compatible array structure.
     *
     * @return array<string, mixed>
     */
    private function formatDepartmentForView(Department $department): array
    {
        $realStudentCount = $department->students_count ?? 0;
        // If relation students_count is populated via withCount, prioritize it if manual count is 0
        $displayStudents = $department->students_count > 0 ? (int) $department->students_count : (int) ($department->students()->count());

        return [
            'id' => $department->id,
            'name' => $department->name,
            'code' => $department->code,
            'head' => $department->head ?: 'Unassigned',
            'budget' => $department->budget ?: '$1.0M',
            'students' => $displayStudents,
            'enrolled_students_count' => (int) ($department->students_count ?? $department->students()->count()),
            'faculty' => (int) ($department->faculty_count ?? 0),
            'programs' => (int) ($department->programs_count ?? 1),
            'courses_count' => (int) ($department->courses_count ?? $department->courses()->count()),
            'status' => $department->status ?: 'Active',
            'description' => $department->description ?: '',
            'created_at' => $department->created_at?->format('Y-m-d') ?: '',
        ];
    }
}
