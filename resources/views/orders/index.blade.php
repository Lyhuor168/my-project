<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">📋 Orders History</h2>
            <form method="GET" action="{{ route('order.index') }}" class="flex gap-2">
                <input type="date" name="date" value="{{ $date }}"
                    class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm dark:bg-gray-700 dark:text-white">
                <button type="submit" class="bg-amber-700 text-white px-4 py-2 rounded-lg text-sm">🔍 Filter</button>
            </form>
        </div>
    </x-slot>

    <div class="py-8 px-6">

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 text-center">
                <p class="text-3xl font-bold text-amber-600">{{ $count }}</p>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Total Orders</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 text-center">
                <p class="text-3xl font-bold text-green-600">${{ number_format($total, 2) }}</p>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Total Revenue</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 text-center">
                <p class="text-3xl font-bold text-blue-600">{{ $date }}</p>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Date</p>
            </div>
        </div>

        {{-- Orders Table --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-800 text-gray-300 text-xs uppercase">
                    <tr>
                        <th class="px-5 py-4">Invoice</th>
                        <th class="px-5 py-4">Cashier</th>
                        <th class="px-5 py-4">Items</th>
                        <th class="px-5 py-4">Total</th>
                        <th class="px-5 py-4">Time</th>
                        <th class="px-5 py-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-5 py-3 font-semibold text-amber-600">{{ $order->invoice_number }}</td>
                        <td class="px-5 py-3 text-gray-800 dark:text-gray-200">{{ $order->user->name ?? 'N/A' }}</td>
                        <td class="px-5 py-3 text-gray-600 dark:text-gray-300">
                            @foreach($order->items as $item)
                                <span class="inline-block bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded text-xs mr-1 mb-1">
                                    {{ $item->product->name ?? '?' }} x{{ $item->qty }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-5 py-3 font-bold text-green-600">${{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-5 py-3 text-gray-500 text-xs">{{ $order->created_at->format('h:i A') }}</td>
                        <td class="px-5 py-3">
                            <a href="{{ route('pos.invoice', $order->id) }}"
                                class="bg-amber-700 hover:bg-amber-800 text-white px-3 py-1 rounded-lg text-xs">
                                🧾 Invoice
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-gray-400">
                            😕 No orders found for {{ $date }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
