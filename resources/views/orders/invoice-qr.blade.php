{{--<!DOCTYPE html>
<html lang="km">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>វិក័យបត្រ #00006 — School System</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: sans-serif; background: #f3f4f6; min-height: 100vh; padding: 24px 16px; }
  .wrap { max-width: 480px; margin: 0 auto; }

  .dots { display: flex; gap: 8px; justify-content: center; margin-bottom: 20px; }
  .dot { width: 10px; height: 10px; border-radius: 50%; background: #d1d5db; transition: background 0.3s; }
  .dot.active-purple { background: #3730a3; }
  .dot.active-green  { background: #166534; }

  .card { background: #fff; border-radius: 14px; overflow: hidden; border: 1px solid #e5e7eb; }
  .card-head-purple { background: #3730a3; padding: 18px 20px; color: #fff; }
  .card-head-purple h1 { font-size: 17px; font-weight: 600; }
  .card-head-purple .sub { font-size: 11px; opacity: .75; margin-top: 2px; }
  .card-head-center { background: #3730a3; padding: 14px 20px; color: #fff; text-align: center; }
  .card-head-center .title { font-size: 15px; font-weight: 600; }
  .card-head-center .sub  { font-size: 11px; opacity: .75; margin-top: 2px; }
  .card-body { padding: 18px 20px; }
  .card-foot-green { background: #166534; padding: 10px; text-align: center; color: rgba(255,255,255,.85); font-size: 12px; }

  .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 14px; }
  .info-box { border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px; }
  .info-box .label { font-size: 11px; color: #6b7280; margin-bottom: 4px; }
  .info-box .val   { font-size: 14px; font-weight: 600; color: #3730a3; }
  .info-box .sub   { font-size: 11px; color: #6b7280; margin-top: 3px; }
  .badge-wait   { display: inline-block; margin-top: 4px; background: #fef9c3; color: #854d0e; font-size: 11px; padding: 2px 8px; border-radius: 20px; }
  .badge-done   { display: inline-block; margin-top: 4px; background: #dcfce7; color: #166534; font-size: 11px; padding: 2px 8px; border-radius: 20px; }

  .items-box { border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px; margin-bottom: 12px; }
  .items-box .label { font-size: 12px; font-weight: 600; color: #92400e; margin-bottom: 6px; }
  .items-box .item  { font-size: 13px; color: #111; }

  .total-bar { background: #166534; border-radius: 10px; padding: 12px 16px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; }
  .total-bar .t-label { color: rgba(255,255,255,.85); font-size: 12px; }
  .total-bar .t-amount { color: #fff; font-size: 22px; font-weight: 700; }

  .btn-purple { width: 100%; padding: 12px; background: #3730a3; color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; }
  .btn-purple:hover { background: #312e81; }
  .btn-green  { width: 100%; padding: 12px; background: #166534; color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; margin-bottom: 8px; }
  .btn-green:hover { background: #14532d; }
  .btn-ghost  { width: 100%; padding: 10px; background: transparent; color: #6b7280; border: 1px solid #d1d5db; border-radius: 10px; font-size: 13px; cursor: pointer; }
  .btn-ghost:hover { background: #f9fafb; }

  .qr-center { display: flex; justify-content: center; margin: 12px 0; }
  .amount-row { background: #f9fafb; border-radius: 10px; padding: 10px 16px; margin-bottom: 16px; display: flex; justify-content: space-between; }
  .amount-row .a-label { font-size: 13px; color: #6b7280; }
  .amount-row .a-val   { font-size: 15px; font-weight: 600; color: #166534; }

  .success-icon { width: 64px; height: 64px; border-radius: 50%; background: #dcfce7; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 28px; }
  .success-title { font-size: 18px; font-weight: 700; color: #166534; margin-bottom: 6px; text-align: center; }
  .success-sub   { font-size: 13px; color: #6b7280; text-align: center; margin-bottom: 20px; }
  .success-meta  { background: #f9fafb; border-radius: 10px; padding: 12px; margin-bottom: 20px; font-size: 13px; color: #6b7280; text-align: center; }
  .btn-purple-sm { padding: 10px 24px; background: #3730a3; color: #fff; border: none; border-radius: 10px; font-size: 13px; cursor: pointer; display: block; margin: 0 auto; }

  .settings { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 14px 16px; margin-top: 16px; }
  .settings .s-title { font-size: 12px; font-weight: 600; color: #6b7280; margin-bottom: 10px; }
  .settings .s-grid  { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
  .settings label    { font-size: 11px; color: #6b7280; display: block; margin-bottom: 3px; }
  .settings input    { width: 100%; font-size: 13px; padding: 7px 9px; border: 1px solid #d1d5db; border-radius: 7px; outline: none; }
  .settings input:focus { border-color: #3730a3; }

  .step { display: none; }
  .step.active { display: block; }

  .head-row { display: flex; justify-content: space-between; align-items: flex-start; }
  .invoice-badge { background: rgba(255,255,255,.15); border-radius: 8px; padding: 6px 12px; font-size: 13px; font-weight: 600; }
  .invoice-date  { font-size: 11px; opacity: .75; margin-top: 5px; text-align: right; }
</style>
</head>
<body>
<div class="wrap">

  <div class="dots">
    <div class="dot active-purple" id="dot1"></div>
    <div class="dot" id="dot2"></div>
    <div class="dot" id="dot3"></div>
  </div>

  <!-- Step 1: Receipt -->
  <div class="step active" id="stepReceipt">
    <div class="card">
      <div class="card-head-purple">
        <div class="head-row">
          <div>
            <h1>🏫 SCHOOL SYSTEM</h1>
            <div class="sub">Street 214, BKK1, Phnom Penh</div>
            <div class="sub">Tel: +855 23 456 789</div>
          </div>
          <div>
            <div class="invoice-badge">វិក័យបត្រ #00006</div>
            <div class="invoice-date">23/04/2026 01:43</div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="grid2">
          <div class="info-box">
            <div class="label">👤 អតិថិជន</div>
            <div class="val">Admin</div>
            <div class="sub">admin@school.com</div>
          </div>
          <div class="info-box">
            <div class="label">💳 ការទូទាត់</div>
            <div class="val">QR Code</div>
            <span class="badge-wait">⏳ រង់ចាំ</span>
          </div>
        </div>
        <div class="items-box">
          <div class="label">📦 វត្ថុបញ្ជា</div>
          <div class="item">• HTML CSS &amp; JS Book x1</div>
        </div>
        <div class="total-bar">
          <div class="t-label">សរុបទូទាត់</div>
          <div class="t-amount">$12.00</div>
        </div>
        <button class="btn-purple" onclick="showQR()">បង្ហាញ QR សម្រាប់ទូទាត់</button>
      </div>
      <div class="card-foot-green">សូមអរគុណចំពោះការទិញ! 🙏</div>
    </div>
  </div>

  <!-- Step 2: QR -->
  <div class="step" id="stepQR">
    <div class="card">
      <div class="card-head-center">
        <div class="title">ស្កែន QR ដើម្បីទូទាត់</div>
        <div class="sub">វិក័យបត្រ #00006 — $12.00</div>
      </div>
      <div class="card-body" style="text-align:center;">
        <div style="font-size:12px;color:#6b7280;margin-bottom:8px;">ទូទាត់ទៅ</div>
        <div style="font-size:16px;font-weight:700;color:#3730a3;margin-bottom:3px;" id="displayName">School System</div>
        <div style="font-size:13px;color:#6b7280;margin-bottom:16px;" id="displayAccount">+855 23 456 789</div>
        <div class="qr-center"><div id="qrCode"></div></div>
        <div style="font-size:11px;color:#9ca3af;margin-top:10px;margin-bottom:16px;">ស្កែនតាម ABA / WING / ACLEDA / TrueMoney</div>
        <div class="amount-row">
          <span class="a-label">ចំនួនទឹកប្រាក់</span>
          <span class="a-val">$12.00</span>
        </div>
        <button class="btn-green" onclick="confirmPaid()">បញ្ជាក់ការទូទាត់</button>
        <button class="btn-ghost" onclick="backToReceipt()">ត្រលប់ក្រោយ</button>
      </div>
    </div>
  </div>

  <!-- Step 3: Done -->
  <div class="step" id="stepDone">
    <div class="card">
      <div class="card-body" style="padding: 40px 24px; text-align:center;">
        <div class="success-icon">✓</div>
        <div class="success-title">ទូទាត់បានជោគជ័យ!</div>
        <div class="success-sub">វិក័យបត្រ #00006 — $12.00</div>
        <div class="success-meta">23/04/2026 · QR Code · <span id="doneAccount">+855 23 456 789</span></div>
        <button class="btn-purple-sm" onclick="resetAll()">បង្កើតវិក័យបត្រថ្មី</button>
      </div>
    </div>
  </div>

  <!-- Settings -->
  <div class="settings">
    <div class="s-title">ការកំណត់ QR (ផ្ទាល់ខ្លួន)</div>
    <div class="s-grid">
      <div>
        <label>ឈ្មោះ</label>
        <input id="inputName" type="text" value="School System" />
      </div>
      <div>
        <label>លេខទូរស័ព្ទ / គណនី</label>
        <input id="inputAccount" type="text" value="+855 23 456 789" />
      </div>
    </div>
  </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
let qrGenerated = false;

function setDots(active) {
  ['dot1','dot2','dot3'].forEach((id, i) => {
    document.getElementById(id).className = 'dot';
  });
  if (active === 1) document.getElementById('dot1').classList.add('active-purple');
  if (active === 2) document.getElementById('dot2').classList.add('active-purple');
  if (active === 3) document.getElementById('dot3').classList.add('active-green');
}

function showStep(id) {
  ['stepReceipt','stepQR','stepDone'].forEach(s => {
    document.getElementById(s).classList.remove('active');
  });
  document.getElementById(id).classList.add('active');
}

function showQR() {
  const name    = document.getElementById('inputName').value    || 'School System';
  const account = document.getElementById('inputAccount').value || '+855 23 456 789';
  document.getElementById('displayName').textContent    = name;
  document.getElementById('displayAccount').textContent = account;
  document.getElementById('doneAccount').textContent    = account;

  if (!qrGenerated) {
    const qrData = name + '\n' + account + '\nAmount: $12.00\nInvoice: #00006';
    new QRCode(document.getElementById('qrCode'), {
      text: qrData, width: 200, height: 200,
      colorDark: '#1e1b4b', colorLight: '#ffffff',
      correctLevel: QRCode.CorrectLevel.M
    });
    qrGenerated = true;
  }

  showStep('stepQR');
  setDots(2);
}

function confirmPaid() {
  showStep('stepDone');
  setDots(3);
}

function backToReceipt() {
  showStep('stepReceipt');
  setDots(1);
}

function resetAll() {
  qrGenerated = false;
  document.getElementById('qrCode').innerHTML = '';
  showStep('stepReceipt');
  setDots(1);
}
</script>
</body>
</html>--}}

