<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        // ប្តូរមកប្រើ schedules.index ឱ្យត្រូវតាម Folder view ថ្មី
        return view('schedules.index');
    }
}
