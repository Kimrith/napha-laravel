<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the main system dashboard overview.
     */
    public function dashboard(): View
    {
        return view('dashboard');
    }

    /**
     * Display active courses and syllabus catalogue.
     */
    public function courses(): View
    {
        return view('courses.index');
    }

    /**
     * Display attendance logs and roll-call manager.
     */
    public function attendance(): View
    {
        return view('attendance.index');
    }

    /**
     * Display academic grades, GPA matrices, and exam records.
     */
    public function grades(): View
    {
        return view('grades.index');
    }

    /**
     * Display university departments and academic divisions.
     */
    public function departments(): View
    {
        return view('departments.index');
    }

    /**
     * Display administrative system settings and configurations.
     */
    public function settings(): View
    {
        return view('settings.index');
    }
}
