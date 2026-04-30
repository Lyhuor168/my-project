@extends('layouts.master')

@section('title', 'បញ្ជាទិញ - Order')

@section('content')

<style>
    .od-wrap { max-width: 720px; margin: 0 auto; padding: 2.5rem 2rem 4rem; font-family: 'Kantumruy Pro', sans-serif; }

    .od-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(26,35,126,0.08); }
    .od-icon { width: 52px; height: 52px; border-radius: 16px; background: linear-gradient(135deg,#2e7d32,#43a047); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; box-shadow: 0 6px 18px rgba(46,125,50,0.25); }
    .od-title { font-size: 1.5rem; font-weight: 700; color: #1a237e; margin: 0; }
    .od-bread a { color: #3949ab; text-decoration: none; font-size: 0.8rem; }

    .od-card { background: #fff; border-radius: 18px; border: 1px solid rgba(26,35,126,0.07); box-shadow: 0 4px 24px rgba(26,35,126,0.06); overflow: hidden; margin-bottom: 1.25rem; }
    .od-card-head { padding: 1.1rem 1.5rem; border-bottom: 1px solid rgba(26,35,126,0.07); display: flex; align-items: center; gap: 10px; background: #fafbff; }
    .od-card-head h5 { font-size: 0.95rem; font-weight: 700; color: #1a237e; margin: 0; }
    .step-b { width: 26px; height: 26px; border-radius: 50%; background: #2e7d32; color: #fff; font-size: 0.72rem; font-weight: 800; display: flex; align-items: center; justify-content: center; }
    .od-card-body { padding: 1.5rem; }

    .od-field { margin-bottom: 1.2rem; }
    .od-field label { font-size: 0.8rem; font-weight: 700; color: #374151; display: block; margin-bottom: 6px; }
    .od-input { width: 100%; padding: 12px 15px; background: #f8faff; border: 1.5px solid rgba(26,35,126,0.1); border-radius: 10px; font-size: 0.9rem; transition: 0.2s; box-sizing: border-box; }
    .od-input:focus { outline: none; border-color: #2e7d32; box-shadow: 0 0 0 3px rgba(46,125,50,0.1); background: #fff; }
    .od-input.is-invalid { border-color: #e11d48; }
    .od-err { font-size: 0.75rem; color: #e11d48; margin-top: 4px; }

    .od-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
    @media(max-width:560px){ .od-row-2 { grid-template-columns: 1fr; } }

    .od-alert-err { padding: 1rem; background: #fff5f5; border-left: 5px solid #e11d48; color: #c53030; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; }

    /* Book Card Preview */
    .book-preview { background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 12px; padding: 1rem 1.25rem; display: flex; align-items: center; gap: 1rem; margin-bottom: 1.2rem; }
    .book-preview img { width: 56px; height: 72px; object-fit: cover; border-radius: 6px; background: #e2e8f0; }
    .book-preview .bp-info h4 { margin: 0 0 4px; font-size: 0.95rem; font-weight: 700; color: #1a237e; }
    .book-preview .bp-info span { font-size: 0.8rem; color: #6b7280; }
    .book-price { margin-left: auto; font-size: 1.1rem; font-weight: 800; color: #2e7d32; }

    /* Total Box */
    .od-total { background: linear-gradient(135deg,#2e7d32,#43a047); border-radius: 14px; padding: 1.25rem 1.5rem; color: #fff; display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; }
    .od-total .label { font-size: 0.9rem; opacity: 0.9; }
    .od-total .amount { font-size: 1.6rem; font-weight: 800; }

    /* Status Badge */
    .status-group { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 5px; }
    .status-group label { background: #f1f3f9; padding: 8px 16px; border-radius: 50px; cursor: pointer; transition: 0.2s; border: 1.5px solid transparent; font-size: 0.85rem; }
    .status-group input { margin-right: 5px; cursor: pointer; }
    .status-group input:checked + span { font-weight: 700; }

    .btn-order { background: linear-gradient(135deg,#2e7d32,#43a047); color: #fff; border: none; border-radius: 12px; padding: 12px 30px; font-weight: 700; cursor: pointer; box-shadow: 0 6px 20px rgba(46,125,50,0.3); transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; font-size: 0.95rem; }
    .btn-order:hover { transform: translateY(-2px); opacity: 0.9; }
    .btn-back { background: #f3f4f6; color: #374151; padding: 11px 20px; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 5px; }
</style>

<div class="od-wrap">

    @if($errors->any())
        <div class="od-alert-err">
            ❌ មានបញ្ហា {{ $errors->count() }} ចំណុច — សូមពិនិត្យម្ដងទៀត
        </div>
    @endif

    {{-- Header --}}
    <div class="od-header">
        <div style="display:flex; align-items:center; gap:15px;">
            <div class="od-icon">🛒</div>
            <div>
                <div class="od-bread">
                    <a href="/">Home</a> /
                    <a href="{{ route('shop') }}">Shop</a> /
                    <span>បញ្ជាទិញ</span>
                </div>
                <h1 class="od-title">បញ្ជាទិញសៀវភៅ</h1>
                <div style="color:#6b7280; font-size:0.85rem;">Place a new book order</div>
            </div>
        </div>
        <a href="{{ route('shop') }}" class="btn-back">⬅ ត្រឡប់ក្រោយ</a>
    </div>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        {{-- BOOK PREVIEW --}}
        @isset($book)
        <div class="book-preview">
            @if(!empty($book->image))
                <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}">
            @else
                <img src="" alt="no image">
            @endif
            <div class="bp-info">
                <h4>{{ $book->title ?? '' }}</h4>
                <span>{{ $book->author ?? '' }} • {{ $book->category ?? '' }}</span>
            </div>
            <div class="book-price">{{ number_format($book->price ?? 0) }} ៛</div>
        </div>
        <input type="hidden" name="book_id" value="{{ $book->id }}">
        @endisset

        {{-- CUSTOMER INFO --}}
        <div class="od-card">
            <div class="od-card-head">
                <div class="step-b">1</div>
                <h5>ព័ត៌មានអតិថិជន — Customer Info</h5>
            </div>
            <div class="od-card-body">

                <div class="od-field">
                    <label>ឈ្មោះអតិថិជន *</label>
                    <input type="text" name="customer_name" class="od-input @error('customer_name') is-invalid @enderror"
                        placeholder="ឧ. សុខ ដារ៉ា" value="{{ old('customer_name') }}">
                    @error('customer_name') <div class="od-err">{{ $message }}</div> @enderror
                </div>

                <div class="od-row-2">
                    <div class="od-field">
                        <label>លេខទូរស័ព្ទ *</label>
                        <input type="text" name="phone" class="od-input @error('phone') is-invalid @enderror"
                            placeholder="ឧ. 012345678" value="{{ old('phone') }}">
                        @error('phone') <div class="od-err">{{ $message }}</div> @enderror
                    </div>

                    <div class="od-field">
                        <label>Email</label>
                        <input type="email" name="email" class="od-input @error('email') is-invalid @enderror"
                            placeholder="ឧ. example@mail.com" value="{{ old('email') }}">
                        @error('email') <div class="od-err">{{ $message }}</div> @enderror
                    </div>
                </div>

            </div>
        </div>

        {{-- ORDER DETAILS --}}
        <div class="od-card">
            <div class="od-card-head">
                <div class="step-b">2</div>
                <h5>ព័ត៌មានការបញ្ជាទិញ — Order Details</h5>
            </div>
            <div class="od-card-body">

                @unless(isset($book))
                <div class="od-field">
                    <label>ជ្រើសរើសសៀវភៅ *</label>
                    <select name="book_id" class="od-input @error('book_id') is-invalid @enderror" onchange="calcTotal()">
                        <option value="">-- ជ្រើសរើសសៀវភៅ --</option>
                        @foreach($books ?? [] as $b)
                            <option value="{{ $b->id }}" data-price="{{ $b->price }}" {{ old('book_id') == $b->id ? 'selected' : '' }}>
                                {{ $b->title }} — {{ number_format($b->price) }} ៛
                            </option>
                        @endforeach
                    </select>
                    @error('book_id') <div class="od-err">{{ $message }}</div> @enderror
                </div>
                @endunless

                <div class="od-row-2">
                    <div class="od-field">
                        <label>ចំនួន *</label>
                        <input type="number" name="quantity" id="quantity" class="od-input @error('quantity') is-invalid @enderror"
                            value="{{ old('quantity', 1) }}" min="1" onchange="calcTotal()">
                        @error('quantity') <div class="od-err">{{ $message }}</div> @enderror
                    </div>

                    <div class="od-field">
                        <label>វិធីទូទាត់</label>
                        <select name="payment_method" class="od-input @error('payment_method') is-invalid @enderror">
                            @php $pm = old('payment_method', 'cash'); @endphp
                            <option value="cash"     {{ $pm=='cash'    ?'selected':'' }}>💵 សាច់ប្រាក់</option>
                            <option value="aba"      {{ $pm=='aba'     ?'selected':'' }}>🏦 ABA Bank</option>
                            <option value="acleda"   {{ $pm=='acleda'  ?'selected':'' }}>🏦 ACLEDA</option>
                            <option value="wing"     {{ $pm=='wing'    ?'selected':'' }}>📱 Wing</option>
                        </select>
                        @error('payment_method') <div class="od-err">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="od-field">
                    <label>ស្ថានភាព</label>
                    <div class="status-group">
                        @php $st = old('status', 'pending'); @endphp
                        <label><input type="radio" name="status" value="pending"   {{ $st=='pending'  ?'checked':'' }}> <span>⏳ រង់ចាំ</span></label>
                        <label><input type="radio" name="status" value="paid"      {{ $st=='paid'     ?'checked':'' }}> <span>✅ បានទូទាត់</span></label>
                        <label><input type="radio" name="status" value="cancelled" {{ $st=='cancelled'?'checked':'' }}> <span>❌ បានបោះបង់</span></label>
                    </div>
                    @error('status') <div class="od-err">{{ $message }}</div> @enderror
                </div>

                <div class="od-field">
                    <label>កំណត់ចំណាំ</label>
                    <textarea name="note" class="od-input" rows="2" placeholder="...">{{ old('note') }}</textarea>
                </div>

            </div>
        </div>

        {{-- TOTAL --}}
        <div class="od-total">
            <div>
                <div class="label">តម្លៃសរុប</div>
                <div style="font-size:0.8rem; opacity:0.8;">Total Amount</div>
            </div>
            <div class="amount" id="totalDisplay">
                {{ number_format(($book->price ?? 0) * (old('quantity', 1))) }} ៛
            </div>
        </div>
        <input type="hidden" name="total_price" id="totalPrice" value="{{ ($book->price ?? 0) * (old('quantity', 1)) }}">

        {{-- SUBMIT --}}
        <div style="display:flex; gap:10px; margin-top:1rem;">
            <button type="submit" class="btn-order">🛒 បញ្ជាក់ការទិញ</button>
            <a href="{{ route('shop') }}" class="btn-back" style="background:#eee;">❌ បោះបង់</a>
        </div>

    </form>
</div>

<script>
const bookPrice = {{ $book->price ?? 0 }};

function calcTotal() {
    const qty = parseInt(document.getElementById('quantity').value) || 1;
    const total = bookPrice * qty;
    document.getElementById('totalDisplay').textContent = total.toLocaleString() + ' ៛';
    document.getElementById('totalPrice').value = total;
}
</script>

@endsection
