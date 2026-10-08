<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Department;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the main system dashboard overview.
     */
    public function dashboard(): View
    {
        $recentStudents = Student::latest()->take(5)->get();
        $studentsCount = Student::count();
        $coursesCount = Course::count();
        $departmentsCount = Department::count();

        return view('dashboard', [
            'recentStudents' => $recentStudents,
            'studentsCount' => $studentsCount,
            'coursesCount' => $coursesCount,
            'departmentsCount' => $departmentsCount,
        ]);
    }

    /**
     * Display active courses and syllabus catalogue.
     */
    public function courses(): View
    {
        $courses = Course::with('department')->get()->map(function (Course $c): array {
            return [
                'id' => $c->id,
                'code' => $c->code,
                'name' => $c->name,
                'dept' => $c->department?->name ?? 'General',
                'instructor' => $c->instructor ?? 'Unassigned',
                'credits' => (int) $c->credits,
                'enrolled' => (int) $c->enrolled,
                'capacity' => (int) $c->capacity,
                'days' => $c->days ?? 'TBA',
                'room' => $c->room ?? 'TBA',
                'status' => $c->status,
            ];
        });

        return view('courses.index', ['courses' => $courses]);
    }

    /**
     * Display attendance logs and roll-call manager.
     */
    public function attendance(): View
    {
        $attendees = Attendance::with(['student', 'course'])->latest()->get()->map(function (Attendance $a): array {
            return [
                'id' => $a->student?->student_id ?? 'N/A',
                'name' => $a->student?->name ?? 'Unknown',
                'major' => $a->student?->major ?? 'N/A',
                'timeIn' => $a->time_in ?? '--:--',
                'status' => $a->status,
            ];
        });

        return view('attendance.index', ['attendees' => $attendees]);
    }

    /**
     * Display academic grades, GPA matrices, and exam records.
     */
    public function grades(): View
    {
        $records = Grade::with(['student', 'course'])->latest()->get()->map(function (Grade $g): array {
            return [
                'id' => $g->student?->student_id ?? 'N/A',
                'name' => $g->student?->name ?? 'Unknown',
                'major' => $g->student?->major ?? 'N/A',
                'course' => $g->course_name,
                'midScore' => $g->mid_score,
                'finalScore' => $g->final_score,
                'grade' => $g->grade,
                'gpa' => number_format((float) $g->gpa, 2),
                'standing' => $g->standing ?? 'Good Standing',
            ];
        });

        return view('grades.index', ['records' => $records]);
    }

    /**
     * Display university departments and academic divisions.
     */
    public function departments(): View
    {
        $departments = Department::all()->map(function (Department $d): array {
            return [
                'id' => $d->id,
                'name' => $d->name,
                'code' => $d->code,
                'head' => $d->head ?? 'Unassigned',
                'students' => (int) $d->students_count,
                'faculty' => (int) $d->faculty_count,
                'programs' => (int) $d->programs_count,
                'budget' => $d->budget ?? '$0M',
                'status' => $d->status,
            ];
        });

        return view('departments.index', ['departments' => $departments]);
    }

    /**
     * Display administrative system settings and configurations.
     */
    public function settings(): View
    {
        return view('settings.index');
    }
}
