@extends('layouts.master')

@section('title', 'ហាង - Shop')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Outfit:wght@300;400;500;600;700&display=swap');

    /* ══════════════════════════════
       BASE
    ══════════════════════════════ */
    .sp-page {
        font-family: 'Outfit', sans-serif;
        background: #f4f7fc;
        min-height: 100vh;
    }

    /* ══════════════════════════════
       HERO BANNER
    ══════════════════════════════ */
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
    /* floating decorative circles */
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
    /* Hero stats strip */
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

    /* ══════════════════════════════
       WRAP
    ══════════════════════════════ */
    .sp-wrap { max-width: 1280px; margin: 0 auto; padding: 3rem 2rem 4rem; }

    /* ══════════════════════════════
       TOOLBAR  (search + filter + sort + cart)
    ══════════════════════════════ */
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

    /* Search */
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

    /* Category pills */
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

    /* Sort select */
    .sp-sort {
        padding: 9px 12px; background: #f4f7fc;
        border: 1px solid rgba(11,30,61,0.09); border-radius: 10px;
        font-family: 'Outfit', sans-serif; font-size: 0.84rem;
        color: #0b1e3d; cursor: pointer; outline: none;
        transition: border-color 0.2s;
    }
    .sp-sort:focus { border-color: #1c64b1; }

    /* Cart button */
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

    /* Result count */
    .sp-count { font-size: 0.78rem; color: #8898b5; white-space: nowrap; margin-left: auto; }
    .sp-count strong { color: #0b1e3d; }

    /* ══════════════════════════════
       PRODUCT GRID
    ══════════════════════════════ */
    .sp-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    /* Product card */
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

    /* Image area */
    .sp-img-wrap {
        position: relative; overflow: hidden;
        background: #f0f4fb; height: 200px;
    }
    .sp-img-wrap img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform 0.5s ease;
    }
    .sp-card:hover .sp-img-wrap img { transform: scale(1.06); }

    /* Badge on image */
    .sp-img-badge {
        position: absolute; top: 12px; left: 12px;
        font-size: 0.67rem; font-weight: 700;
        padding: 4px 10px; border-radius: 20px;
        text-transform: uppercase; letter-spacing: 0.07em;
    }
    .badge-new   { background: #1c64b1; color: #fff; }
    .badge-sale  { background: #e8a020; color: #fff; }
    .badge-hot   { background: #e24b4a; color: #fff; }
    .badge-free  { background: #22c55e; color: #fff; }

    /* Wishlist btn on image */
    .sp-wish-btn {
        position: absolute; top: 10px; right: 10px;
        width: 34px; height: 34px; border-radius: 50%;
        background: rgba(255,255,255,0.9);
        border: none; cursor: pointer; font-size: 15px;
        display: flex; align-items: center; justify-content: center;
        transition: background 0.2s, transform 0.15s;
        box-shadow: 0 2px 8px rgba(11,30,61,0.12);
    }
    .sp-wish-btn:hover { background: #fff; transform: scale(1.12); }
    .sp-wish-btn.wished { color: #e24b4a; }

    /* Card body */
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

    /* Stars */
    .sp-stars { display: flex; align-items: center; gap: 4px; margin-bottom: 0.75rem; }
    .sp-stars .star { color: #e8a020; font-size: 13px; }
    .sp-stars .star.empty { color: #d1d5db; }
    .sp-stars small { font-size: 0.73rem; color: #8898b5; margin-left: 2px; }

    /* Price row */
    .sp-price-row {
        display: flex; align-items: center;
        justify-content: space-between; gap: 8px;
    }
    .sp-price {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.4rem; font-weight: 700;
        color: #0b1e3d; line-height: 1;
    }
    .sp-price .orig {
        font-size: 0.85rem; font-weight: 400;
        color: #8898b5; text-decoration: line-through;
        margin-left: 6px; font-family: 'Outfit', sans-serif;
    }
    .sp-add-btn {
        display: inline-flex; align-items: center; gap: 5px;
        background: #0b1e3d; color: #fff;
        border: none; border-radius: 8px;
        padding: 9px 14px; font-family: 'Outfit', sans-serif;
        font-size: 0.8rem; font-weight: 600; cursor: pointer;
        transition: background 0.18s, transform 0.12s;
        white-space: nowrap;
    }
    .sp-add-btn:hover { background: #1c64b1; transform: translateY(-1px); }
    .sp-add-btn.added { background: #22c55e; }

    /* ══════════════════════════════
       NO RESULTS
    ══════════════════════════════ */
    .sp-no-results {
        display: none; grid-column: 1/-1;
        text-align: center; padding: 4rem 1rem; color: #8898b5;
    }
    .sp-no-results .nr-icon { font-size: 3rem; margin-bottom: 1rem; }
    .sp-no-results p { font-size: 0.9rem; line-height: 1.7; }

    /* ══════════════════════════════
       CART DRAWER
    ══════════════════════════════ */
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
    .sp-drawer-empty {
        text-align: center; padding: 3rem 1rem;
        color: #8898b5; font-size: 0.9rem;
    }
    .sp-drawer-empty .de-icon { font-size: 2.5rem; margin-bottom: 0.75rem; }

    /* Cart item */
    .sp-cart-item {
        display: flex; align-items: center; gap: 12px;
        padding: 0.9rem 0; border-bottom: 1px solid rgba(11,30,61,0.06);
        animation: slideIn 0.25s ease;
    }
    @keyframes slideIn { from{opacity:0;transform:translateX(12px)} to{opacity:1;transform:translateX(0)} }
    .sp-cart-item:last-child { border-bottom: none; }
    .sp-ci-img {
        width: 56px; height: 56px; border-radius: 10px;
        object-fit: cover; flex-shrink: 0; background: #f0f4fb;
    }
    .sp-ci-info { flex: 1; min-width: 0; }
    .sp-ci-info h5 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 0.95rem; font-weight: 700;
        color: #0b1e3d; margin-bottom: 3px;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .sp-ci-price { font-size: 0.82rem; font-weight: 600; color: #1c64b1; }
    /* Qty controls */
    .sp-ci-qty {
        display: flex; align-items: center; gap: 6px;
    }
    .sp-qty-btn {
        width: 26px; height: 26px; border-radius: 6px;
        border: 1px solid rgba(11,30,61,0.12);
        background: #f4f7fc; cursor: pointer; font-size: 15px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 600; color: #0b1e3d;
        transition: background 0.15s;
    }
    .sp-qty-btn:hover { background: #e8f0fb; }
    .sp-ci-qty span { font-size: 0.88rem; font-weight: 600; min-width: 18px; text-align: center; color: #0b1e3d; }
    .sp-ci-del { background: none; border: none; color: #e24b4a; cursor: pointer; font-size: 16px; padding: 4px; opacity: 0.6; transition: opacity 0.15s; }
    .sp-ci-del:hover { opacity: 1; }

    /* Drawer footer */
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
        font-size: 1.3rem; font-weight: 700;
        color: #0b1e3d;
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

    /* ══════════════════════════════
       PROMO BANNER
    ══════════════════════════════ */
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
        font-size: 1.4rem; font-weight: 700;
        color: #0b1e3d; margin-bottom: 4px;
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

    /* ══════════════════════════════
       RESPONSIVE
    ══════════════════════════════ */
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

        {{-- ══ TOOLBAR ══ --}}
        <div class="sp-toolbar" id="shopToolbar">
            {{-- Search --}}
            <div class="sp-search-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                <!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</svg>
                <input type="text" class="sp-search" id="shopSearch" placeholder="ស្វែងរកផលិតផល..." oninput="filterProducts()"/>
            </div>

            {{-- Category pills --}}
            <div class="sp-cats">
                <button class="sp-cat active" data-cat="all"     onclick="setCat(this,'all')">🗂 ទាំងអស់</button>
                <button class="sp-cat"        data-cat="book"    onclick="setCat(this,'book')">📚 សៀវភៅ</button>
                <button class="sp-cat"        data-cat="it"      onclick="setCat(this,'it')">💻 IT</button>
                <button class="sp-cat"        data-cat="design"  onclick="setCat(this,'design')">🎨 Design</button>
                <button class="sp-cat"        data-cat="course"  onclick="setCat(this,'course')">🎓 Course</button>
            </div>

            {{-- Sort --}}
            <select class="sp-sort" id="shopSort" onchange="filterProducts()">
                <option value="default">តម្រៀបតាម...</option>
                <option value="price-asc">តម្លៃ: ទាប→ខ្ពស់</option>
                <option value="price-desc">តម្លៃ: ខ្ពស់→ទាប</option>
                <option value="name">ឈ្មោះ A→Z</option>
                <option value="rating">Rating ខ្ពស់</option>
            </select>

            {{-- Cart --}}
            <button class="sp-cart-btn" onclick="toggleCart()">
                🛒 កន្ត្រក
                <span class="sp-cart-count" id="cartCount">0</span>
            </button>

            <div class="sp-count">
                បង្ហាញ <strong id="visibleCount">8</strong> / <strong id="totalCount">8</strong>
            </div>
        </div>

        {{-- ══ PRODUCT GRID ══ --}}
        <div class="sp-grid" id="productGrid">

            {{-- Product 1 --}}
            <div class="sp-card"
                 data-name="html css javascript beginners"
                 data-cat="book" data-price="12" data-rating="5"
                 style="transition-delay:0s">
                <div class="sp-img-wrap">
                    <img src="https://images.pexels.com/photos/1181671/pexels-photo-1181671.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Book"/>
                    <span class="sp-img-badge badge-new">New</span>
                    <button class="sp-wish-btn" onclick="toggleWish(this)">🤍</button>
                </div>
                <div class="sp-card-body">
                    <div class="sp-cat-tag">📚 សៀវភៅ</div>
                    <h3>HTML CSS & JavaScript for Beginners</h3>
                    <p class="sp-card-desc">សៀវភៅណែនាំការសរសេរកូដ Web ចាប់ផ្ដើមពី Zero</p>
                    <div class="sp-stars">
                        <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
                        <small>(128)</small>
                    </div>
                    <div class="sp-price-row">
                        <div class="sp-price">$12 <span class="orig">$18</span></div>
                        <button class="sp-add-btn" onclick="addToCart(this,'HTML CSS & JS Book','$12',12)">🛒 បន្ថែម</button>
                    </div>
                </div>
            </div>

            {{-- Product 2 --}}
            <div class="sp-card"
                 data-name="laravel php framework course"
                 data-cat="course" data-price="35" data-rating="5"
                 style="transition-delay:0.06s">
                <div class="sp-img-wrap">
                    <img src="https://images.pexels.com/photos/574070/pexels-photo-574070.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Course"/>
                    <span class="sp-img-badge badge-hot">Hot</span>
                    <button class="sp-wish-btn" onclick="toggleWish(this)">🤍</button>
                </div>
                <div class="sp-card-body">
                    <div class="sp-cat-tag">🎓 Course</div>
                    <h3>Laravel PHP Framework — Full Course</h3>
                    <p class="sp-card-desc">រៀន Laravel ពី Routing, Blade, Eloquent ដល់ API</p>
                    <div class="sp-stars">
                        <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
                        <small>(94)</small>
                    </div>
                    <div class="sp-price-row">
                        <div class="sp-price">$35 <span class="orig">$55</span></div>
                        <button class="sp-add-btn" onclick="addToCart(this,'Laravel Course','$35',35)">🛒 បន្ថែម</button>
                    </div>
                </div>
            </div>

            {{-- Product 3 --}}
            <div class="sp-card"
                 data-name="ui ux design figma toolkit"
                 data-cat="design" data-price="20" data-rating="4"
                 style="transition-delay:0.12s">
                <div class="sp-img-wrap">
                    <img src="https://images.pexels.com/photos/196644/pexels-photo-196644.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Design"/>
                    <span class="sp-img-badge badge-sale">Sale</span>
                    <button class="sp-wish-btn" onclick="toggleWish(this)">🤍</button>
                </div>
                <div class="sp-card-body">
                    <div class="sp-cat-tag">🎨 Design</div>
                    <h3>UI/UX Design Figma Toolkit</h3>
                    <p class="sp-card-desc">ប្រព័ន្ធ Component 200+ សម្រាប់ Design Project</p>
                    <div class="sp-stars">
                        <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star empty">★</span>
                        <small>(67)</small>
                    </div>
                    <div class="sp-price-row">
                        <div class="sp-price">$20 <span class="orig">$30</span></div>
                        <button class="sp-add-btn" onclick="addToCart(this,'Figma Toolkit','$20',20)">🛒 បន្ថែម</button>
                    </div>
                </div>
            </div>

            {{-- Product 4 --}}
            <div class="sp-card"
                 data-name="it support hardware troubleshooting"
                 data-cat="it" data-price="8" data-rating="4"
                 style="transition-delay:0.18s">
                <div class="sp-img-wrap">
                    <img src="https://images.pexels.com/photos/1181675/pexels-photo-1181675.jpeg?auto=compress&cs=tinysrgb&w=400" alt="IT"/>
                    <button class="sp-wish-btn" onclick="toggleWish(this)">🤍</button>
                </div>
                <div class="sp-card-body">
                    <div class="sp-cat-tag">💻 IT</div>
                    <h3>IT Support & Hardware Troubleshooting</h3>
                    <p class="sp-card-desc">ការណែនាំជំនួសសំណព្វ ហើយដំណោះស្រាយបញ្ហា PC</p>
                    <div class="sp-stars">
                        <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star empty">★</span>
                        <small>(52)</small>
                    </div>
                    <div class="sp-price-row">
                        <div class="sp-price">$8</div>
                        <button class="sp-add-btn" onclick="addToCart(this,'IT Support Book','$8',8)">🛒 បន្ថែម</button>
                    </div>
                </div>
            </div>

            {{-- Product 5 --}}
            <div class="sp-card"
                 data-name="digital marketing social media ads"
                 data-cat="course" data-price="28" data-rating="5"
                 style="transition-delay:0.24s">
                <div class="sp-img-wrap">
                    <img src="https://images.pexels.com/photos/905163/pexels-photo-905163.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Marketing"/>
                    <span class="sp-img-badge badge-new">New</span>
                    <button class="sp-wish-btn" onclick="toggleWish(this)">🤍</button>
                </div>
                <div class="sp-card-body">
                    <div class="sp-cat-tag">🎓 Course</div>
                    <h3>Digital Marketing & Social Media Ads</h3>
                    <p class="sp-card-desc">Facebook Ads, Google Ads, SEO និង Content Strategy</p>
                    <div class="sp-stars">
                        <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
                        <small>(81)</small>
                    </div>
                    <div class="sp-price-row">
                        <div class="sp-price">$28 <span class="orig">$45</span></div>
                        <button class="sp-add-btn" onclick="addToCart(this,'Digital Marketing Course','$28',28)">🛒 បន្ថែម</button>
                    </div>
                </div>
            </div>

            {{-- Product 6 --}}
            <div class="sp-card"
                 data-name="graphic design adobe photoshop illustrator"
                 data-cat="design" data-price="15" data-rating="4"
                 style="transition-delay:0.30s">
                <div class="sp-img-wrap">
                    <img src="https://images.pexels.com/photos/3183150/pexels-photo-3183150.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Graphic"/>
                    <span class="sp-img-badge badge-sale">Sale</span>
                    <button class="sp-wish-btn" onclick="toggleWish(this)">🤍</button>
                </div>
                <div class="sp-card-body">
                    <div class="sp-cat-tag">🎨 Design</div>
                    <h3>Graphic Design — Photoshop & Illustrator</h3>
                    <p class="sp-card-desc">រៀន Adobe CC ពី Beginner ដល់ Professional Level</p>
                    <div class="sp-stars">
                        <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star empty">★</span>
                        <small>(43)</small>
                    </div>
                    <div class="sp-price-row">
                        <div class="sp-price">$15 <span class="orig">$25</span></div>
                        <button class="sp-add-btn" onclick="addToCart(this,'Graphic Design Course','$15',15)">🛒 បន្ថែម</button>
                    </div>
                </div>
            </div>

            {{-- Product 7 --}}
            <div class="sp-card"
                 data-name="networking cisco ccna book"
                 data-cat="it" data-price="18" data-rating="5"
                 style="transition-delay:0.36s">
                <div class="sp-img-wrap">
                    <img src="https://images.pexels.com/photos/2881232/pexels-photo-2881232.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Network"/>
                    <button class="sp-wish-btn" onclick="toggleWish(this)">🤍</button>
                </div>
                <div class="sp-card-body">
                    <div class="sp-cat-tag">💻 IT</div>
                    <h3>Networking & Cisco CCNA Guide</h3>
                    <p class="sp-card-desc">ណែនាំអំពី TCP/IP, Routing, Switching សម្រាប់ CCNA</p>
                    <div class="sp-stars">
                        <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
                        <small>(110)</small>
                    </div>
                    <div class="sp-price-row">
                        <div class="sp-price">$18</div>
                        <button class="sp-add-btn" onclick="addToCart(this,'CCNA Guide','$18',18)">🛒 បន្ថែម</button>
                    </div>
                </div>
            </div>

            {{-- Product 8 --}}
            <div class="sp-card"
                 data-name="khmer it programming book free"
                 data-cat="book" data-price="0" data-rating="4"
                 style="transition-delay:0.42s">
                <div class="sp-img-wrap">
                    <img src="https://images.pexels.com/photos/159711/books-bookstore-book-reading-159711.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Khmer"/>
                    <span class="sp-img-badge badge-free">Free</span>
                    <button class="sp-wish-btn" onclick="toggleWish(this)">🤍</button>
                </div>
                <div class="sp-card-body">
                    <div class="sp-cat-tag">📚 សៀវភៅ</div>
                    <h3>សៀវភៅ IT ភាសាខ្មែរ — ការសរសេរកម្មវិធី</h3>
                    <p class="sp-card-desc">ឯកសារ IT ជាភាសាខ្មែរ ឥតគិតថ្លៃ ១០០%</p>
                    <div class="sp-stars">
                        <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star empty">★</span>
                        <small>(200)</small>
                    </div>
                    <div class="sp-price-row">
                        <div class="sp-price" style="color:#22c55e;">Free</div>
                        <button class="sp-add-btn" onclick="addToCart(this,'Khmer IT Book','$0',0)" style="background:#22c55e;">⬇️ ទាញយក</button>
                    </div>
                </div>
            </div>

        </div>

        {{-- No results --}}
        <div class="sp-no-results" id="noResults">
            <div class="nr-icon">🔍</div>
            <p>រកមិនឃើញផលិតផលដែលត្រូវនឹងការស្វែងរករបស់អ្នក។<br>
               សូមព្យាយាមពាក្យផ្សេង ឬជ្រើស «ទាំងអស់»។</p>
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
    <div class="sp-drawer-foot">
        <div class="sp-subtotal">
            <span>សរុបទំហំ</span>
            <strong id="cartTotal">$0.00</strong>
        </div>
        <button class="sp-checkout-btn" onclick="handleCheckout()">
            ✅ ដំណើរការការទូទាត់ →
        </button>
    </div>
</div>

<script>
/* ══════════════════════════════
   SCROLL REVEAL
══════════════════════════════ */
const revEls = document.querySelectorAll('.sp-card, .sp-toolbar, .sp-promo');
const io = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); } });
}, { threshold: 0.08 });
revEls.forEach(el => io.observe(el));

/* ══════════════════════════════
   FILTER + SEARCH + SORT
══════════════════════════════ */
let activeCat = 'all';

function setCat(btn, cat) {
    activeCat = cat;
    document.querySelectorAll('.sp-cat').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    filterProducts();
}

function filterProducts() {
    const q     = document.getElementById('shopSearch').value.toLowerCase().trim();
    const sort  = document.getElementById('shopSort').value;
    const cards = [...document.querySelectorAll('#productGrid .sp-card')];
    let visible = 0;

    /* filter */
    cards.forEach(c => {
        const name = c.dataset.name || '';
        const cat  = c.dataset.cat  || '';
        const ok   = (activeCat === 'all' || cat === activeCat) &&
                     (!q || name.includes(q));
        c.classList.toggle('hidden-item', !ok);
        if (ok) { if (!c.classList.contains('visible')) c.classList.add('visible'); visible++; }
    });

    /* sort visible cards */
    const grid    = document.getElementById('productGrid');
    const visible_cards = cards.filter(c => !c.classList.contains('hidden-item'));
    if (sort === 'price-asc')  visible_cards.sort((a,b) => +a.dataset.price - +b.dataset.price);
    if (sort === 'price-desc') visible_cards.sort((a,b) => +b.dataset.price - +a.dataset.price);
    if (sort === 'name')       visible_cards.sort((a,b) => a.dataset.name.localeCompare(b.dataset.name));
    if (sort === 'rating')     visible_cards.sort((a,b) => +b.dataset.rating - +a.dataset.rating);
    visible_cards.forEach(c => grid.appendChild(c));

    document.getElementById('visibleCount').textContent = visible;
    document.getElementById('noResults').style.display  = visible === 0 ? 'block' : 'none';
}

document.getElementById('totalCount').textContent = document.querySelectorAll('#productGrid .sp-card').length;

/* ══════════════════════════════
   WISHLIST
══════════════════════════════ */
function toggleWish(btn) {
    btn.classList.toggle('wished');
    btn.textContent = btn.classList.contains('wished') ? '❤️' : '🤍';
}

/* ══════════════════════════════
   CART
══════════════════════════════ */
let cart = {};   /* { name: { name, price, priceNum, qty, img } } */

function addToCart(btn, name, price, priceNum) {
    /* get image from card */
    const card = btn.closest('.sp-card');
    const img  = card.querySelector('img')?.src || '';

    if (cart[name]) {
        cart[name].qty++;
    } else {
        cart[name] = { name, price, priceNum, qty: 1, img };
    }

    btn.classList.add('added');
    btn.textContent = '✅ បន្ថែម';
    setTimeout(() => { btn.classList.remove('added'); btn.innerHTML = '🛒 បន្ថែម'; }, 1200);

    renderCart();
    /* bump badge */
    const badge = document.getElementById('cartCount');
    badge.classList.remove('bump');
    void badge.offsetWidth;
    badge.classList.add('bump');
}

function removeFromCart(name) {
    delete cart[name];
    renderCart();
}

function changeQty(name, delta) {
    if (!cart[name]) return;
    cart[name].qty += delta;
    if (cart[name].qty <= 0) { delete cart[name]; }
    renderCart();
}

function renderCart() {
    const items     = Object.values(cart);
    const totalQty  = items.reduce((s, i) => s + i.qty, 0);
    const totalPrice= items.reduce((s, i) => s + i.priceNum * i.qty, 0);

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

function handleCheckout() {
    if (Object.keys(cart).length === 0) { alert('កន្ត្រករបស់អ្នកនៅទទេ!'); return; }
    alert('✅ ការបញ្ជាទិញបានទទួលស្គាល់! សូមអរគុណ 🎉');
    cart = {};
    renderCart();
    toggleCart();
}

/* ══════════════════════════════
   PROMO CODE COPY
══════════════════════════════ */
function copyCode(el) {
    navigator.clipboard?.writeText(el.textContent).then(() => {
        const orig = el.textContent;
        el.textContent = '✅ ចម្លងបានហើយ!';
        setTimeout(() => el.textContent = orig, 1800);
    });
}
</script>

@endsection