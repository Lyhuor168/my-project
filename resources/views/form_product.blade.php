<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                {{ isset($product) ? '✏️ Edit Product' : '+ Add Product' }}
            </h2>
            <a href="{{ route('product.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg text-sm">← Back</a>
        </div>
    </x-slot>

    <div class="py-8 px-6">
        <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow p-8">

            @if($errors->any())
                <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-lg text-sm">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ isset($product) ? route('product.update', $product->id) : route('product.store') }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($product))
                    @method('PUT')
                @endif

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Product Name</label>
                    <input type="text" name="name" value="{{ $product->name ?? old('name') }}"
                        placeholder="Enter product name"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 text-sm dark:bg-gray-700 dark:text-white outline-none focus:border-amber-500">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Price ($)</label>
                    <input type="number" name="price" step="0.01" value="{{ $product->price ?? old('price', '0.00') }}"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 text-sm dark:bg-gray-700 dark:text-white outline-none focus:border-amber-500">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Quantity</label>
                    <input type="number" name="qty" value="{{ $product->qty ?? old('qty', '0') }}"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 text-sm dark:bg-gray-700 dark:text-white outline-none focus:border-amber-500">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Category</label>
                    <select name="category_id" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 text-sm dark:bg-gray-700 dark:text-white outline-none focus:border-amber-500">
                        @foreach($categories as $id => $name)
                            <option value="{{ $id }}" {{ isset($product) && $product->category_id == $id ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Photo</label>
                    @if(isset($product) && $product->img)
                        <img src="{{ asset('storage/' . $product->img) }}" class="h-20 w-20 rounded-lg object-cover mb-2">
                    @endif
                    <input type="file" name="img" accept="image/*"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 text-sm dark:bg-gray-700 dark:text-white">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <textarea name="description" rows="3" placeholder="Optional description..."
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 text-sm dark:bg-gray-700 dark:text-white outline-none focus:border-amber-500">{{ $product->description ?? old('description') }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-amber-700 hover:bg-amber-800 text-white font-bold py-3 rounded-lg transition">
                        {{ isset($product) ? '💾 Update' : '💾 Save' }}
                    </button>
                    <a href="{{ route('product.index') }}" class="flex-1 text-center bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold py-3 rounded-lg">
                        ← Back
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
