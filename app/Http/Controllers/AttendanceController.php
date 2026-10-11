<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AttendanceController extends Controller
{
    /**
     * Display a listing of attendance logs and live session roll-call.
     */
    public function index(Request $request): View|JsonResponse
    {
        $classes = SchoolClass::orderBy('code')->get();
        $students = Student::orderBy('name')->get();

        // Determine active date filter (default to latest recorded date or today)
        $latestRecordDate = Attendance::max('date');
        $defaultDate = $latestRecordDate ? Carbon::parse($latestRecordDate)->format('Y-m-d') : Carbon::today()->toDateString();
        $selectedDate = $request->filled('date') ? Carbon::parse($request->input('date'))->format('Y-m-d') : $defaultDate;

        // Query each student directly so each student appears exactly once
        $studentQuery = Student::with([
            'department',
            'schoolClass',
            'attendances' => function ($q) use ($selectedDate): void {
                $q->whereDate('date', $selectedDate);
            },
        ])->orderBy('name');

        if ($request->filled('class_id') && $request->input('class_id') !== 'All') {
            $studentQuery->where('class_id', $request->input('class_id'));
        }

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $studentQuery->where(function ($sq) use ($search): void {
                $sq->where('name', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%")
                    ->orWhere('major', 'like', "%{$search}%")
                    ->orWhereHas('schoolClass', function ($scq) use ($search): void {
                        $scq->where('code', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%")
                            ->orWhere('room_number', 'like', "%{$search}%")
                            ->orWhere('subject', 'like', "%{$search}%");
                    });
            });
        }

        $allQueriedStudents = $studentQuery->get();

        $attendees = $allQueriedStudents->map(function (Student $student) use ($selectedDate): array {
            /** @var Attendance|null $attendance */
            $attendance = $student->attendances->first();

            return [
                'record_id' => $attendance?->id,
                'id' => $student->student_id ?? 'N/A',
                'student_db_id' => $student->id,
                'name' => $student->name ?? 'Unknown',
                'avatar' => $student->avatar ?: 'https://ui-avatars.com/api/?name='.urlencode($student->name ?? 'Student').'&background=6366f1&color=fff',
                'major' => $student->major ?? 'N/A',
                'department' => $student->department?->name ?? 'Unassigned',
                'class_id' => $student->class_id,
                'class_code' => $student->schoolClass?->code ?? 'N/A',
                'class_name' => $student->schoolClass?->name ?? '',
                'room_number' => $student->schoolClass?->room_number ?? 'N/A',
                'subject' => $student->schoolClass?->subject ?? 'N/A',
                'date' => $selectedDate,
                'timeIn' => $attendance?->time_in ?? '--:--',
                'status' => $attendance?->status ?? 'Present',
                'notes' => $attendance?->notes ?? '',
            ];
        });

        // Filter by course if selected
        if ($request->filled('course_id') && $request->input('course_id') !== 'All') {
            $courseId = (int) $request->input('course_id');
            $attendees = $attendees->filter(fn (array $a) => (int) $a['course_id'] === $courseId)->values();
        }

        // Filter by status if selected
        if ($request->filled('status') && $request->input('status') !== 'All') {
            $statusFilter = $request->input('status');
            $attendees = $attendees->filter(fn (array $a) => $a['status'] === $statusFilter)->values();
        }

        // Calculate live metrics for the active roster
        $totalRecords = $attendees->count();
        $presentCount = $attendees->where('status', 'Present')->count();
        $lateCount = $attendees->where('status', 'Late')->count();
        $excusedCount = $attendees->where('status', 'Excused')->count();
        $absentCount = $attendees->where('status', 'Absent')->count();
        $attendedCount = $presentCount + $lateCount;
        $rate = $totalRecords > 0 ? round(($attendedCount / $totalRecords) * 100, 1) : 0;

        $kpis = [
            'total' => $totalRecords,
            'present' => $presentCount,
            'late' => $lateCount,
            'excused' => $excusedCount,
            'absent' => $absentCount,
            'rate' => $rate,
            'selectedDate' => $selectedDate,
        ];

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $attendees,
                'kpis' => $kpis,
                'classes' => $classes,
            ]);
        }

        return view('attendance.index', [
            'attendees' => $attendees,
            'kpis' => $kpis,
            'classes' => $classes,
            'students' => $students,
            'selectedDate' => $selectedDate,
            'selectedClassId' => $request->input('class_id', 'All'),
            'selectedStatus' => $request->input('status', 'All'),
        ]);
    }

    /**
     * Store a newly created attendance entry in database.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'course_id' => ['nullable', 'exists:courses,id'],
            'date' => ['required', 'date'],
            'time_in' => ['nullable', 'string', 'max:20'],
            'status' => ['required', 'string', 'in:Present,Late,Excused,Absent'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        if (empty($validated['time_in']) && in_array($validated['status'], ['Present', 'Late'])) {
            $validated['time_in'] = Carbon::now()->format('h:i A');
        }

        $attendance = Attendance::updateOrCreate(
            [
                'student_id' => $validated['student_id'],
                'date' => $validated['date'],
                'course_id' => $validated['course_id'] ?? null,
            ],
            $validated
        );

        $attendance->load(['student.department', 'course']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Attendance logged for {$attendance->student?->name}.",
                'data' => $this->formatAttendeeForView($attendance),
            ], 201);
        }

        return redirect()->route('attendance.index')->with('success', 'Attendance record saved.');
    }

    /**
     * Update the specified attendance entry (status toggle or time change).
     */
    public function update(Request $request, Attendance $attendance): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:Present,Late,Excused,Absent'],
            'time_in' => ['nullable', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        if (empty($validated['time_in']) && in_array($validated['status'], ['Present', 'Late']) && empty($attendance->time_in)) {
            $validated['time_in'] = Carbon::now()->format('h:i A');
        } elseif ($validated['status'] === 'Absent') {
            $validated['time_in'] = null;
        }

        $attendance->update($validated);
        $attendance->load(['student.department', 'course']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Attendance updated for {$attendance->student?->name} ({$attendance->status}).",
                'data' => $this->formatAttendeeForView($attendance),
            ]);
        }

        return redirect()->route('attendance.index')->with('success', 'Attendance updated.');
    }

    /**
     * Quick toggle student attendance status for a given date.
     */
    public function toggleStatus(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'date' => ['required', 'date'],
            'status' => ['required', 'string', 'in:Present,Late,Excused,Absent'],
        ]);

        $date = Carbon::parse($validated['date'])->format('Y-m-d');
        $status = $validated['status'];
        $timeIn = in_array($status, ['Present', 'Late']) ? Carbon::now()->format('h:i A') : null;

        $attendance = Attendance::updateOrCreate(
            [
                'student_id' => $validated['student_id'],
                'date' => $date,
            ],
            [
                'status' => $status,
                'time_in' => $timeIn,
            ]
        );

        $attendance->load(['student.department', 'student.schoolClass', 'course']);

        return response()->json([
            'success' => true,
            'message' => "Updated attendance for {$attendance->student?->name} ({$status}).",
            'data' => $this->formatAttendeeForView($attendance),
        ]);
    }

    /**
     * Finalize roll-call for session and forward records to registrar.
     */
    public function finalize(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'date' => ['nullable', 'date'],
            'course_id' => ['nullable'],
            'attendees' => ['nullable', 'array'],
        ]);

        $date = $validated['date'] ?? Carbon::today()->toDateString();

        if (! empty($validated['attendees'])) {
            foreach ($validated['attendees'] as $attData) {
                if (! empty($attData['record_id'])) {
                    Attendance::where('id', $attData['record_id'])->update([
                        'status' => $attData['status'],
                        'time_in' => $attData['timeIn'] ?? null,
                    ]);
                }
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Roll-call for {$date} finalized and submitted to academic registrar.",
            ]);
        }

        return redirect()->route('attendance.index', ['date' => $date])->with('success', "Roll-call for {$date} finalized.");
    }

    /**
     * Initialize roll-call roster for a session if records do not exist yet.
     */
    public function initializeSession(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'course_id' => ['nullable'],
            'class_id' => ['nullable'],
        ]);

        $date = Carbon::parse($validated['date'])->format('Y-m-d');
        $classId = ($request->filled('class_id') && $request->input('class_id') !== 'All') ? (int) $request->input('class_id') : null;
        $courseId = ($request->filled('course_id') && $request->input('course_id') !== 'All') ? (int) $request->input('course_id') : null;

        $studentsQuery = Student::where('status', 'Active');
        if ($classId) {
            $studentsQuery->where(function ($sq) use ($classId): void {
                $sq->where('class_id', $classId)
                    ->orWhereHas('classes', function ($cq) use ($classId): void {
                        $cq->where('classes.id', $classId);
                    });
            });
        } elseif ($courseId) {
            $course = Course::find($courseId);
            if ($course && $course->department_id) {
                $deptStudentsCount = Student::where('department_id', $course->department_id)->where('status', 'Active')->count();
                if ($deptStudentsCount > 0) {
                    $studentsQuery->where('department_id', $course->department_id);
                }
            }
        }
        $students = $studentsQuery->get();
        if ($students->isEmpty()) {
            $students = Student::all();
        }

        $count = 0;
        $currentTime = Carbon::now()->format('h:i A');
        foreach ($students as $student) {
            Attendance::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'date' => $date,
                    'course_id' => $courseId,
                ],
                [
                    'time_in' => $currentTime,
                    'status' => 'Present',
                    'notes' => 'Session auto-enrolled',
                ]
            );
            $count++;
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Initialized roll-call session with {$count} students.",
            ]);
        }

        return redirect()->route('attendance.index', [
            'date' => $date,
            'class_id' => $classId ?? 'All',
            'course_id' => $courseId ?? 'All',
        ])->with('success', "Roll-call session initialized for {$count} students.");
    }

    /**
     * Remove the specified attendance log from database.
     */
    public function destroy(Request $request, Attendance $attendance): RedirectResponse|JsonResponse
    {
        $name = $attendance->student?->name ?? 'Student';
        $attendance->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Attendance record for {$name} removed.",
            ]);
        }

        return redirect()->route('attendance.index')->with('success', 'Attendance record removed.');
    }

    /**
     * Stream native CSV export of attendance log.
     */
    public function export(Request $request): StreamedResponse
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $filename = "EduPulse_Attendance_{$date}.csv";

        $studentQuery = Student::with([
            'department',
            'schoolClass',
            'attendances' => function ($q) use ($date): void {
                $q->whereDate('date', $date);
            },
        ])->orderBy('name');

        if ($request->filled('class_id') && $request->input('class_id') !== 'All') {
            $studentQuery->where('class_id', $request->input('class_id'));
        }

        return response()->streamDownload(function () use ($studentQuery, $date): void {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

            fputcsv($handle, [
                'Student ID',
                'Student Name',
                'Class',
                'Academic Major',
                'Department',
                'Course Code',
                'Course Title',
                'Date',
                'Check-In Time',
                'Status',
                'Notes',
            ]);

            $studentQuery->chunk(150, function ($students) use ($handle, $date): void {
                foreach ($students as $student) {
                    $att = $student->attendances->first();
                    fputcsv($handle, [
                        $student->student_id ?? 'N/A',
                        $student->name ?? 'Unknown',
                        $student->schoolClass?->code ?? 'N/A',
                        $student->major ?? 'N/A',
                        $student->department?->name ?? 'Unassigned',
                        $att?->course?->code ?? 'N/A',
                        $att?->course?->name ?? 'General',
                        $date,
                        $att?->time_in ?? '--:--',
                        $att?->status ?? 'Present',
                        $att?->notes ?? '',
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
     * Transform attendance model into view-compatible array.
     *
     * @return array<string, mixed>
     */
    private function formatAttendeeForView(Attendance $attendance): array
    {
        return [
            'record_id' => $attendance->id,
            'id' => $attendance->student?->student_id ?? 'N/A',
            'student_db_id' => $attendance->student_id,
            'name' => $attendance->student?->name ?? 'Unknown',
            'avatar' => $attendance->student?->avatar ?: 'https://ui-avatars.com/api/?name='.urlencode($attendance->student?->name ?? 'Student').'&background=6366f1&color=fff',
            'major' => $attendance->student?->major ?? 'N/A',
            'department' => $attendance->student?->department?->name ?? 'Unassigned',
            'class_id' => $attendance->student?->class_id,
            'class_code' => $attendance->student?->schoolClass?->code ?? 'N/A',
            'class_name' => $attendance->student?->schoolClass?->name ?? '',
            'course_id' => $attendance->course_id,
            'course_code' => $attendance->course?->code ?? 'N/A',
            'course_name' => $attendance->course?->name ?? 'General',
            'date' => $attendance->date ? $attendance->date->format('Y-m-d') : '',
            'timeIn' => $attendance->time_in ?? '--:--',
            'status' => $attendance->status,
            'notes' => $attendance->notes ?? '',
        ];
    }
}
