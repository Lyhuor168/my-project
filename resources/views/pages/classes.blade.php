@extends('layouts.master')

@section('title', 'ថ្នាក់រៀន - Class Schedule')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Outfit:wght@300;400;500;600&display=swap');

    .cl-page { font-family: 'Outfit', sans-serif; background: #d1e1fc; min-height: 100vh; }

    /* ── HERO ── */
    .cl-hero {
        background: linear-gradient(135deg, #0b1e3d 0%, #122a54 60%, #1c64b1 100%);
        padding: 5rem 2rem 4rem; text-align: center;
        position: relative; overflow: hidden;
    }
    .cl-hero::before {
        content: ''; position: absolute; left: 50%; top: -100px;
        transform: translateX(-50%); width: 500px; height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(59,158,255,0.13) 0%, transparent 70%);
        pointer-events: none;
    }
    .cl-badge {
        display: inline-flex; align-items: center; gap: 7px;
        background: rgba(59,158,255,0.15); border: 1px solid rgba(59,158,255,0.3);
        color: #3b9eff; font-size: 0.72rem; font-weight: 600;
        letter-spacing: 0.15em; text-transform: uppercase;
        padding: 5px 14px; border-radius: 20px; margin-bottom: 1.25rem;
    }
    .cl-hero h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2.2rem, 5vw, 3.5rem); font-weight: 700;
        color: #fff; margin-bottom: 0.75rem; line-height: 1.2;
    }
    .cl-hero h1 span {
        background: linear-gradient(90deg, #e8a020, #ffd270);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    }
    .cl-hero p { color: rgba(255,255,255,0.55); font-size: 1rem; max-width: 480px; margin: 0 auto; line-height: 1.75; }

    /* ── WRAP ── */
    .cl-wrap { max-width: 1200px; margin: 0 auto; padding: 4rem 2rem; }
    .cl-section-label { font-size: 0.7rem; font-weight: 600; letter-spacing: 0.18em; text-transform: uppercase; color: #1c64b1; margin-bottom: 0.4rem; }
    .cl-section-title { font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 700; color: #0b1e3d; margin-bottom: 2rem; }

    /* ── FILTER BAR ── */
    .cl-filter-bar {
        background: #fff; border-radius: 16px; padding: 1.25rem 1.5rem;
        border: 1px solid rgba(11,30,61,0.07); box-shadow: 0 4px 20px rgba(11,30,61,0.05);
        margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
        opacity: 0; transform: translateY(18px); transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .cl-filter-bar.visible { opacity: 1; transform: translateY(0); }
    .cl-search-wrap { position: relative; flex: 1; min-width: 200px; }
    .cl-search-wrap svg { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); width: 15px; height: 15px; color: #8898b5; pointer-events: none; transition: color 0.2s; }
    .cl-search-wrap:focus-within svg { color: #1c64b1; }
    .cl-search-input { width: 100%; padding: 10px 12px 10px 38px; background: #f4f7fc; border: 1px solid rgba(11,30,61,0.09); border-radius: 10px; font-family: 'Outfit', sans-serif; font-size: 0.88rem; color: #0b1e3d; transition: border-color 0.2s, box-shadow 0.2s; }
    .cl-search-input::placeholder { color: #8898b5; }
    .cl-search-input:focus { outline: none; border-color: #1c64b1; box-shadow: 0 0 0 3px rgba(28,100,177,0.1); background: #fff; }
    .cl-filter-pills { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .cl-filter-pill { display: inline-flex; align-items: center; gap: 5px; padding: 7px 16px; border-radius: 50px; font-size: 0.8rem; font-weight: 600; cursor: pointer; border: 1.5px solid rgba(11,30,61,0.1); background: transparent; color: #8898b5; font-family: 'Outfit', sans-serif; transition: all 0.18s ease; white-space: nowrap; }
    .cl-filter-pill:hover { border-color: #1c64b1; color: #1c64b1; background: #e8f0fb; }
    .cl-filter-pill.active { background: #1c64b1; border-color: #1c64b1; color: #fff; box-shadow: 0 4px 12px rgba(28,100,177,0.25); }
    .cl-result-count { font-size: 0.78rem; color: #8898b5; white-space: nowrap; margin-left: auto; }
    .cl-result-count strong { color: #0b1e3d; }
    .cl-no-results { display: none; text-align: center; padding: 3rem 1rem; color: #8898b5; }
    .cl-no-results .no-icon { font-size: 2.5rem; margin-bottom: 0.75rem; }
    .cl-no-results p { font-size: 0.9rem; line-height: 1.7; }

    /* ── CLASS CARDS ── */
    .cl-cards { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 4rem; }
    .cl-card {
        background: #fff; border-radius: 16px; padding: 1.75rem;
        border: 1px solid rgba(11,30,61,0.07);
        position: relative; overflow: hidden;
        transition: all 0.28s ease; opacity: 0; transform: translateY(22px);
    }
    .cl-card.visible { opacity: 1; transform: translateY(0); }
    .cl-card:hover { transform: translateY(-5px); box-shadow: 0 20px 50px rgba(11,30,61,0.1); border-color: rgba(28,100,177,0.18); }
    .cl-card.hidden-card { display: none; }
    .cl-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--accent); border-radius: 16px 16px 0 0; }
    .cl-card-icon { width: 52px; height: 52px; border-radius: 14px; background: var(--accent-pale); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1rem; }
    .cl-card h3 { font-family: 'Cormorant Garamond', serif; font-size: 1.2rem; font-weight: 700; color: #0b1e3d; margin-bottom: 0.4rem; }
    .cl-card-meta { font-size: 0.8rem; color: #8898b5; margin-bottom: 1rem; display: flex; align-items: center; gap: 6px; }
    .cl-card-meta span { color: #0b1e3d; font-weight: 500; }
    .cl-time-pill { display: inline-flex; align-items: center; gap: 6px; background: var(--accent-pale); color: var(--accent); font-size: 0.78rem; font-weight: 600; padding: 5px 12px; border-radius: 20px; margin-bottom: 1rem; }

    /* ── COUNTDOWN BLOCK ── */
    .cl-countdown {
        margin-top: 0.85rem;
        padding-top: 0.85rem;
        border-top: 1px solid rgba(11,30,61,0.06);
    }

    /* Label row with status dot */
    .cl-cd-label {
        display: flex; align-items: center; gap: 6px;
        font-size: 0.68rem; font-weight: 600;
        letter-spacing: 0.09em; text-transform: uppercase;
        color: #8898b5; margin-bottom: 0.6rem;
    }
    .cl-dot {
        width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0;
        background: #8898b5;
        transition: background 0.3s;
    }
    .cl-dot.live    { background: #22c55e; animation: dotPulse 1.4s ease-in-out infinite; }
    .cl-dot.soon    { background: #f59e0b; }
    .cl-dot.done    { background: #e24b4a; }
    @keyframes dotPulse {
        0%,100% { box-shadow: 0 0 0 0 rgba(34,197,94,0.4); }
        50%      { box-shadow: 0 0 0 5px rgba(34,197,94,0); }
    }

    /* Digit boxes */
    .cl-cd-digits {
        display: flex; align-items: center; gap: 5px;
        margin-bottom: 0.7rem;
    }
    .cl-cd-box {
        flex: 1;
        background: var(--accent-pale);
        border-radius: 10px;
        padding: 8px 4px 5px;
        text-align: center;
    }
    .cl-cd-num {
        display: block;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.45rem; font-weight: 700;
        color: var(--accent); line-height: 1;
        transition: color 0.3s;
    }
    .cl-cd-unit {
        display: block;
        font-size: 0.58rem; font-weight: 600;
        color: #8898b5; text-transform: uppercase;
        letter-spacing: 0.07em; margin-top: 3px;
    }
    .cl-cd-sep {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.2rem; font-weight: 700;
        color: var(--accent); opacity: 0.35;
        margin-bottom: 14px; flex-shrink: 0;
    }

    /* Live banner */
    .cl-live-msg {
        display: none;
        align-items: center; justify-content: center; gap: 7px;
        background: linear-gradient(135deg, #16a34a, #22c55e);
        color: #fff; font-size: 0.76rem; font-weight: 600;
        padding: 8px 12px; border-radius: 9px;
        letter-spacing: 0.04em; margin-bottom: 0.65rem;
        animation: livePulse 2s ease-in-out infinite;
    }
    .cl-live-msg.show { display: flex; }
    @keyframes livePulse { 0%,100%{opacity:1} 50%{opacity:0.82} }

    /* Ended banner */
    .cl-done-msg {
        display: none;
        align-items: center; justify-content: center; gap: 7px;
        background: #f4f7fc; color: #8898b5;
        font-size: 0.76rem; font-weight: 600;
        padding: 8px 12px; border-radius: 9px;
        border: 1px solid rgba(11,30,61,0.07);
        letter-spacing: 0.03em; margin-bottom: 0.65rem;
    }
    .cl-done-msg.show { display: flex; }

    /* Progress bar */
    .cl-cd-bar { height: 4px; background: rgba(11,30,61,0.07); border-radius: 4px; overflow: hidden; }
    .cl-cd-fill { height: 100%; border-radius: 4px; background: var(--accent); width: 0; transition: width 1s linear; }
    .cl-cd-prog { font-size: 0.68rem; color: #8898b5; text-align: right; margin-top: 4px; min-height: 1em; }

    /* ── SCHEDULE TABLE ── */
    .cl-table-card { background: #fff; border-radius: 16px; border: 1px solid rgba(11,30,61,0.07); overflow: hidden; margin-bottom: 4rem; opacity: 0; transform: translateY(22px); transition: opacity 0.6s ease, transform 0.6s ease; }
    .cl-table-card.visible { opacity: 1; transform: translateY(0); }
    .cl-table-header { padding: 1.25rem 1.75rem; border-bottom: 1px solid rgba(11,30,61,0.07); display: flex; align-items: center; gap: 10px; }
    .cl-table-header h5 { font-family: 'Cormorant Garamond', serif; font-size: 1.25rem; font-weight: 700; color: #0b1e3d; margin: 0; }
    .schedule-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
    .schedule-table thead tr { background: linear-gradient(135deg, #0b1e3d, #122a54); color: #fff; }
    .schedule-table th { padding: 13px 16px; font-weight: 600; font-size: 0.78rem; letter-spacing: 0.06em; text-transform: uppercase; text-align: center; border: none; }
    .schedule-table th:first-child { text-align: left; }
    .schedule-table tbody tr { border-bottom: 1px solid rgba(11,30,61,0.06); transition: background 0.15s; }
    .schedule-table tbody tr:last-child { border-bottom: none; }
    .schedule-table tbody tr:hover { background: #f8fafd; }
    .schedule-table td { padding: 12px 16px; text-align: center; color: #445; vertical-align: middle; }
    .schedule-table td:first-child { text-align: left; font-weight: 600; color: #0b1e3d; white-space: nowrap; font-size: 0.82rem; width: 130px; }
    .has-class { background: rgba(28,100,177,0.07); color: #1c64b1; font-weight: 600; border-radius: 6px; font-size: 0.8rem; }

    /* ── Subject color chips ── */
    .sub-web      { background: rgba(28,100,177,0.09);  color: #1c64b1; }
    .sub-db       { background: rgba(61,21,224,0.09);   color: #3d15e0; }
    .sub-mobile   { background: rgba(232,160,32,0.1);   color: #c07800; }
    .sub-net      { background: rgba(16,185,129,0.09);  color: #0b7a57; }
    .sub-laravel  { background: rgba(255,69,58,0.09);   color: #c0392b; }
    .sub-cyber    { background: rgba(139,92,246,0.1);   color: #6d28d9; }
    .sub-ai       { background: rgba(236,72,153,0.09);  color: #be185d; }
    .sub-os       { background: rgba(245,158,11,0.1);   color: #b45309; }
    .sub-algo     { background: rgba(20,184,166,0.09);  color: #0f766e; }
    .sub-uiux     { background: rgba(99,102,241,0.1);   color: #4338ca; }
    .sub-itsup    { background: rgba(6,182,212,0.1);    color: #0e7490; }
    .sub-graphic  { background: rgba(251,113,133,0.1);  color: #be123c; }
    .sub-digmkt   { background: rgba(52,211,153,0.1);   color: #065f46; }
    .sub-break    { background: #fff8e8; color: #c07800; }

    td.has-class  { border-radius: 6px; font-weight: 600; font-size: 0.8rem; padding: 10px 8px; }

    .lunch-row td { background: #fff8e8; color: #c07800; font-weight: 700; font-size: 0.78rem; letter-spacing: 0.06em; text-transform: uppercase; }
    .lunch-row td:first-child { color: #e8a020; }
    .empty-slot { color: rgba(11,30,61,0.2); font-size: 0.8rem; }

    /* ── Weekend columns highlight ── */
    .schedule-table th:nth-child(7),
    .schedule-table th:nth-child(8) {
        border-left: 2px solid rgba(255,255,255,0.15);
    }
    .schedule-table td:nth-child(7) {
        background: rgba(255,202,40,0.04);
        border-left: 2px solid rgba(255,202,40,0.15);
    }
    .schedule-table td:nth-child(8) {
        background: rgba(255,107,107,0.04);
        border-left: 2px solid rgba(255,107,107,0.15);
    }

    /* ── Teacher table specific ── */
    .teacher-table th { font-size: 0.7rem; padding: 9px 8px; }
    .teacher-table .sub-header th { background: rgba(255,255,255,0.08); font-size: 0.65rem; font-weight: 600; color: rgba(255,255,255,0.7); }
    .teacher-table .row-num { text-align: center; color: #9ca3af; font-size: 0.8rem; width: 30px; }
    .teacher-table .teacher-name { font-weight: 700; color: #1a237e; font-size: 0.83rem; white-space: nowrap; padding: 12px 14px; }
    .teacher-table td.has-class { font-size: 0.75rem; line-height: 1.4; padding: 10px 8px; vertical-align: middle; }
    .teacher-table td.has-class small { display: block; font-size: 0.65rem; font-weight: 500; opacity: 0.75; margin-top: 3px; }

    /* ── Legend ── */
    .sch-legend {
        display: flex; flex-wrap: wrap; gap: 8px;
        padding: 1rem 1.75rem;
        border-top: 1px solid rgba(11,30,61,0.06);
    }
    .leg-item {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 0.72rem; font-weight: 600;
        padding: 4px 12px; border-radius: 20px;
    }

    /* ── SERVICES ── */
    .cl-services { margin-bottom: 2rem; }
    .cl-srv-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(270px, 1fr)); gap: 1.25rem; }
    .cl-srv-item { background: #fff; border-radius: 14px; padding: 1.5rem; border: 1px solid rgba(11,30,61,0.07); display: flex; align-items: flex-start; gap: 1rem; transition: all 0.25s ease; opacity: 0; transform: translateY(20px); }
    .cl-srv-item.visible { opacity: 1; transform: translateY(0); }
    .cl-srv-item:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(11,30,61,0.09); border-color: rgba(28,100,177,0.15); }
    .cl-srv-icon { width: 46px; height: 46px; border-radius: 12px; background: #e8f5e9; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
    .cl-srv-text h3 { font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; font-weight: 700; color: #0b1e3d; margin-bottom: 0.3rem; }
    .cl-srv-text p { font-size: 0.845rem; color: #8898b5; line-height: 1.65; margin: 0; }

    @media (max-width: 600px) {
        .cl-filter-bar { flex-direction: column; align-items: stretch; }
        .cl-result-count { margin-left: 0; }
        .cl-filter-pills { justify-content: flex-start; }
    }
</style>

<div class="cl-page">

    <!-- Hero -->
    <div class="cl-hero">
        <div class="cl-badge">📅 Schedule</div>
        <h1>កាលវិភាគ<span>ថ្នាក់រៀន</span></h1>
        <p>គ្រប់គ្រង និងតាមដានរាល់ម៉ោងសិក្សារបស់សិស្ស</p>
    </div>

    <div class="cl-wrap">

        <!-- Filter Bar -->
        <div class="cl-filter-bar" id="filterBar">
            <div class="cl-search-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
                <input type="text" class="cl-search-input" id="classSearch"
                    placeholder="ស្វែងរកថ្នាក់រៀន... (e.g. Web, Database)"
                    oninput="filterCards()"/>
            </div>
            <div class="cl-filter-pills">
                <button class="cl-filter-pill active" data-filter="all"       onclick="setFilter(this,'all')">🗂 ទាំងអស់</button>
                <button class="cl-filter-pill"        data-filter="morning"   onclick="setFilter(this,'morning')">🌅 ព្រឹក</button>
                <button class="cl-filter-pill"        data-filter="afternoon" onclick="setFilter(this,'afternoon')">☀️ ល្ងាច</button>
            </div>
            <div class="cl-result-count" id="resultCount">
                បង្ហាញ <strong id="visibleCount">3</strong> / <strong>3</strong> ថ្នាក់
            </div>
        </div>

        <div class="cl-no-results" id="noResults">
            <div class="no-icon">🔍</div>
            <p>រកមិនឃើញថ្នាក់ដែលត្រូវនឹងការស្វែងរករបស់អ្នក។<br>
               សូមព្យាយាមពាក្យផ្សេង ឬជ្រើសតម្រង «ទាំងអស់»។</p>
        </div>

        <!-- Class Cards -->
        <div class="cl-section-label">ថ្នាក់រៀន</div>
        <h2 class="cl-section-title">ថ្នាក់រៀនបច្ចុប្បន្ន</h2>

        <div class="cl-cards" id="classCards">

            <!-- Card 1: Web Development 08:00–10:00 -->
            <div class="cl-card"
                 style="--accent:#1c64b1; --accent-pale:#e8f0fb;"
                 data-name="web development" data-time="morning" data-teacher="លោកគ្រូ ហ៊ី ឡេងសែ"
                 data-start="08:00" data-end="10:00">
                <div class="cl-card-icon">💻</div>
                <h3>Web Development</h3>
                <p class="cl-card-meta">🏫 បន្ទប់: <span>A101</span> &nbsp;|&nbsp; 👨‍🏫 <span>លោកគ្រូ ហ៊ី ឡេងសែ</span></p>
                <div class="cl-time-pill">🕗 07:30 AM – 12:00 AM</div>
                <div class="cl-countdown">
                    <div class="cl-cd-label"><span class="cl-dot"></span><span class="cd-lbl-text"></span></div>
                    <div class="cl-live-msg">🟢 &nbsp;កំពុងរៀន — ចូលថ្នាក់ឥឡូវ!</div>
                    <div class="cl-done-msg">✅ &nbsp;ថ្នាក់បានបញ្ចប់ហើយ</div>
                    <div class="cl-cd-digits">
                        <div class="cl-cd-box"><span class="cl-cd-num" id="h0">00</span><span class="cl-cd-unit">ម៉ោង</span></div>
                        <span class="cl-cd-sep">:</span>
                        <div class="cl-cd-box"><span class="cl-cd-num" id="m0">00</span><span class="cl-cd-unit">នាទី</span></div>
                        <span class="cl-cd-sep">:</span>
                        <div class="cl-cd-box"><span class="cl-cd-num" id="s0">00</span><span class="cl-cd-unit">វិនាទី</span></div>
                    </div>
                    <div class="cl-cd-bar"><div class="cl-cd-fill"></div></div>
                    <div class="cl-cd-prog"></div>
                </div>
            </div>

            <!-- Card 2: Database Design 13:00–15:00 -->
            <div class="cl-card"
                 style="--accent:#3d15e0; --accent-pale:#ede8fd; transition-delay:0.1s;"
                 data-name="database design" data-time="afternoon" data-teacher="សុភា"
                 data-start="13:00" data-end="15:00">
                <div class="cl-card-icon">🗄️</div>
                <h3>Database Design</h3>
                <p class="cl-card-meta">🏫 បន្ទប់: <span>B205</span> &nbsp;|&nbsp; 👩‍🏫 <span>អ្នកគ្រូ សុភា</span></p>
                <div class="cl-time-pill">🕐 01:00 PM – 04:30 PM</div>
                <div class="cl-countdown">
                    <div class="cl-cd-label"><span class="cl-dot"></span><span class="cd-lbl-text"></span></div>
                    <div class="cl-live-msg">🟢 &nbsp;កំពុងរៀន — ចូលថ្នាក់ឥឡូវ!</div>
                    <div class="cl-done-msg">✅ &nbsp;ថ្នាក់បានបញ្ចប់ហើយ</div>
                    <div class="cl-cd-digits">
                        <div class="cl-cd-box"><span class="cl-cd-num" id="h1">00</span><span class="cl-cd-unit">ម៉ោង</span></div>
                        <span class="cl-cd-sep">:</span>
                        <div class="cl-cd-box"><span class="cl-cd-num" id="m1">00</span><span class="cl-cd-unit">នាទី</span></div>
                        <span class="cl-cd-sep">:</span>
                        <div class="cl-cd-box"><span class="cl-cd-num" id="s1">00</span><span class="cl-cd-unit">វិនាទី</span></div>
                    </div>
                    <div class="cl-cd-bar"><div class="cl-cd-fill"></div></div>
                    <div class="cl-cd-prog"></div>
                </div>
            </div>

            <!-- Card 3: Mobile App 15:30–17:30 -->
            <div class="cl-card"
                 style="--accent:#e8a020; --accent-pale:#fff3e0; transition-delay:0.2s;"
                 data-name="mobile app" data-time="afternoon" data-teacher="ហុងមុំ"
                 data-start="15:30" data-end="17:30">
                <div class="cl-card-icon">📱</div>
                <h3>Mobile App</h3>
                <p class="cl-card-meta">🏫 បន្ទប់: <span>C301</span> &nbsp;|&nbsp; 👨‍🏫 <span>អ្នកស្រី ហុងមុំ</span></p>
                <div class="cl-time-pill">🕞 05:30 PM – 08:30 PM</div>
                <div class="cl-countdown">
                    <div class="cl-cd-label"><span class="cl-dot"></span><span class="cd-lbl-text"></span></div>
                    <div class="cl-live-msg">🟢 &nbsp;កំពុងរៀន — ចូលថ្នាក់ឥឡូវ!</div>
                    <div class="cl-done-msg">✅ &nbsp;ថ្នាក់បានបញ្ចប់ហើយ</div>
                    <div class="cl-cd-digits">
                        <div class="cl-cd-box"><span class="cl-cd-num" id="h2">00</span><span class="cl-cd-unit">ម៉ោង</span></div>
                        <span class="cl-cd-sep">:</span>
                        <div class="cl-cd-box"><span class="cl-cd-num" id="m2">00</span><span class="cl-cd-unit">នាទី</span></div>
                        <span class="cl-cd-sep">:</span>
                        <div class="cl-cd-box"><span class="cl-cd-num" id="s2">00</span><span class="cl-cd-unit">វិនាទី</span></div>
                    </div>
                    <div class="cl-cd-bar"><div class="cl-cd-fill"></div></div>
                    <div class="cl-cd-prog"></div>
                </div>
            </div>

        </div>

        <!-- Teacher Schedule Table (from picture) -->
        <div class="cl-section-label">ប្រចាំសប្តាហ៍</div>
        <h2 class="cl-section-title">កាលវិភាគបង្រៀន — ក្រុម IT010b1</h2>

        {{-- Info banner --}}
        <div style="background:linear-gradient(135deg,#1a237e,#3949ab);border-radius:14px;padding:1.25rem 1.75rem;margin-bottom:1.5rem;color:#fff;display:flex;align-items:center;gap:1rem;flex-wrap:wrap;">
            <i class="fas fa-graduation-cap" style="font-size:1.5rem;opacity:.8;"></i>
            <div>
                <div style="font-size:0.7rem;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;opacity:.65;margin-bottom:2px;">កាលវិភាគ</div>
                <div style="font-weight:700;font-size:0.95rem;">ការបែងចែកម៉ោងបង្រៀន មុខវិជ្ជាទីបី ឆ្នាំទីបី ឆ្នាំសិក្សា ២០២៥–២០២៦</div>
                <div style="font-size:0.78rem;opacity:.7;margin-top:3px;">ចាប់អនុវត្តន៍ ថ្ងៃទី ២៣ ខែ មីនា ឆ្នាំ ២០២៦</div>
            </div>
        </div>

        <div class="cl-table-card">
            <div class="cl-table-header"><span>📆</span><h5>តារាងម៉ោងបង្រៀន — ក្រុម IT010b1</h5></div>
            <div style="overflow-x:auto;">
                <table class="schedule-table teacher-table">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width:30px;">#</th>
                            <th rowspan="2" style="min-width:140px;text-align:left;">គ្រូបង្រៀន</th>
                            <th colspan="2">ច័ន្ទ</th>
                            <th colspan="2">អង្គារ</th>
                            <th colspan="2">ពុធ</th>
                            <th colspan="2">ព្រហស្បតិ៍</th>
                            <th colspan="2">សុក្រ</th>
                            <th colspan="2" style="background:rgba(255,202,40,0.2);color:#b8860b;">សៅរ៍</th>
                        </tr>
                        <tr class="sub-header">
                            <th>5:30–6:50</th><th>7:10–8:30</th>
                            <th>5:30–6:50</th><th>7:10–8:30</th>
                            <th>5:30–6:50</th><th>7:10–8:30</th>
                            <th>5:30–6:50</th><th>7:10–8:30</th>
                            <th>5:30–6:50</th><th>7:10–8:30</th>
                            <th style="background:rgba(255,202,40,0.1);">5:30–6:50</th>
                            <th style="background:rgba(255,202,40,0.1);">7:10–8:30</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Row 1 --}}
                        <tr>
                            <td class="row-num">១</td>
                            <td class="teacher-name">លោក យុង សាវុធ</td>
                            <td class="has-class sub-os" colspan="2">System Server Administration<br><small>(Linux) 48h · AK-316</small></td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                        </tr>
                        {{-- Row 2 --}}
                        <tr>
                            <td class="row-num">២</td>
                            <td class="teacher-name">លោក ហ៊ី ឡេងសែ</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="has-class sub-web" colspan="2">Web Application Development<br><small>48h · AK-316</small></td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                        </tr>
                        {{-- Row 3 --}}
                        <tr>
                            <td class="row-num">៣</td>
                            <td class="teacher-name">លោក កើត បូរ៉ា</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="has-class sub-laravel" colspan="2">Software Project Development<br><small>48h · AK-316</small></td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                        </tr>
                        {{-- Row 4 --}}
                        <tr>
                            <td class="row-num">៤</td>
                            <td class="teacher-name">លោក ហេង វណ្ណា</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="has-class sub-net" colspan="2">Cisco Routing and Switching<br><small>48h · AK-316</small></td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                        </tr>
                        {{-- Row 5 --}}
                        <tr>
                            <td class="row-num">៥</td>
                            <td class="teacher-name">លោក ស្រី ប៊ុនផុន</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="has-class sub-algo" colspan="2">System Analysis and Design<br><small>48h · AK-316</small></td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                        </tr>
                        {{-- Row 6 --}}
                        <tr>
                            <td class="row-num">៦</td>
                            <td class="teacher-name">លោក ប៊ិន ប៊ុនចេត</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="has-class sub-ai">Python Programming<br><small>48h · AK-316<br>(2:00–5:00)</small></td>
                            <td class="empty-slot">—</td>
                        </tr>
                        {{-- Row 7 --}}
                        <tr>
                            <td class="row-num">៧</td>
                            <td class="teacher-name">អ្នកស្រី ហុងមុំ</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td><td class="empty-slot">—</td>
                            <td class="empty-slot">—</td>
                            <td class="has-class sub-mobile">Native Mobile Application<br><small>48h · AK-316</small></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Legend --}}
            <div class="sch-legend">
                <span class="leg-item sub-os">🖥️ System Server (Linux)</span>
                <span class="leg-item sub-web">🌐 Web App Development</span>
                <span class="leg-item sub-laravel">🔴 Software Project</span>
                <span class="leg-item sub-net">🔌 Cisco Routing</span>
                <span class="leg-item sub-algo">📐 System Analysis</span>
                <span class="leg-item sub-ai">🤖 Python Programming</span>
                <span class="leg-item sub-mobile">📱 Mobile Application</span>
                <span class="leg-item sub-itsup">🛠️ IT Support</span>
                <span class="leg-item sub-graphic">🖌️ Graphic Design</span>
                <span class="leg-item sub-digmkt">📣 Digital Marketing</span>
            </div>
        </div>

        <!-- Services -->
     <div class="cl-services">
            <div class="cl-section-label">សេវាកម្ម</div>
            <h2 class="cl-section-title">សេវាកម្មដែលយើងផ្តល់ជូន</h2>
            <div class="cl-srv-grid">
                <div class="cl-srv-item">
                    <div class="cl-srv-icon">🚚</div>
                    <div class="cl-srv-text"><h3>សេវាដឹកជញ្ជូនរហ័ស</h3><p>យើងដឹកជញ្ជូនសៀវភៅទៅដល់ដៃអ្នកក្នុងរយៈពេល ២៤ ម៉ោងសម្រាប់ភ្នំពេញ។</p></div>
                </div>
                <div class="cl-srv-item" style="transition-delay:0.08s;">
                    <div class="cl-srv-icon" style="background:#e8f0fb;">🔄</div>
                    <div class="cl-srv-text"><h3>ការប្តូរសៀវភៅវិញ</h3><p>ប្រសិនបើសៀវភៅមានបញ្ហា បាក់ទំព័រ ឬខូចខាត អ្នកអាចប្តូរវិញបានក្នុងរយៈពេល ៧ ថ្ងៃ។</p></div>
                </div>
                <div class="cl-srv-item" style="transition-delay:0.16s;">
                    <div class="cl-srv-icon" style="background:#fff3e0;">🪪</div>
                    <div class="cl-srv-text"><h3>សមាជិកភាពបណ្ណាល័យ</h3><p>ចុះឈ្មោះជាសមាជិកដើម្បីទទួលបានការបញ្ចុះតម្លៃ ១០% រាល់ការទិញសៀវភៅ។</p></div>
                </div>
                <div class="cl-srv-item" style="transition-delay:0.24s;">
                    <div class="cl-srv-icon" style="background:#fce4ec;">📖</div>
                    <div class="cl-srv-text"><h3>កម្មវិធីអានសៀវភៅហ្វ្រី</h3><p>មានកន្លែងសម្រាប់អានសៀវភៅដោយសេរីនៅក្នុងបណ្ណាគាររបស់យើង។</p></div>
                </div>
            </div>
        </div>


    </div>
</div>

<script>
/* ── Scroll reveal ── */
const revealEls = document.querySelectorAll('.cl-card, .cl-table-card, .cl-srv-item, .cl-filter-bar');
const io = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); } });
}, { threshold: 0.1 });
revealEls.forEach(el => io.observe(el));

/* ── Search / Filter ── */
let activeFilter = 'all';
function setFilter(btn, filter) {
    activeFilter = filter;
    document.querySelectorAll('.cl-filter-pill').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    filterCards();
}
function filterCards() {
    const query = document.getElementById('classSearch').value.toLowerCase().trim();
    const cards = document.querySelectorAll('#classCards .cl-card');
    let visible = 0;
    cards.forEach(card => {
        const name    = card.dataset.name    || '';
        const time    = card.dataset.time    || '';
        const teacher = card.dataset.teacher || '';
        const ok = (!query || name.includes(query) || teacher.includes(query)) &&
                   (activeFilter === 'all' || time === activeFilter);
        card.classList.toggle('hidden-card', !ok);
        if (ok) { if (!card.classList.contains('visible')) card.classList.add('visible'); visible++; }
    });
    document.getElementById('visibleCount').textContent = visible;
    document.getElementById('noResults').style.display = visible === 0 ? 'block' : 'none';
}

/* ── Countdown Timers ── */
function pad(n) { return String(n).padStart(2, '0'); }

function todayAt(hhmm) {
    const [h, m] = hhmm.split(':').map(Number);
    const d = new Date(); d.setHours(h, m, 0, 0); return d;
}

function tickCard(card, idx) {
    const start = todayAt(card.dataset.start);
    const end   = todayAt(card.dataset.end);
    const now   = new Date();

    const dot      = card.querySelector('.cl-dot');
    const lblText  = card.querySelector('.cd-lbl-text');
    const digits   = card.querySelector('.cl-cd-digits');
    const liveBan  = card.querySelector('.cl-live-msg');
    const doneBan  = card.querySelector('.cl-done-msg');
    const fill     = card.querySelector('.cl-cd-fill');
    const progTxt  = card.querySelector('.cl-cd-prog');
    const hEl      = card.querySelector('#h' + idx);
    const mEl      = card.querySelector('#m' + idx);
    const sEl      = card.querySelector('#s' + idx);

    const totalSec = (end - start) / 1000;
    const SOON     = 30 * 60; /* 30 min warning */

    /* LIVE */
    if (now >= start && now < end) {
        dot.className    = 'cl-dot live';
        lblText.textContent = 'កំពុងរៀន';
        digits.style.display = 'none';
        liveBan.classList.add('show');
        doneBan.classList.remove('show');
        const elapsed = (now - start) / 1000;
        fill.style.width = Math.min(100, (elapsed / totalSec * 100)).toFixed(2) + '%';
        const remMs = end - now;
        const rm = Math.floor(remMs / 60000);
        const rs = Math.floor((remMs % 60000) / 1000);
        progTxt.textContent = `នៅសល់ ${rm} នាទី ${pad(rs)} វិនាទីទៀត`;
        return;
    }

    /* ENDED */
    if (now >= end) {
        dot.className    = 'cl-dot done';
        lblText.textContent = 'បានបញ្ចប់';
        digits.style.display = 'none';
        liveBan.classList.remove('show');
        doneBan.classList.add('show');
        fill.style.width = '100%';
        progTxt.textContent = '';
        return;
    }

    /* UPCOMING */
    liveBan.classList.remove('show');
    doneBan.classList.remove('show');
    digits.style.display = 'flex';

    const diffMs = start - now;
    const diffS  = Math.floor(diffMs / 1000);
    hEl.textContent = pad(Math.floor(diffS / 3600));
    mEl.textContent = pad(Math.floor((diffS % 3600) / 60));
    sEl.textContent = pad(diffS % 60);

    if (diffS <= SOON) {
        dot.className = 'cl-dot soon';
        lblText.textContent = 'ជិតដល់ម៉ោងរៀន';
    } else {
        dot.className = 'cl-dot';
        lblText.textContent = 'ចាប់ផ្ដើមមុន';
    }

    /* progress = fraction of 24h elapsed */
    const dayMs = 24 * 3600 * 1000;
    const midnight = new Date(now); midnight.setHours(0,0,0,0);
    fill.style.width = Math.min(100, ((now - midnight) / dayMs * 100)).toFixed(2) + '%';
    progTxt.textContent = `ចាប់ផ្ដើម ${card.dataset.start} — បញ្ចប់ ${card.dataset.end}`;
}

function tickAll() {
    document.querySelectorAll('#classCards .cl-card').forEach((card, i) => tickCard(card, i));
}

tickAll();
setInterval(tickAll, 1000);
</script>

@endsection