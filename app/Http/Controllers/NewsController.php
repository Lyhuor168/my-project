<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        return view('pages.news');
    }

    public function create()
    {
        return view('pages.add-news');
    }

    public function store(Request $request)
    {
        // save to database
    }

    public function show($id)
    {
        return view('pages.news');
    }

    public function edit($id)
    {
        return view('pages.news');
    }
}