@extends('layouts.master')

@section('title', 'សេវាកម្ម - Services')

@section('content')
<style>
    .sv-wrap { padding: 0; }

    /* ── Hero ── */
    .sv-hero {
        background: linear-gradient(135deg, #0b3d6b 0%, #1c64b1 60%, #3b9eff 100%);
        padding: 5rem 2.5rem 5rem;
        text-align: center;
        position: relative; overflow: hidden;
    }
    .sv-hero::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(ellipse 70% 60% at 50% 0%, rgba(255,255,255,0.08) 0%, transparent 60%);
        pointer-events: none;
    }
    .sv-hero::after {
        content: ''; position: absolute; bottom: -2px; left: 0; right: 0;
        height: 60px; background: #f4f7fc;
        clip-path: ellipse(55% 100% at 50% 100%);
    }
    .sv-hero-inner { position: relative; z-index: 2; max-width: 640px; margin: 0 auto; }
    .sv-hero-badge {
        display: inline-flex; align-items: center; gap: 7px;
        background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.22);
        color: rgba(255,255,255,0.9); font-size: 0.72rem; font-weight: 700;
        letter-spacing: 0.14em; text-transform: uppercase;
        padding: 5px 16px; border-radius: 20px; margin-bottom: 1.25rem;
    }
    .sv-hero h1 {
        font-size: clamp(2rem, 5vw, 3rem); font-weight: 700; color: #fff;
        line-height: 1.2; margin-bottom: 1rem;
    }
    .sv-hero h1 span {
        background: linear-gradient(90deg, #ffca28, #ffe082);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    }
    .sv-hero p { font-size: 1rem; color: rgba(255,255,255,0.65); line-height: 1.8; max-width: 480px; margin: 0 auto; }

    /* ── Body ── */
    .sv-body { max-width: 1200px; margin: 0 auto; padding: 4rem 2rem 5rem; }
    .sv-sec-lbl { font-size: 0.68rem; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: #1c64b1; margin-bottom: 0.35rem; }
    .sv-sec-title { font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 700; color: #1a237e; margin-bottom: 2rem; }

    /* ── Stats ── */
    .sv-stats {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem; margin-bottom: 4rem;
        opacity: 0; transform: translateY(18px);
        transition: opacity 0.5s, transform 0.5s;
    }
    .sv-stats.show { opacity: 1; transform: translateY(0); }
    @media(max-width:768px){ .sv-stats { grid-template-columns: repeat(2,1fr); } }
    .sv-stat {
        background: #fff; border-radius: 16px; padding: 1.5rem 1.25rem;
        text-align: center; border: 1px solid rgba(26,35,126,0.07);
        box-shadow: 0 4px 18px rgba(26,35,126,0.05);
        position: relative; overflow: hidden;
        transition: transform 0.22s, box-shadow 0.22s;
    }
    .sv-stat:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(26,35,126,0.1); }
    .sv-stat::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: var(--c, #1a237e); }
    .sv-stat-ico { width: 48px; height: 48px; border-radius: 14px; background: var(--bg, #e8eaf6); color: var(--c, #1a237e); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; margin: 0 auto 0.75rem; }
    .sv-stat-num { font-size: 2rem; font-weight: 700; color: var(--c, #1a237e); font-family: Georgia, serif; line-height: 1; margin-bottom: 0.25rem; }
    .sv-stat-lbl { font-size: 0.78rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.08em; }

    /* ── Featured Banner ── */
    .sv-featured {
        background: linear-gradient(135deg, #1a237e 0%, #283593 60%, #3949ab 100%);
        border-radius: 20px; padding: 3rem;
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 2rem; align-items: center;
        margin-bottom: 4rem;
        opacity: 0; transform: translateY(18px);
        transition: opacity 0.5s 0.1s, transform 0.5s 0.1s;
    }
    .sv-featured.show { opacity: 1; transform: translateY(0); }
    @media(max-width:640px){ .sv-featured { grid-template-columns: 1fr; } }
    .sv-feat-lbl { font-size: 0.7rem; font-weight: 700; color: #ffca28; letter-spacing: 0.14em; text-transform: uppercase; margin-bottom: 0.75rem; }
    .sv-feat-h  { font-size: clamp(1.4rem,3vw,1.9rem); font-weight: 700; color: #fff; line-height: 1.25; margin-bottom: 0.85rem; }
    .sv-feat-p  { font-size: 0.85rem; color: rgba(255,255,255,0.65); line-height: 1.75; margin-bottom: 1.5rem; }
    .sv-feat-btn {
        display: inline-flex; align-items: center; gap: 8px;
        background: #ffca28; color: #1a237e; border: none; border-radius: 50px;
        padding: 12px 26px; font-weight: 700; font-size: 0.875rem;
        cursor: pointer; text-decoration: none;
        box-shadow: 0 6px 20px rgba(255,202,40,0.35);
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .sv-feat-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(255,202,40,0.45); color: #1a237e; }
    .sv-feat-right { display: flex; flex-direction: column; gap: 1rem; }
    .sv-feat-item {
        display: flex; align-items: center; gap: 1rem;
        background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);
        border-radius: 14px; padding: 1rem 1.25rem;
    }
    .sv-feat-ico { width: 42px; height: 42px; border-radius: 12px; background: rgba(255,255,255,0.12); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
    .sv-feat-text h5 { font-size: 0.88rem; font-weight: 700; color: #fff; margin-bottom: 2px; }
    .sv-feat-text p  { font-size: 0.75rem; color: rgba(255,255,255,0.55); margin: 0; }

    /* ── Services Grid ── */
    .sv-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(300px,1fr));
        gap: 1.5rem; margin-bottom: 4rem;
    }
    .sv-card {
        background: #fff; border-radius: 20px;
        border: 1px solid rgba(26,35,126,0.07); overflow: hidden;
        transition: all 0.28s ease;
        opacity: 0; transform: translateY(22px);
    }
    .sv-card.show { opacity: 1; transform: translateY(0); }
    .sv-card:hover { transform: translateY(-6px); box-shadow: 0 24px 56px rgba(26,35,126,0.12); border-color: rgba(26,35,126,0.15); }
    .sv-card-top  { height: 10px; background: var(--accent, #1a237e); }
    .sv-card-body { padding: 1.75rem; }
    .sv-card-icon { width: 56px; height: 56px; border-radius: 16px; background: var(--accent-pale, #e8eaf6); display: flex; align-items: center; justify-content: center; font-size: 1.6rem; margin-bottom: 1.1rem; transition: transform 0.2s; }
    .sv-card:hover .sv-card-icon { transform: scale(1.1) rotate(-3deg); }
    .sv-card h3 { font-size: 1.05rem; font-weight: 700; color: #1a237e; margin-bottom: 0.5rem; }
    .sv-card p  { font-size: 0.83rem; color: #6b7280; line-height: 1.7; margin-bottom: 1.25rem; }
    .sv-tag {
        display: inline-flex; align-items: center; gap: 5px;
        background: var(--accent-pale, #e8eaf6); color: var(--accent, #1a237e);
        font-size: 0.7rem; font-weight: 700; padding: 4px 11px; border-radius: 20px;
        text-transform: uppercase; letter-spacing: 0.07em;
    }

    /* ── FAQ ── */
    .sv-faq { margin-bottom: 4rem; }
    .sv-faq-list { display: flex; flex-direction: column; gap: 0.75rem; }
    .sv-faq-item { background: #fff; border-radius: 14px; border: 1px solid rgba(26,35,126,0.07); overflow: hidden; opacity: 0; transform: translateY(14px); transition: opacity 0.4s, transform 0.4s; }
    .sv-faq-item.show { opacity: 1; transform: translateY(0); }
    .sv-faq-q { width: 100%; padding: 1.1rem 1.5rem; display: flex; align-items: center; justify-content: space-between; background: none; border: none; cursor: pointer; font-family: 'Kantumruy Pro','Outfit',sans-serif; font-size: 0.9rem; font-weight: 700; color: #1a237e; text-align: left; gap: 1rem; transition: background 0.15s; }
    .sv-faq-q:hover { background: #f8faff; }
    .sv-faq-q .arr { width: 28px; height: 28px; border-radius: 8px; background: #e8eaf6; color: #1a237e; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; flex-shrink: 0; transition: transform 0.25s, background 0.15s; }
    .sv-faq-item.open .sv-faq-q .arr { transform: rotate(180deg); background: #1a237e; color: #fff; }
    .sv-faq-a { max-height: 0; overflow: hidden; transition: max-height 0.35s ease, padding 0.25s; font-size: 0.84rem; color: #6b7280; line-height: 1.75; padding: 0 1.5rem; }
    .sv-faq-item.open .sv-faq-a { max-height: 300px; padding: 0 1.5rem 1.25rem; }

    /* ── CTA ── */
    .sv-cta { background: linear-gradient(135deg, #e8eaf6, #c5cae9); border-radius: 20px; padding: 3rem 2.5rem; text-align: center; border: 1px solid rgba(26,35,126,0.1); opacity: 0; transform: translateY(18px); transition: opacity 0.5s, transform 0.5s; }
    .sv-cta.show { opacity: 1; transform: translateY(0); }
    .sv-cta h2 { font-size: 1.75rem; font-weight: 700; color: #1a237e; margin-bottom: 0.75rem; }
    .sv-cta p  { font-size: 0.88rem; color: #3949ab; margin-bottom: 1.75rem; line-height: 1.7; }
    .sv-cta-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
    .sv-cta-btn-main { display: inline-flex; align-items: center; gap: 8px; background: #1a237e; color: #fff; border: none; border-radius: 50px; padding: 12px 28px; font-size: 0.875rem; font-weight: 700; text-decoration: none; box-shadow: 0 6px 20px rgba(26,35,126,0.25); transition: transform 0.15s; }
    .sv-cta-btn-main:hover { transform: translateY(-2px); color: #fff; }
    .sv-cta-btn-out  { display: inline-flex; align-items: center; gap: 8px; background: transparent; color: #1a237e; border: 2px solid rgba(26,35,126,0.25); border-radius: 50px; padding: 11px 26px; font-size: 0.875rem; font-weight: 700; text-decoration: none; transition: all 0.15s; }
    .sv-cta-btn-out:hover { background: rgba(26,35,126,0.06); border-color: #1a237e; color: #1a237e; }

    @media(max-width:600px){ .sv-body { padding: 2.5rem 1.25rem 3rem; } }

    /* ══ IT Courses Grid ══ */
    .sv-courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px,1fr));
        gap: 1.25rem;
        margin-bottom: 4rem;
    }
    .sv-course-card {
        background: #fff; border-radius: 16px;
        border: 1px solid rgba(26,35,126,0.07);
        border-left: 4px solid var(--ca, #1a237e);
        padding: 1.4rem;
        display: flex; align-items: flex-start; gap: 1rem;
        transition: all 0.25s ease;
        opacity: 0; transform: translateY(18px);
    }
    .sv-course-card.show { opacity: 1; transform: translateY(0); }
    .sv-course-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(26,35,126,0.1);
        border-color: var(--ca, #1a237e);
    }
    .sv-course-icon {
        width: 48px; height: 48px; border-radius: 13px;
        background: color-mix(in srgb, var(--ca, #1a237e) 12%, #fff);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; flex-shrink: 0;
    }
    .sv-course-body h4 {
        font-size: 0.95rem; font-weight: 700;
        color: #1a237e; margin-bottom: 4px;
    }
    .sv-course-body p {
        font-size: 0.78rem; color: #6b7280;
        line-height: 1.6; margin-bottom: 0.6rem;
    }
    .sv-course-chips { display: flex; flex-wrap: wrap; gap: 5px; }
    .sv-course-chips span {
        font-size: 0.63rem; font-weight: 700;
        padding: 2px 8px; border-radius: 20px;
        background: color-mix(in srgb, var(--ca, #1a237e) 10%, #fff);
        color: var(--ca, #1a237e);
        border: 1px solid color-mix(in srgb, var(--ca, #1a237e) 20%, transparent);
    }
</style>

<div class="sv-wrap">

    {{-- Hero --}}
    <div class="sv-hero">
        <div class="sv-hero-inner">
            <div class="sv-hero-badge">🎓 School Services</div>
            <h1>សេវាកម្ម<span>របស់​សាលា</span></h1>
            <p>យើង​ផ្ដល់​ជូន​សេវាកម្ម​ច្រើន​ប្រភេទ ដើម្បី​គាំទ្រ​ការ​សិក្សា និង​ការ​អភិវឌ្ឍន៍​របស់​សិស្ស</p>
        </div>
    </div>

    <div class="sv-body">

        {{-- Stats --}}
        <div class="sv-stats" id="svStats">
            <div class="sv-stat" style="--c:#1a237e;--bg:#e8eaf6;">
                <div class="sv-stat-ico"><i class="fas fa-users"></i></div>
                <div class="sv-stat-num">850+</div>
                <div class="sv-stat-lbl">សិស្សសរុប</div>
            </div>
            <div class="sv-stat" style="--c:#00695c;--bg:#e0f2f1;">
                <div class="sv-stat-ico"><i class="fas fa-book-open"></i></div>
                <div class="sv-stat-num">20+</div>
                <div class="sv-stat-lbl">មុខវិជ្ជា</div>
            </div>
            <div class="sv-stat" style="--c:#e65100;--bg:#fff3e0;">
                <div class="sv-stat-ico"><i class="fas fa-chalkboard-teacher"></i></div>
                <div class="sv-stat-num">15+</div>
                <div class="sv-stat-lbl">គ្រូបង្រៀន</div>
            </div>
            <div class="sv-stat" style="--c:#6a1b9a;--bg:#f3e5f5;">
                <div class="sv-stat-ico"><i class="fas fa-award"></i></div>
                <div class="sv-stat-num">100%</div>
                <div class="sv-stat-lbl">គុណភាព</div>
            </div>
        </div>

        {{-- Featured --}}
        <div class="sv-featured" id="svFeat">
            <div>
                <div class="sv-feat-lbl">⭐ សេវាកម្មពិសេស</div>
                <h2 class="sv-feat-h">ប្រព័ន្ធ​គ្រប់គ្រង​សាលា​ ទំនើប​ ២០២៦</h2>
                <p class="sv-feat-p">ប្រព័ន្ធ​គ្រប់គ្រង​សិស្ស-គ្រូ ដ៏​ស្ទើរ​ស្ទាត់ ជាមួយ​ track​ ពិន្ទុ ហើយ​ report​ ច្បាស់ — ទាំងអស់​ ក្នុង​ platform​ ១ ។</p>
                <a href="/students" class="sv-feat-btn"><i class="fas fa-arrow-right"></i> ចូល​មើល​សិស្ស</a>
            </div>
            <div class="sv-feat-right">
                <div class="sv-feat-item">
                    <div class="sv-feat-ico">📊</div>
                    <div class="sv-feat-text"><h5>Real-time Statistics</h5><p>ស្ថិតិ​ ភ្លែតៗ​ ពី​ database​ ពិត</p></div>
                </div>
                <div class="sv-feat-item">
                    <div class="sv-feat-ico">🔒</div>
                    <div class="sv-feat-text"><h5>Secure Auth System</h5><p>Login/Register​ ជាមួយ​ Laravel​ Auth</p></div>
                </div>
                <div class="sv-feat-item">
                    <div class="sv-feat-ico">📱</div>
                    <div class="sv-feat-text"><h5>Responsive Design</h5><p>ប្រើ​ ទូរស័ព្ទ​ Tablet​ Desktop​ បាន</p></div>
                </div>
            </div>
        </div>

        {{-- Services --}}
        <div class="sv-sec-lbl">🔧 សេវាកម្ម</div>
        <h2 class="sv-sec-title">សេវាកម្ម​ ដែល​ យើង​ ផ្ដល់​ ជូន</h2>

        <div class="sv-grid">
            <div class="sv-card" style="--accent:#1a237e;--accent-pale:#e8eaf6;">
                <div class="sv-card-top"></div>
                <div class="sv-card-body">
                    <div class="sv-card-icon">👨‍🎓</div>
                    <h3>ការ​គ្រប់គ្រង​សិស្ស</h3>
                    <p>Register, track, ហើយ manage ព័ត៌មានសិស្ស ពិន្ទុ ថ្ងៃខែ ហើយ ការចូលរៀន ក្នុង real-time ។</p>
                    <span class="sv-tag">📋 Management</span>
                </div>
            </div>

            <div class="sv-card" style="--accent:#00695c;--accent-pale:#e0f2f1;transition-delay:.07s">
                <div class="sv-card-top"></div>
                <div class="sv-card-body">
                    <div class="sv-card-icon">👩‍🏫</div>
                    <h3>ការ​គ្រប់គ្រង​គ្រូ</h3>
                    <p>ព័ត៌មាន​គ្រូ​ ម៉ោង​បង្រៀន​ ម​ុខ​វិជ្ជា​ ហើយ​ contact​ ក្នុង​ system​ ១ ។</p>
                    <span class="sv-tag">🏫 Teachers</span>
                </div>
            </div>

            <div class="sv-card" style="--accent:#1565c0;--accent-pale:#e3f2fd;transition-delay:.14s">
                <div class="sv-card-top"></div>
                <div class="sv-card-body">
                    <div class="sv-card-icon">📚</div>
                    <h3>មុខវិជ្ជា​ IT</h3>
                    <p>Web, Database, Networking, Mobile App, AI & ML, UI/UX, Cybersecurity ហើយ​ច្រើន​ទៀត ។</p>
                    <span class="sv-tag">💻 IT Courses</span>
                </div>
            </div>

            <div class="sv-card" style="--accent:#e65100;--accent-pale:#fff3e0;transition-delay:.21s">
                <div class="sv-card-top"></div>
                <div class="sv-card-body">
                    <div class="sv-card-icon">🗓️</div>
                    <h3>កាលវិភាគ​រៀន</h3>
                    <p>ម៉ោង​រៀន​ ប្រចាំ​ថ្ងៃ​ countdown​ timer​ ហើយ​ weekly​ schedule ​ ច្បាស់ ។</p>
                    <span class="sv-tag">⏰ Schedule</span>
                </div>
            </div>

            <div class="sv-card" style="--accent:#6a1b9a;--accent-pale:#f3e5f5;transition-delay:.28s">
                <div class="sv-card-top"></div>
                <div class="sv-card-body">
                    <div class="sv-card-icon">🛒</div>
                    <h3>ហាង​លក់​សៀវភៅ</h3>
                    <p>ទិញ​ សៀវភៅ​ IT​ ជា​ ភាសា​ ខ្មែរ​ ។ Cart, Checkout​ ហើយ​ Promo​ Code ។</p>
                    <span class="sv-tag">📖 Bookshop</span>
                </div>
            </div>

            <div class="sv-card" style="--accent:#c62828;--accent-pale:#ffebee;transition-delay:.35s">
                <div class="sv-card-top"></div>
                <div class="sv-card-body">
                    <div class="sv-card-icon">🔒</div>
                    <h3>សុវត្ថិភាព​ & Auth</h3>
                    <p>Login / Register​ ជាមួយ​ Laravel​ Auth​ ។ Password​ strength​ ហើយ​ session​ secure ។</p>
                    <span class="sv-tag">🛡️ Security</span>
                </div>
            </div>
        </div>

        {{-- ══ IT COURSES ══ --}}
        <div class="sv-sec-lbl">💻 មេរៀន IT</div>
        <h2 class="sv-sec-title">មុខ​វិជ្ជា​ ដែល​ ផ្ដល់​ ជូន</h2>

        <div class="sv-courses-grid">
            <div class="sv-course-card" style="--ca:#1c64b1;">
                <div class="sv-course-icon">🌐</div>
                <div class="sv-course-body">
                    <h4>Web Design</h4>
                    <p>HTML, CSS, JS, Bootstrap, Responsive Design</p>
                    <div class="sv-course-chips">
                        <span>Beginner</span><span>HTML</span><span>CSS</span>
                    </div>
                </div>
            </div>

            <div class="sv-course-card" style="--ca:#3d15e0;transition-delay:.05s">
                <div class="sv-course-icon">🗄️</div>
                <div class="sv-course-body">
                    <h4>Database Design</h4>
                    <p>MySQL, SQLite, ERD, Query Optimization</p>
                    <div class="sv-course-chips">
                        <span>Intermediate</span><span>MySQL</span><span>SQL</span>
                    </div>
                </div>
            </div>

            <div class="sv-course-card" style="--ca:#c07800;transition-delay:.10s">
                <div class="sv-course-icon">📱</div>
                <div class="sv-course-body">
                    <h4>Mobile App</h4>
                    <p>Flutter, React Native, Android/iOS Development</p>
                    <div class="sv-course-chips">
                        <span>Intermediate</span><span>Flutter</span>
                    </div>
                </div>
            </div>

            <div class="sv-course-card" style="--ca:#0b7a57;transition-delay:.15s">
                <div class="sv-course-icon">🔌</div>
                <div class="sv-course-body">
                    <h4>Networking</h4>
                    <p>CCNA, TCP/IP, Router, Switch, Network Security</p>
                    <div class="sv-course-chips">
                        <span>All Levels</span><span>CCNA</span>
                    </div>
                </div>
            </div>

            <div class="sv-course-card" style="--ca:#c0392b;transition-delay:.20s">
                <div class="sv-course-icon">🔴</div>
                <div class="sv-course-body">
                    <h4>Laravel</h4>
                    <p>PHP Laravel, MVC, Blade, Eloquent ORM, API</p>
                    <div class="sv-course-chips">
                        <span>Intermediate</span><span>PHP</span><span>MVC</span>
                    </div>
                </div>
            </div>

            <div class="sv-course-card" style="--ca:#6d28d9;transition-delay:.25s">
                <div class="sv-course-icon">🔒</div>
                <div class="sv-course-body">
                    <h4>Cybersecurity</h4>
                    <p>Ethical Hacking, Penetration Testing, Security Tools</p>
                    <div class="sv-course-chips">
                        <span>Advanced</span><span>Security</span>
                    </div>
                </div>
            </div>

            <div class="sv-course-card" style="--ca:#be185d;transition-delay:.30s">
                <div class="sv-course-icon">🤖</div>
                <div class="sv-course-body">
                    <h4>AI & ML</h4>
                    <p>Python, Machine Learning, Deep Learning, Data Science</p>
                    <div class="sv-course-chips">
                        <span>Advanced</span><span>Python</span>
                    </div>
                </div>
            </div>

            <div class="sv-course-card" style="--ca:#b45309;transition-delay:.35s">
                <div class="sv-course-icon">🖥️</div>
                <div class="sv-course-body">
                    <h4>OS Concepts</h4>
                    <p>Linux, Windows Server, Shell Script, File System</p>
                    <div class="sv-course-chips">
                        <span>Intermediate</span><span>Linux</span>
                    </div>
                </div>
            </div>

            <div class="sv-course-card" style="--ca:#0f766e;transition-delay:.40s">
                <div class="sv-course-icon">📐</div>
                <div class="sv-course-body">
                    <h4>Algorithm</h4>
                    <p>Data Structures, Sorting, Searching, Complexity</p>
                    <div class="sv-course-chips">
                        <span>All Levels</span><span>DSA</span>
                    </div>
                </div>
            </div>

            <div class="sv-course-card" style="--ca:#4338ca;transition-delay:.45s">
                <div class="sv-course-icon">🎨</div>
                <div class="sv-course-body">
                    <h4>UI/UX Design</h4>
                    <p>Figma, Wireframe, Prototype, User Research</p>
                    <div class="sv-course-chips">
                        <span>Beginner</span><span>Figma</span>
                    </div>
                </div>
            </div>

            <div class="sv-course-card" style="--ca:#0e7490;transition-delay:.50s">
                <div class="sv-course-icon">🛠️</div>
                <div class="sv-course-body">
                    <h4>IT Support</h4>
                    <p>Hardware, Troubleshooting, Help Desk, CompTIA A+</p>
                    <div class="sv-course-chips">
                        <span>Beginner</span><span>Hardware</span>
                    </div>
                </div>
            </div>

            <div class="sv-course-card" style="--ca:#be123c;transition-delay:.55s">
                <div class="sv-course-icon">🖌️</div>
                <div class="sv-course-body">
                    <h4>Graphic Design</h4>
                    <p>Photoshop, Illustrator, Branding, Typography</p>
                    <div class="sv-course-chips">
                        <span>All Levels</span><span>Adobe</span>
                    </div>
                </div>
            </div>

            <div class="sv-course-card" style="--ca:#065f46;transition-delay:.60s">
                <div class="sv-course-icon">📣</div>
                <div class="sv-course-body">
                    <h4>Digital Marketing</h4>
                    <p>SEO, Social Media, Google Ads, Content Marketing</p>
                    <div class="sv-course-chips">
                        <span>All Levels</span><span>SEO</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- FAQ --}}
        <div class="sv-faq">
            <div class="sv-sec-lbl">❓ FAQ</div>
            <h2 class="sv-sec-title">សំណួរ​ដែល​សួរ​ញឹក​ញាប់</h2>
            <div class="sv-faq-list">

                <div class="sv-faq-item">
                    <button class="sv-faq-q" onclick="toggleFaq(this)">
                        តើ​ប្រព័ន្ធ​នេះ​ប្រើ​ database​ ប្រភេទ​ណា?
                        <span class="arr"><i class="fas fa-chevron-down"></i></span>
                    </button>
                    <div class="sv-faq-a">ប្រព័ន្ធ​នេះ​ប្រើ SQLite ឬ MySQL — កំណត់​ក្នុង .env file ។ SQLite ងាយ​ប្រើ​ LocalHost; MySQL សម្រាប់​ production ។</div>
                </div>

                <div class="sv-faq-item">
                    <button class="sv-faq-q" onclick="toggleFaq(this)">
                        តើ​អាច​បន្ថែម​សិស្ស​ ១ ​ ម្នាក់​ ៗ​ ឬ​ seed​ bulk​ បាន​ទេ?
                        <span class="arr"><i class="fas fa-chevron-down"></i></span>
                    </button>
                    <div class="sv-faq-a">អាច​ ២ ​វិធី — បន្ថែម manual តាម Form /students/create ឬ run Seeder: php artisan db:seed --class=StudentSeeder ដើម្បី​ insert 850 នាក់​ ភ្លាម ។</div>
                </div>

                <div class="sv-faq-item">
                    <button class="sv-faq-q" onclick="toggleFaq(this)">
                        Login ហើយ​ redirect​ ទៅ​ ណា?
                        <span class="arr"><i class="fas fa-chevron-down"></i></span>
                    </button>
                    <div class="sv-faq-a">Login/Register​ ជោគជ័យ​ → redirect ទៅ​ / (Home page) ។ អ្នក​អាច​ប្ដូរ​ redirect ក្នុង AuthenticatedSessionController ។</div>
                </div>

                <div class="sv-faq-item">
                    <button class="sv-faq-q" onclick="toggleFaq(this)">
                        ប្រព័ន្ធ​នេះ​ responsive​ ទូរស័ព្ទ​ បាន​ទេ?
                        <span class="arr"><i class="fas fa-chevron-down"></i></span>
                    </button>
                    <div class="sv-faq-a">បាន​ ១០០% — ប្រើ Bootstrap 5 + custom responsive CSS ។ Sidebar​ collapse​ លើ mobile ហើយ​ navbar​ ប្ដូរ​ ជា​ hamburger menu ។</div>
                </div>

            </div>
        </div>

        {{-- CTA --}}
        <div class="sv-cta" id="svCta">
            <h2>🚀 ចាប់​ផ្ដើម​ប្រើ​ភ្លាម!</h2>
            <p>ចូល​ប្រើ​ប្រព័ន្ធ​គ្រប់គ្រង​សាលា​ ​ ។ ​ Register ​ ហើយ​ explore​ ​ features ​ ទាំង​អស់​ ។</p>
            <div class="sv-cta-btns">
                <a href="/students" class="sv-cta-btn-main"><i class="fas fa-user-graduate"></i> ចូល​មើល​សិស្ស</a>
                <a href="/register" class="sv-cta-btn-out"><i class="fas fa-user-plus"></i> Register ឥឡូវ</a>
            </div>
        </div>

    </div>
</div>

<script>
    /* Scroll reveal */
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('show'); io.unobserve(e.target); } });
    }, { threshold: 0.1 });
    document.querySelectorAll('.sv-stats,.sv-featured,.sv-card,.sv-course-card,.sv-faq-item,.sv-cta').forEach(el => io.observe(el));

    /* FAQ toggle */
    function toggleFaq(btn) {
        const item = btn.closest('.sv-faq-item');
        const isOpen = item.classList.contains('open');
        document.querySelectorAll('.sv-faq-item.open').forEach(i => i.classList.remove('open'));
        if (!isOpen) item.classList.add('open');
    }
</script>

@endsection