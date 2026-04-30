<!DOCTYPE html>
<html lang="km">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>វិក័យបត្រ #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</title>
<style>
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:sans-serif;background:#f3f4f6;min-height:100vh;padding:24px 16px;}
.wrap{max-width:480px;margin:0 auto;}
.dots{display:flex;gap:8px;justify-content:center;margin-bottom:20px;}
.dot{width:10px;height:10px;border-radius:50%;background:#d1d5db;transition:background .3s;}
.dot.active-purple{background:#3730a3;}
.dot.active-green{background:#166534;}
.card{background:#fff;border-radius:14px;overflow:hidden;border:1px solid #e5e7eb;}
.card-head{background:#3730a3;padding:18px 20px;color:#fff;}
.head-row{display:flex;justify-content:space-between;align-items:flex-start;}
.head-title{font-size:17px;font-weight:600;}
.head-sub{font-size:11px;opacity:.75;margin-top:2px;}
.invoice-badge{background:rgba(255,255,255,.15);border-radius:8px;padding:6px 12px;font-size:13px;font-weight:600;}
.invoice-date{font-size:11px;opacity:.75;margin-top:5px;text-align:right;}
.card-body{padding:18px 20px;}
.card-foot{background:#166534;padding:10px;text-align:center;color:rgba(255,255,255,.85);font-size:12px;}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px;}
.info-box{border:1px solid #e5e7eb;border-radius:10px;padding:12px;}
.info-label{font-size:11px;color:#6b7280;margin-bottom:4px;}
.info-val{font-size:14px;font-weight:600;color:#3730a3;}
.info-sub{font-size:11px;color:#6b7280;margin-top:3px;}
.badge-wait{display:inline-block;margin-top:4px;background:#fef9c3;color:#854d0e;font-size:11px;padding:2px 8px;border-radius:20px;}
.badge-done{display:inline-block;margin-top:4px;background:#dcfce7;color:#166534;font-size:11px;padding:2px 8px;border-radius:20px;}
.items-box{border:1px solid #e5e7eb;border-radius:10px;padding:12px;margin-bottom:12px;}
.items-label{font-size:12px;font-weight:600;color:#92400e;margin-bottom:8px;}
.item-row{display:flex;justify-content:space-between;align-items:center;padding:7px 0;border-bottom:1px solid #f3f4f6;font-size:13px;}
.item-row:last-child{border-bottom:none;}
.item-name{color:#111;flex:1;}
.item-price{font-weight:700;color:#166534;margin-left:8px;white-space:nowrap;}
.total-bar{background:#166534;border-radius:10px;padding:12px 16px;display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;}
.total-label{color:rgba(255,255,255,.85);font-size:12px;}
.total-amount{color:#fff;font-size:22px;font-weight:700;}
.btn-purple{width:100%;padding:12px;background:#3730a3;color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;margin-bottom:8px;}
.btn-green{width:100%;padding:12px;background:#166534;color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;margin-bottom:8px;}
.btn-ghost{width:100%;padding:10px;background:transparent;color:#6b7280;border:1px solid #d1d5db;border-radius:10px;font-size:13px;cursor:pointer;}
.qr-center{display:flex;justify-content:center;margin:12px 0;}
.amount-row{background:#f9fafb;border-radius:10px;padding:10px 16px;margin-bottom:16px;display:flex;justify-content:space-between;}
.step{display:none;}
.step.active{display:block;}
.success-wrap{padding:40px 24px;text-align:center;}
.success-icon{width:64px;height:64px;border-radius:50%;background:#dcfce7;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:28px;}
.success-title{font-size:18px;font-weight:700;color:#166534;margin-bottom:6px;}
.success-sub{font-size:13px;color:#6b7280;margin-bottom:20px;}
.success-meta{background:#f9fafb;border-radius:10px;padding:12px;margin-bottom:20px;font-size:13px;color:#6b7280;}
.back-btn{padding:10px 24px;background:#3730a3;color:#fff;border:none;border-radius:10px;font-size:13px;cursor:pointer;text-decoration:none;display:inline-block;}
@media print{.no-print{display:none!important;}}
</style>
</head>
<body>
<div class="wrap">

  <div class="dots no-print">
    <div class="dot active-purple" id="dot1"></div>
    <div class="dot" id="dot2"></div>
    <div class="dot" id="dot3"></div>
  </div>

  {{-- Step 1: Invoice --}}
  <div class="step active" id="stepReceipt">
    <div class="card">
      <div class="card-head">
        <div class="head-row">
          <div>
            <div class="head-title">🏫 SCHOOL SYSTEM</div>
            <div class="head-sub">Street 214, BKK1, Phnom Penh</div>
            <div class="head-sub">Tel: +855 23 456 789</div>
          </div>
          <div>
            <div class="invoice-badge">វិក័យបត្រ #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
            <div class="invoice-date">{{ $order->created_at->format('d/m/Y H:i') }}</div>
          </div>
        </div>
      </div>

      <div class="card-body">
        <div class="grid2">
          <div class="info-box">
            <div class="info-label">👤 អតិថិជន</div>
            <div class="info-val">{{ $order->customer_name }}</div>
            <div class="info-sub">📞 {{ $order->phone }}</div>
            @if($order->email)
            <div class="info-sub">✉️ {{ $order->email }}</div>
            @endif
          </div>
          <div class="info-box">
            <div class="info-label">💳 ការទូទាត់</div>
            <div class="info-val">
              @if($order->payment_method==='cash') 💵 សាច់ប្រាក់
              @elseif($order->payment_method==='aba') 🏦 ABA
              @elseif($order->payment_method==='acleda') 🏦 ACLEDA
              @elseif($order->payment_method==='wing') 📱 Wing
              @else {{ $order->payment_method }} @endif
            </div>
            @if($order->status==='completed' || $order->status==='paid')
              <span class="badge-done">✅ បានទូទាត់</span>
            @else
              <span class="badge-wait">⏳ រង់ចាំ</span>
            @endif
          </div>
        </div>

        {{-- Items with price --}}
        <div class="items-box">
          <div class="items-label">📦 វត្ថុបញ្ជា</div>
          @php
            $noteItems = [];
            if ($order->note) {
              foreach (explode(',', $order->note) as $part) {
                $part = trim($part);
                // format: "HTML CSS & JS Book x1 @$12.00"
                if (preg_match('/^(.+?)\s+x(\d+)\s+@\$([0-9.]+)$/i', $part, $m)) {
                  $noteItems[] = [
                    'name'  => trim($m[1]),
                    'qty'   => (int)$m[2],
                    'price' => (float)$m[3],
                  ];
                } else {
                  // old format fallback
                  $noteItems[] = ['name' => $part, 'qty' => 1, 'price' => null];
                }
              }
            }
          @endphp

          @if(count($noteItems) > 0)
            @foreach($noteItems as $item)
            <div class="item-row">
              <span class="item-name">• {{ $item['name'] }} x{{ $item['qty'] }}</span>
              <span class="item-price">
                @if($item['price'] !== null)
                  ${{ number_format($item['price'] * $item['qty'], 2) }}
                @endif
              </span>
            </div>
            @endforeach
          @elseif($order->book)
            <div class="item-row">
              <span class="item-name">• {{ $order->book->title }} x{{ $order->quantity }}</span>
              <span class="item-price">${{ number_format($order->total_price, 2) }}</span>
            </div>
          @else
            <div class="item-row">
              <span class="item-name">• បញ្ជាទិញ x{{ $order->quantity }}</span>
              <span class="item-price">${{ number_format($order->total_price, 2) }}</span>
            </div>
          @endif
        </div>

        <div class="total-bar">
          <div>
            <div class="total-label">សរុបទូទាត់</div>
            <div style="font-size:11px;color:rgba(255,255,255,.7);">{{ count($noteItems) ?: $order->quantity }} items</div>
          </div>
          <div class="total-amount">${{ number_format($order->total_price, 2) }}</div>
        </div>

        @if($order->payment_method !== 'cash')
        <button class="btn-purple no-print" onclick="showQR()">📱 បង្ហាញ QR សម្រាប់ទូទាត់</button>
        @endif
        <button class="btn-ghost no-print" onclick="window.print()">🖨️ បោះពុម្ព</button>
      </div>
      <div class="card-foot">សូមអរគុណចំពោះការទិញ! 🙏</div>
    </div>
  </div>

  {{-- Step 2: QR --}}
  <div class="step" id="stepQR">
    <div class="card">
      <div style="background:#3730a3;padding:14px 20px;color:#fff;text-align:center;">
        <div style="font-size:15px;font-weight:600;">ស្កែន QR ដើម្បីទូទាត់</div>
        <div style="font-size:11px;opacity:.75;margin-top:2px;">
          វិក័យបត្រ #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} — ${{ number_format($order->total_price, 2) }}
        </div>
      </div>
      <div class="card-body" style="text-align:center;">
        <div style="font-size:12px;color:#6b7280;margin-bottom:6px;">ទូទាត់ទៅ</div>
        <div style="font-size:16px;font-weight:700;color:#3730a3;margin-bottom:3px;">SCHOOL SYSTEM</div>
        <div style="font-size:13px;color:#6b7280;margin-bottom:16px;">+855 23 456 789</div>
        <div class="qr-center"><div id="qrCode"></div></div>
        <div style="font-size:11px;color:#9ca3af;margin:10px 0 16px;">ស្កែនតាម ABA / WING / ACLEDA / TrueMoney</div>
        <div class="amount-row">
          <span style="font-size:13px;color:#6b7280;">ចំនួនទឹកប្រាក់</span>
          <span style="font-size:15px;font-weight:600;color:#166534;">${{ number_format($order->total_price, 2) }}</span>
        </div>
        <button class="btn-green no-print" onclick="confirmPaid()">✅ បញ្ជាក់ការទូទាត់</button>
        <button class="btn-ghost no-print" onclick="backToReceipt()">ត្រលប់ក្រោយ</button>
      </div>
    </div>
  </div>

  {{-- Step 3: Done --}}
  <div class="step" id="stepDone">
    <div class="card">
      <div class="success-wrap">
        <div class="success-icon">✓</div>
        <div class="success-title">ទូទាត់បានជោគជ័យ!</div>
        <div class="success-sub">
          វិក័យបត្រ #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} — ${{ number_format($order->total_price, 2) }}
        </div>
        <div class="success-meta">
          {{ $order->created_at->format('d/m/Y') }} · {{ $order->payment_method }} · +855 23 456 789
        </div>
        <a href="{{ route('orders.index') }}" class="back-btn no-print">មើល Orders ទាំងអស់</a>
      </div>
    </div>
  </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
let qrGenerated = false;
const amount    = "${{ number_format($order->total_price, 2) }}";
const invoiceNo = "#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}";
const payMethod = "{{ $order->payment_method }}";

function setDots(a){
  ['dot1','dot2','dot3'].forEach(id=>{ document.getElementById(id).className='dot'; });
  if(a===1) document.getElementById('dot1').classList.add('active-purple');
  if(a===2) document.getElementById('dot2').classList.add('active-purple');
  if(a===3) document.getElementById('dot3').classList.add('active-green');
}
function showStep(id){
  ['stepReceipt','stepQR','stepDone'].forEach(s=>{ document.getElementById(s).classList.remove('active'); });
  document.getElementById(id).classList.add('active');
}
function showQR(){
  if(!qrGenerated){
    new QRCode(document.getElementById('qrCode'),{
      text:'SCHOOL SYSTEM\n+855 23 456 789\nAmount:'+amount+'\nInvoice:'+invoiceNo,
      width:200, height:200,
      colorDark:'#1e1b4b', colorLight:'#ffffff',
      correctLevel:QRCode.CorrectLevel.M
    });
    qrGenerated=true;
  }
  showStep('stepQR'); setDots(2);
}
function confirmPaid(){ showStep('stepDone'); setDots(3); }
function backToReceipt(){ showStep('stepReceipt'); setDots(1); }
</script>
</body>
</html>
