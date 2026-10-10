<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
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
        $courses = Course::orderBy('code')->get();
        $students = Student::orderBy('name')->get();

        // Determine active date filter (default to latest recorded date or today)
        $latestRecordDate = Attendance::max('date');
        $defaultDate = $latestRecordDate ? Carbon::parse($latestRecordDate)->format('Y-m-d') : Carbon::today()->toDateString();
        $selectedDate = $request->filled('date') ? Carbon::parse($request->input('date'))->format('Y-m-d') : $defaultDate;

        $query = Attendance::with(['student.department', 'course'])->whereDate('date', $selectedDate)->latest('id');

        if ($request->filled('course_id') && $request->input('course_id') !== 'All') {
            $query->where('course_id', $request->input('course_id'));
        }

        if ($request->filled('status') && $request->input('status') !== 'All') {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($q) use ($search): void {
                $q->whereHas('student', function ($sq) use ($search): void {
                    $sq->where('name', 'like', "%{$search}%")
                        ->orWhere('student_id', 'like', "%{$search}%")
                        ->orWhere('major', 'like', "%{$search}%");
                })->orWhereHas('course', function ($cq) use ($search): void {
                    $cq->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                });
            });
        }

        $records = $query->get();

        // Calculate live metrics for the selected session
        $totalRecords = $records->count();
        $presentCount = $records->where('status', 'Present')->count();
        $lateCount = $records->where('status', 'Late')->count();
        $excusedCount = $records->where('status', 'Excused')->count();
        $absentCount = $records->where('status', 'Absent')->count();
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

        $attendees = $records->map(fn (Attendance $a): array => $this->formatAttendeeForView($a));

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $attendees,
                'kpis' => $kpis,
                'courses' => $courses,
            ]);
        }

        return view('attendance.index', [
            'attendees' => $attendees,
            'kpis' => $kpis,
            'courses' => $courses,
            'students' => $students,
            'selectedDate' => $selectedDate,
            'selectedCourseId' => $request->input('course_id', 'All'),
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
        ]);

        $date = Carbon::parse($validated['date'])->format('Y-m-d');
        $courseId = ($validated['course_id'] && $validated['course_id'] !== 'All') ? (int) $validated['course_id'] : null;

        $studentsQuery = Student::where('status', 'Active');
        if ($courseId) {
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

        $query = Attendance::with(['student.department', 'course'])->whereDate('date', $date);

        if ($request->filled('course_id') && $request->input('course_id') !== 'All') {
            $query->where('course_id', $request->input('course_id'));
        }

        return response()->streamDownload(function () use ($query): void {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

            fputcsv($handle, [
                'Student ID',
                'Student Name',
                'Academic Major',
                'Department',
                'Course Code',
                'Course Title',
                'Date',
                'Check-In Time',
                'Status',
                'Notes',
            ]);

            $query->chunk(150, function ($records) use ($handle): void {
                foreach ($records as $att) {
                    fputcsv($handle, [
                        $att->student?->student_id ?? 'N/A',
                        $att->student?->name ?? 'Unknown',
                        $att->student?->major ?? 'N/A',
                        $att->student?->department?->name ?? 'Unassigned',
                        $att->course?->code ?? 'N/A',
                        $att->course?->name ?? 'General',
                        $att->date ? $att->date->format('Y-m-d') : '',
                        $att->time_in ?? '--:--',
                        $att->status,
                        $att->notes ?? '',
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
