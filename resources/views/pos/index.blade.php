<x-app-layout>
    <div class="flex h-screen overflow-hidden bg-gray-100 dark:bg-gray-900">

        {{-- Left: Product Menu --}}
        <div class="flex-1 flex flex-col overflow-hidden p-6">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">☕ Coffee Menu</h1>
                <input type="text" id="search" placeholder="Search menu..." onkeyup="filterProducts()"
                    class="border rounded-lg px-4 py-2 text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
            </div>

            {{-- Category Filter --}}
            <div class="flex gap-2 mb-4 flex-wrap">
                <button onclick="filterCategory('all')" class="cat-btn active px-4 py-1 rounded-full text-sm font-semibold bg-amber-700 text-white">All</button>
                <button onclick="filterCategory('1')" class="cat-btn px-4 py-1 rounded-full text-sm font-semibold bg-gray-200 dark:bg-gray-700 dark:text-white">🧊 Iced</button>
                <button onclick="filterCategory('2')" class="cat-btn px-4 py-1 rounded-full text-sm font-semibold bg-gray-200 dark:bg-gray-700 dark:text-white">🔥 Hot</button>
                <button onclick="filterCategory('3')" class="cat-btn px-4 py-1 rounded-full text-sm font-semibold bg-gray-200 dark:bg-gray-700 dark:text-white">🥤 Frappe</button>
                <button onclick="filterCategory('4')" class="cat-btn px-4 py-1 rounded-full text-sm font-semibold bg-gray-200 dark:bg-gray-700 dark:text-white">💧 Water</button>
                <button onclick="filterCategory('5')" class="cat-btn px-4 py-1 rounded-full text-sm font-semibold bg-gray-200 dark:bg-gray-700 dark:text-white">🥤 Soft Drinks</button>
                <button onclick="filterCategory('6')" class="cat-btn px-4 py-1 rounded-full text-sm font-semibold bg-gray-200 dark:bg-gray-700 dark:text-white">⚡ Energy Drinks</button>
            </div>

            {{-- Products Grid --}}
            <div class="overflow-y-auto flex-1">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="product-grid">
                    @foreach($products as $product)
                    <div class="product-card bg-white dark:bg-gray-800 rounded-xl shadow p-4 cursor-pointer hover:shadow-lg transition"
                        data-category="{{ $product->category_id }}"
                        data-name="{{ strtolower($product->name) }}"
                        onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }})">
                        <div class="w-full h-24 bg-amber-100 dark:bg-amber-900 rounded-lg flex items-center justify-center mb-3 text-4xl">
                            @if($product->img)
                                <img src="{{ asset('storage/' . $product->img) }}" class="w-full h-full object-cover rounded-lg">
                            @elseif($product->category_id == 1) 🧊
                            @elseif($product->category_id == 2) ☕
                            @elseif($product->category_id == 3) 🥤
                            @else 💧
                            @endif
                        </div>
                        <p class="font-semibold text-sm text-gray-800 dark:text-gray-100 truncate">{{ $product->name }}</p>
                        <p class="text-amber-600 font-bold text-sm mt-1">${{ number_format($product->price, 2) }}</p>
                        <p class="text-xs text-gray-400">Stock: {{ $product->qty }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right: Cart / Bills --}}
        <div class="w-80 bg-white dark:bg-gray-800 shadow-lg flex flex-col p-6">

            {{-- Cashier Info --}}
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-full bg-amber-700 flex items-center justify-center text-white font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <p class="text-xs text-gray-400">Cashier</p>
                    <p class="font-semibold text-gray-800 dark:text-gray-100">{{ auth()->user()->name }}</p>
                </div>
            </div>

            <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">🧾 Bills</h2>

            {{-- Cart Items --}}
            <div class="flex-1 overflow-y-auto space-y-3" id="cart-items">
                <p class="text-gray-400 text-sm text-center mt-8" id="empty-cart">No items yet. Click a product!</p>
            </div>

            {{-- Totals --}}
            <div class="border-t dark:border-gray-700 pt-4 mt-4 space-y-2">
                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300">
                    <span>Subtotal</span>
                    <span id="subtotal">$0.00</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300">
                    <span>Tax (10%)</span>
                    <span id="tax">$0.00</span>
                </div>
                <div class="flex justify-between font-bold text-gray-800 dark:text-gray-100 text-lg">
                    <span>Total</span>
                    <span id="total">$0.00</span>
                </div>
            </div>

            
            <form method="POST" action="{{ route('pos.checkout') }}" id="checkout-form">
                @csrf
                <input type="hidden" name="cart" id="cart-input">
                <button type="button" onclick="checkout()"
                    class="w-full mt-4 bg-amber-700 hover:bg-amber-800 text-white font-bold py-3 rounded-xl transition">
                    Print Bills & Checkout
                </button>
            </form>
        </div>
    </div>

    <script>
        let cart = {};

        function addToCart(id, name, price) {
            if (cart[id]) {
                cart[id].qty += 1;
            } else {
                cart[id] = { name, price, qty: 1 };
            }
            renderCart();
        }

        function removeFromCart(id) {
            if (cart[id]) {
                cart[id].qty -= 1;
                if (cart[id].qty <= 0) delete cart[id];
            }
            renderCart();
        }

        function renderCart() {
            const container = document.getElementById('cart-items');
            const empty = document.getElementById('empty-cart');
            container.innerHTML = '';

            let subtotal = 0;
            const keys = Object.keys(cart);

            if (keys.length === 0) {
                container.innerHTML = '<p class="text-gray-400 text-sm text-center mt-8">No items yet. Click a product!</p>';
            } else {
                keys.forEach(id => {
                    const item = cart[id];
                    subtotal += item.price * item.qty;
                    container.innerHTML += `
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">${item.name}</p>
                                <p class="text-xs text-amber-600">$${(item.price * item.qty).toFixed(2)}</p>
                            </div>
                            <div class="flex items-center gap-1">
                                <button onclick="removeFromCart(${id})" class="w-6 h-6 rounded-full bg-gray-200 dark:bg-gray-600 text-sm font-bold">-</button>
                                <span class="text-sm font-bold w-4 text-center text-gray-800 dark:text-gray-100">${item.qty}</span>
                                <button onclick="addToCart(${id}, '${item.name}', ${item.price})" class="w-6 h-6 rounded-full bg-amber-700 text-white text-sm font-bold">+</button>
                            </div>
                        </div>`;
                });
            }

            
            const total = subtotal;
            document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
            
            document.getElementById('total').textContent = '$' + total.toFixed(2);
        }

        function filterCategory(cat) {
            document.querySelectorAll('.product-card').forEach(card => {
                card.style.display = (cat === 'all' || card.dataset.category === cat) ? '' : 'none';
            });
            document.querySelectorAll('.cat-btn').forEach(btn => {
                btn.classList.remove('bg-amber-700', 'text-white');
                btn.classList.add('bg-gray-200', 'dark:bg-gray-700');
            });
            event.target.classList.add('bg-amber-700', 'text-white');
        }

        function filterProducts() {
            const q = document.getElementById('search').value.toLowerCase();
            document.querySelectorAll('.product-card').forEach(card => {
                card.style.display = card.dataset.name.includes(q) ? '' : 'none';
            });
        }

        function checkout() {
            if (Object.keys(cart).length === 0) {
                alert('Please add items to cart first!');
                return;
            }
            document.getElementById('cart-input').value = JSON.stringify(cart);
            document.getElementById('checkout-form').submit();
        }
    </script>
</x-app-layout>
