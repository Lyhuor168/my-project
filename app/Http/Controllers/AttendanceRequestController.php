<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRequest;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceRequestController extends Controller
{
    public function create()
    {
        $user    = Auth::user();
        $student = Student::where('email', $user->email)->first();
        $classes = SchoolClass::all();
        return view('student.requests.create', compact('student', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'date'     => 'required|date|before_or_equal:today',
            'reason'   => 'required|string|max:500',
        ]);
        $user    = Auth::user();
        $student = Student::where('email', $user->email)->first();
        if (!$student) {
            return redirect()->back()->with('error', 'គ្មាន Student profile!');
        }
        AttendanceRequest::create([
            'student_id' => $student->id,
            'class_id'   => $request->class_id,
            'date'       => $request->date,
            'reason'     => $request->reason,
            'status'     => 'pending',
        ]);
        return redirect()->route('attendance-requests.my')
            ->with('success', '✅ Request submitted!');
    }

    public function myRequests()
    {
        $user    = Auth::user();
        $student = Student::where('email', $user->email)->first();
        $requests = $student
            ? AttendanceRequest::with('schoolClass', 'reviewer')
                ->where('student_id', $student->id)
                ->orderByDesc('created_at')->get()
            : collect();
        return view('student.requests.index', compact('requests', 'student'));
    }

    public function index()
    {
        $role = Auth::user()->role ?? 'student';
        if ($role === 'student') {
            return redirect()->route('attendance-requests.my');
        }
        $requests = AttendanceRequest::with('student', 'schoolClass', 'reviewer')
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->orderByDesc('created_at')->get();
        return view('student.requests.index', compact('requests', 'role'));
    }

    public function review(Request $request, AttendanceRequest $attendanceRequest)
    {
        $role = Auth::user()->role ?? 'student';
        if ($role === 'student') {
            return redirect()->back()->with('error', 'Permission denied!');
        }
        $request->validate([
            'action'      => 'required|in:approved,rejected',
            'review_note' => 'nullable|string|max:255',
        ]);
        $attendanceRequest->update([
            'status'      => $request->action,
            'reviewed_by' => Auth::id(),
            'review_note' => $request->review_note,
            'reviewed_at' => now(),
        ]);
        if ($request->action === 'approved') {
            Attendance::updateOrCreate(
                ['student_id'=>$attendanceRequest->student_id,'class_id'=>$attendanceRequest->class_id,'date'=>$attendanceRequest->date],
                ['status'=>'present','note'=>'Approved: '.$attendanceRequest->reason,'recorded_by'=>Auth::id()]
            );
        }
        $msg = $request->action === 'approved' ? '✅ Approved!' : '❌ Rejected.';
        return redirect()->route('attendance-requests.index')->with('success', $msg);
    }
}
