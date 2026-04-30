<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function index()
    {
        $slides = Slide::orderBy('order')->get();
        return view('slides.index', compact('slides'));
    }

    public function create()
    {
        return view('slides.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'nullable|string|max:100',
            'subtitle' => 'nullable|string|max:200',
            'image'    => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'order'    => 'nullable|integer',
        ]);

        $path = $request->file('image')->store('slides', 'public');

        Slide::create([
            'title'      => $request->title,
            'subtitle'   => $request->subtitle,
            'image_path' => $path,
            'order'      => $request->order ?? 0,
            'is_active'  => $request->has('is_active'),
        ]);

        return redirect()->route('slides.index')
            ->with('success', 'បានបន្ថែម Slide ថ្មីរួចរាល់!');
    }

    public function edit(Slide $slide)
    {
        return view('slides.edit', compact('slide'));
    }

    public function update(Request $request, Slide $slide)
    {
        $request->validate([
            'title'    => 'nullable|string|max:100',
            'subtitle' => 'nullable|string|max:200',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'order'    => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($slide->image_path);
            $path = $request->file('image')->store('slides', 'public');
            $slide->image_path = $path;
        }

        $slide->update([
            'title'     => $request->title,
            'subtitle'  => $request->subtitle,
            'image_path'=> $slide->image_path,
            'order'     => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('slides.index')
            ->with('success', 'បានកែ Slide រួចរាល់!');
    }

    public function destroy(Slide $slide)
    {
        Storage::disk('public')->delete($slide->image_path);
        $slide->delete();
        return redirect()->route('slides.index')
            ->with('success', 'បានលុប Slide រួចរាល់!');
    }
}
