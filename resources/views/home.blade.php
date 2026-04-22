<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=DM+Mono:wght@300;400&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --cream: #f5f0e8;
            --ink: #7e5829;
            --rust: #c4501a;
            --warm-mid: #8c7355;
            --pale: #ede8de;
        }

        html { scroll-behavior: smooth; }

        body {
            background-color: var(--cream);
            color: var(--ink);
            font-family: 'DM Mono', monospace;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Grain overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 999;
            opacity: 0.4;
        }

        /* NAV */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.4rem 3rem;
            background: transparent;
            mix-blend-mode: multiply;
        }

        .nav-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            font-style: italic;
            color: var(--ink);
            text-decoration: none;
            letter-spacing: 0.02em;
        }

        .nav-links {
            display: flex;
            gap: 2.5rem;
            list-style: none;
        }

        .nav-links a {
            font-size: 0.68rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--warm-mid);
            text-decoration: none;
            position: relative;
            transition: color 0.25s;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -3px; left: 0;
            width: 0; height: 1px;
            background: var(--rust);
            transition: width 0.3s ease;
        }

        .nav-links a:hover { color: var(--rust); }
        .nav-links a:hover::after { width: 100%; }

        .nav-login {
            font-size: 0.68rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--cream);
            background: var(--ink);
            text-decoration: none;
            padding: 0.55rem 1.3rem;
            transition: background 0.25s, color 0.25s;
        }

        .nav-login:hover {
            background: var(--rust);
        }

        /* HERO */
        .hero {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            position: relative;
        }

        .hero-left {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 7rem 3rem 5rem 3rem;
            position: relative;
            z-index: 2;
        }

        .hero-eyebrow {
            font-size: 0.65rem;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--rust);
            margin-bottom: 1.5rem;
            opacity: 0;
            animation: fadeUp 0.8s 0.2s forwards;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3.5rem, 6vw, 6rem);
            line-height: 1.05;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 2rem;
            opacity: 0;
            animation: fadeUp 0.8s 0.4s forwards;
        }

        .hero-title em {
            font-style: italic;
            color: var(--rust);
        }

        .hero-sub {
            font-size: 0.8rem;
            line-height: 1.8;
            color: var(--warm-mid);
            max-width: 38ch;
            margin-bottom: 3rem;
            font-weight: 300;
            opacity: 0;
            animation: fadeUp 0.8s 0.6s forwards;
        }

        .hero-cta-group {
            display: flex;
            gap: 1.2rem;
            align-items: center;
            opacity: 0;
            animation: fadeUp 0.8s 0.8s forwards;
        }

        .cta-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
            background: var(--ink);
            color: var(--cream);
            text-decoration: none;
            padding: 0.9rem 2rem;
            font-size: 0.7rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            transition: background 0.25s, transform 0.2s;
        }

        .cta-primary:hover {
            background: var(--rust);
            transform: translateY(-2px);
        }

        .cta-primary svg { transition: transform 0.25s; }
        .cta-primary:hover svg { transform: translateX(4px); }

        .cta-secondary {
            font-size: 0.7rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--warm-mid);
            text-decoration: none;
            border-bottom: 1px solid var(--warm-mid);
            padding-bottom: 2px;
            transition: color 0.25s, border-color 0.25s;
        }

        .cta-secondary:hover {
            color: var(--rust);
            border-color: var(--rust);
        }

        /* Hero right — decorative panel */
        .hero-right {
            position: relative;
            background: var(--pale);
            overflow: hidden;
        }

        .hero-right::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 60% 30%, rgba(196,80,26,0.12) 0%, transparent 60%),
                radial-gradient(ellipse at 20% 80%, rgba(140,115,85,0.1) 0%, transparent 50%);
        }

        .deco-number {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Playfair Display', serif;
            font-size: clamp(10rem, 20vw, 22rem);
            font-weight: 700;
            color: transparent;
            -webkit-text-stroke: 1px rgba(99, 71, 38, 0.08);
            line-height: 1;
            user-select: none;
            animation: slowSpin 40s linear infinite;
        }

        .deco-circle {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(196,80,26,0.15);
        }
        .deco-circle:nth-child(1) { width: 300px; height: 300px; top: 10%; right: 10%; animation: pulse 6s ease-in-out infinite; }
        .deco-circle:nth-child(2) { width: 200px; height: 200px; bottom: 15%; left: 15%; animation: pulse 8s ease-in-out 2s infinite; }
        .deco-circle:nth-child(3) { width: 120px; height: 120px; top: 55%; right: 25%; animation: pulse 5s ease-in-out 1s infinite; }

        .hero-tagline-vert {
            position: absolute;
            bottom: 3rem;
            right: 2rem;
            font-size: 0.6rem;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--warm-mid);
            writing-mode: vertical-rl;
            opacity: 0.6;
        }

        /* MARQUEE BAND */
        .marquee-band {
            background: var(--ink);
            color: var(--cream);
            padding: 0.85rem 0;
            overflow: hidden;
            white-space: nowrap;
        }

        .marquee-inner {
            display: inline-flex;
            animation: marquee 18s linear infinite;
        }

        .marquee-inner span {
            font-size: 0.65rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            padding: 0 2rem;
            color: var(--cream);
            opacity: 0.8;
        }

        .marquee-inner span.dot {
            color: var(--rust);
            font-size: 1rem;
            opacity: 1;
            padding: 0 0.5rem;
        }

        /* GRID SECTION */
        .section-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            border-top: 1px solid rgba(26,18,8,0.1);
        }

        .grid-card {
            padding: 3rem 2.5rem;
            border-right: 1px solid rgba(26,18,8,0.08);
            position: relative;
            overflow: hidden;
            transition: background 0.3s;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .grid-card:last-child { border-right: none; }

        .grid-card::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            height: 2px; width: 0;
            background: var(--rust);
            transition: width 0.4s ease;
        }

        .grid-card:hover { background: var(--pale); }
        .grid-card:hover::after { width: 100%; }

        .card-num {
            font-size: 0.6rem;
            letter-spacing: 0.2em;
            color: var(--rust);
            margin-bottom: 1.5rem;
            font-weight: 400;
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 400;
            color: var(--ink);
            margin-bottom: 0.8rem;
            line-height: 1.2;
        }

        .card-desc {
            font-size: 0.72rem;
            line-height: 1.7;
            color: var(--warm-mid);
            font-weight: 300;
        }

        .card-arrow {
            display: inline-block;
            margin-top: 1.5rem;
            font-size: 0.65rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--ink);
            transition: transform 0.25s, color 0.25s;
        }

        .grid-card:hover .card-arrow {
            transform: translateX(6px);
            color: var(--rust);
        }

        /* FOOTER */
        footer {
            padding: 2.5rem 3rem;
            border-top: 1px solid rgba(26,18,8,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-copy {
            font-size: 0.62rem;
            letter-spacing: 0.1em;
            color: var(--warm-mid);
        }

        .footer-tagline {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 0.9rem;
            color: var(--warm-mid);
        }

        /* ANIMATIONS */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes slowSpin {
            from { transform: translate(-50%, -50%) rotate(0deg); }
            to   { transform: translate(-50%, -50%) rotate(360deg); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.6; }
            50%       { transform: scale(1.05); opacity: 1; }
        }

        @keyframes marquee {
            from { transform: translateX(0); }
            to   { transform: translateX(-50%); }
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            nav { padding: 1.2rem 1.5rem; }
            .nav-links { display: none; }
            .hero { grid-template-columns: 1fr; min-height: auto; }
            .hero-left { padding: 7rem 1.5rem 3rem; }
            .hero-right { display: none; }
            .section-grid { grid-template-columns: 1fr 1fr; }
            footer { flex-direction: column; gap: 1rem; text-align: center; }
        }

        @media (max-width: 540px) {
            .section-grid { grid-template-columns: 1fr; }
            .grid-card { border-right: none; border-bottom: 1px solid rgba(26,18,8,0.08); }
        }
    </style>
</head>
<body>

    <!-- NAV -->
    <nav>
        <a href="/" class="nav-logo">Studio.</a>
        <ul class="nav-links">
            <li><a href="/about">About Us</a></li>
            <li><a href="/products">Products</a></li>
            <li><a href="/services">Services</a></li>
            <li><a href="/contact">Contact</a></li>
        </ul>
        <a href="/login" class="nav-login">Login →</a>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-left">
            <p class="hero-eyebrow">Welcome — Est. 2025</p>
            <h1 class="hero-title">Where ideas<br><em>find their</em><br>form.</h1>
            <p class="hero-sub">We craft purposeful experiences — built with precision, refined with intention. Everything we make carries the weight of careful thought.</p>
            <div class="hero-cta-group">
                <a href="/products" class="cta-primary">
                    Explore Our Work
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M1 7h12M8 2l5 5-5 5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="/about" class="cta-secondary">Our Story</a>
            </div>
        </div>

        <div class="hero-right">
            <div class="deco-circle"></div>
            <div class="deco-circle"></div>
            <div class="deco-circle"></div>
            <div class="deco-number">H</div>
            <span class="hero-tagline-vert">Est. 2025 · Crafted with care</span>
        </div>
    </section>

    <!-- MARQUEE -->
    <div class="marquee-band" aria-hidden="true">
        <div class="marquee-inner">
            <span>About Us</span><span class="dot">·</span>
            <span>Our Products</span><span class="dot">·</span>
            <span>Our Services</span><span class="dot">·</span>
            <span>Get in Touch</span><span class="dot">·</span>
            <span>Welcome Home</span><span class="dot">·</span>
            <span>About Us</span><span class="dot">·</span>
            <span>Our Products</span><span class="dot">·</span>
            <span>Our Services</span><span class="dot">·</span>
            <span>Get in Touch</span><span class="dot">·</span>
            <span>Welcome Home</span><span class="dot">·</span>
        </div>
    </div>

    <!-- CARDS GRID -->
    <section class="section-grid">
        <a href="/about" class="grid-card">
            <p class="card-num">01</p>
            <h2 class="card-title">About Us</h2>
            <p class="card-desc">The story behind the studio — our values, our people, and what drives every decision we make.</p>
            <span class="card-arrow">Read more →</span>
        </a>
        <a href="/products" class="grid-card">
            <p class="card-num">02</p>
            <h2 class="card-title">Our Products</h2>
            <p class="card-desc">A curated range built with care. Each piece is designed to endure, delight, and serve its purpose well.</p>
            <span class="card-arrow">Browse →</span>
        </a>
        <a href="/services" class="grid-card">
            <p class="card-num">03</p>
            <h2 class="card-title">Our Services</h2>
            <p class="card-desc">Tailored solutions for every need. We work closely with you to deliver outcomes that truly matter.</p>
            <span class="card-arrow">Discover →</span>
        </a>
        <a href="/contact" class="grid-card">
            <p class="card-num">04</p>
            <h2 class="card-title">Contact Us</h2>
            <p class="card-desc">Have a question or a project in mind? We would love to hear from you — let's start a conversation.</p>
            <span class="card-arrow">Get in touch →</span>
        </a>
    </section>

    <!-- PRODUCTS TABLE -->
    <section style="padding:4rem 3rem;background:var(--pale)">
        <p style="font-size:0.65rem;letter-spacing:0.25em;text-transform:uppercase;color:var(--rust);margin-bottom:0.75rem">Our Menu</p>
        <h2 style="font-family:'Playfair Display',serif;font-size:2.5rem;font-weight:400;color:var(--ink);margin-bottom:2.5rem">Featured Products</h2>
        <table style="width:100%;border-collapse:collapse;background:var(--ink);border-radius:8px;overflow:hidden">
            <thead>
                <tr style="background:#2a1e10">
                    <th style="padding:1rem 1.25rem;text-align:left;color:#8c7355;font-size:0.65rem;letter-spacing:0.2em;text-transform:uppercase;font-weight:400">ID</th>
                    <th style="padding:1rem 1.25rem;text-align:left;color:#8c7355;font-size:0.65rem;letter-spacing:0.2em;text-transform:uppercase;font-weight:400">Name</th>
                    <th style="padding:1rem 1.25rem;text-align:left;color:#8c7355;font-size:0.65rem;letter-spacing:0.2em;text-transform:uppercase;font-weight:400">Price</th>
                    <th style="padding:1rem 1.25rem;text-align:left;color:#8c7355;font-size:0.65rem;letter-spacing:0.2em;text-transform:uppercase;font-weight:400">Qty</th>
                    <th style="padding:1rem 1.25rem;text-align:left;color:#8c7355;font-size:0.65rem;letter-spacing:0.2em;text-transform:uppercase;font-weight:400">Img</th>
                    <th style="padding:1rem 1.25rem;text-align:left;color:#8c7355;font-size:0.65rem;letter-spacing:0.2em;text-transform:uppercase;font-weight:400">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $p)
                <tr style="border-bottom:1px solid rgba(255,255,255,0.05)">
                    <td style="padding:0.875rem 1.25rem;color:#f5f0e8;font-size:0.85rem">{{ $p->id }}</td>
                    <td style="padding:0.875rem 1.25rem;color:#f5f0e8;font-size:0.85rem">{{ $p->name }}</td>
                    <td style="padding:0.875rem 1.25rem;color:#c4501a;font-size:0.85rem;font-weight:600">${{ number_format($p->price,2) }}</td>
                    <td style="padding:0.875rem 1.25rem;color:#f5f0e8;font-size:0.85rem">{{ $p->qty }}</td>
                    <td style="padding:0.875rem 1.25rem;color:#8c7355;font-size:0.85rem">{{ $p->img }}</td>
                    <td style="padding:0.875rem 1.25rem;font-size:0.85rem"><span style="padding:2px 10px;border-radius:50px;background:rgba(196,80,26,0.15);color:#c4501a;font-size:0.72rem">{{ $p->status == 1 ? 'Active' : 'Inactive' }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:1rem;font-size:0.72rem;color:var(--warm-mid)">Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} products</div>
        <div style="display:flex;gap:0.5rem;margin-top:0.75rem">
            @if($products->onFirstPage())<span style="padding:6px 14px;border:1px solid rgba(26,18,8,0.15);color:#ccc;font-size:0.72rem;border-radius:4px">« Prev</span>
            @else<a href="{{ $products->previousPageUrl() }}" style="padding:6px 14px;border:1px solid rgba(26,18,8,0.2);color:var(--ink);font-size:0.72rem;border-radius:4px;text-decoration:none">« Prev</a>@endif
            @for($i=1;$i<=$products->lastPage();$i++)
            @if($i==$products->currentPage())<span style="padding:6px 14px;background:var(--rust);color:#fff;font-size:0.72rem;border-radius:4px">{{ $i }}</span>
            @else<a href="{{ $products->url($i) }}" style="padding:6px 14px;border:1px solid rgba(26,18,8,0.2);color:var(--ink);font-size:0.72rem;border-radius:4px;text-decoration:none">{{ $i }}</a>@endif
            @endfor
            @if($products->hasMorePages())<a href="{{ $products->nextPageUrl() }}" style="padding:6px 14px;border:1px solid rgba(26,18,8,0.2);color:var(--ink);font-size:0.72rem;border-radius:4px;text-decoration:none">Next »</a>
            @else<span style="padding:6px 14px;border:1px solid rgba(26,18,8,0.15);color:#ccc;font-size:0.72rem;border-radius:4px">Next »</span>@endif
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <span class="footer-copy">© 2025 Studio. All rights reserved.</span>
        <span class="footer-tagline">Made with intention.</span>
    </footer>

</body>
</html>
