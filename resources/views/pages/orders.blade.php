@extends('layouts.master')
@section('title', 'បញ្ជី Orders')
@section('content')
<div style="max-width:1100px;margin:0 auto;padding:2rem 1.5rem;font-family:'Kantumruy Pro',sans-serif">

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;flex-wrap:wrap;gap:1rem">
        <div style="display:flex;align-items:center;gap:1rem">
            <div style="width:52px;height:52px;border-radius:16px;background:linear-gradient(135deg,#1a237e,#3949ab);color:#fff;display:flex;align-items:center;justify-content:center;font-size:1.4rem">🧾</div>
            <div>
                <h1 style="font-size:1.5rem;font-weight:700;color:#1a237e;margin:0">បញ្ជី Orders</h1>
                <p style="font-size:0.8rem;color:#6b7280;margin:0">គ្រប់គ្រងការទិញទាំងអស់</p>
            </div>
        </div>
    </div>

    {{-- Success --}}
    @if(session('success'))
    <div style="padding:1rem;background:#f0fdf4;border-left:4px solid #22c55e;border-radius:8px;color:#166534;margin-bottom:1.5rem;font-weight:600">
        ✅ {{ session('success') }}
    </div>
    @endif

    {{-- Stats Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1.25rem;margin-bottom:2rem">
        <div style="background:#fff;border-radius:16px;padding:1.5rem;border:1px solid rgba(26,35,126,0.08);box-shadow:0 2px 12px rgba(26,35,126,0.06)">
            <div style="font-size:0.75rem;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.5rem">💰 លក់បានថ្ងៃនេះ</div>
            <div style="font-size:2rem;font-weight:800;color:#2e7d32">${{ number_format($todaySales, 2) }}</div>
            <div style="font-size:0.8rem;color:#6b7280;margin-top:0.25rem">{{ $todayCount }} orders</div>
        </div>
        <div style="background:#fff;border-radius:16px;padding:1.5rem;border:1px solid rgba(26,35,126,0.08);box-shadow:0 2px 12px rgba(26,35,126,0.06)">
            <div style="font-size:0.75rem;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.5rem">📦 Orders សរុប</div>
            <div style="font-size:2rem;font-weight:800;color:#1a237e">{{ $orders->count() }}</div>
            <div style="font-size:0.8rem;color:#6b7280;margin-top:0.25rem">គ្រប់ Orders</div>
        </div>
        <div style="background:#fff;border-radius:16px;padding:1.5rem;border:1px solid rgba(26,35,126,0.08);box-shadow:0 2px 12px rgba(26,35,126,0.06)">
            <div style="font-size:0.75rem;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.5rem">💵 Sales សរុប</div>
            <div style="font-size:2rem;font-weight:800;color:#c2410c">${{ number_format($totalSales, 2) }}</div>
            <div style="font-size:0.8rem;color:#6b7280;margin-top:0.25rem">រហូតដល់ឥឡូវ</div>
        </div>
    </div>

    {{-- Table --}}
    <div style="background:#fff;border-radius:18px;border:1px solid rgba(26,35,126,0.07);box-shadow:0 4px 24px rgba(26,35,126,0.06);overflow:hidden">
        <div style="padding:1.25rem 1.5rem;border-bottom:1px solid rgba(26,35,126,0.07);background:#fafbff">
            <h5 style="margin:0;font-size:0.95rem;font-weight:700;color:#1a237e">🧾 តារាង Orders</h5>
        </div>
        <div style="overflow-x:auto">
            <table style="width:100%;border-collapse:collapse;font-size:0.875rem">
                <thead>
                    <tr style="background:#f8faff">
                        <th style="padding:0.875rem 1rem;text-align:left;color:#374151;font-weight:600;border-bottom:1px solid rgba(26,35,126,0.07)">#</th>
                        <th style="padding:0.875rem 1rem;text-align:left;color:#374151;font-weight:600;border-bottom:1px solid rgba(26,35,126,0.07)">អតិថិជន</th>
                        <th style="padding:0.875rem 1rem;text-align:left;color:#374151;font-weight:600;border-bottom:1px solid rgba(26,35,126,0.07)">ទូរស័ព្ទ</th>
                        <th style="padding:0.875rem 1rem;text-align:left;color:#374151;font-weight:600;border-bottom:1px solid rgba(26,35,126,0.07)">ទំនិញ</th>
                        <th style="padding:0.875rem 1rem;text-align:left;color:#374151;font-weight:600;border-bottom:1px solid rgba(26,35,126,0.07)">ចំនួន</th>
                        <th style="padding:0.875rem 1rem;text-align:left;color:#374151;font-weight:600;border-bottom:1px solid rgba(26,35,126,0.07)">សរុប</th>
                        <th style="padding:0.875rem 1rem;text-align:left;color:#374151;font-weight:600;border-bottom:1px solid rgba(26,35,126,0.07)">ការទូទាត់</th>
                        <th style="padding:0.875rem 1rem;text-align:left;color:#374151;font-weight:600;border-bottom:1px solid rgba(26,35,126,0.07)">ថ្ងៃ</th>
                        <th style="padding:0.875rem 1rem;text-align:left;color:#374151;font-weight:600;border-bottom:1px solid rgba(26,35,126,0.07)">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr style="border-bottom:1px solid rgba(26,35,126,0.05);transition:background 0.15s" onmouseover="this.style.background='#f8faff'" onmouseout="this.style.background='#fff'">
                        <td style="padding:0.875rem 1rem;color:#6b7280">{{ $loop->iteration }}</td>
                        <td style="padding:0.875rem 1rem">
                            <div style="font-weight:600;color:#1a237e">{{ $order->customer_name }}</div>
                            <div style="font-size:0.75rem;color:#9ca3af">{{ $order->user->email ?? '—' }}</div>
                        </td>
                        <td style="padding:0.875rem 1rem;color:#374151">{{ $order->phone }}</td>
                        <td style="padding:0.875rem 1rem;color:#374151;max-width:200px">
                            <div style="font-size:0.8rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $order->note ?? '—' }}</div>
                        </td>
                        <td style="padding:0.875rem 1rem;color:#374151">{{ $order->quantity }}</td>
                        <td style="padding:0.875rem 1rem;font-weight:700;color:#2e7d32">${{ number_format($order->total_price, 2) }}</td>
                        <td style="padding:0.875rem 1rem">
                            <span style="padding:3px 10px;border-radius:50px;font-size:0.75rem;font-weight:600;background:{{ $order->payment_method === 'cash' ? '#fef3c7' : '#dbeafe' }};color:{{ $order->payment_method === 'cash' ? '#92400e' : '#1e40af' }}">
                                {{ $order->payment_method === 'cash' ? '💵 Cash' : '📱 ' . $order->payment_method }}
                            </span>
                        </td>
                        <td style="padding:0.875rem 1rem;color:#6b7280;font-size:0.8rem">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td style="padding:0.875rem 1rem">
                            <div style="display:flex;gap:0.5rem">
                                <a href="{{ route('orders.invoice', $order->id) }}" style="padding:5px 12px;background:#1a237e;color:#fff;border-radius:8px;font-size:0.75rem;text-decoration:none;font-weight:600">🧾 វិក័យ</a>
                                <a href="{{ route('orders.delete', $order->id) }}"
                                   onclick="return confirm('លុប Order នេះ?')"
                                   style="padding:5px 12px;background:#fee2e2;color:#dc2626;border-radius:8px;font-size:0.75rem;text-decoration:none;font-weight:600">🗑️</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="padding:3rem;text-align:center;color:#9ca3af">
                            <div style="font-size:2rem;margin-bottom:0.5rem">📭</div>
                            គ្មាន Order នៅឡើយទេ
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
