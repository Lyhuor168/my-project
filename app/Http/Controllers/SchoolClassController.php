<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classes::withCount('students')->get();
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'room' => 'nullable'
        ]);

        Classes::create($request->all());

        return redirect()->route('classes.index')->with('success','Class Created');
    }

    public function show($id)
    {
        $class = Classes::with('students')->findOrFail($id);
        return view('classes.show', compact('class'));
    }

    public function edit($id)
    {
        $class = Classes::findOrFail($id);
        return view('classes.edit', compact('class'));
    }

    public function update(Request $request, $id)
    {
        $class = Classes::findOrFail($id);

        $class->update($request->all());

        return redirect()->route('classes.index')->with('success','Updated');
    }

    public function destroy($id)
    {
        Classes::findOrFail($id)->delete();
        return redirect()->back();
    }
}