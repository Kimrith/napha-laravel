<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ClassController extends Controller
{
    /**
     * Display a listing of classes with enrolled student counts.
     */
    public function index(Request $request): View|JsonResponse
    {
        $classes = SchoolClass::withCount('students')
            ->with(['students' => function ($q): void {
                $q->select('id', 'student_id', 'name', 'email', 'avatar', 'major', 'class_id', 'gpa', 'status');
            }])
            ->orderBy('code')
            ->get();

        $allStudents = Student::select('id', 'student_id', 'name', 'avatar', 'major', 'class_id', 'status')
            ->orderBy('name')
            ->get();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $classes,
                'students' => $allStudents,
            ]);
        }

        return view('classes.index', [
            'classes' => $classes,
            'allStudents' => $allStudents,
        ]);
    }

    /**
     * Store a newly created class in storage.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:30', 'unique:classes,code'],
            'name' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:30'],
        ]);

        if (empty($validated['status'])) {
            $validated['status'] = 'Active';
        }

        $class = SchoolClass::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Class {$class->code} created successfully.",
                'data' => $class,
            ], 201);
        }

        return redirect()->route('classes.index')->with('success', "Class {$class->code} ({$class->name}) created successfully.");
    }

    /**
     * Update the specified class in storage.
     */
    public function update(Request $request, SchoolClass $class): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:30', "unique:classes,code,{$class->id}"],
            'name' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:30'],
        ]);

        if (empty($validated['status'])) {
            $validated['status'] = 'Active';
        }

        $class->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Class {$class->code} updated successfully.",
                'data' => $class,
            ]);
        }

        return redirect()->route('classes.index')->with('success', "Class {$class->code} updated successfully.");
    }

    /**
     * Remove the specified class from storage.
     */
    public function destroy(Request $request, SchoolClass $class): RedirectResponse|JsonResponse
    {
        $code = $class->code;
        $class->students()->update(['class_id' => null]);
        $class->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Class {$code} deleted successfully.",
            ]);
        }

        return redirect()->route('classes.index')->with('success', "Class {$code} deleted successfully.");
    }

    /**
     * Assign selected students to this class.
     */
    public function assignStudents(Request $request, SchoolClass $class): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'student_ids' => ['required', 'array'],
            'student_ids.*' => ['exists:students,id'],
        ]);

        DB::transaction(function () use ($class, $validated): void {
            Student::whereIn('id', $validated['student_ids'])->update(['class_id' => $class->id]);
            $class->enrolledStudents()->syncWithoutDetaching($validated['student_ids']);
        });

        $count = count($validated['student_ids']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Assigned {$count} students to {$class->code}.",
            ]);
        }

        return redirect()->route('classes.index')->with('success', "Assigned {$count} students to {$class->code} successfully.");
    }

    /**
     * Remove a student from this class.
     */
    public function removeStudent(Request $request, SchoolClass $class, Student $student): RedirectResponse|JsonResponse
    {
        DB::transaction(function () use ($class, $student): void {
            if ($student->class_id === $class->id) {
                $student->update(['class_id' => null]);
            }
            $class->enrolledStudents()->detach($student->id);
        });

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Student {$student->name} removed from {$class->code}.",
            ]);
        }

        return redirect()->route('classes.index')->with('success', "Student {$student->name} removed from {$class->code}.");
    }
}
