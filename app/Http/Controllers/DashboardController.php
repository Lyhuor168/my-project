<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'students'      => DB::table('students')->count(),
            'teachers'      => DB::table('teachers')->count(),
            'courses'       => DB::table('courses')->count(),
            'users'         => User::count(),
            'male'          => DB::table('students')->where('gender','male')->count(),
            'female'        => DB::table('students')->where('gender','female')->count(),
            'avg_score'     => round(DB::table('students')->avg('score'), 1) ?? 0,
            'top_students'  => DB::table('students')->orderByDesc('score')->limit(5)->get(),
            'recent_users'  => User::latest()->limit(5)->get(),
            'recent_teachers' => DB::table('teachers')->latest()->limit(5)->get(),
            'recent_courses' => DB::table('courses')->latest()->limit(5)->get(),
            'user_role'     => Auth::user()->role,
            'user_name'     => Auth::user()->name,
            'user_email'    => Auth::user()->email,
            'user_id'       => Auth::id(),
            'user_count'    => User::count(),
            'teacher_count' => DB::table('teachers')->count(),
            'course_count'  => DB::table('courses')->count(),   
            'student_count' => DB::table('students')->count(),
            'avg_score'     => round(DB::table('students')->avg('score'), 1) ?? 0,
            'top_students'  => DB::table('students')->orderByDesc('score')->limit(5)->get(),
            'recent_users'  => User::latest()->limit(5)->get(),
            'recent_teachers' => DB::table('teachers')->latest()->limit(5)->get(),
            'recent_courses' => DB::table('courses')->latest()->limit(5)->get(),
        ];

        $recentStudents = \App\Models\Student::with('schoolClass')->latest()->limit(10)->get();
        return view('pages.dashboard', compact('stats', 'recentStudents'));
    }
}