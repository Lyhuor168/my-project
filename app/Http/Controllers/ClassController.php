<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\SchoolClass;

class ClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::withCount('students')->get();
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:school_classes,code',
            'max_students' => 'required|integer|min:1',
        ]);
        SchoolClass::create($request->all());
        return redirect()->route('classes.index')->with('success', 'បង្កើត Class បានជោគជ័យ!');
    }

    public function show($id)
    {
        $class = SchoolClass::withCount('students')->findOrFail($id);
        return view('classes.show', compact('class'));
    }

    public function edit($id)
    {
        $class = SchoolClass::findOrFail($id);
        return view('classes.edit', compact('class'));
    }

    public function update(Request $request, $id)
    {
        $class = SchoolClass::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:school_classes,code,'.$id,
            'max_students' => 'required|integer|min:1',
        ]);
        $class->update($request->all());
        return redirect()->route('classes.index')->with('success', 'កែ Class បានជោគជ័យ!');
    }

    public function destroy($id)
    {
        SchoolClass::findOrFail($id)->delete();
        return redirect()->route('classes.index')->with('success', 'លុប Class បានជោគជ័យ!');
    }
}
