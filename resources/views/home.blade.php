@extends('layouts.app')
@section('title', 'ទំព័រដើម - Home')

@section('content')
<style>
    .hm-wrap { padding: 0; margin: 0; }

    /* ══ HERO ══ */
    .hm-hero {
        background: linear-gradient(135deg, #0d1b5e 0%, #1a237e 45%, #1565c0 80%, #1e88e5 100%);
        padding: 6rem 2.5rem 5rem;
        position: relative; overflow: hidden; text-align: center;
    }
    .hm-hero::before {
        content: ''; position: absolute; inset: 0;
        background:
            radial-gradient(ellipse 60% 50% at 20% 30%, rgba(255,255,255,0.06) 0%, transparent 60%),
            radial-gradient(ellipse 50% 60% at 80% 70%, rgba(100,180,255,0.1) 0%, transparent 60%);
        pointer-events: none;
    }
    .hm-hero::after {
        content: ''; position: absolute; bottom: -2px; left: 0; right: 0;
        height: 70px; background: var(--bg-light, #f4f7fc);
        clip-path: ellipse(55% 100% at 50% 100%);
    }
    /* Floating circles deco */
    .hm-hero-deco {
        position: absolute; border-radius: 50%;
        background: rgba(255,255,255,0.04);
        pointer-events: none;
    }
    .hm-hero-deco-1 { width: 400px; height: 400px; top: -100px; right: -80px; }
    .hm-hero-deco-2 { width: 250px; height: 250px; bottom: 20px; left: -60px; }

    .hm-hero-inner { position: relative; z-index: 2; max-width: 760px; margin: 0 auto; }
    .hm-hero-badge {
        display: inline-flex; align-items: center; gap: 7px;
        background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.25);
        color: rgba(255,255,255,0.92); font-size: 0.7rem; font-weight: 700;
        letter-spacing: 0.15em; text-transform: uppercase;
        padding: 5px 16px; border-radius: 20px; margin-bottom: 1.5rem;
        backdrop-filter: blur(6px);
    }
    .hm-hero h1 {
        font-size: clamp(2.2rem, 5vw, 3.5rem);
        font-weight: 800; color: #fff; line-height: 1.15; margin-bottom: 1.25rem;
    }
    .hm-hero h1 .gold {
        background: linear-gradient(90deg, #ffca28, #ffee58, #ffca28);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    }
    .hm-hero p {
        font-size: 1.05rem; color: rgba(255,255,255,0.65);
        line-height: 1.85; margin-bottom: 2.5rem; max-width: 560px; margin-left: auto; margin-right: auto;
    }
    .hm-hero-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
    .hm-btn-gold {
        display: inline-flex; align-items: center; gap: 8px;
        background: linear-gradient(135deg, #ffca28, #ffa000);
        color: #1a237e; border: none; border-radius: 50px;
        padding: 14px 30px; font-weight: 800; font-size: 0.92rem;
        cursor: pointer; text-decoration: none;
        box-shadow: 0 8px 24px rgba(255,160,0,0.4);
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .hm-btn-gold:hover { transform: translateY(-3px); box-shadow: 0 14px 32px rgba(255,160,0,0.5); color: #1a237e; }
    .hm-btn-outline {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(255,255,255,0.1); border: 1.5px solid rgba(255,255,255,0.3);
        color: #fff; border-radius: 50px;
        padding: 13px 28px; font-weight: 600; font-size: 0.92rem;
        cursor: pointer; text-decoration: none;
        backdrop-filter: blur(6px); transition: background 0.18s;
    }
    .hm-btn-outline:hover { background: rgba(255,255,255,0.2); color: #fff; }

    /* ══ BODY ══ */
    .hm-body { max-width: 1200px; margin: 0 auto; padding: 4rem 2rem 2rem; }

    /* ══ STATS ══ */
    .hm-stats {
        display: grid; grid-template-columns: repeat(4,1fr);
        gap: 1.25rem; margin-bottom: 4rem;
        opacity: 0; transform: translateY(20px);
        transition: opacity 0.5s, transform 0.5s;
    }
    .hm-stats.visible { opacity: 1; transform: translateY(0); }
    @media(max-width:768px){ .hm-stats { grid-template-columns: repeat(2,1fr); } }
    @media(max-width:440px){ .hm-stats { grid-template-columns: 1fr; } }

    .hm-stat {
        background: #fff; border-radius: 18px; padding: 1.6rem 1.25rem;
        text-align: center; position: relative; overflow: hidden;
        border: 1px solid rgba(26,35,126,0.07);
        box-shadow: 0 4px 20px rgba(26,35,126,0.06);
        transition: transform 0.22s, box-shadow 0.22s;
        text-decoration: none; display: block; color: inherit;
    }
    .hm-stat:hover { transform: translateY(-5px); box-shadow: 0 18px 44px rgba(26,35,126,0.12); }
    .hm-stat::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 4px; background: var(--sc,#1a237e); }
    .hm-stat-ico { width: 54px; height: 54px; border-radius: 16px; background: var(--sb,#e8eaf6); color: var(--sc,#1a237e); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; margin: 0 auto 0.9rem; }
    .hm-stat-num { font-size: 2.4rem; font-weight: 800; color: var(--sc,#1a237e); font-family: Georgia,serif; line-height: 1; margin-bottom: 0.25rem; }
    .hm-stat-lbl { font-size: 0.78rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.08em; }

    /* ══ SECTION TITLE ══ */
    .hm-sec-lbl { font-size: 0.68rem; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: #1565c0; margin-bottom: 0.3rem; }
    .hm-sec-title { font-size: clamp(1.5rem,3vw,2rem); font-weight: 800; color: #0d1b5e; margin-bottom: 0.5rem; }
    .hm-sec-title span { background: linear-gradient(90deg,#1565c0,#42a5f5); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
    .hm-sec-sub { font-size: 0.88rem; color: #6b7280; margin-bottom: 2.5rem; }

    /* ══ QUICK LINKS ══ */
    .hm-quick-grid {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 1.1rem; margin-bottom: 4rem;
    }
    .hm-quick-card {
        background: #fff; border-radius: 16px; padding: 1.5rem 1.25rem;
        text-align: center; text-decoration: none; color: inherit;
        border: 1px solid rgba(26,35,126,0.07);
        box-shadow: 0 3px 16px rgba(26,35,126,0.05);
        transition: all 0.25s;
        opacity: 0; transform: translateY(18px);
    }
    .hm-quick-card.visible { opacity: 1; transform: translateY(0); }
    .hm-quick-card:hover { transform: translateY(-5px); box-shadow: 0 18px 44px rgba(26,35,126,0.1); border-color: rgba(26,35,126,0.15); }
    .hm-quick-ico { font-size: 2rem; margin-bottom: 0.65rem; display: block; transition: transform 0.2s; }
    .hm-quick-card:hover .hm-quick-ico { transform: scale(1.15); }
    .hm-quick-card h5 { font-size: 0.9rem; font-weight: 700; color: #1a237e; margin-bottom: 3px; }
    .hm-quick-card p  { font-size: 0.75rem; color: #9ca3af; margin: 0; }

    /* ══ PHOTO GALLERY ══ */
    .hm-gallery-wrap { background: #fff; padding: 5rem 2rem; }
    .hm-gallery-inner { max-width: 1200px; margin: 0 auto; }
    .hm-gallery-grid {
        display: grid;
        grid-template-columns: repeat(3,1fr);
        grid-template-rows: 240px 240px;
        gap: 1rem;
    }
    @media(max-width:768px){ .hm-gallery-grid { grid-template-columns: repeat(2,1fr); grid-template-rows: auto; } .hm-photo-large { grid-column:span 1; grid-row:span 1; } }
    @media(max-width:480px){ .hm-gallery-grid { grid-template-columns: 1fr; } }
    .hm-photo-large { grid-row: span 2; }
    .hm-photo {
        border-radius: 18px; overflow: hidden; cursor: pointer; position: relative;
        opacity: 0; transform: translateY(20px);
        transition: opacity 0.5s, transform 0.5s, box-shadow 0.25s;
    }
    .hm-photo.visible { opacity: 1; transform: translateY(0); }
    .hm-photo:hover { box-shadow: 0 20px 50px rgba(26,35,126,0.18); transform: translateY(-4px) !important; }
    .hm-photo img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.4s; }
    .hm-photo:hover img { transform: scale(1.07); }
    .hm-photo-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(13,27,94,0.72) 0%, transparent 55%);
        display: flex; align-items: flex-end; padding: 1rem;
        opacity: 0; transition: opacity 0.3s;
    }
    .hm-photo:hover .hm-photo-overlay { opacity: 1; }
    .hm-photo-tag {
        background: rgba(255,255,255,0.15); backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.25); color: #fff;
        font-size: 0.75rem; font-weight: 700; padding: 5px 13px; border-radius: 20px;
    }

    /* ══ FEATURES ══ */
    .hm-feat-wrap { max-width: 1200px; margin: 0 auto; padding: 4rem 2rem 3rem; }
    .hm-feat-grid {
        display: grid; grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem; align-items: stretch;
    }
    .hm-feat {
        background: #fff; border-radius: 16px; padding: 1.75rem;
        border: 1px solid rgba(26,35,126,0.07);
        box-shadow: 0 3px 16px rgba(26,35,126,0.05);
        display: flex; gap: 1rem; align-items: flex-start;
        height: 100%;
        transition: all 0.25s;
        opacity: 0; transform: translateY(18px);
    }
    .hm-feat.visible { opacity: 1; transform: translateY(0); }
    .hm-feat:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(26,35,126,0.1); }
    .hm-feat-icon { width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
    .hm-feat h4 { font-size: 0.95rem; font-weight: 700; color: #0d1b5e; margin-bottom: 5px; }
    .hm-feat p  { font-size: 0.8rem; color: #6b7280; line-height: 1.7; margin: 0; }

    /* ══ CTA BANNER ══ */
    .hm-cta {
        background: linear-gradient(135deg, #0d1b5e, #1565c0);
        margin: 0 2rem 3rem; border-radius: 24px; padding: 3.5rem 2.5rem;
        text-align: center; position: relative; overflow: hidden;
        opacity: 0; transform: translateY(18px);
        transition: opacity 0.5s, transform 0.5s;
    }
    .hm-cta.visible { opacity: 1; transform: translateY(0); }
    .hm-cta::before { content:''; position:absolute; width:400px; height:400px; border-radius:50%; background:rgba(255,255,255,0.04); top:-100px; right:-80px; }
    .hm-cta h2 { font-size: clamp(1.5rem,3vw,2.2rem); font-weight: 800; color: #fff; margin-bottom: 0.75rem; }
    .hm-cta p  { font-size: 0.92rem; color: rgba(255,255,255,0.65); margin-bottom: 2rem; }
    .hm-cta-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

    @media(max-width:600px){ .hm-body, .hm-feat-wrap { padding: 2.5rem 1.25rem; } .hm-cta { margin: 0 1rem 2rem; padding: 2.5rem 1.5rem; } }
</style>

<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000" style="width:100%;overflow:hidden;position:relative;margin-top:0;">

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1400&q=80" class="d-block w-100" style="object-fit:cover;height:520px;" alt="Slide 1">
                <div class="carousel-caption d-none d-md-block" style="background:rgba(0,0,0,0.45);border-radius:12px;padding:20px 30px;">
                    <h2 style="font-weight:800;">🎓 ប្រព័ន្ធគ្រប់គ្រងសាលា</h2>
                    <p>គ្រប់គ្រងសិស្ស គ្រូ មុខវិជ្ជា និងវត្តមានយ៉ាងងាយស្រួល</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?w=1400&q=80" class="d-block w-100" style="object-fit:cover;height:520px;" alt="Slide 2">
                <div class="carousel-caption d-none d-md-block" style="background:rgba(0,0,0,0.40);border-radius:12px;padding:20px 30px;">
                    <h2 style="font-weight:800;">👨‍🏫 គ្រូបង្រៀនជំនាញ</h2>
                    <p>ក្រុមគ្រូមានបទពិសោធន៍ខ្ពស់ និងការបំណិនទំនើប</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=1400&q=80" class="d-block w-100" style="object-fit:cover;height:520px;" alt="Slide 3">
                <div class="carousel-caption d-none d-md-block" style="background:rgba(0,0,0,0.40);border-radius:12px;padding:20px 30px;">
                    <h2 style="font-weight:800;">📚 មុខវិជ្ជាច្រើន</h2>
                    <p>មុខវិជ្ជាជ្រើសរើសតាមតម្រូវការ និងចំណាប់អារម្មណ៍</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1400&q=80" class="d-block w-100" style="object-fit:cover;height:520px;" alt="Slide 4">
                <div class="carousel-caption d-none d-md-block" style="background:rgba(0,0,0,0.40);border-radius:12px;padding:20px 30px;">
                    <h2 style="font-weight:800;">🤝 សិស្សរៀនជាក្រុម</h2>
                    <p>បង្កើតបរិយាកាសសិក្សាសហការ និងទំនុកចិត្ត</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=1400&q=80" class="d-block w-100" style="object-fit:cover;height:520px;" alt="Slide 5">
                <div class="carousel-caption d-none d-md-block" style="background:rgba(0,0,0,0.40);border-radius:12px;padding:20px 30px;">
                    <h2 style="font-weight:520;">🏫 សាលារៀនទំនើប</h2>
                    <p>បរិស្ថានសិក្សាទំនើប ស្អាត និងមានសុវត្ថិភាព</p>
                </div>
            </div>
        </div>
    
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    {{-- ══ CAROUSEL BUTTONS ══ --}}
    <div style="background:#1a237e;padding:16px 0;text-align:center;">
        <div style="display:inline-flex;gap:10px;flex-wrap:wrap;justify-content:center;">
            @guest
            <a href="{{ route('login') }}" style="background:#fff;color:#1a237e;padding:10px 28px;border-radius:6px;font-weight:700;text-decoration:none;font-size:0.9rem;display:inline-flex;align-items:center;gap:8px;">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
            <a href="{{ route('register') }}" style="background:#ffca28;color:#1a237e;padding:10px 28px;border-radius:6px;font-weight:700;text-decoration:none;font-size:0.9rem;display:inline-flex;align-items:center;gap:8px;">
                <i class="fas fa-user-plus"></i> Register
            </a>
            @endguest
            @auth
            <a href="/dashboard" style="background:#fff;color:#1a237e;padding:10px 28px;border-radius:6px;font-weight:700;text-decoration:none;font-size:0.9rem;display:inline-flex;align-items:center;gap:8px;">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="/students" style="background:#ffca28;color:#1a237e;padding:10px 28px;border-radius:6px;font-weight:700;text-decoration:none;font-size:0.9rem;display:inline-flex;align-items:center;gap:8px;">
                <i class="fas fa-user-graduate"></i> សិស្ស
            </a>
            <a href="/teachers" style="background:rgba(255,255,255,0.15);color:#fff;border:1.5px solid rgba(255,255,255,0.5);padding:10px 28px;border-radius:6px;font-weight:700;text-decoration:none;font-size:0.9rem;display:inline-flex;align-items:center;gap:8px;">
                <i class="fas fa-chalkboard-teacher"></i> គ្រូ
            </a>
            <a href="/classes" style="background:rgba(255,255,255,0.15);color:#fff;border:1.5px solid rgba(255,255,255,0.5);padding:10px 28px;border-radius:6px;font-weight:700;text-decoration:none;font-size:0.9rem;display:inline-flex;align-items:center;gap:8px;">
                <i class="fas fa-school"></i> ថ្នាក់
            </a>
            <a href="/courses" style="background:rgba(255,255,255,0.15);color:#fff;border:1.5px solid rgba(255,255,255,0.5);padding:10px 28px;border-radius:6px;font-weight:700;text-decoration:none;font-size:0.9rem;display:inline-flex;align-items:center;gap:8px;">
                <i class="fas fa-book-open"></i> មុខវិជ្ជា
            </a>
            @endauth
        </div>
    </div>

<div class="hm-wrap">
    <div class="hm-hero" style="display:none;">
        <div class="hm-hero-deco hm-hero-deco-1"></div>
        <div class="hm-hero-deco hm-hero-deco-2"></div>
        <div class="hm-hero-inner">
            <div class="hm-hero-badge">🎓 School Management System 2026</div>
            <h1>ប្រព័ន្ធ​គ្រប់​គ្រង​<br><span class="gold">សាលា​ IT</span> ទំនើប</h1>
            <p>គ្រប់​គ្រង​ សិស្ស​ គ្រូ​ ហើយ​ មុខ​ វិជ្ជា​ ជាមួយ​ ប្រព័ន្ធ​ Laravel ​ ដ៏​ ទំនើប​ — ងាយ​ ស្រួល​ ប្រើ​  ២​ ភាសា​ ។</p>
            <div class="hm-hero-btns">
                <a href="/students" class="hm-btn-gold"><i class="fas fa-user-graduate"></i> ចូល​ មើល​ សិស្ស</a>
                <a href="/services" class="hm-btn-outline"><i class="fas fa-concierge-bell"></i> សេវា​ កម្ម</a>
                <a href="/contact" class="hm-btn-outline"><i class="fas fa-envelope"></i> ទំនាក់ទំនង</a>    
                <a href="/about" class="hm-btn-outline"><i class="fas fa-info-circle"></i> អំពីយើង</a>
            </div>
        </div>
    </div>

    {{-- ══ STATS ══ --}}
    <div class="hm-body">
        <div class="hm-stats" id="hmStats">
            <a href="/students" class="hm-stat" style="--sc:#1a237e;--sb:#e8eaf6;">
                <div class="hm-stat-ico"><i class="fas fa-user-graduate"></i></div>
                <div class="hm-stat-num">{{ $totalStudents }}</div>
                <div class="hm-stat-lbl">សិស្សសរុប</div>
            </a>
            <a href="/teachers" class="hm-stat" style="--sc:#00695c;--sb:#e0f2f1;transition-delay:.07s">
                <div class="hm-stat-ico"><i class="fas fa-chalkboard-teacher"></i></div>
                <div class="hm-stat-num">{{ $totalTeachers }}</div>
                <div class="hm-stat-lbl">គ្រូបង្រៀន</div>
            </a>
            <a href="/courses" class="hm-stat" style="--sc:#6a1b9a;--sb:#f3e5f5;transition-delay:.14s">
                <div class="hm-stat-ico"><i class="fas fa-book-open"></i></div>
                <div class="hm-stat-num">{{ $totalCourses }}</div>
                <div class="hm-stat-lbl">មុខវិជ្ជា</div>
            </a>
            <a href="/class" class="hm-stat" style="--sc:#e65100;--sb:#fff3e0;transition-delay:.21s">
                <div class="hm-stat-ico"><i class="fas fa-school"></i></div>
                <div class="hm-stat-num">{{ $totalClasses }}</div>
                <div class="hm-stat-lbl">ថ្នាក់រៀន</div>
            </a>
        </div>

        {{-- ══ QUICK LINKS ══ --}}
        <div class="hm-sec-lbl">⚡ Quick Links</div>
        <h2 class="hm-sec-title">ចូល​ <span>ប្រើ​ ភ្លាម</span></h2>
        <p class="hm-sec-sub">Links សំខាន់​ ៗ​ ដែល​ ប្រើ​ ញឹក​ញាប់</p>

        <div class="hm-quick-grid" id="hmQuickGrid">    
            <a href="/teachers" class="hm-quick-card" style="transition-delay:.10s">
                <span class="hm-quick-ico">👩‍🏫</span>
                <h5>Teachers</h5>
                <p>View all teachers</p>
            </a>
             <a href="/students" class="hm-quick-card">
                <span class="hm-quick-ico">👨‍🎓</span>
                <h5>Students</h5>
                <p>List & manage</p>
            </a>
            <a href="/courses" class="hm-quick-card" style="transition-delay:.15s">
                <span class="hm-quick-ico">📚</span>
                <h5>Courses</h5>
                <p>All IT courses</p>
            </a>
            <a href="/class" class="hm-quick-card" style="transition-delay:.20s">
                <span class="hm-quick-ico">🗓</span>
                <h5>Schedule</h5>
                <p>Class timetable</p>
            </a>
            <a href="/shop" class="hm-quick-card" style="transition-delay:.25s">
                <span class="hm-quick-ico">🛒</span>
                <h5>Shop</h5>
                <p>IT Books store</p>
            </a>
             <a href="/services" class="hm-quick-card" style="transition-delay:.10s">
                <span class="hm-quick-ico">🛎️</span>
                <h5>Services</h5>
                <p>School services</p>
            </a>
            @auth
            <a href="/dashboard" class="hm-quick-card" style="transition-delay:.30s">
                <span class="hm-quick-ico">📊</span>
                <h5>Dashboard</h5>
                <p>Stats & charts</p>
            </a>
            <a href="/users" class="hm-quick-card" style="transition-delay:.35s">
                <span class="hm-quick-ico">👥</span>
                <h5>Users</h5>
                <p>Manage accounts</p>
            </a>
            @endauth
        </div>
    </div>

    {{-- ══ PHOTO GALLERY ══ --}}
    <div class="hm-gallery-wrap">
        <div class="hm-gallery-inner">
            <div style="text-align:center;margin-bottom:2.5rem;">
                <div class="hm-sec-lbl">📸 Gallery</div>
                <h2 class="hm-sec-title">រូប​ភាព​ <span>សាលា​ យើង</span></h2>
                <p class="hm-sec-sub">ថ្ងៃ​ ធម្មតា​ ក្នុង​ សាលា​ — ការ​ រៀន​ ការ​ បង្រៀន​ ហើយ​ ព្រឹត្តិការណ៍​</p>
            </div>
            <div class="hm-gallery-grid">
                <div class="hm-photo hm-photo-large">
                    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&q=80" alt="Graduation" loading="lazy"/>
                    <div class="hm-photo-overlay"><span class="hm-photo-tag">🎓 Graduation</span></div>
                </div>
                <div class="hm-photo" style="transition-delay:.08s">
                    <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=600&q=80" alt="Classroom" loading="lazy"/>
                    <div class="hm-photo-overlay"><span class="hm-photo-tag">🏫 Classroom</span></div>
                </div>
                <div class="hm-photo" style="transition-delay:.16s">
                    <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&q=80" alt="IT Students" loading="lazy"/>
                    <div class="hm-photo-overlay"><span class="hm-photo-tag">💻 IT Students</span></div>
                </div>
                <div class="hm-photo" style="transition-delay:.24s">
                    <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?w=600&q=80" alt="Teacher" loading="lazy"/>
                    <div class="hm-photo-overlay"><span class="hm-photo-tag">👩‍🏫 Teacher</span></div>
                </div>
                <div class="hm-photo" style="transition-delay:.32s">
                    <img src="https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=600&q=80" alt="Books" loading="lazy"/>
                    <div class="hm-photo-overlay"><span class="hm-photo-tag">📚 Learning</span></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ FEATURES ══ --}}
    <div class="hm-feat-wrap">
        <div style="text-align:center;margin-bottom:2.5rem;">
            <div class="hm-sec-lbl">✨ Features</div>
            <h2 class="hm-sec-title">មុខ​ងារ​ <span>សំខាន់​ ៗ</span></h2>
        </div>
        <div class="hm-feat-grid">
            <div class="hm-feat">
                <div class="hm-feat-icon" style="background:#e8eaf6;">📊</div>
                <div><h4>Dashboard ស្ថិតិ</h4><p>Real-time stats ពី Database — students, teachers, scores ។</p></div>
            </div>
            <div class="hm-feat" style="transition-delay:.07s">
                <div class="hm-feat-icon" style="background:#e0f2f1;">🔐</div>
                <div><h4>Auth System</h4><p>Login / Register / Logout ជាមួយ Laravel Auth secure ។</p></div>
            </div>
            <div class="hm-feat" style="transition-delay:.14s">
                <div class="hm-feat-icon" style="background:#fff3e0;">📱</div>
                <div><h4>Responsive</h4><p>ប្រើ​ ទូរស័ព្ទ​ Tablet​ Desktop​ បាន​ ទាំង​ អស់​ ។</p></div>
            </div>
            <div class="hm-feat" style="transition-delay:.21s">
                <div class="hm-feat-icon" style="background:#f3e5f5;">🌙</div>
                <div><h4>Dark Mode</h4><p>ប្ដូរ​ ពណ៌​ Dark / Light mode ចុច​ ១ ដង​ ។</p></div>
            </div>
            <div class="hm-feat" style="transition-delay:.28s">
                <div class="hm-feat-icon" style="background:#fce4ec;">🛒</div>
                <div><h4>ហាង​ IT Books</h4><p>ទិញ​ សៀវភៅ IT​ ជា​ ភាសា​ ខ្មែរ​ Cart & Checkout ។</p></div>
            </div>
            <div class="hm-feat" style="transition-delay:.35s">
                <div class="hm-feat-icon" style="background:#e8f5e9;">🌐</div>
                <div><h4>២ ភាសា</h4><p>ភាសា​ ខ្មែរ​ ហើយ​ English​ switch​ ភ្លាម ។</p></div>
            </div>
        </div>
    </div>

    {{-- ══ CTA BANNER ══ --}}
    <div style="max-width:1200px;margin:0 auto;padding:0 2rem 4rem;">
        <div class="hm-cta" id="hmCta">
            <h2>🚀 ចាប់​ ផ្ដើម​ ប្រើ​ ភ្លាម!</h2>
            <p>Register ហើយ​ explore​ ប្រព័ន្ធ​ ទាំង​ អស់​ — ឥឡូវ​ នេះ​ !</p>
            <div class="hm-cta-btns">
                <a href="/students" class="hm-btn-gold"><i class="fas fa-user-graduate"></i> ចូល​ មើល​ សិស្ស</a>
                @guest
                <a href="{{ route('register') }}" class="hm-btn-outline"><i class="fas fa-user-plus"></i> Register ឥឡូវ</a>
                @endguest
            </div>
        </div>
    </div>

</div>

<script>
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => { if(e.isIntersecting){ e.target.classList.add('visible'); io.unobserve(e.target); } });
    }, { threshold: 0.08 });
    document.querySelectorAll('.hm-stats,.hm-quick-card,.hm-photo,.hm-feat,.hm-cta').forEach(el => io.observe(el));
</script>
@endsection