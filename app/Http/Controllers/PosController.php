<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 1)->get();
        return view('pos.index', compact('products'));
    }

    public function checkout(Request $request)
    {
        $cart = json_decode($request->cart, true);
        if (!$cart) return back()->with('error', 'Cart is empty!');

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }
        

        $order = Order::create([
            'user_id'        => auth()->id(),
            'total_amount'   => $total,
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
        ]);

        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $id,
                'qty'        => $item['qty'],
                'price'      => $item['price'],
            ]);
            Product::where('id', $id)->decrement('qty', $item['qty']);
        }

        return redirect()->route('pos.invoice', $order->id);
    }

    public function invoice($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('orders.invoice', compact('order'));
    }
}
