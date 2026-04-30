@extends('layouts.master')

@section('title', 'បញ្ជីមុខវិជ្ជា - Courses')

@section('content')
<style>
    /* ══ COURSES INDEX ══ */
    .ci-wrap { max-width: 1200px; margin: 0 auto; padding: 2.5rem 2rem 4rem; }

    /* ── Page header ── */
    .ci-header {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 1rem;
        margin-bottom: 2rem; padding-bottom: 1.25rem;
        border-bottom: 1px solid rgba(26,35,126,0.08);
    }
    .ci-header-left { display: flex; align-items: center; gap: 14px; }
    .ci-page-icon {
        width: 52px; height: 52px; border-radius: 16px;
        background: linear-gradient(135deg, #1a237e, #3949ab);
        color: #fff; display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; box-shadow: 0 6px 18px rgba(26,35,126,0.25);
    }
    .ci-page-title { font-size: 1.5rem; font-weight: 700; color: #1a237e; margin: 0; }
    .ci-page-sub   { font-size: 0.8rem; color: #6b7280; margin-top: 2px; }
    .ci-breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 0.78rem; color: #9ca3af; margin-bottom: 4px; }
    .ci-breadcrumb a { color: #3949ab; text-decoration: none; }

    .ci-btn-add {
        display: inline-flex; align-items: center; gap: 8px;
        background: linear-gradient(135deg, #1a237e, #3949ab);
        color: #fff; border: none; border-radius: 12px;
        padding: 11px 22px; font-size: 0.875rem; font-weight: 700;
        text-decoration: none; cursor: pointer;
        box-shadow: 0 5px 18px rgba(26,35,126,0.28);
        transition: opacity 0.15s, transform 0.12s;
    }
    .ci-btn-add:hover { opacity: 0.9; transform: translateY(-1px); color: #fff; }

    /* ── Alert ── */
    .ci-alert { padding: 0.9rem 1.25rem; border-radius: 12px; font-size: 0.87rem; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; }
    .ci-alert-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }

    /* ── Toolbar ── */
    .ci-toolbar {
        display: flex; align-items: center; gap: 0.9rem; flex-wrap: wrap;
        background: #fff; border-radius: 14px; padding: 0.9rem 1.25rem;
        border: 1px solid rgba(26,35,126,0.07);
        box-shadow: 0 3px 14px rgba(26,35,126,0.05);
        margin-bottom: 1.75rem;
    }
    .ci-srch-wrap { position: relative; flex: 1; min-width: 180px; }
    .ci-srch-wrap svg { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; color: #9ca3af; pointer-events: none; }
    .ci-srch { width: 100%; padding: 9px 12px 9px 33px; background: #f4f7fc; border: 1.5px solid rgba(26,35,126,0.09); border-radius: 9px; font-family: 'Kantumruy Pro','Outfit',sans-serif; font-size: 0.86rem; color: #111827; transition: border-color 0.18s; }
    .ci-srch:focus { outline: none; border-color: #1a237e; background: #fff; }

    .ci-filter { padding: 7px 14px; border-radius: 50px; font-size: 0.78rem; font-weight: 700; cursor: pointer; border: 1.5px solid rgba(26,35,126,0.1); background: transparent; color: #6b7280; font-family: 'Kantumruy Pro','Outfit',sans-serif; transition: all 0.15s; white-space: nowrap; }
    .ci-filter:hover  { border-color: #1a237e; color: #1a237e; background: #e8eaf6; }
    .ci-filter.active { background: #1a237e; border-color: #1a237e; color: #fff; box-shadow: 0 4px 12px rgba(26,35,126,0.22); }

    .ci-count { font-size: 0.77rem; color: #6b7280; white-space: nowrap; margin-left: auto; }
    .ci-count strong { color: #1a237e; }

    /* ── Grid ── */
    .ci-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1.4rem;
        margin-bottom: 2rem;
    }

    /* ── Course card ── */
    .ci-card {
        background: #fff; border-radius: 18px;
        border: 1px solid rgba(26,35,126,0.07);
        overflow: hidden; position: relative;
        transition: all 0.26s ease;
        opacity: 0; transform: translateY(18px);
    }
    .ci-card.show { opacity: 1; transform: translateY(0); }
    .ci-card:hover { transform: translateY(-5px); box-shadow: 0 20px 50px rgba(26,35,126,0.11); border-color: rgba(26,35,126,0.16); }
    .ci-card.hidden { display: none; }

    .ci-card-bar  { height: 4px; }
    .ci-card-body { padding: 1.4rem 1.35rem 1.2rem; }

    .ci-card-top  { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 0.9rem; }
    .ci-icon-box  { width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; }
    .ci-actions   { display: flex; gap: 6px; }
    .ci-act-btn   { width: 30px; height: 30px; border-radius: 8px; border: 1px solid rgba(26,35,126,0.1); background: #f8faff; display: flex; align-items: center; justify-content: center; font-size: 0.78rem; cursor: pointer; text-decoration: none; color: #374151; transition: all 0.15s; }
    .ci-act-btn:hover { background: #e8eaf6; color: #1a237e; border-color: #1a237e; }
    .ci-act-btn.del:hover { background: #ffebee; color: #c62828; border-color: #ef9a9a; }

    .ci-cat-tag { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px; }
    .ci-card-name { font-size: 1.05rem; font-weight: 700; color: #1a237e; line-height: 1.3; margin-bottom: 4px; }
    .ci-card-code { display: inline-block; font-size: 0.68rem; font-weight: 700; background: #f0f4ff; color: #3949ab; border-radius: 6px; padding: 2px 9px; margin-bottom: 10px; }

    .ci-meta { display: flex; flex-direction: column; gap: 4px; margin-bottom: 1rem; }
    .ci-meta-row { display: flex; align-items: center; gap: 7px; font-size: 0.78rem; color: #6b7280; }
    .ci-meta-row i { width: 14px; text-align: center; color: #9ca3af; font-size: 0.75rem; }

    .ci-chips { display: flex; flex-wrap: wrap; gap: 5px; }
    .ci-chip  { font-size: 0.63rem; font-weight: 700; padding: 3px 9px; border-radius: 20px; background: #e8eaf6; color: #1a237e; }

    /* ── Empty state ── */
    .ci-empty { grid-column: 1/-1; text-align: center; padding: 4rem 1rem; color: #9ca3af; }
    .ci-empty .ei { font-size: 3rem; margin-bottom: 1rem; }
    .ci-empty p { font-size: 0.88rem; }

    /* Delete form hidden */
    .del-form { display: none; }

    @media (max-width: 640px) {
        .ci-toolbar { flex-direction: column; align-items: stretch; }
        .ci-count { margin-left: 0; }
    }
</style>

<div class="ci-wrap">

    {{-- Alert --}}
    @if(session('success'))
        <div class="ci-alert ci-alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="ci-header">
        <div class="ci-header-left">
            <div class="ci-page-icon"><i class="fas fa-book-open"></i></div>
            <div>
                <div class="ci-breadcrumb">
                    <a href="/">Home</a> / <span>Courses</span>
                </div>
                <h1 class="ci-page-title">មុខវិជ្ជាទាំងអស់</h1>
                <div class="ci-page-sub">All courses in the school system</div>
            </div>
        </div>
        <a href="{{ route('courses.create') }}" class="ci-btn-add">
            <i class="fas fa-plus"></i> បន្ថែមមុខវិជ្ជា
        </a>
    </div>

    {{-- Toolbar --}}
    <div class="ci-toolbar">
        <div class="ci-srch-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" class="ci-srch" id="ciSearch"
                placeholder="ស្វែងរកមុខវិជ្ជា, គ្រូ, លេខកូដ..."
                oninput="ciFilter()"/>
        </div>

        <div style="display:flex;gap:7px;flex-wrap:wrap;">
            <button class="ci-filter active" data-cat="all"       onclick="ciCat(this,'all')">🗂 ទាំងអស់</button>
            <button class="ci-filter"        data-cat="Web Development"  onclick="ciCat(this,'Web Development')">🌐 Web</button>
            <button class="ci-filter"        data-cat="Database"         onclick="ciCat(this,'Database')">🗄️ DB</button>
            <button class="ci-filter"        data-cat="Networking"       onclick="ciCat(this,'Networking')">🔌 Network</button>
            <button class="ci-filter"        data-cat="UI/UX Design"     onclick="ciCat(this,'UI/UX Design')">🎨 UI/UX</button>
            <button class="ci-filter"        data-cat="Cybersecurity"    onclick="ciCat(this,'Cybersecurity')">🔒 Security</button>
        </div>

        <div class="ci-count">
            <strong id="ciVisible">{{ count($courses) }}</strong> / <strong>{{ count($courses) }}</strong> មុខវិជ្ជា
        </div>
    </div>

    {{-- Course grid --}}
    <div class="ci-grid" id="ciGrid">

        @forelse($courses as $course)
        <div class="ci-card"
             data-name="{{ strtolower($course->name . ' ' . $course->code . ' ' . $course->teacher) }}"
             data-cat="{{ $course->category }}"
             style="transition-delay: {{ $loop->index * 0.05 }}s">

            <div class="ci-card-bar" style="background:{{ $course->color ?? '#1a237e' }};"></div>
            <div class="ci-card-body">

                <div class="ci-card-top">
                    <div class="ci-icon-box" style="background:{{ $course->color ?? '#1a237e' }}20;">
                        {{ $course->icon ?? '💻' }}
                    </div>
                    <div class="ci-actions">
                        <a href="{{ route('courses.edit', $course->id) }}"
                           class="ci-act-btn" title="Edit">
                            <i class="fas fa-pen"></i>
                        </a>
                        <button class="ci-act-btn del" title="Delete"
                            onclick="confirmDelete({{ $course->id }}, '{{ addslashes($course->name) }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                        {{-- Hidden delete form --}}
                        <form id="del-{{ $course->id }}" class="del-form"
                              action="{{ route('courses.destroy', $course->id) }}"
                              method="POST">
                            @csrf @method('DELETE')
                        </form>
                    </div>
                </div>

                <div class="ci-cat-tag" style="color:{{ $course->color ?? '#1a237e' }};">
                    {{ $course->category }}
                </div>
                <div class="ci-card-name">{{ $course->name }}</div>
                <div class="ci-card-code">{{ $course->code }}</div>

                <div class="ci-meta">
                    <div class="ci-meta-row">
                        <i class="fas fa-chalkboard-teacher"></i>
                        {{ $course->teacher }}
                    </div>
                    @if($course->room)
                    <div class="ci-meta-row">
                        <i class="fas fa-door-open"></i>
                        {{ $course->room }}
                    </div>
                    @endif
                    @if($course->time_start && $course->time_end)
                    <div class="ci-meta-row">
                        <i class="fas fa-clock"></i>
                        {{ $course->time_start }} – {{ $course->time_end }}
                    </div>
                    @endif
                    @if($course->start_date)
                    <div class="ci-meta-row">
                        <i class="fas fa-calendar-alt"></i>
                        {{ \Carbon\Carbon::parse($course->start_date)->format('d/m/Y') }}
                        @if($course->end_date)
                            → {{ \Carbon\Carbon::parse($course->end_date)->format('d/m/Y') }}
                        @endif
                    </div>
                    @endif
                </div>

                <div class="ci-chips">
                    @if($course->level)
                        <span class="ci-chip">🎯 {{ $course->level }}</span>
                    @endif
                    @if($course->max_students)
                        <span class="ci-chip">👥 {{ $course->max_students }} នាក់</span>
                    @endif
                    @if($course->duration)
                        <span class="ci-chip">⏱ {{ $course->duration }}h</span>
                    @endif
                    @if($course->days)
                        <span class="ci-chip">📅 {{ $course->days }}</span>
                    @endif
                </div>

            </div>
        </div>
        @empty
        <div class="ci-empty">
            <div class="ei">📭</div>
            <p>មិនទាន់មានមុខវិជ្ជា<br>
               <a href="{{ route('courses.create') }}" style="color:#1a237e;font-weight:700;">
                   + បន្ថែមមុខវិជ្ជាដំបូង
               </a>
            </p>
        </div>
        @endforelse

        {{-- No results (JS) --}}
        <div class="ci-empty" id="ciEmpty" style="display:none;">
            <div class="ei">🔍</div>
            <p>រកមិនឃើញ — សូមព្យាយាមពាក្យផ្សេង</p>
        </div>

    </div>

</div>

<script>
    /* ── Scroll reveal ── */
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('show'); io.unobserve(e.target); } });
    }, { threshold: 0.08 });
    document.querySelectorAll('.ci-card').forEach(c => io.observe(c));

    /* ── Filter state ── */
    let activeCat = 'all';

    function ciCat(btn, cat) {
        activeCat = cat;
        document.querySelectorAll('.ci-filter').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        ciFilter();
    }

    function ciFilter() {
        const q     = document.getElementById('ciSearch').value.toLowerCase().trim();
        const cards = [...document.querySelectorAll('#ciGrid .ci-card')];
        let   vis   = 0;

        cards.forEach(c => {
            const name = c.dataset.name || '';
            const cat  = c.dataset.cat  || '';
            const ok   = (activeCat === 'all' || cat === activeCat) && (!q || name.includes(q));
            c.classList.toggle('hidden', !ok);
            if (ok) { if (!c.classList.contains('show')) c.classList.add('show'); vis++; }
        });

        document.getElementById('ciVisible').textContent = vis;
        document.getElementById('ciEmpty').style.display = vis === 0 ? 'block' : 'none';
    }

    /* ── Delete confirm ── */
    function confirmDelete(id, name) {
        if (confirm('តើអ្នកចង់លុប "' + name + '" មែនទេ?\nការលុបនេះមិនអាចត្រឡប់វិញបានទេ!')) {
            document.getElementById('del-' + id).submit();
        }
    }
</script>

@endsection