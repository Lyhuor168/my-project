<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            ☕ {{ __('Coffee Shop Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-4xl">☕</p>
                    <p class="text-3xl font-bold text-indigo-500 mt-2">{{ \App\Models\Product::count() }}</p>
                    <p class="text-gray-500 dark:text-gray-400">Total Products</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-4xl">🧾</p>
                    <p class="text-3xl font-bold text-green-500 mt-2">{{ \App\Models\Order::count() }}</p>
                    <p class="text-gray-500 dark:text-gray-400">Total Orders</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-4xl">💰</p>
                    <p class="text-3xl font-bold text-yellow-500 mt-2">${{ number_format(\App\Models\Order::sum('total_amount'), 2) }}</p>
                    <p class="text-gray-500 dark:text-gray-400">Total Revenue</p>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <a href="{{ route('product.index') }}" class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 flex items-center gap-4 hover:bg-indigo-50 dark:hover:bg-gray-700 transition">
                    <span class="text-4xl">☕</span>
                    <div>
                        <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">Products</p>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Manage coffee menu</p>
                    </div>
                </a>
                <a href="#" class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 flex items-center gap-4 hover:bg-green-50 dark:hover:bg-gray-700 transition">
                    <span class="text-4xl">🧾</span>
                    <div>
                        <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">Orders</p>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Manage customer orders</p>
                    </div>
                </a>
            </div>

            {{-- Latest Products --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Latest Products</h3>
                <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                    <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(\App\Models\Product::latest()->take(5)->get() as $product)
                        <tr class="border-b dark:border-gray-700">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $product->name }}</td>
                            <td class="px-4 py-2">${{ number_format($product->price, 2) }}</td>
                            <td class="px-4 py-2">{{ $product->qty }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-4 py-2 text-center text-gray-400">No products yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Latest Orders --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Latest Orders</h3>
                <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                    <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2">Invoice</th>
                            <th class="px-4 py-2">Cashier</th>
                            <th class="px-4 py-2">Total</th>
                            <th class="px-4 py-2">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(\App\Models\Order::with('user')->latest()->take(5)->get() as $order)
                        <tr class="border-b dark:border-gray-700">
                            <td class="px-4 py-2">{{ $order->invoice_number }}</td>
                            <td class="px-4 py-2">{{ $order->user->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2">${{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-4 py-2 text-center text-gray-400">No orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
