<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    // 📊 Dashboard + 🔍 Search + Filter
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'today');
        $search = $request->get('search', '');

        $query = Order::with('user');

        // Filter by date
        switch ($filter) {
            case 'yesterday':
                $query->whereDate('created_at', Carbon::yesterday());
                break;
            case 'week':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('created_at', Carbon::now()->month);
                break;
            case 'all':
                break;
            default:
                $query->whereDate('created_at', Carbon::today());
        }

        // 🔍 Search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $orders = $query->latest()->get();

        // 📊 Summary
        $summary = [
            'total_orders'  => $orders->count(),
            'total_revenue' => $orders->sum('total_price'),
            'pending'       => $orders->where('status', 'pending')->count(),
            'completed'     => $orders->where('status', 'completed')->count(),
        ];

        // Chart data (7 ថ្ងៃចុងក្រោយ)
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartData[] = [
                'date'    => $date->format('d/m'),
                'revenue' => Order::whereDate('created_at', $date)->sum('total_price'),
                'count'   => Order::whereDate('created_at', $date)->count(),
            ];
        }

        $todaySales = Order::whereDate('created_at', today())->sum('total_price');
        $todayCount = Order::whereDate('created_at', today())->count();
        $totalSales = Order::sum('total_price');

        return view('pages.orders', compact(
            'orders', 'summary', 'filter', 'search',
            'chartData', 'todaySales', 'todayCount', 'totalSales'
        ));
    }

    // Form order
    public function create($book_id)
    {
        $book = DB::table('books')->where('id', $book_id)->first();
        abort_if(!$book, 404);
        return view('pages.order-create', compact('book'));
    }

    // Save order
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'  => 'required|string|max:100',
            'phone'          => 'required|string|max:20',
            'email'          => 'nullable|email',
            'quantity'       => 'required|numeric|min:1',
            'payment_method' => 'required|string',
            'total_price'    => 'required|numeric',
            'note'           => 'nullable|string',
        ]);
        $validated['user_id']    = Auth::id();
        $validated['book_id']    = null;
        $validated['product_id'] = null;
        $validated['status']     = 'completed';

        $order = Order::create($validated);
        return redirect()->route('orders.invoice', $order->id)
            ->with('success', 'ការទិញបានជោគជ័យ! ✅');
    }

    // Invoice
    public function invoice($id)
    {
        $order = Order::with('user')->findOrFail($id);
        return view('pages.invoice', compact('order'));
    }

    // 📄 Export PDF
    public function exportPdf($id)
    {
        $order = Order::with('user')->findOrFail($id);
        $pdf = Pdf::loadView('orders.pdf-invoice', compact('order'));
        return $pdf->download('invoice-' . $order->id . '.pdf');
    }

    // Update Status
    public function updateStatus(Request $request, $id)
    {
        Order::findOrFail($id)->update(['status' => $request->status]);
        return back()->with('success', 'បានកែប្រែស្ថានភាព!');
    }

    // លុប order
    public function delete($id)
    {
        Order::findOrFail($id)->delete();
        return redirect()->route('orders.index')
            ->with('success', 'Order បានលុប! 🗑️');
    }
}