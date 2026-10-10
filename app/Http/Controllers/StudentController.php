<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\SchoolClass;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StudentController extends Controller
{
    /**
     * Display a listing of students with live KPI metrics and server filtering.
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = $this->buildFilteredQuery($request);

        // Live KPI Aggregations directly calculated via Eloquent ORM
        $kpis = [
            'total' => Student::count(),
            'active' => Student::where('status', 'Active')->count(),
            'inactive' => Student::where('status', '!=', 'Active')->count(),
            'avg_gpa' => number_format((float) (Student::avg('gpa') ?? 0.0), 2),
            'unassigned' => Student::whereNull('class_id')->count(),
        ];

        // Retrieve active departments and classes for dropdown filters and forms
        $departments = Department::where('status', 'Active')->orderBy('name')->get();
        $classes = SchoolClass::where('status', 'Active')->orderBy('code')->get();

        // Unique majors currently in database for dynamic filter
        $majors = Student::distinct()->whereNotNull('major')->pluck('major')->toArray();
        if (empty($majors)) {
            $majors = [
                'Computer Science',
                'Data Science & AI',
                'Digital Design',
                'Robotics & Automation',
                'Biotechnology',
                'International Finance',
                'Cybersecurity',
                'Media Communications',
            ];
        }

        if ($request->wantsJson() && $request->boolean('paginate', false)) {
            $perPage = (int) $request->input('per_page', 10);
            $paginated = $query->paginate($perPage)->withQueryString();

            return response()->json([
                'success' => true,
                'data' => collect($paginated->items())->map(fn (Student $s): array => $this->formatStudentForView($s)),
                'meta' => [
                    'current_page' => $paginated->currentPage(),
                    'last_page' => $paginated->lastPage(),
                    'per_page' => $paginated->perPage(),
                    'total' => $paginated->total(),
                ],
                'kpis' => $kpis,
            ]);
        }

        $students = $query->get()->map(fn (Student $s): array => $this->formatStudentForView($s));

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $students,
                'kpis' => $kpis,
            ]);
        }

        return view('students.index', [
            'students' => $students,
            'departments' => $departments,
            'classes' => $classes,
            'majors' => $majors,
            'kpis' => $kpis,
            'appliedFilters' => [
                'search' => $request->input('search', ''),
                'major' => $request->input('major', 'All'),
                'department_id' => $request->input('department_id', 'All'),
                'class_id' => $request->input('class_id', 'All'),
                'status' => $request->input('status', 'All'),
            ],
        ]);
    }

    /**
     * Show form data for creating a student.
     */
    public function create(): View|JsonResponse
    {
        $departments = Department::where('status', 'Active')->orderBy('name')->get();
        $classes = SchoolClass::where('status', 'Active')->orderBy('code')->get();

        if (request()->wantsJson()) {
            return response()->json([
                'departments' => $departments,
                'classes' => $classes,
            ]);
        }

        return view('students.index', [
            'departments' => $departments,
            'classes' => $classes,
        ]);
    }

    /**
     * Store a newly created student in database.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email'],
            'student_id' => ['nullable', 'string', 'max:50', 'unique:students,student_id'],
            'major' => ['required', 'string', 'max:255'],
            'degree' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'max:20'],
            'pronouns' => ['nullable', 'string', 'max:50'],
            'dob' => ['nullable', 'date'],
            'age' => ['nullable', 'integer', 'min:10', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'class_id' => ['nullable', 'exists:classes,id'],
            'advisor' => ['nullable', 'string', 'max:255'],
            'gpa' => ['nullable', 'numeric', 'between:0,4.00'],
            'credits' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'string', 'max:30'],
            'avatar' => $request->hasFile('avatar')
                ? ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048']
                : ['nullable', 'string', 'max:500'],
        ]);

        if (empty($validated['student_id'])) {
            $nextId = (Student::max('id') ?? 0) + 1;
            $validated['student_id'] = 'STU-2026-'.str_pad((string) $nextId, 3, '0', STR_PAD_LEFT);
        }

        if (empty($validated['status'])) {
            $validated['status'] = 'Active';
        }

        if (empty($validated['department_id'])) {
            $validated['department_id'] = null;
        }

        if (empty($validated['class_id'])) {
            $validated['class_id'] = null;
        }

        if (empty($validated['age']) && ! empty($validated['dob'])) {
            try {
                $validated['age'] = Carbon::parse($validated['dob'])->age;
            } catch (\Throwable) {
                // Ignore parse failures
            }
        }

        // Profile avatar handling using the public disk
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = Storage::url($path);
        } elseif (empty($validated['avatar'])) {
            $validated['avatar'] = 'https://ui-avatars.com/api/?name='.urlencode($validated['name']).'&background=6366f1&color=fff';
        }

        $student = DB::transaction(function () use ($validated): Student {
            $s = Student::create($validated);

            // Sync with class_student pivot if class assigned
            if (! empty($validated['class_id'])) {
                $s->classes()->sync([$validated['class_id']]);
            }

            return $s;
        });

        $student->load(['department', 'schoolClass']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Student {$student->name} ({$student->student_id}) enrolled successfully.",
                'data' => $this->formatStudentForView($student),
            ], 201);
        }

        return redirect()->route('students.index')->with('success', "Student {$student->name} created successfully.");
    }

    /**
     * Display the specified student dossier.
     */
    public function show(Request $request, Student $student): JsonResponse|View
    {
        $student->load(['department', 'schoolClass', 'attendances', 'grades']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $this->formatStudentForView($student),
            ]);
        }

        return view('students.index', [
            'activeStudent' => $student,
        ]);
    }

    /**
     * Update the specified student in database.
     */
    public function update(Request $request, Student $student): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', "unique:students,email,{$student->id}"],
            'major' => ['required', 'string', 'max:255'],
            'degree' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'max:20'],
            'pronouns' => ['nullable', 'string', 'max:50'],
            'dob' => ['nullable', 'date'],
            'age' => ['nullable', 'integer', 'min:10', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'class_id' => ['nullable', 'exists:classes,id'],
            'advisor' => ['nullable', 'string', 'max:255'],
            'gpa' => ['nullable', 'numeric', 'between:0,4.00'],
            'credits' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'string', 'max:30'],
            'avatar' => $request->hasFile('avatar')
                ? ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048']
                : ['nullable', 'string', 'max:500'],
        ]);

        if (array_key_exists('department_id', $validated) && empty($validated['department_id'])) {
            $validated['department_id'] = null;
        }

        if (array_key_exists('class_id', $validated) && empty($validated['class_id'])) {
            $validated['class_id'] = null;
        }

        if (empty($validated['age']) && ! empty($validated['dob'])) {
            try {
                $validated['age'] = Carbon::parse($validated['dob'])->age;
            } catch (\Throwable) {
                // Ignore parse failures
            }
        }

        // Profile avatar handling using the public disk
        if ($request->hasFile('avatar')) {
            if ($student->avatar && str_starts_with($student->avatar, '/storage/avatars/')) {
                $oldPath = str_replace('/storage/', '', $student->avatar);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = Storage::url($path);
        } else {
            if (! array_key_exists('avatar', $validated) || $validated['avatar'] === null || $validated['avatar'] === '') {
                unset($validated['avatar']);
            }
        }

        DB::transaction(function () use ($student, $validated): void {
            $student->update($validated);

            // Sync with class_student pivot
            if (array_key_exists('class_id', $validated)) {
                if (! empty($validated['class_id'])) {
                    $student->classes()->sync([$validated['class_id']]);
                } else {
                    $student->classes()->detach();
                }
            }
        });

        $student->load(['department', 'schoolClass']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Student {$student->name} records updated successfully.",
                'data' => $this->formatStudentForView($student),
            ]);
        }

        return redirect()->route('students.index')->with('success', "Student {$student->name} updated successfully.");
    }

    /**
     * Remove the specified student from database.
     */
    public function destroy(Request $request, Student $student): RedirectResponse|JsonResponse
    {
        $name = $student->name;
        $studentId = $student->student_id;

        if ($student->avatar && str_starts_with($student->avatar, '/storage/avatars/')) {
            $oldPath = str_replace('/storage/', '', $student->avatar);
            Storage::disk('public')->delete($oldPath);
        }

        DB::transaction(function () use ($student): void {
            $student->classes()->detach();
            $student->delete();
        });

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Student record for {$name} ({$studentId}) removed successfully.",
            ]);
        }

        return redirect()->route('students.index')->with('success', "Student {$name} deleted successfully.");
    }

    /**
     * Batch assign multiple students to a class.
     */
    public function batchAssign(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'student_ids' => ['required', 'array', 'min:1'],
            'student_ids.*' => ['exists:students,student_id'],
            'class_id' => ['nullable'],
        ]);

        $classId = ! empty($validated['class_id']) && $validated['class_id'] !== 'unassigned'
            ? (int) $validated['class_id']
            : null;

        $targetClass = $classId ? SchoolClass::find($classId) : null;

        DB::transaction(function () use ($validated, $classId): void {
            $students = Student::whereIn('student_id', $validated['student_ids'])->get();

            foreach ($students as $student) {
                $student->update(['class_id' => $classId]);
                if ($classId) {
                    $student->classes()->sync([$classId]);
                } else {
                    $student->classes()->detach();
                }
            }
        });

        $count = count($validated['student_ids']);
        $className = $targetClass ? $targetClass->code : 'Unassigned';

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Assigned {$count} students to {$className}.",
            ]);
        }

        return redirect()->route('students.index')->with('success', "Assigned {$count} students to {$className} successfully.");
    }

    /**
     * Batch update status for selected students.
     */
    public function batchStatus(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'student_ids' => ['required', 'array', 'min:1'],
            'student_ids.*' => ['exists:students,student_id'],
            'status' => ['required', 'string', 'in:Active,Inactive'],
        ]);

        Student::whereIn('student_id', $validated['student_ids'])->update(['status' => $validated['status']]);

        $count = count($validated['student_ids']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Updated status to {$validated['status']} for {$count} students.",
            ]);
        }

        return redirect()->route('students.index')->with('success', "Updated status to {$validated['status']} for {$count} students.");
    }

    /**
     * Batch delete selected students.
     */
    public function batchDelete(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'student_ids' => ['required', 'array', 'min:1'],
            'student_ids.*' => ['exists:students,student_id'],
        ]);

        $count = 0;
        DB::transaction(function () use ($validated, &$count): void {
            $students = Student::whereIn('student_id', $validated['student_ids'])->get();
            foreach ($students as $s) {
                if ($s->avatar && str_starts_with($s->avatar, '/storage/avatars/')) {
                    $oldPath = str_replace('/storage/', '', $s->avatar);
                    Storage::disk('public')->delete($oldPath);
                }
                $s->classes()->detach();
                $s->delete();
                $count++;
            }
        });

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Deleted {$count} student records.",
            ]);
        }

        return redirect()->route('students.index')->with('success', "Deleted {$count} student records successfully.");
    }

    /**
     * Stream native CSV export of filtered students.
     */
    public function export(Request $request): StreamedResponse
    {
        $query = $this->buildFilteredQuery($request);
        $filename = 'EduPulse_Students_Export_'.now()->format('Y-m-d_His').'.csv';

        return response()->streamDownload(function () use ($query): void {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'Student ID',
                'Name',
                'Gender',
                'Pronouns',
                'Email',
                'Phone',
                'Class Code',
                'Class Name',
                'Department',
                'Major',
                'Degree',
                'Date of Birth',
                'Age',
                'Cumulative GPA',
                'Credits',
                'Academic Advisor',
                'Status',
                'Enrolled Date',
            ]);

            $query->chunk(150, function ($students) use ($handle): void {
                foreach ($students as $student) {
                    fputcsv($handle, [
                        $student->student_id,
                        $student->name,
                        $student->gender ?? 'Other',
                        $student->pronouns ?? '',
                        $student->email,
                        $student->phone ?? '',
                        $student->schoolClass?->code ?? 'Unassigned',
                        $student->schoolClass?->name ?? 'Unassigned',
                        $student->department?->name ?? 'Unassigned',
                        $student->major,
                        $student->degree ?? $student->major,
                        $student->dob ?? '',
                        $student->age ?? '',
                        $student->gpa !== null ? number_format((float) $student->gpa, 2) : '0.00',
                        (int) ($student->credits ?? 0),
                        $student->advisor ?? 'Unassigned',
                        $student->status,
                        $student->created_at ? $student->created_at->format('Y-m-d') : '',
                    ]);
                }
            });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Helper to construct filtered query according to incoming request parameters.
     *
     * @return Builder<Student>
     */
    private function buildFilteredQuery(Request $request)
    {
        $query = Student::with(['department', 'schoolClass'])->latest('id');

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('advisor', 'like', "%{$search}%")
                    ->orWhere('major', 'like', "%{$search}%")
                    ->orWhereHas('schoolClass', function ($cq) use ($search): void {
                        $cq->where('code', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('major') && $request->input('major') !== 'All') {
            $query->where('major', $request->input('major'));
        }

        if ($request->filled('department_id') && $request->input('department_id') !== 'All') {
            $query->where('department_id', $request->input('department_id'));
        }

        if ($request->filled('class_id') && $request->input('class_id') !== 'All') {
            if ($request->input('class_id') === 'unassigned') {
                $query->whereNull('class_id');
            } else {
                $query->where('class_id', $request->input('class_id'));
            }
        }

        if ($request->filled('status') && $request->input('status') !== 'All') {
            $query->where('status', $request->input('status'));
        }

        return $query;
    }

    /**
     * Transform a student model into view/Alpine-compatible array structure.
     *
     * @return array<string, mixed>
     */
    private function formatStudentForView(Student $student): array
    {
        $avatar = $student->avatar;
        if (! empty($avatar) && ! str_starts_with($avatar, 'http://') && ! str_starts_with($avatar, 'https://') && ! str_starts_with($avatar, '/')) {
            $avatar = Storage::url($avatar);
        }

        return [
            'id' => $student->student_id,
            'db_id' => $student->id,
            'student_id' => $student->student_id,
            'name' => $student->name,
            'gender' => $student->gender ?? 'Other',
            'pronouns' => $student->pronouns ?? 'They/Them',
            'dob' => $student->dob,
            'age' => $student->age,
            'email' => $student->email,
            'phone' => $student->phone,
            'major' => $student->major,
            'degree' => $student->degree ?: $student->major,
            'department' => $student->department?->name ?: 'Unassigned',
            'department_id' => $student->department_id,
            'class_id' => $student->class_id,
            'class_name' => $student->schoolClass ? ($student->schoolClass->code.' - '.$student->schoolClass->name) : 'Unassigned',
            'class_code' => $student->schoolClass?->code ?: 'Unassigned',
            'gpa' => $student->gpa !== null ? number_format((float) $student->gpa, 2) : '0.00',
            'credits' => (int) ($student->credits ?? 0),
            'advisor' => $student->advisor ?: 'Unassigned',
            'status' => $student->status,
            'avatar' => $avatar ?: 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&background=6366f1&color=fff',
        ];
    }
}
