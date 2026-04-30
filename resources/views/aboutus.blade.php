@extends('layouts.master')

@section('title', 'អំពីយើង - Our Story')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Outfit:wght@300;400;500;600&display=swap');

    .ab-page {
        font-family: 'Outfit', sans-serif;
        background: #f4f7fc;
        min-height: 100vh;
    }

    /* ── HERO ── */
    .ab-hero {
        position: relative;
        background-image: url('https://images.pexels.com/photos/267507/pexels-photo-267507.jpeg?auto=compress&cs=tinysrgb&w=1200');
        background-size: cover;
        background-position: center;
        padding: 6rem 2rem 5rem;
        text-align: center;
        overflow: hidden;
    }

    .ab-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(11,30,61,0.88) 0%, rgba(28,100,177,0.75) 100%);
    }

    .ab-hero::after {
        content: '';
        position: absolute;
        left: 50%; top: -100px;
        transform: translateX(-50%);
        width: 500px; height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(59,158,255,0.12) 0%, transparent 70%);
        pointer-events: none;
    }

    .ab-hero-inner { position: relative; z-index: 2; }

    .ab-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(59,158,255,0.15);
        border: 1px solid rgba(59,158,255,0.3);
        color: #3b9eff;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        padding: 5px 14px;
        border-radius: 20px;
        margin-bottom: 1.25rem;
    }

    .ab-hero h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2.2rem, 5vw, 3.8rem);
        font-weight: 700;
        color: #fff;
        margin-bottom: 0.75rem;
        line-height: 1.2;
    }

    .ab-hero h1 span {
        background: linear-gradient(90deg, #e8a020, #ffd270);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .ab-hero p {
        color: rgba(255,255,255,0.55);
        font-size: 1rem;
        max-width: 500px;
        margin: 0 auto;
        line-height: 1.75;
    }

    /* ── WRAP ── */
    .ab-wrap {
        max-width: 1200px;
        margin: 0 auto;
        padding: 5rem 2rem;
    }

    /* ── STORY SECTION ── */
    .ab-story {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3.5rem;
        align-items: center;
        margin-bottom: 5rem;
    }

    @media (max-width: 860px) {
        .ab-story { grid-template-columns: 1fr; gap: 2rem; }
    }

    .ab-img-wrap {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 24px 64px rgba(11,30,61,0.15);
        opacity: 0;
        transform: translateX(-28px);
        transition: opacity 0.7s ease, transform 0.7s ease;
    }

    .ab-img-wrap.visible { opacity: 1; transform: translateX(0); }

    .ab-img-wrap img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }

    .ab-img-wrap:hover img { transform: scale(1.04); }

    /* Floating year badge on image */
    .ab-year-badge {
        position: absolute;
        bottom: 20px;
        left: 20px;
        background: rgba(11,30,61,0.85);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.12);
        color: white;
        border-radius: 12px;
        padding: 10px 16px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .ab-year-badge strong {
        display: block;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.5rem;
        font-weight: 700;
        color: #ffd270;
        line-height: 1;
        margin-bottom: 2px;
    }

    /* Story text */
    .ab-story-text {
        opacity: 0;
        transform: translateX(28px);
        transition: opacity 0.7s 0.1s ease, transform 0.7s 0.1s ease;
    }

    .ab-story-text.visible { opacity: 1; transform: translateX(0); }

    .ab-section-label {
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: #1c64b1;
        margin-bottom: 0.5rem;
    }

    .ab-story-text h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.8rem, 3vw, 2.5rem);
        font-weight: 700;
        color: #0b1e3d;
        margin-bottom: 1rem;
        line-height: 1.25;
    }

    .ab-story-text p {
        font-size: 0.925rem;
        color: #8898b5;
        line-height: 1.8;
        margin-bottom: 1.5rem;
    }

    /* Admin info card */
    .ab-admin-card {
        background: #fff;
        border-radius: 14px;
        padding: 1.5rem;
        border: 1px solid rgba(11,30,61,0.07);
        box-shadow: 0 4px 20px rgba(11,30,61,0.06);
        position: relative;
        overflow: hidden;
    }

    .ab-admin-card::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 4px;
        background: linear-gradient(to bottom, #1c64b1, #3b9eff);
        border-radius: 4px 0 0 4px;
    }

    .ab-admin-card h5 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: #0b1e3d;
        margin-bottom: 0.75rem;
        padding-bottom: 0.65rem;
        border-bottom: 1px solid rgba(11,30,61,0.07);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .ab-admin-row {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.875rem;
        color: #445;
        margin-bottom: 0.55rem;
    }

    .ab-admin-row:last-child { margin-bottom: 0; }

    .ab-admin-row .lbl {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #8898b5;
        width: 90px;
        flex-shrink: 0;
    }

    .ab-admin-row .val {
        color: #0b1e3d;
        font-weight: 500;
    }

    .id-pill {
        background: #e8f0fb;
        color: #1c64b1;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 2px 10px;
        border-radius: 20px;
    }

    /* ── STATS ── */
    .ab-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 5rem;
    }

    @media (max-width: 640px) { .ab-stats { grid-template-columns: 1fr; } }

    .ab-stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 2rem 1.5rem;
        text-align: center;
        border: 1px solid rgba(11,30,61,0.07);
        position: relative;
        overflow: hidden;
        transition: all 0.28s ease;
        opacity: 0;
        transform: translateY(24px);
    }

    .ab-stat-card.visible { opacity: 1; transform: translateY(0); }
    .ab-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 50px rgba(11,30,61,0.1);
    }

    .ab-stat-card::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 3px;
        background: var(--accent);
        border-radius: 0 0 16px 16px;
    }

    .stat-num {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3rem;
        font-weight: 700;
        color: var(--accent);
        line-height: 1;
        margin-bottom: 0.4rem;
    }

    .stat-label {
        font-size: 0.8rem;
        font-weight: 500;
        color: #8898b5;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }

    .stat-icon {
        font-size: 1.8rem;
        margin-bottom: 0.75rem;
    }

    /* ── TEAM SECTION ── */
    .ab-team {
        margin-bottom: 5rem;
        opacity: 0;
        transform: translateY(24px);
        transition: opacity 0.7s ease, transform 0.7s ease;
    }

    .ab-team.visible { opacity: 1; transform: translateY(0); }

    .ab-team-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .ab-team-header h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.8rem, 3vw, 2.4rem);
        font-weight: 700;
        color: #0b1e3d;
        margin-bottom: 0.5rem;
        line-height: 1.25;
    }

    .ab-team-header p {
        font-size: 0.925rem;
        color: #8898b5;
        max-width: 480px;
        margin: 0 auto;
        line-height: 1.7;
    }

    .ab-team-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
    }

    @media (max-width: 900px) { .ab-team-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 500px) { .ab-team-grid { grid-template-columns: 1fr; } }

    .ab-member-card {
        background: #fff;
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid rgba(11,30,61,0.07);
        box-shadow: 0 4px 20px rgba(11,30,61,0.05);
        transition: all 0.28s ease;
        text-align: center;
    }

    .ab-member-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 50px rgba(11,30,61,0.12);
    }

    .ab-member-photo {
        position: relative;
        overflow: hidden;
    }

    .ab-member-photo img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }

    .ab-member-card:hover .ab-member-photo img {
        transform: scale(1.06);
    }

    .ab-member-photo-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(11,30,61,0.45) 0%, transparent 60%);
        pointer-events: none;
    }

    .ab-member-info {
        padding: 1.25rem 1rem 1.4rem;
    }

    .ab-member-info h4 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: #0b1e3d;
        margin-bottom: 0.2rem;
        line-height: 1.3;
    }

    .ab-member-role {
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #1c64b1;
        margin-bottom: 0.75rem;
    }

    .ab-member-bio {
        font-size: 0.82rem;
        color: #8898b5;
        line-height: 1.65;
        margin-bottom: 1rem;
    }

    .ab-member-socials {
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .ab-social-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f0f4fb;
        color: #1c64b1;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid rgba(28,100,177,0.12);
    }

    .ab-social-btn:hover {
        background: #1c64b1;
        color: #fff;
        border-color: #1c64b1;
    }

    /* ── CTA ROW ── */
    .ab-cta {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .ab-cta.visible { opacity: 1; transform: translateY(0); }

    .btn-outline-ab {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #1c64b1;
        background: #fff;
        border: 1.5px solid rgba(28,100,177,0.3);
        text-decoration: none;
        padding: 13px 28px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s;
    }

    .btn-outline-ab:hover {
        border-color: #1c64b1;
        background: #e8f0fb;
        color: #0b1e3d;
    }

    .btn-fill-ab {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #fff;
        background: linear-gradient(135deg, #1c64b1, #3b9eff);
        text-decoration: none;
        padding: 13px 32px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 8px 24px rgba(28,100,177,0.35);
        transition: all 0.22s;
    }

    .btn-fill-ab:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 32px rgba(28,100,177,0.45);
        color: #fff;
    }
    <style>
    * {
        font-family: 'Khmer OS', 'Khmer OS Siemreap', 
                     'Noto Sans Khmer', 'Hanuman', 
                     Arial Unicode MS, sans-serif !important;
    }
</style>
</style>

<div class="ab-page">

    <!-- Hero -->
    <div class="ab-hero">
        <div class="ab-hero-inner">
            <div class="ab-badge">🏫 About Us</div>
            <h1>រឿងរ៉ាវ<span>របស់សាលា</span></h1>
            <p>តើអ្វីទៅដែលធ្វើឱ្យសាលារបស់យើងមានលក្ខណៈពិសេស?</p>
        </div>
    </div>

    <div class="ab-wrap">

        <!-- Story Section -->
        <div class="ab-story">

            <!-- Image -->
            <div class="ab-img-wrap">
                <img src="https://images.pexels.com/photos/301920/pexels-photo-301920.jpeg?auto=compress&cs=tinysrgb&w=800" alt="School Story">
                <div class="ab-year-badge">
                    <strong>1890</strong>
                    ឆ្នាំបង្កើត
                </div>
            </div>

            <!-- Text -->
            <div class="ab-story-text">
                <div class="ab-section-label">ប្រភពដើម</div>
                <h2>ប្រភពដើមនៃ<br>សាលារបស់យើង</h2>
                <p>
                    សាលារបស់យើងត្រូវបានបង្កើតឡើងក្នុងឆ្នាំ <strong>១៨៩០</strong> ចាប់ផ្ដើមពីបំណងប្រាថ្នាតូចមួយ
                    ក្នុងការកែលម្អការអប់រំនៅកម្ពុជា។ យើងជឿជាក់ថាការអប់រំគឺជាគន្លឹះ
                    នៃភាពជោគជ័យ ហើយបានប្រឹងប្រែងពង្រីកសេវានេះប្រចាំឆ្នាំ។
                </p>

                <!-- Admin Card -->
                <div class="ab-admin-card">
                    <h5>👤 ព័ត៌មានអ្នកគ្រប់គ្រង</h5>

                    <div class="ab-admin-row">
                        <span class="lbl">ឈ្មោះ</span>
                        <span class="val">{{ $name }}</span>
                    </div>

                    <div class="ab-admin-row">
                        <span class="lbl">Email</span>
                        <span class="val">{{ $email }}</span>
                    </div>

                    <div class="ab-admin-row">
                        <span class="lbl">ID</span>
                        <span class="id-pill">#{{ $id }}</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- ── TEAM MEMBERS SECTION ── -->
        <div class="ab-team">
            <div class="ab-team-header">
                <div class="ab-section-label">ក្រុមការងារ</div>
                <h2>ជួបជាមួយ<span style="color:#1c64b1;">ក្រុមការងាររបស់យើង</span></h2>
                <p>អ្នកជំនាញដែលលះបង់ខ្លួន ដើម្បីភ្លឺបំណងប្រាថ្នារបស់សិស្សានុសិស្ស</p>
            </div>

            <div class="ab-team-grid">

                <!-- Member 1 -->
                <div class="ab-member-card">
                    <div class="ab-member-photo">
                        <img src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Team Member">
                        <div class="ab-member-photo-overlay"></div>
                    </div>
                    <div class="ab-member-info">
                        <h4>សុខ វណ្ណា</h4>
                        <div class="ab-member-role">នាយកសាលា</div>
                        <p class="ab-member-bio">មានបទពិសោធន៍ ៣៥ ឆ្នាំក្នុងការអប់រំ និងការគ្រប់គ្រងស្ថាប័ន។</p>
                        <div class="ab-member-socials">
                            <a href="#" class="ab-social-btn" title="Facebook">f</a>
                            <a href="#" class="ab-social-btn" title="LinkedIn">in</a>
                            <a href="#" class="ab-social-btn" title="Email">✉</a>
                        </div>
                    </div>
                </div>

                <!-- Member 2 -->
                <div class="ab-member-card">
                    <div class="ab-member-photo">
                        <img src="https://images.pexels.com/photos/3769021/pexels-photo-3769021.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Team Member">
                        <div class="ab-member-photo-overlay"></div>
                    </div>
                    <div class="ab-member-info">
                        <h4>ចាន់ សុភាព</h4>
                        <div class="ab-member-role">គ្រូបង្រៀន · គណិតវិទ្យា</div>
                        <p class="ab-member-bio">បញ្ចប់ការសិក្សាថ្នាក់បរិញ្ញាបត្រពីសកលវិទ្យាល័យភ្នំពេញ ឯកទេសគណិតវិទ្យា។</p>
                        <div class="ab-member-socials">
                            <a href="#" class="ab-social-btn" title="Facebook">f</a>
                            <a href="#" class="ab-social-btn" title="LinkedIn">in</a>
                            <a href="#" class="ab-social-btn" title="Email">✉</a>
                        </div>
                    </div>
                </div>

                <!-- Member 3 -->
                <div class="ab-member-card">
                    <div class="ab-member-photo">
                        <img src="https://images.pexels.com/photos/3184405/pexels-photo-3184405.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Team Member">
                        <div class="ab-member-photo-overlay"></div>
                    </div>
                    <div class="ab-member-info">
                        <h4>លី សុខឡាយ</h4>
                        <div class="ab-member-role">គ្រូបង្រៀន · វិទ្យាសាស្ត្រ</div>
                        <p class="ab-member-bio">ជំនាញខាងជីវវិទ្យា និងគីមីវិទ្យា ដែលមានបទពិសោធន៍ ២០ ឆ្នាំ។</p>
                        <div class="ab-member-socials">
                            <a href="#" class="ab-social-btn" title="Facebook">f</a>
                            <a href="#" class="ab-social-btn" title="LinkedIn">in</a>
                            <a href="#" class="ab-social-btn" title="Email">✉</a>
                        </div>
                    </div>
                </div>

                <!-- Member 4 -->
                <div class="ab-member-card">
                    <div class="ab-member-photo">
                        <img src="https://images.pexels.com/photos/5212700/pexels-photo-5212700.jpeg?auto=compress&cs=tinysrgb&w=400" alt="Team Member">
                        <div class="ab-member-photo-overlay"></div>
                    </div>
                    <div class="ab-member-info">
                        <h4>ហេង បូរ៉ា</h4>
                        <div class="ab-member-role">គ្រូបង្រៀន · Software Project Development</div>
                        <p class="ab-member-bio">ទទួលបានសញ្ញាបត្រ TESOL និងមានបទពិសោធន៍បង្រៀនអន្តរជាតិ។</p>
                        <div class="ab-member-socials">
                            <a href="#" class="ab-social-btn" title="Facebook">f</a>
                            <a href="#" class="ab-social-btn" title="LinkedIn">in</a>
                            <a href="#" class="ab-social-btn" title="Email">✉</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- ── END TEAM MEMBERS ── -->

        <!-- Stats -->
        <div class="ab-stats">
            <div class="ab-stat-card" style="--accent: #1c64b1; transition-delay: 0s;">
                <div class="stat-icon">🏆</div>
                <div class="stat-num">15<span style="font-size:1.5rem">+</span></div>
                <div class="stat-label">Experience Years</div>
            </div>
            <div class="ab-stat-card" style="--accent: #e8a020; transition-delay: 0.1s;">
                <div class="stat-icon">🎓</div>
                <div class="stat-num">2,500<span style="font-size:1.5rem">+</span></div>
                <div class="stat-label">Happy Students</div>
            </div>
            <div class="ab-stat-card" style="--accent: #4caf50; transition-delay: 0.2s;">
                <div class="stat-icon">⭐</div>
                <div class="stat-num">100<span style="font-size:1.5rem">%</span></div>
                <div class="stat-label">Quality Education</div>
            </div>
        </div>

        <!-- CTA -->
        <div class="ab-cta">
            <a href="https://www.google.com" target="_blank" class="btn-outline-ab">
                🔍 ស្វែងរកបន្ថែម
            </a>
            <a href="/contact-us" class="btn-fill-ab">
                ✉️ ទំនាក់ទំនងមកយើង →
            </a>
        </div>

    </div>
</div>

<script>
    const els = document.querySelectorAll('.ab-img-wrap, .ab-story-text, .ab-stat-card, .ab-cta, .ab-team');
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.12 });
    els.forEach(el => io.observe(el));
</script>

@endsection