<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Course;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $books   = Book::all();
        $courses = Course::all();
        return view('pages.shop', compact('books', 'courses'));
    }
}
