@extends('layouts.master')

@section('title', 'ទំព័រដើម - Home')

@section('content')

<style>
    /* ══════════════════════════════
       HOME PAGE STYLES
    ══════════════════════════════ */
    .hm-wrap {
        padding: 0;
    }

    /* ── HERO ── */
    .hm-hero {
        background: linear-gradient(135deg, #1a237e 0%, #283593 55%, #3949ab 100%);
        padding: 5rem 2.5rem 4.5rem;
        position: relative;
        overflow: hidden;
        text-align: center;
    }
    .hm-hero::before {
        content: '';
        position: absolute; left: 50%; top: -100px;
        transform: translateX(-50%);
        width: 600px; height: 600px; border-radius: 50%;
        background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%);
        pointer-events: none;
    }
    /* Diagonal decorative stripe */
    .hm-hero::after {
        content: '';
        position: absolute; bottom: -2px; left: 0; right: 0;
        height: 60px;
        background: #f4f7fc;
        clip-path: ellipse(55% 100% at 50% 100%);
    }

    .hm-hero-inner { position: relative; z-index: 2; max-width: 720px; margin: 0 auto; }

    .hm-hero-badge {
        display: inline-flex; align-items: center; gap: 7px;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.22);
        color: rgba(255,255,255,0.9);
        font-size: 0.72rem; font-weight: 700;
        letter-spacing: 0.14em; text-transform: uppercase;
        padding: 5px 16px; border-radius: 20px;
        margin-bottom: 1.4rem;
    }

    .hm-hero h1 {
        font-size: clamp(2rem, 5vw, 3.2rem);
        font-weight: 700; color: #fff;
        line-height: 1.2; margin-bottom: 1rem;
    }
    .hm-hero h1 span {
        background: linear-gradient(90deg, #ffca28, #ffe082);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .hm-hero p {
        font-size: 1rem; color: rgba(255,255,255,0.65);
        line-height: 1.8; margin-bottom: 2rem; max-width: 520px; margin-left: auto; margin-right: auto;
    }

    /* Hero CTA buttons */
    .hm-hero-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
    .hm-btn-primary {
        display: inline-flex; align-items: center; gap: 8px;
        background: #ffca28; color: #1a237e;
        border: none; border-radius: 50px;
        padding: 13px 28px; font-weight: 700; font-size: 0.9rem;
        cursor: pointer; text-decoration: none;
        box-shadow: 0 6px 22px rgba(255,202,40,0.35);
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .hm-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(255,202,40,0.45); color: #1a237e; }
    .hm-btn-outline {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(255,255,255,0.1);
        border: 1.5px solid rgba(255,255,255,0.3);
        color: #fff; border-radius: 50px;
        padding: 12px 26px; font-weight: 600; font-size: 0.9rem;
        cursor: pointer; text-decoration: none;
        transition: background 0.18s;
    }
    .hm-btn-outline:hover { background: rgba(255,255,255,0.18); color: #fff; }

    /* ── MAIN CONTENT WRAP ── */
    .hm-body { max-width: 1200px; margin: 0 auto; padding: 3.5rem 2rem 4rem; }

    /* ── STATS ROW ── */
    .hm-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 3.5rem;
        opacity: 0; transform: translateY(18px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .hm-stats.visible { opacity: 1; transform: translateY(0); }

    @media (max-width: 768px) { .hm-stats { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 440px) { .hm-stats { grid-template-columns: 1fr; } }

    .hm-stat {
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem 1.25rem;
        text-align: center;
        border: 1px solid rgba(26,35,126,0.07);
        box-shadow: 0 4px 18px rgba(26,35,126,0.05);
        position: relative; overflow: hidden;
        transition: transform 0.22s, box-shadow 0.22s;
    }
    .hm-stat:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(26,35,126,0.1); }
    .hm-stat::after {
        content: '';
        position: absolute; bottom: 0; left: 0; right: 0;
        height: 3px;
        background: var(--stat-color, #1a237e);
        border-radius: 0 0 16px 16px;
    }
    .hm-stat-icon {
        width: 48px; height: 48px;
        border-radius: 14px;
        background: var(--stat-bg, #e8eaf6);
        color: var(--stat-color, #1a237e);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem;
        margin: 0 auto 0.75rem;
    }
    .hm-stat-num {
        font-size: 2rem; font-weight: 700;
        color: var(--stat-color, #1a237e);
        line-height: 1; margin-bottom: 0.3rem;
        font-family: Georgia, serif;
    }
    .hm-stat-label {
        font-size: 0.78rem; font-weight: 600;
        color: #6b7280; text-transform: uppercase; letter-spacing: 0.08em;
    }

    /* ── SECTION LABEL & TITLE ── */
    .hm-sec-label {
        font-size: 0.68rem; font-weight: 700;
        letter-spacing: 0.16em; text-transform: uppercase;
        color: #3949ab; margin-bottom: 0.35rem;
    }
    .hm-sec-title {
        font-size: clamp(1.5rem, 3vw, 2rem);
        font-weight: 700; color: #1a237e;
        margin-bottom: 1.75rem; line-height: 1.25;
    }

    /* ── QUICK LINKS GRID ── */
    .hm-quick {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.1rem;
        margin-bottom: 3.5rem;
    }
    .hm-quick-card {
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem 1.25rem;
        text-align: center;
        border: 1px solid rgba(26,35,126,0.07);
        text-decoration: none;
        color: inherit;
        transition: all 0.24s ease;
        opacity: 0; transform: translateY(20px);
        display: flex; flex-direction: column; align-items: center; gap: 0.6rem;
    }
    .hm-quick-card.visible { opacity: 1; transform: translateY(0); }
    .hm-quick-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 48px rgba(26,35,126,0.1);
        border-color: rgba(57,73,171,0.2);
        color: inherit;
    }
    .hm-quick-icon {
        width: 56px; height: 56px;
        border-radius: 16px;
        background: var(--qc-bg, #e8eaf6);
        color: var(--qc-color, #1a237e);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.6rem;
        transition: transform 0.2s;
    }
    .hm-quick-card:hover .hm-quick-icon { transform: scale(1.1); }
    .hm-quick-label {
        font-size: 0.875rem; font-weight: 700; color: #1a237e;
    }
    .hm-quick-desc {
        font-size: 0.75rem; color: #6b7280; line-height: 1.5;
    }

    /* ── FEATURES ── */
    .hm-features {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1.25rem;
        margin-bottom: 3.5rem;
    }
    .hm-feat {
        background: #fff;
        border-radius: 16px;
        padding: 1.75rem;
        border: 1px solid rgba(26,35,126,0.07);
        box-shadow: 0 4px 18px rgba(26,35,126,0.04);
        display: flex; align-items: flex-start; gap: 1rem;
        opacity: 0; transform: translateY(18px);
        transition: all 0.4s ease;
    }
    .hm-feat.visible { opacity: 1; transform: translateY(0); }
    .hm-feat:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(26,35,126,0.09); }
    .hm-feat-icon {
        width: 50px; height: 50px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; flex-shrink: 0;
    }
    .hm-feat-text h4 {
        font-size: 1rem; font-weight: 700;
        color: #1a237e; margin-bottom: 5px;
    }
    .hm-feat-text p {
        font-size: 0.82rem; color: #6b7280; line-height: 1.65; margin: 0;
    }

    /* ── LATEST NOTICE BANNER ── */
    .hm-notice {
        background: linear-gradient(135deg, #e8eaf6, #c5cae9);
        border-radius: 16px;
        padding: 1.5rem 2rem;
        display: flex; align-items: center; gap: 1.25rem;
        flex-wrap: wrap;
        border: 1px solid rgba(26,35,126,0.1);
        margin-bottom: 3.5rem;
        opacity: 0; transform: translateY(16px);
        transition: opacity 0.5s 0.1s, transform 0.5s 0.1s;
    }
    .hm-notice.visible { opacity: 1; transform: translateY(0); }
    .hm-notice-icon {
        width: 52px; height: 52px; border-radius: 14px;
        background: #1a237e; color: #ffca28;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; flex-shrink: 0;
    }
    .hm-notice-body { flex: 1; min-width: 0; }
    .hm-notice-body h4 {
        font-size: 1rem; font-weight: 700; color: #1a237e; margin-bottom: 4px;
    }
    .hm-notice-body p { font-size: 0.83rem; color: #3949ab; line-height: 1.6; margin: 0; }
    .hm-notice-btn {
        display: inline-flex; align-items: center; gap: 6px;
        background: #1a237e; color: #fff;
        border: none; border-radius: 10px;
        padding: 10px 20px; font-size: 0.83rem; font-weight: 700;
        cursor: pointer; text-decoration: none; white-space: nowrap;
        transition: background 0.15s;
    }
    .hm-notice-btn:hover { background: #3949ab; color: #fff; }

    /* Responsive */
    @media (max-width: 600px) {
        .hm-hero { padding: 3.5rem 1.25rem 4rem; }
        .hm-body  { padding: 2.5rem 1.25rem 3rem; }
    }
</style>

<div class="hm-wrap">

    {{-- ══ HERO ══ --}}
    <div class="hm-hero">
        <div class="hm-hero-inner">
            <div class="hm-hero-badge">🎓 School Management System</div>
            <h1>ស្វាគមន៍មក<span>ប្រព័ន្ធគ្រប់គ្រង</span>សាលារបស់យើង</h1>
            <p>គ្រប់គ្រងសិស្ស គ្រូបង្រៀន ម៉ោងរៀន ហើយ​追跡​ ការ​ចូលរៀន — ទាំងអស់​ក្នុង​ប្រព័ន្ធ​តែ​មួយ</p>
            <div class="hm-hero-btns">
                <a href="/students" class="hm-btn-primary">
                    <i class="fas fa-user-graduate"></i> ចូលមើលសិស្ស
                </a>
                <a href="/class" class="hm-btn-outline">
                    <i class="fas fa-calendar-alt"></i> កាលវិភាគ
                </a>
            </div>
        </div>
    </div>

    <div class="hm-body">

        {{-- ══ STATS (ទាញពី DB ពិតប្រាកដ) ══ --}}
        <div class="hm-stats" id="hmStats">
            <div class="hm-stat" style="--stat-color:#1a237e; --stat-bg:#e8eaf6;">
                <div class="hm-stat-icon"><i class="fas fa-user-graduate"></i></div>
                <div class="hm-stat-num">{{ $totalStudents ?? 0 }}</div>
                <div class="hm-stat-label">សិស្សសរុប</div>
            </div>
            <div class="hm-stat" style="--stat-color:#00695c; --stat-bg:#e0f2f1;">
                <div class="hm-stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <div class="hm-stat-num">{{ $totalTeachers ?? 0 }}</div>
                <div class="hm-stat-label">គ្រូបង្រៀន</div>
            </div>
            <div class="hm-stat" style="--stat-color:#e65100; --stat-bg:#fff3e0;">
                <div class="hm-stat-icon"><i class="fas fa-school"></i></div>
                <div class="hm-stat-num">{{ $totalClasses ?? 0 }}</div>
                <div class="hm-stat-label">ថ្នាក់រៀន</div>
            </div>
            <div class="hm-stat" style="--stat-color:#6a1b9a; --stat-bg:#f3e5f5;">
                <div class="hm-stat-icon"><i class="fas fa-book-open"></i></div>
                <div class="hm-stat-num">{{ $totalCourses ?? 0 }}</div>
                <div class="hm-stat-label">មុខវិជ្ជា</div>
            </div>
        </div>

        {{-- ══ NOTICE BANNER ══ --}}
        <div class="hm-notice" id="hmNotice">
            <div class="hm-notice-icon"><i class="fas fa-bullhorn"></i></div>
            <div class="hm-notice-body">
                <h4>📢 សេចក្ដីជូនដំណឹងថ្មី</h4>
                <p>ការប្រឡងពាក់កណ្ដាលឆ្នាំ នឹងចាប់ផ្ដើមនៅថ្ងៃ <strong>១ ឧសភា ២០២៦</strong> — សូម​សិស្ស​ទាំងអស់​ត្រៀម​ខ្លួន​ជា​មុន!</p>
            </div>
            <a href="/services" class="hm-notice-btn">
                <i class="fas fa-arrow-right"></i> មើលបន្ថែម
            </a>
        </div>

        {{-- ══ QUICK LINKS ══ --}}
        <div class="hm-sec-label">🔗 ផ្លូវកាត់</div>
        <h2 class="hm-sec-title">ចូលប្រើប្រាស់ភ្លាម</h2>

        <div class="hm-quick">

            <a href="/students" class="hm-quick-card" style="--qc-bg:#e8eaf6; --qc-color:#1a237e;">
                <div class="hm-quick-icon"><i class="fas fa-user-graduate"></i></div>
                <div class="hm-quick-label">Students</div>
                <div class="hm-quick-desc">បញ្ជីសិស្ស ព័ត៌មាន ការចូលរៀន</div>
            </a>

            <a href="/teachers" class="hm-quick-card" style="--qc-bg:#e0f2f1; --qc-color:#00695c;">
                <div class="hm-quick-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <div class="hm-quick-label">Teachers</div>
                <div class="hm-quick-desc">ព័ត៌មានគ្រូ ម៉ោងបង្រៀន</div>
            </a>

            <a href="/class" class="hm-quick-card" style="--qc-bg:#fff3e0; --qc-color:#e65100;">
                <div class="hm-quick-icon"><i class="fas fa-calendar-alt"></i></div>
                <div class="hm-quick-label">Class Schedule</div>
                <div class="hm-quick-desc">កាលវិភាគ ម៉ោងរៀន ប្រចាំថ្ងៃ</div>
            </a>

            <a href="/shop" class="hm-quick-card" style="--qc-bg:#fce4ec; --qc-color:#c62828;">
                <div class="hm-quick-icon"><i class="fas fa-shopping-bag"></i></div>
                <div class="hm-quick-label">Shop / Books</div>
                <div class="hm-quick-desc">ទិញសៀវភៅ Course IT</div>
            </a>

            <a href="/services" class="hm-quick-card" style="--qc-bg:#e8f5e9; --qc-color:#2e7d32;">
                <div class="hm-quick-icon"><i class="fas fa-concierge-bell"></i></div>
                <div class="hm-quick-label">Services</div>
                <div class="hm-quick-desc">សេវាកម្ម ព័ត៌មានសាលា</div>
            </a>

            <a href="/about-us" class="hm-quick-card" style="--qc-bg:#ede7f6; --qc-color:#6a1b9a;">
                <div class="hm-quick-icon"><i class="fas fa-info-circle"></i></div>
                <div class="hm-quick-label">About Us</div>
                <div class="hm-quick-desc">ប្រវត្តិ លក្ខណៈ ក្រុមការងារ</div>
            </a>

        </div>

        {{-- ══ FEATURES ══ --}}
        <div class="hm-sec-label">⭐ លក្ខណៈពិសេស</div>
        <h2 class="hm-sec-title">ហេតុអ្វីជ្រើសសាលារបស់យើង?</h2>

        <div class="hm-features">

            <div class="hm-feat">
                <div class="hm-feat-icon" style="background:#e8eaf6;">📊</div>
                <div class="hm-feat-text">
                    <h4>ប្រព័ន្ធគ្រប់គ្រងទំនើប</h4>
                    <p>ចូលមើល ហើយ​ គ្រប់គ្រង​ ព័ត៌មាន​ សិស្ស-គ្រូ​ ទាំងអស់​ ក្នុង​ real-time ។</p>
                </div>
            </div>

            <div class="hm-feat" style="transition-delay:.08s">
                <div class="hm-feat-icon" style="background:#e0f2f1;">📅</div>
                <div class="hm-feat-text">
                    <h4>កាលវិភាគច្បាស់លាស់</h4>
                    <p>ម៉ោង​រៀន​ ប្រចាំ​ថ្ងៃ​ ហើយ Countdown Timer ដល់​ ម៉ោង​ ចាប់​ ផ្ដើម​ ថ្នាក់​ ។</p>
                </div>
            </div>

            <div class="hm-feat" style="transition-delay:.16s">
                <div class="hm-feat-icon" style="background:#fff3e0;">📚</div>
                <div class="hm-feat-text">
                    <h4>ហាងសៀវភៅ IT</h4>
                    <p>ទិញ​ សៀវភៅ​ Course​ ឧបករណ៍​ IT​ ជាភាសាខ្មែរ​ ជូន​ដល់​ ដៃ​ ២៤​ ម៉ោង​ ។</p>
                </div>
            </div>

            <div class="hm-feat" style="transition-delay:.24s">
                <div class="hm-feat-icon" style="background:#fce4ec;">🎨</div>
                <div class="hm-feat-text">
                    <h4>UI/UX ស្អាត ងាយប្រើ</h4>
                    <p>ចំណុច​ ប្រទាក់​ ទំនើប​ ប្រើ​ ជា​ ភាសា​ ខ្មែរ​ ២​ ភាសា​ responsive ​ ទូរស័ព្ទ​ ។</p>
                </div>
            </div>

            <div class="hm-feat" style="transition-delay:.32s">
                <div class="hm-feat-icon" style="background:#e8f5e9;">🔒</div>
                <div class="hm-feat-text">
                    <h4>សុវត្ថិភាពខ្ពស់</h4>
                    <p>ទិន្នន័យ​ ត្រូវ​ បាន​ ការពារ​ ដោយ​ Laravel​ Auth​ ហើយ HTTPS​ ។</p>
                </div>
            </div>

            <div class="hm-feat" style="transition-delay:.40s">
                <div class="hm-feat-icon" style="background:#ede7f6;">📈</div>
                <div class="hm-feat-text">
                    <h4>របាយការណ៍​ និង​ ស្ថិតិ</h4>
                    <p>ចូល​ មើល​ ស្ថិតិ​ សិស្ស​ ហើយ​ ការ​ ចូល​ រៀន​ ក្នុង​ Dashboard​ ច្បាស់​ ។</p>
                </div>
            </div>

        </div>

    </div>{{-- /.hm-body --}}
</div>{{-- /.hm-wrap --}}

<script>
    /* Scroll reveal */
    const hmEls = document.querySelectorAll(
        '.hm-stats, .hm-notice, .hm-quick-card, .hm-feat'
    );
    const hmIO = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                hmIO.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });
    hmEls.forEach(el => hmIO.observe(el));
</script>

@endsection