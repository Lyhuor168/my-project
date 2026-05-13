<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index() 
{
    $todaySales = \App\Models\Order::whereDate('created_at', now()->today())->sum('total_amount');
    
    
    $orderCount = \App\Models\Order::whereDate('created_at', now()->today())->count();

    return view('dashboard', compact('todaySales', 'orderCount'));
}
}
