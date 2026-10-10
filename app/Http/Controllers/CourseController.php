<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    /**
     * Display a listing of courses with real-time KPI metrics and filters.
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = Course::with('department')->orderBy('code');

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search): void {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('instructor', 'like', "%{$search}%")
                    ->orWhere('room', 'like', "%{$search}%")
                    ->orWhereHas('department', function ($dq) use ($search): void {
                        $dq->where('name', 'like', "%{$search}%")
                            ->orWhere('code', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('department') && $request->input('department') !== 'All') {
            $deptFilter = $request->input('department');
            if (is_numeric($deptFilter)) {
                $query->where('department_id', (int) $deptFilter);
            } else {
                $query->whereHas('department', function ($dq) use ($deptFilter): void {
                    $dq->where('name', $deptFilter)->orWhere('code', $deptFilter);
                });
            }
        }

        if ($request->filled('status') && $request->input('status') !== 'All') {
            $query->where('status', $request->input('status'));
        }

        $coursesList = $query->get()->map(fn (Course $c): array => $this->formatCourseForView($c));

        $kpis = [
            'total' => Course::count(),
            'active' => Course::where('status', 'Active')->count(),
            'full' => Course::where('status', 'Full')->count(),
            'total_enrolled' => (int) Course::sum('enrolled'),
            'total_capacity' => (int) Course::sum('capacity'),
        ];

        $departments = Department::where('status', 'Active')->orderBy('name')->get();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $coursesList,
                'kpis' => $kpis,
                'departments' => $departments,
            ]);
        }

        return view('courses.index', [
            'courses' => $coursesList,
            'departments' => $departments,
            'kpis' => $kpis,
            'appliedFilters' => [
                'search' => $request->input('search', ''),
                'department' => $request->input('department', 'All'),
                'status' => $request->input('status', 'All'),
            ],
        ]);
    }

    /**
     * Store a newly created course in database.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:courses,code'],
            'name' => ['required', 'string', 'max:255'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'dept' => ['nullable', 'string', 'max:255'],
            'instructor' => ['required', 'string', 'max:255'],
            'credits' => ['required', 'integer', 'min:1', 'max:12'],
            'enrolled' => ['nullable', 'integer', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1', 'max:500'],
            'days' => ['nullable', 'string', 'max:255'],
            'room' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'string', 'in:Active,Full,Upcoming,Inactive'],
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));
        $validated['enrolled'] = (int) ($validated['enrolled'] ?? 0);
        $validated['status'] = $validated['status'] ?: 'Active';

        // Auto-match department if department_id was not directly given
        if (empty($validated['department_id']) && ! empty($validated['dept'])) {
            $dept = Department::where('name', $validated['dept'])
                ->orWhere('code', $validated['dept'])
                ->first();
            if ($dept) {
                $validated['department_id'] = $dept->id;
            }
        }
        unset($validated['dept']);

        $course = Course::create($validated);
        $course->load('department');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Course {$course->code} - {$course->name} created successfully.",
                'data' => $this->formatCourseForView($course),
            ], 201);
        }

        return redirect()->route('courses.index')->with('success', "Course {$course->code} created successfully.");
    }

    /**
     * Display the specified course details.
     */
    public function show(Request $request, Course $course): View|JsonResponse
    {
        $course->load(['department', 'attendances']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $this->formatCourseForView($course),
            ]);
        }

        return view('courses.index', [
            'activeCourse' => $course,
        ]);
    }

    /**
     * Update the specified course in database.
     */
    public function update(Request $request, Course $course): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', "unique:courses,code,{$course->id}"],
            'name' => ['required', 'string', 'max:255'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'dept' => ['nullable', 'string', 'max:255'],
            'instructor' => ['required', 'string', 'max:255'],
            'credits' => ['required', 'integer', 'min:1', 'max:12'],
            'enrolled' => ['nullable', 'integer', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1', 'max:500'],
            'days' => ['nullable', 'string', 'max:255'],
            'room' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'string', 'in:Active,Full,Upcoming,Inactive'],
        ]);

        $validated['code'] = strtoupper(trim($validated['code']));
        if (empty($validated['status'])) {
            $validated['status'] = $course->status ?: 'Active';
        }

        if (array_key_exists('dept', $validated) && ! empty($validated['dept'])) {
            $dept = Department::where('name', $validated['dept'])
                ->orWhere('code', $validated['dept'])
                ->first();
            if ($dept) {
                $validated['department_id'] = $dept->id;
            }
            unset($validated['dept']);
        }

        $course->update($validated);
        $course->load('department');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Course {$course->code} records updated successfully.",
                'data' => $this->formatCourseForView($course),
            ]);
        }

        return redirect()->route('courses.index')->with('success', "Course {$course->code} updated successfully.");
    }

    /**
     * Remove the specified course from database.
     */
    public function destroy(Request $request, Course $course): RedirectResponse|JsonResponse
    {
        $code = $course->code;
        $name = $course->name;

        // Clean up relation references safely
        $course->attendances()->delete();
        $course->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Course {$code} ({$name}) removed successfully.",
            ]);
        }

        return redirect()->route('courses.index')->with('success', "Course {$code} deleted successfully.");
    }

    /**
     * Transform a course model into view-compatible array structure.
     *
     * @return array<string, mixed>
     */
    private function formatCourseForView(Course $course): array
    {
        return [
            'id' => $course->id,
            'code' => $course->code,
            'name' => $course->name,
            'department_id' => $course->department_id,
            'dept' => $course->department?->name ?? 'General',
            'instructor' => $course->instructor ?: 'Unassigned',
            'credits' => (int) $course->credits,
            'enrolled' => (int) $course->enrolled,
            'capacity' => (int) $course->capacity,
            'days' => $course->days ?: 'TBA',
            'room' => $course->room ?: 'TBA',
            'status' => $course->status ?: 'Active',
            'created_at' => $course->created_at?->format('Y-m-d') ?: '',
        ];
    }
}
