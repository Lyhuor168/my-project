<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        if ($role === 'teacher') {
            return $this->teacherDashboard();
        }
        if ($role === 'student') {
            return $this->studentDashboard();
        }
        $totalStudents  = DB::table('students')->count();
        $totalTeachers  = DB::table('teachers')->count();
        $totalCourses   = DB::table('courses')->count();
        $totalClasses   = DB::table('classes')->count();
        $totalSchedules = DB::table('schedules')->count();

        $stats = [
            'male'            => DB::table('students')->where('gender','male')->count(),
            'female'          => DB::table('students')->where('gender','female')->count(),
            'avg_score'       => round(DB::table('students')->avg('score') ?? 0, 1),
            'user_role'       => Auth::user()->role,
            'user_name'       => Auth::user()->name,
            'user_email'      => Auth::user()->email,
            'user_id'         => Auth::id(),
            'user_count'      => User::count(),
            'top_students'    => DB::table('students')->orderByDesc('score')->limit(5)->get(),
            'recent_users'    => User::latest()->limit(5)->get(),
            'recent_teachers' => DB::table('teachers')->latest()->limit(5)->get(),
            'recent_courses'  => DB::table('courses')->latest()->limit(5)->get(),
        ];

        $recentStudents = \App\Models\Student::with('schoolClass')->latest()->limit(10)->get();

        return view('pages.dashboard', compact(
            'stats','recentStudents',
            'totalStudents','totalTeachers',
            'totalCourses','totalClasses','totalSchedules'
        ));
    }

    // ═══ TEACHER DASHBOARD ═══
    private function teacherDashboard()
    {
        $teacher = DB::table('teachers')->where('email', Auth::user()->email)->first();

        $myClasses    = \App\Models\SchoolClass::all();
        $totalClasses = $myClasses->count();

        $attendanceToday = \App\Models\Attendance::whereDate('date', today())
            ->with('student', 'schoolClass')
            ->get();

        $attendanceSummary = [
            'present' => \App\Models\Attendance::whereDate('date', today())->where('status', 'present')->count(),
            'absent'  => \App\Models\Attendance::whereDate('date', today())->where('status', 'absent')->count(),
            'late'    => \App\Models\Attendance::whereDate('date', today())->where('status', 'late')->count(),
        ];

        $totalStudents = DB::table('students')->count();

        return view('teacher.dashboard', compact(
            'teacher',
            'myClasses',
            'totalClasses',
            'totalStudents',
            'attendanceToday',
            'attendanceSummary'
        ));
    }

    // ═══ STUDENT DASHBOARD ═══
    private function studentDashboard()
    {
        $student = \App\Models\Student::where('email', Auth::user()->email)->first();

        $attendances = $student
            ? \App\Models\Attendance::where('student_id', $student->id)
                ->latest()
                ->get()
            : collect();

        $summary = [
            'total'   => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'absent'  => $attendances->where('status', 'absent')->count(),
            'late'    => $attendances->where('status', 'late')->count(),
            'percent' => $attendances->count() > 0
                ? round($attendances->where('status', 'present')->count() / $attendances->count() * 100, 1)
                : 0,
        ];

        return view('student.dashboard', compact('student', 'attendances', 'summary'));
    }
}