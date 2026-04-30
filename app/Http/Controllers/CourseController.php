<?php

namespace App\Http\Controllers;   // ← namespace ត្រឹមត្រូវ

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    // បញ្ជីមុខវិជ្ជា
    public function index()
    {
        $courses = DB::table('courses')->latest()->get();
        return view('pages.courses', compact('courses'));
    }

    // Form បន្ថែម
    public function create()
    {
        return view('pages.add-course');
    }

    // រក្សាទុក
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:80',
            'code'         => 'required|string|max:20|unique:courses,code',
            'category'     => 'required|string|max:50',
            'teacher'      => 'required|string|max:100',
            'description'  => 'nullable|string|max:300',
            'level'        => 'nullable|string|max:30',
            'start_date'   => 'required|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
            'duration'     => 'nullable|integer|min:1',
            'max_students' => 'nullable|integer|min:1',
            'time_start'   => 'nullable|string',
            'time_end'     => 'nullable|string',
            'room'         => 'nullable|string|max:50',
            'days'         => 'nullable|array',
            'color'        => 'nullable|string|max:10',
            'icon'         => 'nullable|string|max:10',
        ], [
            'name.required'           => 'សូមបញ្ចូលឈ្មោះមុខវិជ្ជា',
            'code.required'           => 'សូមបញ្ចូលលេខកូដ',
            'code.unique'             => 'លេខកូដនេះមានរួចហើយ',
            'category.required'       => 'សូមជ្រើសប្រភេទ',
            'teacher.required'        => 'សូមជ្រើសគ្រូបង្រៀន',
            'start_date.required'     => 'សូមជ្រើសថ្ងៃចាប់ផ្ដើម',
            'end_date.after_or_equal' => 'ថ្ងៃបញ្ចប់ >= ថ្ងៃចាប់ផ្ដើម',
        ]);

        // days array → string
        $validated['days'] = !empty($validated['days'])
            ? implode(',', $validated['days'])
            : null;

        DB::table('courses')->insert(array_merge($validated, [
            'created_at' => now(),
            'updated_at' => now(),
        ]));

        return redirect()
            ->route('courses.index')
            ->with('success', 'មុខវិជ្ជា "' . $validated['name'] . '" បានបន្ថែមដោយជោគជ័យ! ✅');
    }

    // លម្អិត
    public function show($id)
    {
        $course = DB::table('courses')->where('id', $id)->first();
        abort_if(!$course, 404);
        return view('pages.course-detail', compact('course'));
    }

    // Form កែ
    public function edit($id)
    {
        $course = DB::table('courses')->where('id', $id)->first();
        abort_if(!$course, 404);
        return view('pages.edit-course', compact('course'));
    }

    // រក្សាទុកការកែ
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:80',
            'code'         => 'required|string|max:20|unique:courses,code,' . $id,
            'category'     => 'required|string|max:50',
            'teacher'      => 'required|string|max:100',
            'description'  => 'nullable|string|max:300',
            'level'        => 'nullable|string|max:30',
            'start_date'   => 'required|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
            'duration'     => 'nullable|integer|min:1',
            'max_students' => 'nullable|integer|min:1',
            'time_start'   => 'nullable|string',
            'time_end'     => 'nullable|string',
            'room'         => 'nullable|string|max:50',
            'days'         => 'nullable|array',
            'color'        => 'nullable|string|max:10',
            'icon'         => 'nullable|string|max:10',
        ]);

        $validated['days'] = !empty($validated['days'])
            ? implode(',', $validated['days'])
            : null;

        DB::table('courses')->where('id', $id)->update(array_merge($validated, [
            'updated_at' => now(),
        ]));

        return redirect()
            ->route('courses.index')
            ->with('success', 'មុខវិជ្ជា "' . $validated['name'] . '" បានកែដោយជោគជ័យ! ✅');
    }

    // លុប
    public function destroy($id)
    {
        $course = DB::table('courses')->where('id', $id)->first();
        abort_if(!$course, 404);
        $name = $course->name;
        DB::table('courses')->where('id', $id)->delete();

        return redirect()
            ->route('courses.index')
            ->with('success', 'មុខវិជ្ជា "' . $name . '" បានលុបដោយជោគជ័យ! 🗑️');
    }
}