<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = DB::table('books')->latest()->get();
        return view('pages.shop', compact('books'));
    }

    public function add()
    {
        return view('pages.add-book');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:200',
            'author'      => 'required|string|max:100',
            'category'    => 'required|string',
            'language'    => 'required|string',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('books', 'public');
        }

        DB::table('books')->insert(array_merge($validated, [
            'created_at' => now(),
            'updated_at' => now(),
        ]));

        return redirect()->route('books.index')
            ->with('success', 'សៀវភៅ "' . $validated['title'] . '" បានបន្ថែមដោយជោគជ័យ! ✅');
    }

    public function show($id)
    {
        $book = DB::table('books')->where('id', $id)->first();
        abort_if(!$book, 404);
        return view('pages.book-detail', compact('book'));
    }

    public function edit($id)
    {
        $book = DB::table('books')->where('id', $id)->first();
        abort_if(!$book, 404);
        return view('pages.edit-book', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:200',
            'author'      => 'required|string|max:100',
            'category'    => 'required|string',
            'language'    => 'required|string',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('books', 'public');
        }

        DB::table('books')->where('id', $id)->update(array_merge($validated, [
            'updated_at' => now(),
        ]));

        return redirect()->route('books.index')
            ->with('success', 'សៀវភៅបានកែប្រែដោយជោគជ័យ! ✅');
    }

    public function delete($id)
    {
        $book = DB::table('books')->where('id', $id)->first();
        abort_if(!$book, 404);
        DB::table('books')->where('id', $id)->delete();

        return redirect()->route('books.index')
            ->with('success', 'សៀវភៅបានលុបដោយជោគជ័យ! 🗑️');
    }
}