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
            'user_count'      => User::query()->count(),
            'top_students'    => DB::table('students')->orderByDesc('score')->limit(5)->get(),
            'recent_users'    => User::query()->latest()->limit(5)->get(),
            'recent_teachers' => DB::table('teachers')->latest()->limit(5)->get(),
            'recent_courses'  => DB::table('courses')->latest()->limit(5)->get(),
        ];

        $presentToday = \App\Models\Attendance::whereDate('date', today())->where('status', 'present')->count();
        $absentToday = \App\Models\Attendance::whereDate('date', today())->where('status', 'absent')->count();
        $lateToday = \App\Models\Attendance::whereDate('date', today())->where('status', 'late')->count();
        $totalToday = $presentToday + $absentToday + $lateToday;
        $attendanceRate = $totalToday > 0 ? round($presentToday / $totalToday * 100) : 0;

        $classSummary = \App\Models\SchoolClass::withCount(['students as present' => function($q) {
                $q->join('attendances', 'students.id', '=', 'attendances.student_id')
                    ->where('attendances.date', today())
                    ->where('attendances.status', 'present');
            }])
            ->get()
            ->map(function($c) use ($totalToday) {
                $rate = $totalToday > 0 ? round($c->present / $totalToday * 100) : 0;
                return ['name' => $c->name, 'rate' => $rate];
            })->toArray();

        $recentAttendance = \App\Models\Attendance::with('student', 'schoolClass')
            ->whereDate('date', today())->latest()->limit(10)->get();

        $weekTrend = collect(range(0, 6))->map(function($i) {
            $date = today()->subDays(6 - $i);
            $total = \App\Models\Attendance::whereDate('date', $date)->count();
            $present = \App\Models\Attendance::whereDate('date', $date)->where('status', 'present')->count();
            return ['day' => $date->format('D'), 'rate' => $total > 0 ? round($present / $total * 100) : 0];
        });

        $recentStudents = \App\Models\Student::with('schoolClass')->latest()->limit(10)->get();

        $alerts = collect();

        return view('pages.dashboard', compact(
            'stats','recentStudents',
            'totalStudents','totalTeachers',
            'totalCourses','totalClasses','totalSchedules',
            'presentToday','absentToday','lateToday','totalToday','attendanceRate',
            'classSummary','recentAttendance','weekTrend','alerts'
        ));
    }

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