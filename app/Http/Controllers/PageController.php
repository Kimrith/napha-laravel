<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Department;
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

    /**
     * Display attendance logs and roll-call manager.
     */

    /**
     * Display academic grades, GPA matrices, and exam records.
     */

    /**
     * Display university departments and academic divisions.
     */

    /**
     * Display administrative system settings and configurations.
     */
    public function settings(): View
    {
        return view('settings.index');
    }
}
