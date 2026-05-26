<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // Student មើល attendance ផ្ទាល់ខ្លួន
    public function studentAttendance()
    {
        $student = auth()->user()->student;

        $attendances = Attendance::where('student_id', $student->id)
            ->latest()
            ->get();

        return view('student.attendance', compact('attendances'));
    }

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

        return view('attendances.index', compact(
            'attendances',
            'classes',
            'selectedClass',
            'selectedDate'
        ));
    }

    // Form កត់វត្តមាន
    public function create(Request $request)
    {
        $classes = SchoolClass::all();

        $selectedClass = $request->class_id;

        $date = $request->date ?? today()->toDateString();

        $students = $selectedClass
            ? Student::where('class_id', $selectedClass)->get()
            : collect();

        return view('attendances.create', compact(
            'classes',
            'selectedClass',
            'date',
            'students'
        ));
    }

    // Save Attendance
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

        return redirect()
            ->route('attendances.index')
            ->with('success', 'វត្តមានបានកត់ទុករួចរាល់!');
    }

    // Update Attendance
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'date'   => 'required|date',
            'status' => 'required|in:present,absent,late,excused',
            'note'   => 'nullable|string|max:255',
        ]);
        $attendance->update([
            'date'   => $request->date,
            'status' => $request->status,
            'note'   => $request->note,
        ]);
        return redirect()
            ->route('attendances.index')
            ->with('success', 'វត្តមានបានកែរួចរាល់!');
    }

    // Report
    public function report(Request $request)
    {
        $attendances = Attendance::with('student', 'schoolClass')
            ->when($request->class_id, fn($q) => $q->where('class_id', $request->class_id))
            ->when($request->month, fn($q) => $q->whereMonth('date', $request->month))
            ->latest()
            ->get();

        $summary = [
            'present' => $attendances->where('status', 'present')->count(),
            'absent'  => $attendances->where('status', 'absent')->count(),
            'late'    => $attendances->where('status', 'late')->count(),
            'excused' => $attendances->where('status', 'excused')->count(),
        ];

        $classes = \App\Models\SchoolClass::all();
        return view('attendances.report', compact('attendances', 'summary', 'classes'));
    }

    // Delete Attendance
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()
            ->route('attendances.index')
            ->with('success', 'បានលុបរួចរាល់!');
    }
}