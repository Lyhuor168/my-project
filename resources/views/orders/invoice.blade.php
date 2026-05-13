<!DOCTYPE html>
<html lang="km">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Invoice #{{ $order->invoice_number }}</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: sans-serif; background: #f3f4f6; min-height: 100vh; padding: 24px 16px; }
  .wrap { max-width: 480px; margin: 0 auto; }
  .dots { display: flex; gap: 8px; justify-content: center; margin-bottom: 20px; }
  .dot { width: 10px; height: 10px; border-radius: 50%; background: #d1d5db; transition: background 0.3s; }
  .dot.active-brown { background: #7c3d12; }
  .dot.active-green { background: #166534; }
  .card { background: #fff; border-radius: 14px; overflow: hidden; border: 1px solid #e5e7eb; }
  .card-head { background: #7c3d12; padding: 18px 20px; color: #fff; }
  .card-head h1 { font-size: 17px; font-weight: 600; }
  .card-head .sub { font-size: 11px; opacity: .75; margin-top: 2px; }
  .card-head-center { background: #7c3d12; padding: 14px 20px; color: #fff; text-align: center; }
  .card-head-center .title { font-size: 15px; font-weight: 600; }
  .card-head-center .sub { font-size: 11px; opacity: .75; margin-top: 2px; }
  .card-body { padding: 18px 20px; }
  .card-foot { background: #166534; padding: 10px; text-align: center; color: rgba(255,255,255,.85); font-size: 12px; }
  .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 14px; }
  .info-box { border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px; }
  .info-box .label { font-size: 11px; color: #6b7280; margin-bottom: 4px; }
  .info-box .val { font-size: 14px; font-weight: 600; color: #7c3d12; }
  .info-box .sub { font-size: 11px; color: #6b7280; margin-top: 3px; }
  .items-box { border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px; margin-bottom: 12px; }
  .items-box .label { font-size: 12px; font-weight: 600; color: #7c3d12; margin-bottom: 6px; }
  .items-box .item { font-size: 13px; color: #111; padding: 4px 0; border-bottom: 1px solid #f3f4f6; display: flex; justify-content: space-between; }
  .items-box .item:last-child { border-bottom: none; }
  .total-bar { background: #7c3d12; border-radius: 10px; padding: 12px 16px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; }
  .total-bar .t-label { color: rgba(255,255,255,.85); font-size: 12px; }
  .total-bar .t-amount { color: #fff; font-size: 22px; font-weight: 700; }
  .pay-methods { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 14px; }
  .pay-btn { border: 2px solid #e5e7eb; border-radius: 12px; padding: 14px; text-align: center; cursor: pointer; transition: all 0.2s; background: #fff; }
  .pay-btn:hover { border-color: #7c3d12; background: #fef3c7; }
  .pay-btn.selected { border-color: #7c3d12; background: #fef3c7; }
  .pay-btn .icon { font-size: 24px; margin-bottom: 4px; }
  .pay-btn .name { font-size: 13px; font-weight: 600; color: #374151; }
  .btn-brown { width: 100%; padding: 12px; background: #7c3d12; color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; }
  .btn-brown:hover { background: #6b3310; }
  .btn-green { width: 100%; padding: 12px; background: #166534; color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; margin-bottom: 8px; }
  .btn-green:hover { background: #14532d; }
  .btn-ghost { width: 100%; padding: 10px; background: transparent; color: #6b7280; border: 1px solid #d1d5db; border-radius: 10px; font-size: 13px; cursor: pointer; }
  .qr-center { display: flex; justify-content: center; margin: 12px 0; }
  .amount-row { background: #f9fafb; border-radius: 10px; padding: 10px 16px; margin-bottom: 16px; display: flex; justify-content: space-between; }
  .amount-row .a-label { font-size: 13px; color: #6b7280; }
  .amount-row .a-val { font-size: 15px; font-weight: 600; color: #166534; }
  .success-icon { width: 64px; height: 64px; border-radius: 50%; background: #dcfce7; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 28px; }
  .success-title { font-size: 18px; font-weight: 700; color: #166534; margin-bottom: 6px; text-align: center; }
  .success-sub { font-size: 13px; color: #6b7280; text-align: center; margin-bottom: 20px; }
  .success-meta { background: #f9fafb; border-radius: 10px; padding: 12px; margin-bottom: 20px; font-size: 13px; color: #6b7280; text-align: center; }
  .step { display: none; }
  .step.active { display: block; }
  .head-row { display: flex; justify-content: space-between; align-items: flex-start; }
  .invoice-badge { background: rgba(255,255,255,.15); border-radius: 8px; padding: 6px 12px; font-size: 13px; font-weight: 600; }
  .invoice-date { font-size: 11px; opacity: .75; margin-top: 5px; text-align: right; }
  @media print {
    .dots, .btn-brown, .btn-green, .btn-ghost, .pay-methods { display: none; }
    #stepPayment, #stepQR, #stepDone { display: none !important; }
    #stepReceipt { display: block !important; }
  }
</style>
</head>
<body>
<div class="wrap">

  <div class="dots">
    <div class="dot active-brown" id="dot1"></div>
    <div class="dot" id="dot2"></div>
    <div class="dot" id="dot3"></div>
    <div class="dot" id="dot4"></div>
  </div>

  {{-- Step 1: Receipt --}}
  <div class="step active" id="stepReceipt">
    <div class="card">
      <div class="card-head">
        <div class="head-row">
          <div>
            <h1>☕ Coffee Shop</h1>
            <div class="sub">Phnom Penh, Cambodia</div>
            <div class="sub">Cashier: {{ $order->user->name ?? 'Admin' }}</div>
          </div>
          <div>
            <div class="invoice-badge">{{ $order->invoice_number }}</div>
            <div class="invoice-date">{{ $order->created_at->format('d/m/Y H:i') }}</div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="items-box">
          <div class="label">📦 Items</div>
          @foreach($order->items as $item)
          <div class="item">
            <span>{{ $item->product->name ?? 'Product' }} x{{ $item->qty }}</span>
            <span>${{ number_format($item->price * $item->qty, 2) }}</span>
          </div>
          @endforeach
        </div>
        <div class="total-bar">
          <div class="t-label">សរុបទូទាត់</div>
          <div class="t-amount">${{ number_format($order->total_amount, 2) }}</div>
        </div>
        <button class="btn-brown" onclick="showPayment()">💳 ជ្រើសរើសការទូទាត់</button>
      </div>
      <div class="card-foot">សូមអរគុណចំពោះការទិញ! 🙏 Thank you!</div>
    </div>
  </div>

  {{-- Step 2: Payment Method --}}
  <div class="step" id="stepPayment">
    <div class="card">
      <div class="card-head-center">
        <div class="title">💳 ជ្រើសរើសការទូទាត់</div>
        <div class="sub">{{ $order->invoice_number }} — ${{ number_format($order->total_amount, 2) }}</div>
      </div>
      <div class="card-body">
        <p style="font-size:13px;color:#6b7280;margin-bottom:12px;text-align:center;">បងគិតលុយតាមណា?</p>
        <div class="pay-methods">
          <div class="pay-btn" onclick="selectPayment('ABA')">
            <div class="icon">🏦</div>
            <div class="name">ABA</div>
          </div>
          <div class="pay-btn" onclick="selectPayment('ACLEDA')">
            <div class="icon">🏧</div>
            <div class="name">ACLEDA</div>
          </div>
          <div class="pay-btn" onclick="selectPayment('Wing')">
            <div class="icon">📱</div>
            <div class="name">Wing</div>
          </div>
          <div class="pay-btn" id="cashBtn" onclick="selectPayment('Cash')">
            <div class="icon">💵</div>
            <div class="name">សាច់ប្រាក់</div>
          </div>
        </div>
        
        {{-- Cash Input --}}
        <div id="cashInput" style="display:none;margin-bottom:14px;">
            <div style="font-size:13px;color:#6b7280;margin-bottom:8px;">បញ្ចូលចំនួនសាច់ប្រាក់ដែលអតិថិជនបង់</div>
            <input type="number" id="cashAmount" step="0.01" placeholder="0.00"
                oninput="calcChange()"
                style="width:100%;border:2px solid #7c3d12;border-radius:10px;padding:12px;font-size:18px;font-weight:bold;text-align:center;outline:none;margin-bottom:8px;">
            <div class="amount-row" id="changeRow" style="display:none;">
                <span class="a-label">ប្រាក់អាប់</span>
                <span class="a-val" id="changeAmount">$0.00</span>
            </div>
            <button class="btn-green" onclick="confirmCash()">✅ បញ្ជាក់ការទូទាត់</button>
        </div>
        <button class="btn-ghost" onclick="backToReceipt()">← ត្រលប់ក្រោយ</button>
      </div>
    </div>
  </div>

  {{-- Step 3: QR --}}
  <div class="step" id="stepQR">
    <div class="card">
      <div class="card-head-center">
        <div class="title" id="qrTitle">ស្កែន QR ដើម្បីទូទាត់</div>
        <div class="sub">{{ $order->invoice_number }} — ${{ number_format($order->total_amount, 2) }}</div>
      </div>
      <div class="card-body" style="text-align:center;">
        <div style="font-size:13px;color:#6b7280;margin-bottom:4px;">ទូទាត់ទៅ Coffee Shop</div>
        <div class="qr-center">
          <img src="{{ asset('images/khqr.png') }}" style="width:200px;height:200px;object-fit:cover;object-position:center;border-radius:12px;">
        </div>
        <div style="font-size:11px;color:#9ca3af;margin-bottom:16px;">ស្កែនតាម ABA / WING / ACLEDA / TrueMoney</div>
        <div class="amount-row">
          <span class="a-label">ចំនួនទឹកប្រាក់</span>
          <span class="a-val">${{ number_format($order->total_amount, 2) }}</span>
        </div>
        <button class="btn-green" onclick="confirmPaid()">✅ បញ្ជាក់ការទូទាត់</button>
        <button class="btn-ghost" onclick="showPayment()">← ត្រលប់ក្រោយ</button>
      </div>
    </div>
  </div>

  {{-- Step 4: Done --}}
  <div class="step" id="stepDone">
    <div class="card">
      <div class="card-body" style="padding: 40px 24px; text-align:center;">
        <div class="success-icon">✓</div>
        <div class="success-title">ទូទាត់បានជោគជ័យ! 🎉</div>
        <div class="success-sub">{{ $order->invoice_number }} — ${{ number_format($order->total_amount, 2) }}</div>
        <div class="success-meta" id="doneMethod">{{ $order->created_at->format('d/m/Y H:i') }} · Coffee Shop</div>
        <div style="display:flex;gap:10px;justify-content:center;margin-top:16px;flex-wrap:wrap;">
          <button onclick="window.print()" style="padding:10px 20px;background:#7c3d12;color:#fff;border:none;border-radius:10px;font-size:13px;cursor:pointer;">🖨️ Print</button>
          <a href="{{ route('pos.index') }}" style="padding:10px 20px;background:#7c3d12;color:#fff;border-radius:10px;font-size:13px;text-decoration:none;">← New Order</a>
          <a href="{{ route('order.index') }}" style="padding:10px 20px;background:#166534;color:#fff;border-radius:10px;font-size:13px;text-decoration:none;">📋 View Orders</a>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
let selectedPayment = '';

function setDots(active) {
  ['dot1','dot2','dot3','dot4'].forEach((id, i) => {
    const el = document.getElementById(id);
    el.className = 'dot';
    if (i + 1 <= active) {
      el.classList.add(active === 4 ? 'active-green' : 'active-brown');
    }
  });
}

function showStep(id) {
  ['stepReceipt','stepPayment','stepQR','stepDone'].forEach(s => {
    document.getElementById(s).classList.remove('active');
  });
  document.getElementById(id).classList.add('active');
}

function showPayment() { showStep('stepPayment'); setDots(2); }
function backToReceipt() { showStep('stepReceipt'); setDots(1); }

function selectPayment(method) {
  selectedPayment = method;
  document.querySelectorAll('.pay-btn').forEach(b => b.classList.remove('selected'));
  event.currentTarget.classList.add('selected');
  document.getElementById('cashInput').style.display = 'none';
  setTimeout(() => {
    if (method === 'Cash') {
      document.getElementById('cashInput').style.display = 'block';
      document.getElementById('cashAmount').focus();
    } else {
      document.getElementById('qrTitle').textContent = 'ស្កែន QR — ' + method;
      showStep('stepQR');
      setDots(3);
    }
  }, 300);
}

function calcChange() {
  const total = {{ $order->total_amount }};
  const cash = parseFloat(document.getElementById('cashAmount').value) || 0;
  const change = cash - total;
  const changeRow = document.getElementById('changeRow');
  if (cash > 0) {
    changeRow.style.display = 'flex';
    document.getElementById('changeAmount').textContent = '$' + (change >= 0 ? change.toFixed(2) : '0.00');
    document.getElementById('changeAmount').style.color = change >= 0 ? '#166534' : '#dc2626';
  } else {
    changeRow.style.display = 'none';
  }
}

function confirmCash() {
  const total = {{ $order->total_amount }};
  const cash = parseFloat(document.getElementById('cashAmount').value) || 0;
  if (cash < total) {
    alert('សាច់ប្រាក់មិនគ្រប់! ត្រូវការ $' + total.toFixed(2));
    return;
  }
  document.getElementById('doneMethod').textContent =
    '{{ $order->created_at->format("d/m/Y H:i") }} · សាច់ប្រាក់ · ប្រាក់អាប់: $' + (cash - total).toFixed(2);
  showStep('stepDone');
  setDots(4);
}

function confirmPaid() {
  document.getElementById('doneMethod').textContent =
    '{{ $order->created_at->format("d/m/Y H:i") }} · ' + selectedPayment + ' · Coffee Shop';
  showStep('stepDone');
  setDots(4);
}
</script>
</body>
</html>
