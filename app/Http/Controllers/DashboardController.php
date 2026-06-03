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
        if ($role === 'teacher') return $this->teacherDashboard();
        if ($role === 'student') return $this->studentDashboard();
        return $this->adminDashboard();
    }

    private function adminDashboard()
    {
        $today = today()->toDateString();

        $presentToday = DB::table('attendances')->where('date',$today)->where('status','present')->count();
        $absentToday  = DB::table('attendances')->where('date',$today)->where('status','absent')->count();
        $lateToday    = DB::table('attendances')->where('date',$today)->where('status','late')->count();
        $totalToday   = $presentToday + $absentToday + $lateToday;
        $attendanceRate = $totalToday > 0 ? round($presentToday / $totalToday * 100, 1) : 0;

        // Week trend
        $weekTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $total   = DB::table('attendances')->where('date',$date)->count();
            $present = DB::table('attendances')->where('date',$date)->where('status','present')->count();
            $weekTrend[] = [
                'day'  => now()->subDays($i)->format('D'),
                'rate' => $total > 0 ? round($present/$total*100,1) : 0,
            ];
        }

        // Class summary
        $classes = DB::table('school_classes')->get();
        $classSummary = [];
        foreach ($classes as $class) {
            $total   = DB::table('attendances')->where('date',$today)->where('class_id',$class->id)->count();
            $present = DB::table('attendances')->where('date',$today)->where('class_id',$class->id)->where('status','present')->count();
            $classSummary[] = [
                'name' => $class->name,
                'rate' => $total > 0 ? round($present/$total*100) : 0,
            ];
        }

        // Recent attendance
        $recentAttendance = \App\Models\Attendance::with('student','schoolClass')
            ->where('date',$today)
            ->latest()->limit(5)->get();

        // Alerts
        $alerts = [];
        if ($absentToday > 0)
            $alerts[] = ['type'=>'danger','icon'=>'fas fa-exclamation-circle','msg'=>"$absentToday students are absent today",'sub'=>'Please check and follow up.','time'=>'now'];
        $pendingRequests = \App\Models\AttendanceRequest::where('status','pending')->count();
        if ($pendingRequests > 0)
            $alerts[] = ['type'=>'warning','icon'=>'fas fa-clock','msg'=>"$pendingRequests attendance requests pending",'sub'=>'Review student requests.','time'=>'now'];
        if ($lateToday > 0)
            $alerts[] = ['type'=>'info','icon'=>'fas fa-info-circle','msg'=>"$lateToday students arrived late today",'sub'=>'Please take action.','time'=>'now'];

        $stats = ['user_name' => Auth::user()->name];

        return view('pages.dashboard', compact(
            'stats','presentToday','absentToday','lateToday',
            'totalToday','attendanceRate','weekTrend',
            'classSummary','recentAttendance','alerts'
        ));
    }

    private function teacherDashboard()
    {
        $teacher = DB::table('teachers')->where('email', Auth::user()->email)->first();
        $myClasses    = \App\Models\SchoolClass::all();
        $totalClasses = $myClasses->count();
        $today = today()->toDateString();
        $attendanceToday = \App\Models\Attendance::where('date',$today)
            ->join('students','attendances.student_id','=','students.id')
            ->join('classes','attendances.class_id','=','classes.id')
            ->select('attendances.*','students.name as student_name','classes.name as class_name')
            ->get();
        $attendanceSummary = [
            'present' => \App\Models\Attendance::where('date',$today)->where('status','present')->count(),
            'absent'  => \App\Models\Attendance::where('date',$today)->where('status','absent')->count(),
            'late'    => \App\Models\Attendance::where('date',$today)->where('status','late')->count(),
        ];
        $totalStudents   = DB::table('students')->count();
        $pendingRequests = \App\Models\AttendanceRequest::where('status','pending')->count();
        return view('teacher.dashboard', compact(
            'teacher','myClasses','totalClasses','totalStudents',
            'attendanceToday','attendanceSummary','pendingRequests'
        ));
    }

    private function studentDashboard()
    {
        $student = \App\Models\Student::where('email', Auth::user()->email)->first();
        $attendances = $student
            ? \App\Models\Attendance::where('student_id',$student->id)->latest()->get()
            : collect();
        $summary = [
            'total'   => $attendances->count(),
            'present' => $attendances->where('status','present')->count(),
            'absent'  => $attendances->where('status','absent')->count(),
            'late'    => $attendances->where('status','late')->count(),
            'percent' => $attendances->count() > 0
                ? round($attendances->where('status','present')->count()/$attendances->count()*100,1) : 0,
        ];
        return view('student.dashboard', compact('student','attendances','summary'));
    }
}
