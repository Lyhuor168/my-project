<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // បង្ហាញ Attendance ទាំងអស់
    public function index(Request $request)
    {
        $classes = SchoolClass::all();
        $selectedClass = $request->class_id;
        $selectedDate  = $request->date ?? today()->toDateString();

        $attendances = Attendance::with('student', 'schoolClass')
            ->when($selectedClass, fn($q) => $q->where('class_id', $selectedClass))
            ->where('date', $selectedDate)
            ->get();

        return view('attendances.index', compact('attendances', 'classes', 'selectedClass', 'selectedDate'));
    }

    // Form កត់វត្តមាន
    public function create(Request $request)
    {
        $classes  = SchoolClass::all();
        $selectedClass = $request->class_id;
        $date     = $request->date ?? today()->toDateString();
        $students = $selectedClass
            ? Student::where('class_id', $selectedClass)->get()
            : collect();

        return view('attendances.create', compact('classes', 'selectedClass', 'date', 'students'));
    }

    // Save វត្តមាន
    public function store(Request $request)
    {
        $request->validate([
            'class_id'   => 'required|exists:school_classes,id',
            'date'       => 'required|date',
            'attendance' => 'required|array',
        ]);

        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'class_id'   => $request->class_id,
                    'date'       => $request->date,
                ],
                [
                    'status'      => $status,
                    'note'        => $request->notes[$studentId] ?? null,
                    'recorded_by' => Auth::id(),
                ]
            );
        }

        return redirect()->route('attendances.index')
            ->with('success', 'វត្តមានបានកត់ទុករួចរាល់!');
    }

    // លុប
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendances.index')
            ->with('success', 'បានលុបរួចរាល់!');
    }
}
