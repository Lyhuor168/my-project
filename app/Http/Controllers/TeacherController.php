<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    // GET /teachers — បញ្ជីគ្រូ
    public function index()
    {
        $teachers = DB::table('teachers')->latest()->get();
        return view('pages.teachers', compact('teachers'));
    }
    
    // GET /teachers/add — Form បន្ថែម
    public function add()
    {
        return view('pages.add-teacher');
    }

    // POST /teachers/store — រក្សាទុកគ្រូថ្មី
    public function store(Request $request)
{
    $validated = $request->validate([
        'name'          => 'required|string|max:100',
        'email'         => 'required|email|unique:teachers,email',
        'phone'         => 'required|string|max:20',
        'subject'       => 'required|string|max:100',
        'age'           => 'required|numeric|min:18|max:100',
        'gender'        => 'required|string',
        'date_of_birth' => 'required|date',
        'address'       => 'nullable|string|max:255',
    ]);

    DB::table('teachers')->insert(array_merge($validated, [
        'created_at' => now(),
        'updated_at' => now(),
    ]));

    return redirect()
        ->route('teachers.index')
        ->with('success', 'គ្រូ "' . $validated['name'] . '" ត្រូវបានបន្ថែមដោយជោគជ័យ! ✅');
}

    // GET /teachers/{id} — មើលលម្អិត
    public function show($id)
    {
        $teacher = DB::table('teachers')->where('id', $id)->first();
        abort_if(!$teacher, 404);
        return view('pages.teacher-detail', compact('teacher'));
    }

    // GET /teachers/edit/{id} — បង្ហាញ Form កែប្រែ
// GET /teachers/edit/{id} — បង្ហាញ Form កែប្រែ
public function edit($id) // Change 'update' to 'edit' here
{
    $teacher = DB::table('teachers')->where('id', $id)->first();
    abort_if(!$teacher, 404);

    return view('pages.edit-teachers', compact('teacher'));
}

    // PUT /teachers/update/{id} — រក្សាទុកទិន្នន័យដែលបានកែ
  // app/Http/Controllers/TeacherController.php

public function update(Request $request, $id)
{
        // ១. Validation (ដក required ចេញពី age)
    $validated = $request->validate([
        'name'    => 'required|string|max:100',
        'email'   => 'required|email|unique:teachers,email',
        'phone'   => 'required|string|max:20',
        'subject' => 'required|string|max:100',
        'address' => 'nullable|string|max:255',
    ]);
    // ២. ប្រើ Arr::except ដើម្បីដក 'age' ចេញដាច់ខាត មុននឹង Update ចូល DB
    // នេះជាចំណុចសំខាន់បំផុតដើម្បីបាត់ Error 500
    $dataToUpdate = \Illuminate\Support\Arr::except($validated, ['age']);

    // ៣. Update ចូល Database (ប្រើ $dataToUpdate ជំនួស $validated)
    DB::table('teachers')->where('id', $id)->update(array_merge($dataToUpdate, [
        'updated_at' => now(),
    ]));

    return redirect()->route('teachers.index')->with('success', 'កែប្រែទិន្នន័យគ្រូជោគជ័យ! ✅');
}
    // GET /teachers/delete/{id} — លុបទិន្នន័យ
    public function delete($id)
    {
        $teacher = DB::table('teachers')->where('id', $id)->first();
        abort_if(!$teacher, 404);
        
        $name = $teacher->name;
        DB::table('teachers')->where('id', $id)->delete();

        return redirect()
            ->route('teachers.index')
            ->with('success', 'គ្រូ "' . $name . '" ត្រូវបានលុបដោយជោគជ័យ! 🗑️');
    }
    
}