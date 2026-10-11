<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\SchoolClass;
use App\Models\Setting;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the executive dashboard overview.
     */
    public function index(Request $request): View
    {
        // 1. Core metric counters
        $studentsCount = Student::count();
        $activeStudentsCount = Student::where('status', 'Active')->count();
        $classesCount = SchoolClass::count();
        $departmentsCount = Department::count();
        $unassignedStudentsCount = Student::whereNull('class_id')->count();

        // 2. Attendance rate calculation from latest session
        $latestAttendanceDate = Attendance::max('date');
        $attendanceRate = 95.0;
        if ($latestAttendanceDate) {
            $sessionLogs = Attendance::whereDate('date', $latestAttendanceDate)->get();
            if ($sessionLogs->isNotEmpty()) {
                $presentOrLate = $sessionLogs->whereIn('status', ['Present', 'Late'])->count();
                $attendanceRate = round(($presentOrLate / $sessionLogs->count()) * 100, 1);
            }
        }

        // 3. Pending administrative items
        $pendingActionsCount = $unassignedStudentsCount + Student::where('status', '!=', 'Active')->count();
        if ($pendingActionsCount === 0) {
            $pendingActionsCount = max(1, $unassignedStudentsCount);
        }

        // 4. Recent student enrollment activity stream
        $recentStudents = Student::with(['department', 'schoolClass'])
            ->latest('id')
            ->take(5)
            ->get();

        // 5. Active class cohorts with rooms and subjects
        $recentClasses = SchoolClass::withCount('students')
            ->orderBy('code')
            ->take(4)
            ->get();

        // 6. Academic Term Configurations
        $termName = Setting::get('term_name', 'Fall Semester 2026');
        $termWeek = Setting::get('term_week', 'Week 8');

        return view('dashboard.index', [
            'studentsCount' => $studentsCount,
            'activeStudentsCount' => $activeStudentsCount,
            'classesCount' => $classesCount,
            'departmentsCount' => $departmentsCount,
            'unassignedStudentsCount' => $unassignedStudentsCount,
            'attendanceRate' => $attendanceRate,
            'pendingActionsCount' => $pendingActionsCount,
            'recentStudents' => $recentStudents,
            'recentClasses' => $recentClasses,
            'termName' => $termName,
            'termWeek' => $termWeek,
            'userName' => Auth::user()?->name ?? 'Dr. Sarah Vance',
        ]);
    }

    /**
     * Alias for index to maintain backwards compatibility.
     */
    public function dashboard(Request $request): View
    {
        return $this->index($request);
    }
}
