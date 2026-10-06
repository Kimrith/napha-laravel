<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Department;
use App\Models\Grade;
use App\Models\Setting;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User
        User::firstOrCreate(
            ['email' => 'sarah.vance@edupulse.edu'],
            [
                'name' => 'Dr. Sarah Vance',
                'password' => bcrypt('password'),
            ]
        );

        // 2. Seed Academic Departments
        $departmentsData = [
            ['name' => 'School of Computing & Informatics', 'code' => 'SCI', 'head' => 'Prof. Alan Turing', 'students_count' => 894, 'faculty_count' => 34, 'programs_count' => 6, 'budget' => '$2.4M', 'status' => 'Active'],
            ['name' => 'School of Business & Global Finance', 'code' => 'SBGF', 'head' => 'Prof. Paul Krugman', 'students_count' => 642, 'faculty_count' => 26, 'programs_count' => 5, 'budget' => '$1.8M', 'status' => 'Active'],
            ['name' => 'Faculty of Life Sciences & Biotech', 'code' => 'FLSB', 'head' => 'Dr. Jennifer Doudna', 'students_count' => 520, 'faculty_count' => 22, 'programs_count' => 4, 'budget' => '$3.1M', 'status' => 'Active'],
            ['name' => 'Design, Arts & Human Experience', 'code' => 'DAHE', 'head' => 'Prof. Jony Ive', 'students_count' => 410, 'faculty_count' => 18, 'programs_count' => 4, 'budget' => '$1.2M', 'status' => 'Active'],
            ['name' => 'Mechatronics & Robotics Engineering', 'code' => 'MRE', 'head' => 'Dr. Rodney Brooks', 'students_count' => 379, 'faculty_count' => 15, 'programs_count' => 3, 'budget' => '$2.8M', 'status' => 'Active'],
        ];

        $deptMap = [];
        foreach ($departmentsData as $d) {
            $dept = Department::updateOrCreate(['code' => $d['code']], $d);
            $deptMap[$d['code']] = $dept->id;
        }

        // 3. Seed Courses
        $coursesData = [
            ['code' => 'CS-101', 'name' => 'Object-Oriented Programming in C++ & Rust', 'department_id' => $deptMap['SCI'], 'instructor' => 'Prof. Alan Turing', 'credits' => 4, 'enrolled' => 88, 'capacity' => 90, 'days' => 'Mon, Wed 09:00 - 11:00 AM', 'room' => 'Hall Alpha-2', 'status' => 'Active'],
            ['code' => 'AI-402', 'name' => 'Deep Learning & Neural Architectures', 'department_id' => $deptMap['SCI'], 'instructor' => 'Dr. Fei-Fei Li', 'credits' => 4, 'enrolled' => 64, 'capacity' => 65, 'days' => 'Tue, Thu 01:30 - 03:30 PM', 'room' => 'Lab Turing-1', 'status' => 'Active'],
            ['code' => 'DES-204', 'name' => 'Human-Centered UI/UX Systems', 'department_id' => $deptMap['DAHE'], 'instructor' => 'Prof. Jony Ive', 'credits' => 3, 'enrolled' => 52, 'capacity' => 60, 'days' => 'Wed, Fri 10:00 - 12:00 PM', 'room' => 'Studio Beta', 'status' => 'Active'],
            ['code' => 'ROB-310', 'name' => 'Autonomous Robotics & Kinematics', 'department_id' => $deptMap['MRE'], 'instructor' => 'Dr. Rodney Brooks', 'credits' => 4, 'enrolled' => 45, 'capacity' => 50, 'days' => 'Mon, Thu 02:00 - 04:00 PM', 'room' => 'RoboLab 4', 'status' => 'Active'],
            ['code' => 'BIO-215', 'name' => 'Genomic Sequencing & CRISPR Protocols', 'department_id' => $deptMap['FLSB'], 'instructor' => 'Dr. Jennifer Doudna', 'credits' => 4, 'enrolled' => 72, 'capacity' => 75, 'days' => 'Tue, Fri 09:00 - 11:00 AM', 'room' => 'BioLab 3', 'status' => 'Active'],
            ['code' => 'FIN-350', 'name' => 'Quantitative Global Financial Markets', 'department_id' => $deptMap['SBGF'], 'instructor' => 'Prof. Paul Krugman', 'credits' => 3, 'enrolled' => 80, 'capacity' => 80, 'days' => 'Mon, Wed 01:00 - 02:30 PM', 'room' => 'Hall Gamma-1', 'status' => 'Full'],
            ['code' => 'SEC-401', 'name' => 'Applied Cryptography & Zero-Knowledge Proofs', 'department_id' => $deptMap['SCI'], 'instructor' => 'Dr. Whitfield Diffie', 'credits' => 4, 'enrolled' => 58, 'capacity' => 60, 'days' => 'Tue, Thu 11:00 - 01:00 PM', 'room' => 'SecVault Lab', 'status' => 'Active'],
        ];

        $courseMap = [];
        foreach ($coursesData as $c) {
            $course = Course::updateOrCreate(['code' => $c['code']], $c);
            $courseMap[$c['code']] = $course->id;
        }

        // 4. Seed Students
        $studentsData = [
            ['student_id' => 'STU-2026-001', 'name' => 'Alexander Wright', 'gender' => 'Male', 'pronouns' => 'He/Him', 'dob' => 'Sep 12, 2004', 'age' => 22, 'email' => 'alexander.wright@edupulse.edu', 'phone' => '+1 (555) 234-5678', 'department_id' => $deptMap['SCI'], 'major' => 'Computer Science', 'degree' => 'B.Sc. Software Engineering', 'gpa' => 3.92, 'credits' => 84, 'advisor' => 'Prof. Alan Turing', 'status' => 'Active', 'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=250&auto=format&fit=crop'],
            ['student_id' => 'STU-2026-002', 'name' => 'Amara Okafor', 'gender' => 'Female', 'pronouns' => 'She/Her', 'dob' => 'Nov 28, 2003', 'age' => 23, 'email' => 'amara.okafor@edupulse.edu', 'phone' => '+1 (555) 876-5432', 'department_id' => $deptMap['SCI'], 'major' => 'Data Science & AI', 'degree' => 'M.Sc. Artificial Intelligence', 'gpa' => 3.98, 'credits' => 92, 'advisor' => 'Dr. Fei-Fei Li', 'status' => 'Active', 'avatar' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?q=80&w=250&auto=format&fit=crop'],
            ['student_id' => 'STU-2026-003', 'name' => 'Clara Lindqvist', 'gender' => 'Female', 'pronouns' => 'She/Her', 'dob' => 'Jan 15, 2005', 'age' => 21, 'email' => 'clara.lindqvist@edupulse.edu', 'phone' => '+1 (555) 345-6789', 'department_id' => $deptMap['DAHE'], 'major' => 'Digital Design', 'degree' => 'B.A. UI/UX Interaction Design', 'gpa' => 3.85, 'credits' => 64, 'advisor' => 'Prof. Jony Ive', 'status' => 'Active', 'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=250&auto=format&fit=crop'],
            ['student_id' => 'STU-2026-004', 'name' => 'Marcus Chen', 'gender' => 'Male', 'pronouns' => 'He/Him', 'dob' => 'Mar 04, 2004', 'age' => 22, 'email' => 'marcus.chen@edupulse.edu', 'phone' => '+1 (555) 456-7890', 'department_id' => $deptMap['MRE'], 'major' => 'Robotics & Automation', 'degree' => 'B.Sc. Mechatronics Engineering', 'gpa' => 3.71, 'credits' => 78, 'advisor' => 'Dr. Rodney Brooks', 'status' => 'Active', 'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=250&auto=format&fit=crop'],
            ['student_id' => 'STU-2026-005', 'name' => 'Sophia Martinez', 'gender' => 'Female', 'pronouns' => 'She/Her', 'dob' => 'Jul 22, 2005', 'age' => 21, 'email' => 'sophia.martinez@edupulse.edu', 'phone' => '+1 (555) 567-8901', 'department_id' => $deptMap['FLSB'], 'major' => 'Biotechnology', 'degree' => 'B.Sc. Molecular Biology & Genetics', 'gpa' => 3.95, 'credits' => 88, 'advisor' => 'Dr. Jennifer Doudna', 'status' => 'Active', 'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?q=80&w=250&auto=format&fit=crop'],
            ['student_id' => 'STU-2026-006', 'name' => 'Liam Davies', 'gender' => 'Male', 'pronouns' => 'He/Him', 'dob' => 'Oct 30, 2003', 'age' => 23, 'email' => 'liam.davies@edupulse.edu', 'phone' => '+1 (555) 678-9012', 'department_id' => $deptMap['SBGF'], 'major' => 'International Finance', 'degree' => 'B.Sc. Financial Economics', 'gpa' => 3.68, 'credits' => 70, 'advisor' => 'Prof. Paul Krugman', 'status' => 'Active', 'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=250&auto=format&fit=crop'],
            ['student_id' => 'STU-2026-007', 'name' => 'Fatima Al-Zahra', 'gender' => 'Female', 'pronouns' => 'She/Her', 'dob' => 'Dec 05, 2004', 'age' => 22, 'email' => 'fatima.alzahra@edupulse.edu', 'phone' => '+1 (555) 789-0123', 'department_id' => $deptMap['SCI'], 'major' => 'Cybersecurity', 'degree' => 'B.Sc. Information Assurance', 'gpa' => 4.00, 'credits' => 96, 'advisor' => 'Dr. Whitfield Diffie', 'status' => 'Active', 'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=250&auto=format&fit=crop'],
            ['student_id' => 'STU-2026-008', 'name' => 'Ethan Taylor', 'gender' => 'Male', 'pronouns' => 'He/Him', 'dob' => 'Apr 18, 2004', 'age' => 22, 'email' => 'ethan.taylor@edupulse.edu', 'phone' => '+1 (555) 321-7654', 'department_id' => $deptMap['DAHE'], 'major' => 'Media Communications', 'degree' => 'B.A. Digital Journalism & Media', 'gpa' => 3.62, 'credits' => 52, 'advisor' => 'Prof. Marshall McLuhan', 'status' => 'Inactive', 'avatar' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?q=80&w=250&auto=format&fit=crop'],
        ];

        $studentMap = [];
        foreach ($studentsData as $s) {
            $student = Student::updateOrCreate(['student_id' => $s['student_id']], $s);
            $studentMap[$s['student_id']] = $student->id;
        }

        // 5. Seed Attendance Logs
        $attendancesData = [
            ['student_id' => $studentMap['STU-2026-001'], 'course_id' => $courseMap['CS-101'], 'date' => '2026-10-06', 'time_in' => '08:54 AM', 'status' => 'Present'],
            ['student_id' => $studentMap['STU-2026-002'], 'course_id' => $courseMap['CS-101'], 'date' => '2026-10-06', 'time_in' => '08:58 AM', 'status' => 'Present'],
            ['student_id' => $studentMap['STU-2026-003'], 'course_id' => $courseMap['CS-101'], 'date' => '2026-10-06', 'time_in' => '09:05 AM', 'status' => 'Late'],
            ['student_id' => $studentMap['STU-2026-004'], 'course_id' => $courseMap['CS-101'], 'date' => '2026-10-06', 'time_in' => null, 'status' => 'Excused'],
            ['student_id' => $studentMap['STU-2026-005'], 'course_id' => $courseMap['CS-101'], 'date' => '2026-10-06', 'time_in' => '08:50 AM', 'status' => 'Present'],
            ['student_id' => $studentMap['STU-2026-006'], 'course_id' => $courseMap['CS-101'], 'date' => '2026-10-06', 'time_in' => '08:59 AM', 'status' => 'Present'],
            ['student_id' => $studentMap['STU-2026-007'], 'course_id' => $courseMap['CS-101'], 'date' => '2026-10-06', 'time_in' => '08:48 AM', 'status' => 'Present'],
            ['student_id' => $studentMap['STU-2026-008'], 'course_id' => $courseMap['CS-101'], 'date' => '2026-10-06', 'time_in' => null, 'status' => 'Absent'],
        ];

        foreach ($attendancesData as $a) {
            Attendance::updateOrCreate(
                ['student_id' => $a['student_id'], 'date' => $a['date']],
                $a
            );
        }

        // 6. Seed Academic Grades & Transcripts
        $gradesData = [
            ['student_id' => $studentMap['STU-2026-001'], 'course_id' => $courseMap['CS-101'], 'course_name' => 'CS-101 Programming', 'mid_score' => 94, 'final_score' => 96, 'grade' => 'A+', 'gpa' => 4.00, 'standing' => "Dean's Honors"],
            ['student_id' => $studentMap['STU-2026-002'], 'course_id' => $courseMap['AI-402'], 'course_name' => 'AI-402 Deep Learning', 'mid_score' => 98, 'final_score' => 97, 'grade' => 'A+', 'gpa' => 4.00, 'standing' => "Dean's Honors"],
            ['student_id' => $studentMap['STU-2026-003'], 'course_id' => $courseMap['DES-204'], 'course_name' => 'DES-204 UX Systems', 'mid_score' => 88, 'final_score' => 89, 'grade' => 'A-', 'gpa' => 3.70, 'standing' => 'Good Standing'],
            ['student_id' => $studentMap['STU-2026-004'], 'course_id' => $courseMap['ROB-310'], 'course_name' => 'ROB-310 Kinematics', 'mid_score' => 78, 'final_score' => 82, 'grade' => 'B', 'gpa' => 3.00, 'standing' => 'Good Standing'],
            ['student_id' => $studentMap['STU-2026-005'], 'course_id' => $courseMap['BIO-215'], 'course_name' => 'BIO-215 CRISPR Protocols', 'mid_score' => 92, 'final_score' => 94, 'grade' => 'A', 'gpa' => 3.90, 'standing' => "Dean's Honors"],
            ['student_id' => $studentMap['STU-2026-006'], 'course_id' => $courseMap['FIN-350'], 'course_name' => 'FIN-350 Global Finance', 'mid_score' => 84, 'final_score' => 86, 'grade' => 'B+', 'gpa' => 3.30, 'standing' => 'Good Standing'],
            ['student_id' => $studentMap['STU-2026-007'], 'course_id' => $courseMap['SEC-401'], 'course_name' => 'SEC-401 Cryptography', 'mid_score' => 100, 'final_score' => 99, 'grade' => 'A+', 'gpa' => 4.00, 'standing' => "Dean's Honors"],
            ['student_id' => $studentMap['STU-2026-008'], 'course_id' => null, 'course_name' => 'MED-110 Media Ethics', 'mid_score' => 75, 'final_score' => 79, 'grade' => 'C+', 'gpa' => 2.70, 'standing' => 'Academic Review'],
        ];

        foreach ($gradesData as $g) {
            Grade::updateOrCreate(
                ['student_id' => $g['student_id'], 'course_name' => $g['course_name']],
                $g
            );
        }

        // 7. Seed Settings & Term Configurations
        Setting::set('term_name', 'Fall Semester 2026', 'academic');
        Setting::set('term_week', 'Week 8', 'academic');
        Setting::set('start_date', '2026-08-25', 'academic');
        Setting::set('end_date', '2026-12-18', 'academic');
        Setting::set('grading_deadline', '2026-12-24', 'academic');
        Setting::set('two_factor', 'true', 'security');
        Setting::set('audit_logs', 'true', 'security');
        Setting::set('email_alerts', 'true', 'security');
    }
}
