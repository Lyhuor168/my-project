@extends('layouts.master')

@section('title', 'ទំនាក់ទំនង - Contact Us')

@section('content')
<style>
    .ct-wrap { padding: 0; }

    /* ── Hero ── */
    .ct-hero {
        background: linear-gradient(135deg, #1a237e 0%, #283593 55%, #3949ab 100%);
        padding: 5rem 2.5rem 5rem;
        text-align: center; position: relative; overflow: hidden;
    }
    .ct-hero::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(ellipse 70% 60% at 50% 0%, rgba(255,255,255,0.07) 0%, transparent 60%);
    }
    .ct-hero::after {
        content: ''; position: absolute; bottom: -2px; left: 0; right: 0;
        height: 60px; background: #f4f7fc;
        clip-path: ellipse(55% 100% at 50% 100%);
    }
    .ct-hero-inner { position: relative; z-index: 2; max-width: 600px; margin: 0 auto; }
    .ct-hero-badge {
        display: inline-flex; align-items: center; gap: 7px;
        background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22);
        color: rgba(255,255,255,0.9); font-size: 0.72rem; font-weight: 700;
        letter-spacing: 0.14em; text-transform: uppercase;
        padding: 5px 16px; border-radius: 20px; margin-bottom: 1.25rem;
    }
    .ct-hero h1 { font-size: clamp(2rem,5vw,3rem); font-weight: 700; color: #fff; line-height: 1.2; margin-bottom: 1rem; }
    .ct-hero h1 span { background: linear-gradient(90deg,#ffca28,#ffe082); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    .ct-hero p { font-size: 1rem; color: rgba(255,255,255,0.65); line-height: 1.8; }

    /* ── Body ── */
    .ct-body { max-width: 1100px; margin: 0 auto; padding: 4rem 2rem 5rem; }

    /* ── Layout ── */
    .ct-layout { display: grid; grid-template-columns: 1fr 360px; gap: 2rem; align-items: start; margin-bottom: 4rem; }
    @media(max-width:860px){ .ct-layout { grid-template-columns: 1fr; } }

    /* ── Form Card ── */
    .ct-form-card {
        background: #fff; border-radius: 20px;
        border: 1px solid rgba(26,35,126,0.07);
        box-shadow: 0 4px 24px rgba(26,35,126,0.06); overflow: hidden;
        opacity: 0; transform: translateY(22px);
        transition: opacity 0.5s, transform 0.5s;
    }
    .ct-form-card.show { opacity: 1; transform: translateY(0); }
    .ct-form-head { padding: 1.25rem 1.75rem; border-bottom: 1px solid rgba(26,35,126,0.07); background: #fafbff; display: flex; align-items: center; gap: 10px; }
    .ct-form-head h4 { font-size: 1rem; font-weight: 700; color: #1a237e; margin: 0; }
    .ct-form-body { padding: 1.75rem; }

    /* Fields */
    .ct-field { display: flex; flex-direction: column; gap: 5px; margin-bottom: 1.1rem; }
    .ct-field label { font-size: 0.72rem; font-weight: 800; color: #374151; letter-spacing: 0.09em; text-transform: uppercase; display: flex; align-items: center; gap: 5px; }
    .ct-field label .req { color: #e11d48; }
    .iw { position: relative; }
    .iw .fi { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.85rem; pointer-events: none; transition: color 0.18s; }
    .iw:focus-within .fi { color: #1a237e; }
    .ct-input, .ct-select, .ct-textarea {
        width: 100%; padding: 11px 13px 11px 36px;
        background: #f8faff; border: 1.5px solid rgba(26,35,126,0.1); border-radius: 10px;
        font-family: 'Kantumruy Pro','Outfit',sans-serif; font-size: 0.875rem; color: #111827;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .ct-textarea { padding-left: 13px; resize: vertical; min-height: 130px; }
    .ct-select { cursor: pointer; }
    .ct-input::placeholder, .ct-textarea::placeholder { color: #9ca3af; }
    .ct-input:focus, .ct-select:focus, .ct-textarea:focus { outline: none; border-color: #1a237e; box-shadow: 0 0 0 3px rgba(26,35,126,0.1); background: #fff; }
    .ct-row2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    @media(max-width:500px){ .ct-row2 { grid-template-columns: 1fr; } }

    /* Submit */
    .ct-submit {
        width: 100%; padding: 13px;
        background: linear-gradient(135deg, #1a237e, #3949ab);
        color: #fff; border: none; border-radius: 12px;
        font-family: 'Kantumruy Pro','Outfit',sans-serif;
        font-size: 0.9rem; font-weight: 800; cursor: pointer; letter-spacing: 0.04em;
        box-shadow: 0 6px 24px rgba(26,35,126,0.28);
        transition: opacity 0.15s, transform 0.12s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .ct-submit:hover { opacity: 0.92; transform: translateY(-1px); }

    /* Success */
    .ct-success { display: none; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 2.5rem 1rem; gap: 0.85rem; }
    .ct-success.show { display: flex; animation: fuUp 0.4s ease both; }
    @keyframes fuUp { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
    .ct-success-ring { width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg,#059669,#34d399); display: flex; align-items: center; justify-content: center; font-size: 1.6rem; box-shadow: 0 8px 28px rgba(52,211,153,0.35); }
    .ct-success h4 { font-size: 1.2rem; font-weight: 700; color: #1a237e; }
    .ct-success p  { font-size: 0.83rem; color: #6b7280; }
    .ct-reset-btn { background: #e8eaf6; border: none; color: #1a237e; font-family: 'Kantumruy Pro','Outfit',sans-serif; font-weight: 700; font-size: 0.82rem; padding: 8px 18px; border-radius: 50px; cursor: pointer; margin-top: 4px; }

    /* ── Info Cards ── */
    .ct-info-col { display: flex; flex-direction: column; gap: 1.1rem; }
    .ct-info-card {
        background: #fff; border-radius: 16px;
        border: 1px solid rgba(26,35,126,0.07);
        box-shadow: 0 3px 16px rgba(26,35,126,0.05); padding: 1.25rem 1.4rem;
        opacity: 0; transform: translateY(20px);
        transition: opacity 0.5s, transform 0.5s, box-shadow 0.22s;
    }
    .ct-info-card.show { opacity: 1; transform: translateY(0); }
    .ct-info-card:hover { box-shadow: 0 10px 32px rgba(26,35,126,0.09); transform: translateY(-3px); }
    .ct-info-row { display: flex; align-items: flex-start; gap: 1rem; }
    .ct-info-ico { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
    .ct-info-text h5 { font-size: 0.88rem; font-weight: 700; color: #1a237e; margin-bottom: 4px; }
    .ct-info-text p  { font-size: 0.8rem; color: #6b7280; margin: 0; line-height: 1.65; }
    .ct-info-text a  { color: #1a237e; text-decoration: none; font-weight: 600; }
    .ct-info-text a:hover { text-decoration: underline; }

    /* Hours */
    .ct-hours { width: 100%; border-collapse: collapse; font-size: 0.79rem; margin-top: 0.6rem; }
    .ct-hours tr { border-bottom: 1px solid rgba(26,35,126,0.06); }
    .ct-hours tr:last-child { border-bottom: none; }
    .ct-hours td { padding: 5px 0; color: #6b7280; }
    .ct-hours td:last-child { text-align: right; font-weight: 700; color: #1a237e; }
    .ct-hours .off td { color: #9ca3af; }

    /* Socials */
    .ct-socials { display: flex; gap: 7px; flex-wrap: wrap; margin-top: 0.7rem; }
    .ct-soc { display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; border-radius: 9px; font-size: 0.75rem; font-weight: 700; text-decoration: none; border: 1.5px solid rgba(26,35,126,0.1); color: #374151; background: #f8faff; transition: all 0.15s; }
    .ct-soc:hover { background: #e8eaf6; border-color: #1a237e; color: #1a237e; }

    /* ── Map ── */
    .ct-map {
        background: linear-gradient(135deg,#e8eaf6,#c5cae9);
        border-radius: 20px; padding: 3rem 2rem; text-align: center;
        border: 1px solid rgba(26,35,126,0.1); margin-bottom: 4rem;
        opacity: 0; transform: translateY(18px);
        transition: opacity 0.5s, transform 0.5s;
    }
    .ct-map.show { opacity: 1; transform: translateY(0); }
    .ct-map-ico { font-size: 3rem; margin-bottom: 1rem; }
    .ct-map h3 { font-size: 1.3rem; font-weight: 700; color: #1a237e; margin-bottom: 0.5rem; }
    .ct-map p  { font-size: 0.85rem; color: #3949ab; line-height: 1.7; margin-bottom: 1.5rem; }
    .ct-map-btn { display: inline-flex; align-items: center; gap: 8px; background: #1a237e; color: #fff; border: none; border-radius: 50px; padding: 11px 24px; font-size: 0.875rem; font-weight: 700; text-decoration: none; transition: opacity 0.15s, transform 0.12s; }
    .ct-map-btn:hover { opacity: 0.9; transform: translateY(-1px); color: #fff; }

    @media(max-width:600px){ .ct-body { padding: 2.5rem 1.25rem 3rem; } }
</style>

<div class="ct-wrap">

    {{-- Hero --}}
    <div class="ct-hero">
        <div class="ct-hero-inner">
            <div class="ct-hero-badge">📞 Contact Us</div>
            <h1>ទំនាក់<span>ទំនង</span>យើង</h1>
            <p>មាន​សំណួរ​ ឬ​ ត្រូវ​ ការ​ ជំនួយ? យើង​ ត្រៀម​ ខ្លួន​ ជួយ​ អ្នក​ ២៤/៧ !</p>
        </div>
    </div>

    <div class="ct-body">

        <div class="ct-layout">

            {{-- ══ FORM ══ --}}
            <div class="ct-form-card" id="ctCard">
                <div class="ct-form-head">
                    <i class="fas fa-paper-plane" style="color:#1a237e;"></i>
                    <h4>📩 ផ្ញើ​សារ​មក​យើង</h4>
                </div>
                <div class="ct-form-body">

                    <div id="theForm">
                        <div class="ct-row2">
                            <div class="ct-field">
                                <label>ឈ្មោះ <span class="req">*</span></label>
                                <div class="iw">
                                    <i class="fas fa-user fi"></i>
                                    <input type="text" class="ct-input" id="ctName" placeholder="ឈ្មោះ​របស់​អ្នក"/>
                                </div>
                            </div>
                            <div class="ct-field">
                                <label>Email <span class="req">*</span></label>
                                <div class="iw">
                                    <i class="fas fa-envelope fi"></i>
                                    <input type="email" class="ct-input" id="ctEmail" placeholder="you@email.com"/>
                                </div>
                            </div>
                        </div>

                        <div class="ct-field">
                            <label>ទូរស័ព្ទ <span style="opacity:.4;font-size:.9em;text-transform:none">(optional)</span></label>
                            <div class="iw">
                                <i class="fas fa-phone fi"></i>
                                <input type="tel" class="ct-input" id="ctPhone" placeholder="012 345 678"/>
                            </div>
                        </div>

                        <div class="ct-field">
                            <label>ប្រធានបទ <span class="req">*</span></label>
                            <div class="iw">
                                <i class="fas fa-tag fi"></i>
                                <select class="ct-select" id="ctSubject">
                                    <option value="">-- ជ្រើស​ប្រធានបទ --</option>
                                    <option>💬 សំណួរ​ទូទៅ</option>
                                    <option>📚 ព័ត៌មាន​មុខ​វិជ្ជា</option>
                                    <option>💳 ការ​ចុះ​ឈ្មោះ​ & ថ្លៃ</option>
                                    <option>🛒 ការ​ទិញ​សៀវ​ភៅ</option>
                                    <option>🔧 បញ្ហា​បច្ចេក​ទេស</option>
                                    <option>🤝 ការ​ សហការ</option>
                                    <option>📋 ផ្សេង​ ៗ</option>
                                </select>
                            </div>
                        </div>

                        <div class="ct-field">
                            <label>សារ <span class="req">*</span></label>
                            <textarea class="ct-textarea" id="ctMsg"
                                placeholder="សូម​សរសេរ​សារ​របស់​អ្នក​នៅ​ទីនេះ..."></textarea>
                        </div>

                        <button class="ct-submit" onclick="submitContact()">
                            <i class="fas fa-paper-plane"></i> ផ្ញើ​សារ
                        </button>
                    </div>

                    <div class="ct-success" id="ctSuccess">
                        <div class="ct-success-ring">✅</div>
                        <h4>សារ​បាន​ផ្ញើ​ ជោគជ័យ!</h4>
                        <p>អរ​គុណ​! យើង​នឹង​ឆ្លើយ​តប​ ក្នុង​ ២៤​ ម៉ោង ។</p>
                        <button class="ct-reset-btn" onclick="resetContact()">← ផ្ញើ​ម្ដង​ទៀត</button>
                    </div>

                </div>
            </div>

            {{-- ══ INFO ══ --}}
            <div class="ct-info-col">

                <div class="ct-info-card" style="transition-delay:.08s">
                    <div class="ct-info-row">
                        <div class="ct-info-ico" style="background:#e8eaf6;">📍</div>
                        <div class="ct-info-text">
                            <h5>អាស​យ​ដ្ឋាន</h5>
                            <p>ផ្លូវ ១០០ ជ្រោយ​ចង​វារ<br>ភ្នំ​ពេញ​ ប្រ​ចំ​ ទីក្រុង​ កម្ពុជា</p>
                        </div>
                    </div>
                </div>

                <div class="ct-info-card" style="transition-delay:.16s">
                    <div class="ct-info-row">
                        <div class="ct-info-ico" style="background:#e0f2f1;">📞</div>
                        <div class="ct-info-text">
                            <h5>ទូរស័ព្ទ</h5>
                            <p>
                                <a href="tel:+85512345678">+855 12 345 678</a><br>
                                <a href="tel:+85523456789">+855 23 456 789</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="ct-info-card" style="transition-delay:.24s">
                    <div class="ct-info-row">
                        <div class="ct-info-ico" style="background:#fff3e0;">✉️</div>
                        <div class="ct-info-text">
                            <h5>Email</h5>
                            <p>
                                <a href="mailto:info@school.edu.kh">info@school.edu.kh</a><br>
                                <a href="mailto:support@school.edu.kh">support@school.edu.kh</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="ct-info-card" style="transition-delay:.32s">
                    <div class="ct-info-row">
                        <div class="ct-info-ico" style="background:#f3e5f5;">🕐</div>
                        <div class="ct-info-text"><h5>ម៉ោង​ធ្វើ​ការ</h5></div>
                    </div>
                    <table class="ct-hours">
                        <tr><td>ច័ន្ទ – សុក្រ</td><td>07:00 – 21:00</td></tr>
                        <tr><td>សៅរ៍</td><td>08:00 – 17:00</td></tr>
                        <tr class="off"><td>អាទិត្យ</td><td>បិទ</td></tr>
                    </table>
                </div>

                <div class="ct-info-card" style="transition-delay:.4s">
                    <div class="ct-info-row">
                        <div class="ct-info-ico" style="background:#fce4ec;">🌐</div>
                        <div class="ct-info-text"><h5>Social Media</h5></div>
                    </div>
                    <div class="ct-socials">
                            <a href="https://www.facebook.com/lyhuo.heoun" target="_blank" class="ct-soc">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                        <a href="https://t.me/lyhuo_heoun" target="_blank" class="ct-soc">
                            <i class="fab fa-telegram-plane"></i> Telegram
                        </a>
                        <a href=" https://VANNDA.lnk.to/SkullTheAlbum" target="_blank" class="ct-soc">
                            <i class="fab fa-youtube"></i> YouTube
                        </a>
                    </div>
                </div>

            </div>
        </div>

        {{-- Map --}}
        <div class="ct-map" id="ctMap">
            <div class="ct-map-ico">🗺️</div>
            <h3>រក​ ទី​ តាំង​ យើង</h3>
            <p>យើង​ ស្ថិត​ ក្នុង​ ភ្នំ​ ពេញ​ — ងាយ​ ស្រួល​ ទៅ​ ដល់​ ដោយ​ ប្រើ​ Google Maps</p>
            <a href="https://maps.google.com" target="_blank" class="ct-map-btn">
                <i class="fas fa-map-marker-alt"></i> បើក​ Google Maps
            </a>
        </div>

    </div>
</div>

<script>
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('show'); io.unobserve(e.target); } });
    }, { threshold: 0.08 });
    document.querySelectorAll('.ct-form-card,.ct-info-card,.ct-map').forEach(el => io.observe(el));

    function submitContact() {
        const n = document.getElementById('ctName').value.trim();
        const e = document.getElementById('ctEmail').value.trim();
        const s = document.getElementById('ctSubject').value;
        const m = document.getElementById('ctMsg').value.trim();
        if (!n || !e || !s || !m) { alert('សូម​បំពេញ​ ព័ត៌មាន (*) ឲ​គ្រប់!'); return; }
        if (!e.includes('@')) { alert('Email មិន​ត្រឹម​ត្រូវ!'); return; }
        document.getElementById('theForm').style.display = 'none';
        document.getElementById('ctSuccess').classList.add('show');
    }

    function resetContact() {
        ['ctName','ctEmail','ctPhone','ctMsg'].forEach(id => document.getElementById(id).value = '');
        document.getElementById('ctSubject').value = '';
        document.getElementById('ctSuccess').classList.remove('show');
        document.getElementById('theForm').style.display = 'block';
    }
</script>

@endsection
