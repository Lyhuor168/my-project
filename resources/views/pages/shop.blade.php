@extends('layouts.master')

@section('title', 'ហាង - Shop')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Outfit:wght@300;400;500;600;700&display=swap');

    .sp-page {
        font-family: 'Outfit', sans-serif;
        background: #f4f7fc;
        min-height: 100vh;
    }

    .sp-hero {
        background: linear-gradient(135deg, #0b1e3d 0%, #122a54 55%, #1c64b1 100%);
        padding: 5rem 2rem 4rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .sp-hero::before {
        content: '';
        position: absolute; left: 50%; top: -120px;
        transform: translateX(-50%);
        width: 600px; height: 600px; border-radius: 50%;
        background: radial-gradient(circle, rgba(59,158,255,0.12) 0%, transparent 70%);
        pointer-events: none;
    }
    .sp-hero::after {
        content: '';
        position: absolute; right: -80px; bottom: -80px;
        width: 320px; height: 320px; border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.05);
        pointer-events: none;
    }
    .sp-hero-inner { position: relative; z-index: 2; }
    .sp-badge {
        display: inline-flex; align-items: center; gap: 7px;
        background: rgba(59,158,255,0.15);
        border: 1px solid rgba(59,158,255,0.3);
        color: #3b9eff; font-size: 0.72rem; font-weight: 600;
        letter-spacing: 0.15em; text-transform: uppercase;
        padding: 5px 16px; border-radius: 20px; margin-bottom: 1.25rem;
    }
    .sp-hero h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2.4rem, 5vw, 4rem);
        font-weight: 700; color: #fff;
        margin-bottom: 0.75rem; line-height: 1.15;
    }
    .sp-hero h1 span {
        background: linear-gradient(90deg, #e8a020, #ffd270);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .sp-hero p {
        color: rgba(255,255,255,0.52);
        font-size: 1rem; max-width: 520px;
        margin: 0 auto 2rem; line-height: 1.75;
    }
    .sp-hero-stats {
        display: inline-flex; align-items: center;
        gap: 0; border-radius: 14px; overflow: hidden;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .sp-hstat {
        padding: 0.75rem 1.5rem;
        background: rgba(255,255,255,0.07);
        text-align: center; border-right: 1px solid rgba(255,255,255,0.08);
    }
    .sp-hstat:last-child { border-right: none; }
    .sp-hstat strong {
        display: block;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.5rem; font-weight: 700;
        color: #ffd270; line-height: 1;
    }
    .sp-hstat span { font-size: 0.72rem; color: rgba(255,255,255,0.45); letter-spacing: 0.05em; }

    .sp-wrap { max-width: 1280px; margin: 0 auto; padding: 3rem 2rem 4rem; }

    .sp-toolbar {
        display: flex; align-items: center; gap: 1rem;
        flex-wrap: wrap; margin-bottom: 2rem;
        background: #fff; border-radius: 16px;
        padding: 1rem 1.25rem;
        border: 1px solid rgba(11,30,61,0.07);
        box-shadow: 0 4px 20px rgba(11,30,61,0.05);
        opacity: 0; transform: translateY(14px);
        transition: opacity 0.5s, transform 0.5s;
    }
    .sp-toolbar.visible { opacity: 1; transform: translateY(0); }

    .sp-search-wrap { position: relative; flex: 1; min-width: 180px; }
    .sp-search-wrap svg {
        position: absolute; left: 12px; top: 50%;
        transform: translateY(-50%); width: 15px; height: 15px;
        color: #8898b5; pointer-events: none; transition: color 0.2s;
    }
    .sp-search-wrap:focus-within svg { color: #1c64b1; }
    .sp-search {
        width: 100%; padding: 9px 12px 9px 36px;
        background: #f4f7fc; border: 1px solid rgba(11,30,61,0.09);
        border-radius: 10px; font-family: 'Outfit', sans-serif;
        font-size: 0.87rem; color: #0b1e3d;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .sp-search::placeholder { color: #8898b5; }
    .sp-search:focus { outline: none; border-color: #1c64b1; box-shadow: 0 0 0 3px rgba(28,100,177,0.1); background: #fff; }

    .sp-cats { display: flex; gap: 7px; flex-wrap: wrap; }
    .sp-cat {
        padding: 7px 15px; border-radius: 50px;
        font-size: 0.78rem; font-weight: 600;
        cursor: pointer; font-family: 'Outfit', sans-serif;
        border: 1.5px solid rgba(11,30,61,0.1);
        background: transparent; color: #8898b5;
        transition: all 0.16s; white-space: nowrap;
    }
    .sp-cat:hover { border-color: #1c64b1; color: #1c64b1; background: #e8f0fb; }
    .sp-cat.active { background: #1c64b1; border-color: #1c64b1; color: #fff; box-shadow: 0 4px 12px rgba(28,100,177,0.25); }

    .sp-sort {
        padding: 9px 12px; background: #f4f7fc;
        border: 1px solid rgba(11,30,61,0.09); border-radius: 10px;
        font-family: 'Outfit', sans-serif; font-size: 0.84rem;
        color: #0b1e3d; cursor: pointer; outline: none;
        transition: border-color 0.2s;
    }
    .sp-sort:focus { border-color: #1c64b1; }

    .sp-cart-btn {
        position: relative; display: inline-flex;
        align-items: center; gap: 7px;
        background: #0b1e3d; color: #fff;
        border: none; border-radius: 10px;
        padding: 9px 18px; font-family: 'Outfit', sans-serif;
        font-size: 0.85rem; font-weight: 600;
        cursor: pointer; white-space: nowrap;
        transition: background 0.2s, transform 0.12s;
    }
    .sp-cart-btn:hover { background: #1c64b1; transform: translateY(-1px); }
    .sp-cart-count {
        position: absolute; top: -7px; right: -7px;
        width: 19px; height: 19px; border-radius: 50%;
        background: #e8a020; color: #fff;
        font-size: 0.65rem; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        border: 2px solid #fff;
        transition: transform 0.2s;
    }
    .sp-cart-count.bump { animation: bump 0.3s cubic-bezier(0.34,1.56,0.64,1); }
    @keyframes bump { 0%{transform:scale(1)} 50%{transform:scale(1.5)} 100%{transform:scale(1)} }

    .sp-count { font-size: 0.78rem; color: #8898b5; white-space: nowrap; margin-left: auto; }
    .sp-count strong { color: #0b1e3d; }

    .sp-login-banner {
        display: flex; align-items: center; justify-content: space-between;
        gap: 1rem; flex-wrap: wrap;
        background: linear-gradient(135deg, #0b1e3d, #1c64b1);
        border-radius: 16px; padding: 1.25rem 1.75rem;
        margin-bottom: 2rem;
    }
    .sp-login-banner p { color: rgba(255,255,255,0.85); font-size: 0.9rem; margin: 0; }
    .sp-login-banner strong { color: #ffd270; }
    .sp-login-link {
        display: inline-flex; align-items: center; gap: 6px;
        background: #ffd270; color: #0b1e3d;
        padding: 9px 20px; border-radius: 10px;
        font-weight: 700; font-size: 0.85rem;
        text-decoration: none; white-space: nowrap;
        transition: opacity 0.2s;
    }
    .sp-login-link:hover { opacity: 0.88; }

    .sp-section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.4rem, 3vw, 2rem);
        font-weight: 700; color: #0b1e3d;
        margin-bottom: 1.25rem; line-height: 1.2;
    }
    .sp-section-label {
        font-size: 0.72rem; font-weight: 700;
        color: #1c64b1; text-transform: uppercase;
        letter-spacing: 0.15em; margin-bottom: 0.4rem;
    }

    .sp-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .sp-card {
        background: #fff; border-radius: 18px;
        border: 1px solid rgba(11,30,61,0.07);
        overflow: hidden; position: relative;
        transition: all 0.28s ease;
        opacity: 0; transform: translateY(22px);
    }
    .sp-card.visible { opacity: 1; transform: translateY(0); }
    .sp-card:hover { transform: translateY(-6px); box-shadow: 0 24px 60px rgba(11,30,61,0.11); border-color: rgba(28,100,177,0.15); }
    .sp-card.hidden-item { display: none; }

    .sp-img-wrap {
        position: relative; overflow: hidden;
        background: #f0f4fb; height: 200px;
    }
    .sp-img-wrap img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform 0.5s ease;
    }
    .sp-card:hover .sp-img-wrap img { transform: scale(1.06); }

    .sp-img-badge {
        position: absolute; top: 12px; right: 12px;
        font-size: 0.67rem; font-weight: 700;
        padding: 4px 10px; border-radius: 20px;
        text-transform: uppercase; letter-spacing: 0.07em;
    }
    .badge-new   { background: #1c64b1; color: #fff; }
    .badge-sale  { background: #e8a020; color: #fff; }
    .badge-hot   { background: #e24b4a; color: #fff; }
    .badge-free  { background: #22c55e; color: #fff; }

    .sp-cat-badge {
        position: absolute; bottom: 12px; left: 12px;
        font-size: 0.67rem; font-weight: 600;
        padding: 4px 10px; border-radius: 20px;
        background: rgba(0,0,0,0.55); color: #fff;
    }

    .sp-wish-btn {
        position: absolute; top: 10px; left: 10px;
        width: 34px; height: 34px; border-radius: 50%;
        background: rgba(255,255,255,0.9);
        border: none; cursor: pointer; font-size: 15px;
        display: flex; align-items: center; justify-content: center;
        transition: background 0.2s, transform 0.15s;
        box-shadow: 0 2px 8px rgba(11,30,61,0.12);
    }
    .sp-wish-btn:hover { background: #fff; transform: scale(1.12); }
    .sp-wish-btn.wished { color: #e24b4a; }

    .sp-card-body { padding: 1.1rem 1.2rem 1.3rem; }
    .sp-cat-tag {
        font-size: 0.68rem; font-weight: 600;
        color: #1c64b1; text-transform: uppercase;
        letter-spacing: 0.1em; margin-bottom: 5px;
    }
    .sp-card-body h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem; font-weight: 700;
        color: #0b1e3d; line-height: 1.3; margin-bottom: 6px;
    }
    .sp-card-desc { font-size: 0.8rem; color: #8898b5; line-height: 1.6; margin-bottom: 0.9rem; }

    .sp-price-row {
        display: flex; align-items: center;
        justify-content: space-between; gap: 8px;
    }
    .sp-price {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.4rem; font-weight: 700;
        color: #0b1e3d; line-height: 1;
    }
    .sp-add-btn {
        display: inline-flex; align-items: center; gap: 5px;
        background: #0b1e3d; color: #fff;
        border: none; border-radius: 8px;
        padding: 9px 14px; font-family: 'Outfit', sans-serif;
        font-size: 0.8rem; font-weight: 600; cursor: pointer;
        transition: background 0.18s, transform 0.12s;
        white-space: nowrap; text-decoration: none;
    }
    .sp-add-btn:hover { background: #1c64b1; transform: translateY(-1px); }
    .sp-add-btn.added { background: #22c55e; }

    .sp-no-results {
        display: none; grid-column: 1/-1;
        text-align: center; padding: 4rem 1rem; color: #8898b5;
    }
    .sp-no-results .nr-icon { font-size: 3rem; margin-bottom: 1rem; }
    .sp-no-results p { font-size: 0.9rem; line-height: 1.7; }

    .sp-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(11,30,61,0.45);
        z-index: 900; backdrop-filter: blur(3px);
    }
    .sp-overlay.show { display: block; animation: fadeIn 0.2s ease; }
    @keyframes fadeIn { from{opacity:0} to{opacity:1} }

    .sp-drawer {
        position: fixed; top: 0; right: -420px;
        width: min(420px, 100vw); height: 100%;
        background: #fff; z-index: 901;
        display: flex; flex-direction: column;
        box-shadow: -12px 0 40px rgba(11,30,61,0.15);
        transition: right 0.35s cubic-bezier(0.22,1,0.36,1);
    }
    .sp-drawer.open { right: 0; }
    .sp-drawer-head {
        display: flex; align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(11,30,61,0.07);
    }
    .sp-drawer-head h4 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.25rem; font-weight: 700;
        color: #0b1e3d; margin: 0;
    }
    .sp-drawer-close {
        width: 34px; height: 34px; border-radius: 50%;
        border: 1px solid rgba(11,30,61,0.1);
        background: #f4f7fc; cursor: pointer; font-size: 16px;
        display: flex; align-items: center; justify-content: center;
        transition: background 0.15s;
    }
    .sp-drawer-close:hover { background: #e8f0fb; }
    .sp-drawer-items { flex: 1; overflow-y: auto; padding: 1rem 1.5rem; }
    .sp-drawer-empty { text-align: center; padding: 3rem 1rem; color: #8898b5; font-size: 0.9rem; }
    .sp-drawer-empty .de-icon { font-size: 2.5rem; margin-bottom: 0.75rem; }
    .sp-cart-item {
        display: flex; align-items: center; gap: 12px;
        padding: 0.9rem 0; border-bottom: 1px solid rgba(11,30,61,0.06);
        animation: slideIn 0.25s ease;
    }
    @keyframes slideIn { from{opacity:0;transform:translateX(12px)} to{opacity:1;transform:translateX(0)} }
    .sp-cart-item:last-child { border-bottom: none; }
    .sp-ci-img { width: 56px; height: 56px; border-radius: 10px; object-fit: cover; flex-shrink: 0; background: #f0f4fb; }
    .sp-ci-info { flex: 1; min-width: 0; }
    .sp-ci-info h5 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 0.95rem; font-weight: 700;
        color: #0b1e3d; margin-bottom: 3px;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .sp-ci-price { font-size: 0.82rem; font-weight: 600; color: #1c64b1; }
    .sp-ci-qty { display: flex; align-items: center; gap: 6px; }
    .sp-qty-btn {
        width: 26px; height: 26px; border-radius: 6px;
        border: 1px solid rgba(11,30,61,0.12);
        background: #f4f7fc; cursor: pointer; font-size: 15px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 600; color: #0b1e3d; transition: background 0.15s;
    }
    .sp-qty-btn:hover { background: #e8f0fb; }
    .sp-ci-qty span { font-size: 0.88rem; font-weight: 600; min-width: 18px; text-align: center; color: #0b1e3d; }
    .sp-ci-del { background: none; border: none; color: #e24b4a; cursor: pointer; font-size: 16px; padding: 4px; opacity: 0.6; transition: opacity 0.15s; }
    .sp-ci-del:hover { opacity: 1; }
    .sp-drawer-foot {
        padding: 1.25rem 1.5rem;
        border-top: 1px solid rgba(11,30,61,0.07);
        background: #f8fafd;
    }
    .sp-subtotal {
        display: flex; justify-content: space-between;
        align-items: center; margin-bottom: 1rem;
        font-size: 0.9rem; color: #8898b5;
    }
    .sp-subtotal strong {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.3rem; font-weight: 700; color: #0b1e3d;
    }
    .sp-checkout-btn {
        width: 100%; padding: 13px;
        background: linear-gradient(135deg, #0b1e3d, #1c64b1);
        color: #fff; border: none; border-radius: 12px;
        font-family: 'Outfit', sans-serif;
        font-size: 15px; font-weight: 600;
        cursor: pointer; letter-spacing: 0.03em;
        transition: opacity 0.2s, transform 0.12s;
        box-shadow: 0 6px 20px rgba(28,100,177,0.3);
    }
    .sp-checkout-btn:hover { opacity: 0.9; transform: translateY(-1px); }

    .sp-promo {
        background: linear-gradient(135deg, #e8a020, #ffd270);
        border-radius: 16px; padding: 1.5rem 2rem;
        display: flex; align-items: center;
        justify-content: space-between; gap: 1rem;
        flex-wrap: wrap; margin-bottom: 2.5rem;
        opacity: 0; transform: translateY(14px);
        transition: opacity 0.5s 0.1s, transform 0.5s 0.1s;
    }
    .sp-promo.visible { opacity: 1; transform: translateY(0); }
    .sp-promo-text h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.4rem; font-weight: 700; color: #0b1e3d; margin-bottom: 4px;
    }
    .sp-promo-text p { font-size: 0.85rem; color: rgba(11,30,61,0.65); }
    .sp-promo-code {
        background: rgba(11,30,61,0.12);
        border: 1.5px dashed rgba(11,30,61,0.3);
        border-radius: 10px; padding: 8px 18px;
        font-family: 'Outfit', sans-serif;
        font-size: 1rem; font-weight: 700;
        color: #0b1e3d; letter-spacing: 0.15em;
        cursor: pointer; transition: background 0.15s;
    }
    .sp-promo-code:hover { background: rgba(11,30,61,0.18); }

    .sp-services {
        background: #fff; border-radius: 20px;
        padding: 2.5rem 2rem; margin-top: 1rem;
        border: 1px solid rgba(11,30,61,0.07);
        box-shadow: 0 4px 20px rgba(11,30,61,0.05);
    }
    .sp-srv-label { font-size: 0.72rem; font-weight: 700; color: #1c64b1; text-transform: uppercase; letter-spacing: 0.15em; margin-bottom: 0.4rem; }
    .sp-srv-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.6rem, 3vw, 2.2rem);
        font-weight: 700; color: #0b1e3d; margin-bottom: 1.75rem; line-height: 1.2;
    }
    .sp-srv-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.25rem; }
    .sp-srv-item {
        display: flex; align-items: flex-start; gap: 1rem;
        background: #f4f7fc; border-radius: 14px;
        padding: 1.25rem 1.4rem;
        border: 1px solid rgba(11,30,61,0.06);
        transition: box-shadow 0.22s, transform 0.22s;
        opacity: 0; transform: translateY(16px);
    }
    .sp-srv-item.visible { opacity: 1; transform: translateY(0); }
    .sp-srv-item:hover { box-shadow: 0 8px 28px rgba(11,30,61,0.09); transform: translateY(-3px); }
    .sp-srv-icon { width: 48px; height: 48px; border-radius: 12px; background: #e8f5e9; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; }
    .sp-srv-text h3 { font-family: 'Outfit', sans-serif; font-size: 0.95rem; font-weight: 700; color: #0b1e3d; margin-bottom: 5px; }
    .sp-srv-text p { font-size: 0.8rem; color: #8898b5; line-height: 1.65; margin: 0; }

    @media (max-width: 640px) {
        .sp-toolbar { flex-direction: column; align-items: stretch; }
        .sp-count { margin-left: 0; }
        .sp-hstat { padding: 0.6rem 1rem; }
        .sp-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem; }
        .sp-img-wrap { height: 150px; }
    }
</style>

<div class="sp-page">

    {{-- ══ HERO ══ --}}
    <div class="sp-hero">
        <div class="sp-hero-inner">
            <div class="sp-badge">🛒 For Sale</div>
            <h1>ហាង<span>លក់ទំនិញ</span></h1>
            <p>ស្វែងរករបស់ សៀវភៅ និងឧបករណ៍ IT ដែលអ្នកត្រូវការ</p>
            <div class="sp-hero-stats">
                <div class="sp-hstat"><strong>250+</strong><span>Products</span></div>
                <div class="sp-hstat"><strong>98%</strong><span>Satisfied</span></div>
                <div class="sp-hstat"><strong>24h</strong><span>Delivery</span></div>
                <div class="sp-hstat"><strong>Free</strong><span>Returns</span></div>
            </div>
        </div>
    </div>

    <div class="sp-wrap">

        {{-- ══ PROMO BANNER ══ --}}
        <div class="sp-promo" id="promoBanner">
            <div class="sp-promo-text">
                <h3>🎉 ការផ្តល់ជូនពិសេស — ៣០% OFF</h3>
                <p>ប្រើកូដនេះចំពោះការទិញលើ $20 ទៅ! សុពលភាព: ៣១ ធ្នូ</p>
            </div>
            <div class="sp-promo-code" onclick="copyCode(this)" title="ចុចដើម្បីចម្លង">SCHOOL30</div>
        </div>

        {{-- ══ LOGIN BANNER (guest only) ══ --}}
        @guest
        <div class="sp-login-banner">
            <p>🔒 សូម <strong>Login</strong> ជាមុនសិន ដើម្បីអាចបន្ថែមទំនិញទៅក្នុងកន្ត្រក!</p>
            <a href="{{ route('login') }}" class="sp-login-link">🔑 Login ឥឡូវ</a>
        </div>
        @endguest

        {{-- ══ TOOLBAR ══ --}}
        <div class="sp-toolbar" id="shopToolbar">
            <div class="sp-search-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
                <input type="text" class="sp-search" id="shopSearch" placeholder="ស្វែងរកផលិតផល..." oninput="filterProducts()"/>
            </div>
            <div class="sp-cats">
                <button class="sp-cat active" data-cat="all"    onclick="setCat(this,'all')">🗂 ទាំងអស់</button>
                <button class="sp-cat"        data-cat="book"   onclick="setCat(this,'book')">📚 សៀវភៅ</button>
                <button class="sp-cat"        data-cat="course" onclick="setCat(this,'course')">🎓 Course</button>
            </div>
            <select class="sp-sort" id="shopSort" onchange="filterProducts()">
                <option value="default">តម្រៀបតាម...</option>
                <option value="price-asc">តម្លៃ: ទាប→ខ្ពស់</option>
                <option value="price-desc">តម្លៃ: ខ្ពស់→ទាប</option>
                <option value="name">ឈ្មោះ A→Z</option>
            </select>
            <button class="sp-cart-btn" onclick="toggleCart()">
                🛒 កន្ត្រក
                <span class="sp-cart-count" id="cartCount">0</span>
            </button>
            <div class="sp-count">
                បង្ហាញ <strong id="visibleCount">0</strong> / <strong id="totalCount">0</strong>
            </div>
        </div>

        {{-- ══ BOOKS SECTION ══ --}}
        @if($books->count() > 0)
        <div class="sp-section-label">សៀវភៅ</div>
        <h2 class="sp-section-title">សៀវភៅដែលមានលក់</h2>
        <div class="sp-grid" id="productGrid">
            @foreach($books as $i => $book)
            <div class="sp-card"
                 data-name="{{ strtolower($book->title) }}"
                 data-cat="book"
                 data-price="{{ $book->price }}"
                 data-rating="5"
                 style="transition-delay:{{ $i * 0.06 }}s">
                <div class="sp-img-wrap">
                    @if($book->image)
                        <img src="{{ asset('storage/'.$book->image) }}" alt="{{ $book->title }}"/>
                    @else
                        <img src="https://images.pexels.com/photos/159711/books-bookstore-book-reading-159711.jpeg?auto=compress&cs=tinysrgb&w=400" alt="{{ $book->title }}"/>
                    @endif
                    <span class="sp-cat-badge">📚 សៀវភៅ</span>
                    <button class="sp-wish-btn" onclick="toggleWish(this)">🤍</button>
                </div>
                <div class="sp-card-body">
                    <div class="sp-cat-tag">📚 {{ $book->category }}</div>
                    <h3>{{ $book->title }}</h3>
                    <p class="sp-card-desc">{{ $book->description }}</p>
                    <div class="sp-price-row">
                        <div class="sp-price">${{ $book->price }}</div>
                        <div style="display:flex;gap:6px;">
                            <button class="sp-add-btn" style="background:#1a237e;" onclick="addToCart(this,'{{ $book->title }}','${{ $book->price }}',{{ $book->price }})">🛒 ទិញ</button>
                            <a href="{{ route('books.edit', $book->id) }}" class="sp-add-btn" style="background:#f59e0b;">✏️ កែ</a>
                            <form method="POST" action="{{ route('books.delete', $book->id) }}" onsubmit="return confirm('លុបមែនទេ?')">
                                @csrf
                                <button type="submit" class="sp-add-btn" style="background:#e11d48;">🗑️ លុប</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- ══ COURSES SECTION ══ --}}
        <div class="sp-section-label">វគ្គសិក្សា</div>
        <h2 class="sp-section-title">វគ្គសិក្សាដែលមាន</h2>
        <div class="sp-grid" id="courseGrid">
            @forelse($courses as $i => $course)
            <div class="sp-card"
                 data-name="{{ strtolower($course->name) }}"
                 data-cat="course"
                 data-price="{{ $course->price }}"
                 data-rating="5"
                 style="transition-delay:{{ $i * 0.06 }}s">
                <div class="sp-img-wrap">
                    <div style="width:100%;height:200px;background:{{ $course->color ?? '#1c64b1' }};display:flex;align-items:center;justify-content:center;font-size:5rem;">{{ $course->icon ?? '📚' }}</div>
                         alt="{{ $course->name }}"
                         onerror="this.src='https://via.placeholder.com/400x200?text={{ urlencode($course->name) }}'"/>
                    @if($course->price == 0)
                        <span class="sp-img-badge badge-free">FREE</span>
                    @endif
                    <span class="sp-cat-badge">{{ $course->category }}</span>
                    <button class="sp-wish-btn" onclick="toggleWish(this)">🤍</button>
                </div>
                <div class="sp-card-body">
                    <div class="sp-cat-tag">🎓 {{ $course->category }}</div>
                    <h3>ថ្នាក់ {{ $course->name }}</h3>
                    <p class="sp-card-desc">{{ $course->description }}</p>
                    <div class="sp-price-row">
                        <div class="sp-price">
                            @if($course->price == 0)
                                <span style="color:#22c55e;font-size:1rem;font-weight:700;">FREE</span>
                            @else
                                ${{ $course->price }}
                            @endif
                        </div>
                        <button class="sp-add-btn" style="background:#1c64b1;" onclick="addToCart(this,'ថ្នាក់ {{ $course->name }}','${{ $course->price }}',{{ $course->price }})">📖 ចុចរៀន</button>
                    </div>
                </div>
            </div>
            @empty
            <p style="color:#888;grid-column:1/-1;text-align:center;padding:2rem;">គ្មានវគ្គសិក្សាទេ</p>
            @endforelse
        </div>

        {{-- No results --}}
        <div class="sp-no-results" id="noResults">
            <div class="nr-icon">🔍</div>
            <p>រកមិនឃើញផលិតផលដែលត្រូវនឹងការស្វែងរករបស់អ្នក។<br>
               សូមព្យាយាមពាក្យផ្សេង ឬជ្រើស «ទាំងអស់»។</p>
        </div>

        {{-- ══ SERVICES SECTION ══ --}}
        <div class="sp-services">
            <div class="sp-srv-label">សេវាកម្ម</div>
            <h2 class="sp-srv-title">សេវាកម្មដែលយើងផ្តល់ជូន</h2>
            <div class="sp-srv-grid">
                <div class="sp-srv-item">
                    <div class="sp-srv-icon">🚚</div>
                    <div class="sp-srv-text">
                        <h3>សេវាដឹកជញ្ជូនរហ័ស</h3>
                        <p>យើងដឹកជញ្ជូនសៀវភៅទៅដល់ដៃអ្នកក្នុងរយៈពេល ២៤ ម៉ោងសម្រាប់ភ្នំពេញ។</p>
                    </div>
                </div>
                <div class="sp-srv-item" style="transition-delay:0.08s;">
                    <div class="sp-srv-icon" style="background:#e8f0fb;">🔄</div>
                    <div class="sp-srv-text">
                        <h3>ការប្តូរសៀវភៅវិញ</h3>
                        <p>ប្រសិនបើសៀវភៅមានបញ្ហា បាក់ទំព័រ ឬខូចខាត អ្នកអាចប្តូរវិញបានក្នុងរយៈពេល ៧ ថ្ងៃ។</p>
                    </div>
                </div>
                <div class="sp-srv-item" style="transition-delay:0.16s;">
                    <div class="sp-srv-icon" style="background:#fff3e0;">🪪</div>
                    <div class="sp-srv-text">
                        <h3>សមាជិកភាពបណ្ណាល័យ</h3>
                        <p>ចុះឈ្មោះជាសមាជិកដើម្បីទទួលបានការបញ្ចុះតម្លៃ ១០% រាល់ការទិញសៀវភៅ។</p>
                    </div>
                </div>
                <div class="sp-srv-item" style="transition-delay:0.24s;">
                    <div class="sp-srv-icon" style="background:#fce4ec;">📖</div>
                    <div class="sp-srv-text">
                        <h3>កម្មវិធីអានសៀវភៅហ្វ្រី</h3>
                        <p>មានកន្លែងសម្រាប់អានសៀវភៅដោយសេរីនៅក្នុងបណ្ណាគាររបស់យើង។</p>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /.sp-wrap --}}
</div>{{-- /.sp-page --}}

{{-- ══ CART OVERLAY + DRAWER ══ --}}
<div class="sp-overlay" id="cartOverlay" onclick="toggleCart()"></div>

<div class="sp-drawer" id="cartDrawer">
    <div class="sp-drawer-head">
        <h4>🛒 កន្ត្រករបស់ខ្ញុំ</h4>
        <button class="sp-drawer-close" onclick="toggleCart()">✕</button>
    </div>
    <div class="sp-drawer-items" id="cartItems">
        <div class="sp-drawer-empty">
            <div class="de-icon">🛍️</div>
            <p>កន្ត្រករបស់អ្នកនៅទទេ<br>សូមបន្ថែមផលិតផលមួយ!</p>
        </div>
    </div>
    <div id="payModal" style="display:none;padding:12px 16px;border-top:1px solid #e5e7eb;background:#f9fafb;">
        <div style="font-size:12px;font-weight:600;color:#374151;margin-bottom:8px;">💳 ជ្រើសវិធីទូទាត់</div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;margin-bottom:10px;">
            <button onclick="selectPay(this,'cash')" class="pay-opt" style="padding:8px;border:2px solid #e5e7eb;border-radius:8px;background:#fff;cursor:pointer;font-size:12px;">💵 សាច់ប្រាក់</button>
            <button onclick="selectPay(this,'aba')" class="pay-opt" style="padding:8px;border:2px solid #e5e7eb;border-radius:8px;background:#fff;cursor:pointer;font-size:12px;">🏦 ABA</button>
            <button onclick="selectPay(this,'acleda')" class="pay-opt" style="padding:8px;border:2px solid #e5e7eb;border-radius:8px;background:#fff;cursor:pointer;font-size:12px;">🏦 ACLEDA</button>
            <button onclick="selectPay(this,'wing')" class="pay-opt" style="padding:8px;border:2px solid #e5e7eb;border-radius:8px;background:#fff;cursor:pointer;font-size:12px;">📱 Wing</button>
        </div>
        <button onclick="submitOrder()" style="width:100%;padding:11px;background:#166534;color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;">✅ បញ្ជាក់ការទូទាត់</button>
    </div>
    <div class="sp-drawer-foot">
        <div class="sp-subtotal">
            <span>សរុបទំហំ</span>
            <strong id="cartTotal">$0.00</strong>
        </div>
        <button class="sp-checkout-btn" onclick="togglePayModal()">
            ✅ ដំណើរការការទូទាត់ →
        </button>
    </div>
</div>

<script>
const revEls = document.querySelectorAll('.sp-card, .sp-toolbar, .sp-promo, .sp-srv-item');
const io = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); } });
}, { threshold: 0.08 });
revEls.forEach(el => io.observe(el));

let activeCat = 'all';

function setCat(btn, cat) {
    activeCat = cat;
    document.querySelectorAll('.sp-cat').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    filterProducts();
}

function filterProducts() {
    const q    = document.getElementById('shopSearch').value.toLowerCase().trim();
    const sort = document.getElementById('shopSort').value;
    const cards = [...document.querySelectorAll('.sp-card')];
    let visible = 0;

    cards.forEach(c => {
        const name = c.dataset.name || '';
        const cat  = c.dataset.cat  || '';
        const ok   = (activeCat === 'all' || cat === activeCat) && (!q || name.includes(q));
        c.classList.toggle('hidden-item', !ok);
        if (ok) { c.classList.add('visible'); visible++; }
    });

    document.getElementById('visibleCount').textContent = visible;
    document.getElementById('noResults').style.display  = visible === 0 ? 'block' : 'none';
}

const allCards = document.querySelectorAll('.sp-card');
document.getElementById('totalCount').textContent   = allCards.length;
document.getElementById('visibleCount').textContent = allCards.length;

function toggleWish(btn) {
    btn.classList.toggle('wished');
    btn.textContent = btn.classList.contains('wished') ? '❤️' : '🤍';
}

let cart = {};

function addToCart(btn, name, price, priceNum) {
    @guest
        window.location.href = '{{ route("login") }}';
        return;
    @endguest

    const card = btn.closest('.sp-card');
    const imgEl = card.querySelector('img');
    const img = imgEl ? imgEl.src : 'https://placehold.co/56x56/1c64b1/fff?text=Course';    if (cart[name]) { cart[name].qty++; }
    else { cart[name] = { name, price, priceNum, qty: 1, img }; }

    btn.classList.add('added');
    btn.textContent = '✅ បន្ថែម';
    setTimeout(() => { btn.classList.remove('added'); btn.innerHTML = '🛒 ទិញ'; }, 1200);

    renderCart();
    const badge = document.getElementById('cartCount');
    badge.classList.remove('bump');
    void badge.offsetWidth;
    badge.classList.add('bump');
}

function removeFromCart(name) { delete cart[name]; renderCart(); }

function changeQty(name, delta) {
    if (!cart[name]) return;
    cart[name].qty += delta;
    if (cart[name].qty <= 0) { delete cart[name]; }
    renderCart();
}

function renderCart() {
    const items      = Object.values(cart);
    const totalQty   = items.reduce((s, i) => s + i.qty, 0);
    const totalPrice = items.reduce((s, i) => s + i.priceNum * i.qty, 0);

    document.getElementById('cartCount').textContent = totalQty;
    document.getElementById('cartTotal').textContent = '$' + totalPrice.toFixed(2);

    const container = document.getElementById('cartItems');
    if (items.length === 0) {
        container.innerHTML = `<div class="sp-drawer-empty"><div class="de-icon">🛍️</div><p>កន្ត្រករបស់អ្នកនៅទទេ<br>សូមបន្ថែមផលិតផលមួយ!</p></div>`;
        return;
    }
    container.innerHTML = items.map(i => `
        <div class="sp-cart-item">
            <img class="sp-ci-img" src="${i.img}" alt="${i.name}"/>
            <div class="sp-ci-info">
                <h5>${i.name}</h5>
                <div class="sp-ci-price">${i.price} × ${i.qty} = $${(i.priceNum * i.qty).toFixed(2)}</div>
            </div>
            <div class="sp-ci-qty">
                <button class="sp-qty-btn" onclick="changeQty('${i.name}',-1)">−</button>
                <span>${i.qty}</span>
                <button class="sp-qty-btn" onclick="changeQty('${i.name}',1)">+</button>
            </div>
            <button class="sp-ci-del" onclick="removeFromCart('${i.name}')" title="លុប">🗑</button>
        </div>
    `).join('');
}

function toggleCart() {
    document.getElementById('cartDrawer').classList.toggle('open');
    document.getElementById('cartOverlay').classList.toggle('show');
    document.body.style.overflow = document.getElementById('cartDrawer').classList.contains('open') ? 'hidden' : '';
}

let selectedPay = 'cash';
function togglePayModal() {
    if (Object.keys(cart).length === 0) { alert('កន្ត្រករបស់អ្នកនៅទទេ!'); return; }
    const m = document.getElementById('payModal');
    m.style.display = m.style.display === 'none' ? 'block' : 'none';
}
function selectPay(btn, method) {
    selectedPay = method;
    document.querySelectorAll(".pay-opt").forEach(b => b.style.border = "2px solid #e5e7eb");
    btn.style.border = "2px solid #166534";
    btn.style.background = "#f0fdf4";
}
function submitOrder() { handleCheckout(); }
function handleCheckout() {
    if (Object.keys(cart).length === 0) { alert('កន្ត្រករបស់អ្នកនៅទទេ!'); return; }

    let total = 0, itemNames = [], totalQty = 0;
    Object.values(cart).forEach(item => {
        total += item.priceNum * item.qty;
        totalQty += item.qty;
        itemNames.push(item.name + " x" + item.qty + " @$" + item.priceNum.toFixed(2));
    });

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = "/orders/store";
    form.innerHTML = `
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="customer_name" value="{{ Auth::user()->name ?? 'Guest' }}">
        <input type="hidden" name="phone" value="{{ Auth::user()->phone ?? 'N/A' }}">
        <input type="hidden" name="email" value="{{ Auth::user()->email ?? '' }}">
        <input type="hidden" name="quantity" value="${totalQty}">
        <input type="hidden" name="total_price" value="${total}">
        <input type="hidden" name="payment_method" value="${selectedPay}">
        <input type="hidden" name="note" value="${itemNames.join(', ')}">
    `;
    document.body.appendChild(form);
    form.submit();
}

function copyCode(el) {
    navigator.clipboard?.writeText(el.textContent).then(() => {
        const orig = el.textContent;
        el.textContent = '✅ ចម្លងបានហើយ!';
        setTimeout(() => el.textContent = orig, 1800);
    });
}
</script>

@endsection