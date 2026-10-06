<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of students, with optional filtering.
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = Student::with('department')->latest();

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('major') && $request->input('major') !== 'All') {
            $query->where('major', $request->input('major'));
        }

        if ($request->filled('status') && $request->input('status') !== 'All') {
            $query->where('status', $request->input('status'));
        }

        $students = $query->get()->map(function (Student $student): array {
            return $this->formatStudentForView($student);
        });

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $students,
            ]);
        }

        $departments = Department::where('status', 'Active')->get();

        return view('students.index', [
            'students' => $students,
            'departments' => $departments,
        ]);
    }

    /**
     * Show the form for creating a new student.
     */
    public function create(): View|JsonResponse
    {
        $departments = Department::where('status', 'Active')->get();

        if (request()->wantsJson()) {
            return response()->json([
                'departments' => $departments,
            ]);
        }

        return view('students.index', [
            'departments' => $departments,
        ]);
    }

    /**
     * Store a newly created student in storage.
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
            'dob' => ['nullable', 'string', 'max:50'],
            'age' => ['nullable', 'integer', 'min:10', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'advisor' => ['nullable', 'string', 'max:255'],
            'gpa' => ['nullable', 'numeric', 'between:0,4.00'],
            'credits' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'string', 'max:30'],
            'avatar' => ['nullable', 'string', 'max:500'],
        ]);

        if (empty($validated['student_id'])) {
            $nextId = (Student::max('id') ?? 0) + 1;
            $validated['student_id'] = 'STU-2026-'.str_pad((string) $nextId, 3, '0', STR_PAD_LEFT);
        }

        if (empty($validated['status'])) {
            $validated['status'] = 'Active';
        }

        if (empty($validated['avatar'])) {
            $validated['avatar'] = 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=250&auto=format&fit=crop';
        }

        $student = Student::create($validated);
        $student->load('department');

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
     * Display the specified student.
     */
    public function show(Request $request, Student $student): View|JsonResponse
    {
        $student->load(['department', 'attendances', 'grades']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $this->formatStudentForView($student),
            ]);
        }

        return view('students.index', [
            'activeStudent' => $this->formatStudentForView($student),
        ]);
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Request $request, Student $student): View|JsonResponse
    {
        $student->load('department');
        $departments = Department::where('status', 'Active')->get();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'student' => $this->formatStudentForView($student),
                'departments' => $departments,
            ]);
        }

        return view('students.index', [
            'editStudent' => $this->formatStudentForView($student),
            'departments' => $departments,
        ]);
    }

    /**
     * Update the specified student in storage.
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
            'dob' => ['nullable', 'string', 'max:50'],
            'age' => ['nullable', 'integer', 'min:10', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'advisor' => ['nullable', 'string', 'max:255'],
            'gpa' => ['nullable', 'numeric', 'between:0,4.00'],
            'credits' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'string', 'max:30'],
            'avatar' => ['nullable', 'string', 'max:500'],
        ]);

        $student->update($validated);
        $student->load('department');

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
     * Remove the specified student from storage.
     */
    public function destroy(Request $request, Student $student): RedirectResponse|JsonResponse
    {
        $name = $student->name;
        $studentId = $student->student_id;

        $student->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Student record for {$name} ({$studentId}) removed successfully.",
            ]);
        }

        return redirect()->route('students.index')->with('success', "Student {$name} deleted successfully.");
    }

    /**
     * Transform a student model into view/Alpine-compatible array structure.
     *
     * @return array<string, mixed>
     */
    private function formatStudentForView(Student $student): array
    {
        return [
            'id' => $student->student_id,
            'db_id' => $student->id,
            'student_id' => $student->student_id,
            'name' => $student->name,
            'gender' => $student->gender ?? 'Other',
            'pronouns' => $student->pronouns ?? 'They/Them',
            'dob' => $student->dob ?? '2004-01-01',
            'age' => $student->age ?? 21,
            'email' => $student->email,
            'phone' => $student->phone ?? '+1 (555) 000-1122',
            'major' => $student->major,
            'degree' => $student->degree ?? "B.Sc. {$student->major}",
            'department' => $student->department?->name ?? 'School of Computing & Informatics',
            'department_id' => $student->department_id,
            'gpa' => number_format((float) $student->gpa, 2),
            'credits' => (int) $student->credits,
            'advisor' => $student->advisor ?? 'Prof. Alan Turing',
            'status' => $student->status,
            'avatar' => $student->avatar ?: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=250&auto=format&fit=crop',
        ];
    }
}
