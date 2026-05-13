<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date ?? now()->format('Y-m-d');

        $orders = Order::with(['user', 'items.product'])
            ->whereDate('created_at', $date)
            ->latest()
            ->get();

        $total = $orders->sum('total_amount');
        $count = $orders->count();

        return view('orders.index', compact('orders', 'total', 'count', 'date'));
    }
}
