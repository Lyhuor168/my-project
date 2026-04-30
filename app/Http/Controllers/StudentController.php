<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // ១. បង្ហាញបញ្ជីឈ្មោះសិស្ស
    public function index()
    {
        $students = Student::with('schoolClass')->latest()->get();
        return view('students.index', compact('students'));
    }

    // ២. បើកទំព័របង្កើតសិស្សថ្មី
    public function create()
    {
        $classes = SchoolClass::all();
        return view('students.create', compact('classes'));
    }

    // ៣. រក្សាទុកទិន្នន័យសិស្សថ្មី
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'class_id' => 'required|exists:school_classes,id',
            'email'    => 'required|email|unique:students,email',
            'gender'   => 'required|in:male,female,other',
        ]);

        Student::create([
            'name'          => $request->name,
            'gender'        => $request->gender,
            'class_id'      => $request->class_id,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'address'       => $request->address,
        ]);

        return redirect()->route('students.index')->with('success', 'បន្ថែមសិស្សជោគជ័យ!');
    }

    // ៤. បើកទំព័រកែប្រែព័ត៌មានសិស្ស (Function នេះហើយដែលអ្នកខ្វះពីមុន)
    public function edit(Student $student)
    {
        $classes = SchoolClass::all();
        return view('students.edit', compact('student', 'classes'));
    }

    // ៥. រក្សាទុកការកែប្រែ (Update)
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'class_id' => 'required|exists:school_classes,id',
            'email'    => 'required|email|unique:students,email,' . $student->id,
            'dob'      => 'required|date',
        ]);

            $student->update([
            'name'          => $request->name,
            'class_id'      => $request->class_id,
            'email'         => $request->email,
            'date_of_birth' => $request->dob, // យកតម្លៃពី Form (dob) ទៅដាក់ក្នុង DB (date_of_birth)
            'gender'        => $request->gender,
            'phone'         => $request->phone,
            'address'       => $request->address,
        ]);
        return redirect()->route('students.index')->with('success', 'កែប្រែជោគជ័យ!');
    }

    // ៦. លុបទិន្នន័យសិស្ស
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'លុបជោគជ័យ!');
    }
}