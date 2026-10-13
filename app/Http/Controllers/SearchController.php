<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Perform global search across students, classes, departments, courses, and portal actions.
     */
    public function search(Request $request): JsonResponse|RedirectResponse
    {
        $rawQuery = (string) $request->input('q', $request->input('query', ''));
        $query = trim($rawQuery);

        // Fallback for standard non-AJAX browser form submissions
        if (! $request->wantsJson() && ! $request->ajax()) {
            return redirect()->route('students.index', ['search' => $query]);
        }

        $actions = $this->getQuickActions($query);

        if ($query === '') {
            return response()->json([
                'success' => true,
                'query' => '',
                'total' => count($actions),
                'students' => [],
                'classes' => [],
                'departments' => [],
                'courses' => [],
                'actions' => $actions,
            ]);
        }

        // Search Students
        $students = Student::with(['schoolClass', 'department'])
            ->where(function ($q) use ($query): void {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('student_id', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->orWhere('major', 'like', "%{$query}%")
                    ->orWhere('phone', 'like', "%{$query}%")
                    ->orWhere('advisor', 'like', "%{$query}%");
            })
            ->limit(5)
            ->get()
            ->map(function (Student $student): array {
                $classInfo = $student->schoolClass ? ' · '.$student->schoolClass->code : '';

                return [
                    'id' => $student->id,
                    'title' => $student->name,
                    'code' => $student->student_id,
                    'subtitle' => ($student->major ?: 'Student').$classInfo,
                    'avatar' => $student->avatar ?: 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&background=6366f1&color=fff&bold=true',
                    'badge' => $student->status ?: 'Active',
                    'badge_type' => match (strtolower((string) $student->status)) {
                        'active' => 'emerald',
                        'probation' => 'rose',
                        'inactive' => 'slate',
                        default => 'brand',
                    },
                    'meta' => 'GPA: '.number_format((float) ($student->gpa ?? 0), 2),
                    'url' => route('students.index', ['search' => $student->student_id]),
                    'type' => 'student',
                ];
            });

        // Search Classes
        $classes = SchoolClass::withCount('students')
            ->where(function ($q) use ($query): void {
                $q->where('code', 'like', "%{$query}%")
                    ->orWhere('name', 'like', "%{$query}%")
                    ->orWhere('room_number', 'like', "%{$query}%")
                    ->orWhere('subject', 'like', "%{$query}%");
            })
            ->limit(4)
            ->get()
            ->map(function (SchoolClass $class): array {
                $room = $class->room_number ? 'Room '.$class->room_number : null;
                $subject = $class->subject ?: null;
                $subparts = array_filter([$subject, $room]);

                return [
                    'id' => $class->id,
                    'title' => $class->code.' - '.$class->name,
                    'code' => $class->code,
                    'subtitle' => implode(' · ', $subparts) ?: 'Academic Class Cohort',
                    'badge' => $class->students_count.' Enrolled',
                    'badge_type' => 'brand',
                    'meta' => $class->status ?: 'Active',
                    'url' => route('classes.index', ['search' => $class->code]),
                    'type' => 'class',
                ];
            });

        // Search Departments
        $departments = Department::where(function ($q) use ($query): void {
            $q->where('name', 'like', "%{$query}%")
                ->orWhere('code', 'like', "%{$query}%")
                ->orWhere('head', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%");
        })
            ->limit(4)
            ->get()
            ->map(function (Department $dept): array {
                return [
                    'id' => $dept->id,
                    'title' => $dept->code.' · '.$dept->name,
                    'code' => $dept->code,
                    'subtitle' => 'Chair: '.($dept->head ?: 'Dean of Faculty').' · '.($dept->students_count ?? 0).' Students',
                    'badge' => $dept->status ?: 'Active',
                    'badge_type' => 'indigo',
                    'meta' => $dept->budget ?: '',
                    'url' => route('departments.index', ['search' => $dept->code]),
                    'type' => 'department',
                ];
            });

        // Search Courses
        $courses = Course::where(function ($q) use ($query): void {
            $q->where('code', 'like', "%{$query}%")
                ->orWhere('name', 'like', "%{$query}%")
                ->orWhere('instructor', 'like', "%{$query}%")
                ->orWhere('room', 'like', "%{$query}%");
        })
            ->limit(4)
            ->get()
            ->map(function (Course $course): array {
                return [
                    'id' => $course->id,
                    'title' => $course->code.' · '.$course->name,
                    'code' => $course->code,
                    'subtitle' => 'Instructor: '.($course->instructor ?: 'Faculty').($course->room ? ' · Room '.$course->room : ''),
                    'badge' => $course->status ?: 'Active',
                    'badge_type' => 'purple',
                    'meta' => $course->credits.' Credits',
                    'url' => route('students.index', ['search' => $course->code]),
                    'type' => 'course',
                ];
            });

        $totalResults = count($students) + count($classes) + count($departments) + count($courses) + count($actions);

        return response()->json([
            'success' => true,
            'query' => $query,
            'total' => $totalResults,
            'students' => $students,
            'classes' => $classes,
            'departments' => $departments,
            'courses' => $courses,
            'actions' => $actions,
        ]);
    }

    /**
     * Get quick portal actions filtered by query.
     *
     * @return list<array<string, mixed>>
     */
    protected function getQuickActions(string $query): array
    {
        $allActions = [
            [
                'title' => 'Dashboard Overview',
                'description' => 'View institutional KPIs, activity timeline & distribution',
                'category' => 'Navigation',
                'icon' => 'dashboard',
                'url' => route('dashboard'),
                'keywords' => 'dashboard home overview stats analytics metrics',
            ],
            [
                'title' => 'Student Directory',
                'description' => 'Browse, filter, and manage all student dossiers & enrollments',
                'category' => 'Students',
                'icon' => 'students',
                'url' => route('students.index'),
                'keywords' => 'student directory records roster profile dossier add export',
            ],
            [
                'title' => 'Academic Classes (SV1, SV7)',
                'description' => 'Manage academic cohorts, assign students & view rosters',
                'category' => 'Academics',
                'icon' => 'classes',
                'url' => route('classes.index'),
                'keywords' => 'classes cohorts sections groups sv1 sv7 academic assign',
            ],
            [
                'title' => 'Attendance Management',
                'description' => 'Track daily roll call, export attendance logs & mark statuses',
                'category' => 'Academics',
                'icon' => 'attendance',
                'url' => route('attendance.index'),
                'keywords' => 'attendance roll call present absent leave tracking export session',
            ],
            [
                'title' => 'Academic Departments',
                'description' => 'Explore faculty divisions, budgets, and departmental chairs',
                'category' => 'Governance',
                'icon' => 'departments',
                'url' => route('departments.index'),
                'keywords' => 'departments faculty divisions chairs head science engineering',
            ],
            [
                'title' => 'System & Account Settings',
                'description' => 'Change password, manage active semester term & preferences',
                'category' => 'Settings',
                'icon' => 'settings',
                'url' => route('settings.index'),
                'keywords' => 'settings profile password term semester theme preferences dark mode',
            ],
        ];

        if ($query === '') {
            return array_slice($allActions, 0, 4);
        }

        $lowerQuery = strtolower($query);

        return array_values(array_filter($allActions, function (array $action) use ($lowerQuery): bool {
            return str_contains(strtolower((string) $action['title']), $lowerQuery)
                || str_contains(strtolower((string) $action['description']), $lowerQuery)
                || str_contains(strtolower((string) $action['keywords']), $lowerQuery);
        }));
    }
}
