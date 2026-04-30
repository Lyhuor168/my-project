@extends('layouts.master')
@section('title', 'ទិញ - Order')
@section('content')
<div style="max-width:500px;margin:2rem auto;padding:1.5rem;background:#fff;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,0.08);">
    <h2 style="color:#1a237e;margin-bottom:1.5rem;">🛒 ទិញ: {{ $book->title }}</h2>
    <p style="color:#6b7280;">តម្លៃ: <strong>${{ $book->price }}</strong></p>

    <form method="POST" action="{{ route('orders.store') }}">
        @csrf
        <input type="hidden" name="book_id" value="{{ $book->id }}">
        <input type="hidden" name="total_price" value="{{ $book->price }}">

        <div style="margin-bottom:1rem;">
            <label style="font-weight:600;">ឈ្មោះ *</label>
            <input type="text" name="customer_name" value="{{ Auth::user()->name }}" class="form-control" required>
        </div>
        <div style="margin-bottom:1rem;">
            <label style="font-weight:600;">ទូរស័ព្ទ *</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div style="margin-bottom:1rem;">
            <label style="font-weight:600;">Email</label>
            <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control">
        </div>
        <div style="margin-bottom:1rem;">
            <label style="font-weight:600;">ចំនួន *</label>
            <input type="number" name="quantity" value="1" min="1" class="form-control" required>
        </div>
        <div style="margin-bottom:1.5rem;">
            <label style="font-weight:600;">វិធីបង់ប្រាក់ *</label>
            <select name="payment_method" class="form-control" required>
                <option value="cash">សាច់ប្រាក់</option>
                <option value="aba">ABA</option>
                <option value="wing">Wing</option>
            </select>
        </div>
        <button type="submit" style="background:#1a237e;color:#fff;border:none;padding:12px 28px;border-radius:10px;font-size:1rem;cursor:pointer;width:100%;">
            ✅ បញ្ជាក់ការទិញ
        </button>
    </form>
</div>
@endsection
