<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index() 
{
    // គណនាលុយសរុបដែលលក់បាននៅថ្ងៃនេះ
    $todaySales = \App\Models\Order::whereDate('created_at', now()->today())->sum('total_amount');
    
    // រាប់ចំនួនវិក្កយបត្រដែលលក់បានថ្ងៃនេះ
    $orderCount = \App\Models\Order::whereDate('created_at', now()->today())->count();

    return view('dashboard', compact('todaySales', 'orderCount'));
}
}
