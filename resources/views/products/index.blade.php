<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Products</h2>
            <a href="{{ route('product.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">+ Add Product</a>
        </div>
    </x-slot>

    <div class="py-8 px-6">

        @if(session('success'))
            <div class="mb-4 bg-green-50 text-green-600 px-4 py-3 rounded-lg">{{ session('success') }}</div>
        @endif

        <form method="GET" action="{{ request()->url() }}" class="flex gap-3 mb-6">
            <input type="text" name="search" placeholder="Search by ID or Name..."
                value="{{ request('search') }}"
                class="flex-1 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm dark:bg-gray-700 dark:text-white outline-none focus:border-blue-500">
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm">🔍 Search</button>
            @if(request('search'))
                <a href="{{ request()->url() }}" class="bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm">✕ Clear</a>
            @endif
        </form>

    
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-800 text-gray-300 text-xs uppercase">
                    <tr>
                        <th class="px-5 py-4">ID</th>
                        <th class="px-5 py-4">Name</th>
                        <th class="px-5 py-4">Price</th>
                        <th class="px-5 py-4">QTY</th>
                        <th class="px-5 py-4">Image</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pro as $p)
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-5 py-3 text-gray-800 dark:text-gray-200">{{ $p->id }}</td>
                        <td class="px-5 py-3 text-gray-800 dark:text-gray-200 font-medium">{{ $p->name }}</td>
                        <td class="px-5 py-3 text-amber-600 font-semibold">${{ number_format($p->price, 2) }}</td>
                        <td class="px-5 py-3 text-gray-800 dark:text-gray-200">{{ $p->qty }}</td>
                        <td class="px-5 py-3">
                            @if($p->img)
                                <img src="{{ asset('storage/' . $p->img) }}" class="h-10 w-10 rounded-lg object-cover">
                            @else
                                <span class="text-gray-400 text-xs">No image</span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $p->status == 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $p->status == 1 ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-5 py-3 flex gap-2">
                            <a href="{{ route('product.edit', $p->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1 rounded-lg text-xs">✏️ Edit</a>
                            <form action="{{ route('product.destroy', $p->id) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this product?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs">🗑️</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-5 py-8 text-center text-gray-400">No products found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    
        @if(method_exists($pro, 'links'))
        <div class="mt-4 text-sm text-gray-500">Showing {{ $pro->firstItem() }} to {{ $pro->lastItem() }} of {{ $pro->total() }} results</div>
        <div class="flex gap-2 mt-2">
            @if($pro->onFirstPage())
                <span class="px-3 py-1 rounded border text-gray-300">« Previous</span>
            @else
                <a href="{{ $pro->previousPageUrl() }}" class="px-3 py-1 rounded border text-gray-600 hover:bg-gray-100">« Previous</a>
            @endif
            @for($i = 1; $i <= $pro->lastPage(); $i++)
                @if($i == $pro->currentPage())
                    <span class="px-3 py-1 rounded bg-blue-500 text-white font-bold">{{ $i }}</span>
                @else
                    <a href="{{ $pro->url($i) }}" class="px-3 py-1 rounded border text-gray-600 hover:bg-gray-100">{{ $i }}</a>
                @endif
            @endfor
            @if($pro->hasMorePages())
                <a href="{{ $pro->nextPageUrl() }}" class="px-3 py-1 rounded border text-gray-600 hover:bg-gray-100">Next »</a>
            @else
                <span class="px-3 py-1 rounded border text-gray-300">Next »</span>
            @endif
        </div>
        @endif

    </div>
</x-app-layout>
