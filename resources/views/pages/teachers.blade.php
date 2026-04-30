@extends('layouts.master')

@section('title', 'បញ្ជីគ្រូ - Teachers')

@section('content')
<style>
    .tc-wrap  { max-width: 1200px; margin: 0 auto; padding: 2.5rem 2rem 4rem; }

    /* Header */
    .tc-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(26,35,126,0.08); }
    .tc-header-left { display: flex; align-items: center; gap: 14px; }
    .tc-icon  { width: 52px; height: 52px; border-radius: 16px; background: linear-gradient(135deg,#1a237e,#3949ab); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; box-shadow: 0 6px 18px rgba(26,35,126,0.25); }
    .tc-title { font-size: 1.5rem; font-weight: 700; color: #1a237e; margin: 0; }
    .tc-sub   { font-size: 0.8rem; color: #6b7280; margin-top: 2px; }
    .tc-bread { font-size: 0.78rem; color: #9ca3af; margin-bottom: 4px; }
    .tc-bread a { color: #3949ab; text-decoration: none; }
    .btn-add  { display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg,#1a237e,#3949ab); color: #fff; border: none; border-radius: 12px; padding: 11px 22px; font-size: 0.875rem; font-weight: 700; text-decoration: none; box-shadow: 0 5px 18px rgba(26,35,126,0.28); transition: opacity 0.15s, transform 0.12s; }
    .btn-add:hover { opacity: 0.9; transform: translateY(-1px); color: #fff; }

    /* Alert */
    .tc-alert { padding: 0.9rem 1.25rem; border-radius: 12px; font-size: 0.87rem; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; }
    .tc-alert-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }

    /* Stats */
    .tc-stats { display: grid; grid-template-columns: repeat(3,1fr); gap: 1rem; margin-bottom: 1.75rem; }
    @media(max-width:600px){ .tc-stats { grid-template-columns: 1fr; } }
    .tc-stat  { background: #fff; border-radius: 14px; padding: 1.1rem 1.25rem; border: 1px solid rgba(26,35,126,0.07); text-align: center; }
    .tc-stat .num { font-size: 1.8rem; font-weight: 700; color: var(--c,#1a237e); font-family: Georgia,serif; line-height: 1; }
    .tc-stat .lbl { font-size: 0.72rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.08em; margin-top: 4px; }

    /* Toolbar */
    .tc-toolbar { display: flex; align-items: center; gap: 0.9rem; flex-wrap: wrap; background: #fff; border-radius: 14px; padding: 0.9rem 1.25rem; border: 1px solid rgba(26,35,126,0.07); box-shadow: 0 3px 14px rgba(26,35,126,0.05); margin-bottom: 1.5rem; }
    .tc-srch-wrap { position: relative; flex: 1; min-width: 180px; }
    .tc-srch-wrap svg { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; color: #9ca3af; pointer-events: none; }
    .tc-srch { width: 100%; padding: 9px 12px 9px 33px; background: #f4f7fc; border: 1.5px solid rgba(26,35,126,0.09); border-radius: 9px; font-family: 'Kantumruy Pro','Outfit',sans-serif; font-size: 0.86rem; color: #111827; }
    .tc-srch:focus { outline: none; border-color: #1a237e; background: #fff; }
    .tc-count { font-size: 0.77rem; color: #6b7280; margin-left: auto; }
    .tc-count strong { color: #1a237e; }

    /* Grid */
    .tc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px,1fr)); gap: 1.25rem; }

    /* Card */
    .tc-card { background: #fff; border-radius: 18px; border: 1px solid rgba(26,35,126,0.07); overflow: hidden; transition: all 0.26s ease; opacity: 0; transform: translateY(16px); }
    .tc-card.show { opacity: 1; transform: translateY(0); }
    .tc-card:hover { transform: translateY(-5px); box-shadow: 0 20px 50px rgba(26,35,126,0.1); border-color: rgba(26,35,126,0.16); }
    .tc-card.hidden { display: none; }

    .tc-card-top { height: 90px; display: flex; align-items: center; justify-content: center; position: relative; }
    .tc-avatar { width: 72px; height: 72px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 700; color: #fff; border: 3px solid #fff; box-shadow: 0 4px 16px rgba(26,35,126,0.2); }

    .tc-card-body { padding: 0.75rem 1.25rem 1.25rem; text-align: center; }
    .tc-name    { font-size: 1rem; font-weight: 700; color: #1a237e; margin-bottom: 3px; }
    .tc-subject { display: inline-block; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #fff; background: #1a237e; border-radius: 20px; padding: 3px 12px; margin-bottom: 12px; }

    .tc-info { display: flex; flex-direction: column; gap: 5px; margin-bottom: 1rem; text-align: left; }
    .tc-info-row { display: flex; align-items: center; gap: 8px; font-size: 0.79rem; color: #374151; }
    .tc-info-row i { width: 16px; text-align: center; color: #6b7280; font-size: 0.75rem; flex-shrink: 0; }

    .tc-acts { display: flex; gap: 7px; justify-content: center; }
    .tc-act { display: inline-flex; align-items: center; gap: 5px; padding: 7px 14px; border-radius: 9px; font-size: 0.78rem; font-weight: 600; text-decoration: none; border: 1.5px solid; cursor: pointer; transition: all 0.15s; background: transparent; font-family: 'Kantumruy Pro','Outfit',sans-serif; }
    .tc-act-edit { color: #1a237e; border-color: rgba(26,35,126,0.2); }
    .tc-act-edit:hover { background: #e8eaf6; border-color: #1a237e; color: #1a237e; }
    .tc-act-del  { color: #c62828; border-color: rgba(198,40,40,0.2); }
    .tc-act-del:hover  { background: #ffebee; border-color: #c62828; }

    /* Empty */
    .tc-empty { text-align: center; padding: 4rem 1rem; color: #9ca3af; grid-column: 1/-1; }
    .tc-empty .ei { font-size: 3rem; margin-bottom: 1rem; }

    @media(max-width:640px){ .tc-toolbar { flex-direction: column; align-items: stretch; } .tc-count { margin-left: 0; } }
</style>

<div class="tc-wrap">

    @if(session('success'))
        <div class="tc-alert tc-alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="tc-header">
        <div class="tc-header-left">
            <div class="tc-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <div>
                <div class="tc-bread"><a href="/">Home</a> / <span>Teachers</span></div>
                <h1 class="tc-title">បញ្ជីគ្រូបង្រៀន</h1>
                <div class="tc-sub">All teachers in the school system</div>
            </div>
        </div>
        <a href="{{ route('teachers.add') }}" class="btn-add">
            <i class="fas fa-plus"></i> បន្ថែមគ្រូ
        </a>
    </div>

    {{-- Stats --}}
    <div class="tc-stats">
        <div class="tc-stat" style="--c:#1a237e;">
            <div class="num">{{ count($teachers) }}</div>
            <div class="lbl">👨‍🏫 គ្រូសរុប</div>
        </div>
        <div class="tc-stat" style="--c:#1565c0;">
            <div class="num">
                @php
                    $subjects = $teachers->pluck('subject')->unique()->count();
                @endphp
                {{ $subjects }}
            </div>
            <div class="lbl">📚 មុខវិជ្ជា</div>
        </div>
        <div class="tc-stat" style="--c:#2e7d32;">
            <div class="num">{{ $teachers->whereNotNull('email')->count() }}</div>
            <div class="lbl">📧 Email</div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="tc-toolbar">
        <div class="tc-srch-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" class="tc-srch" id="tcSearch"
                placeholder="ស្វែងរកឈ្មោះ, មុខវិជ្ជា, ទូរស័ព្ទ..."
                oninput="tcFilter()"/>
        </div>
        <div class="tc-count">
            <strong id="tcVis">{{ count($teachers) }}</strong>
            / <strong>{{ count($teachers) }}</strong> នាក់
        </div>
    </div>

    {{-- Cards Grid --}}
    <div class="tc-grid" id="tcGrid">
        @php
            $colors = ['#1a237e','#1565c0','#00695c','#6a1b9a','#e65100','#c62828','#2e7d32','#0277bd'];
        @endphp

        @forelse($teachers as $i => $t)
        <div class="tc-card"
             data-name="{{ strtolower(($t->name ?? '') . ' ' . ($t->subject ?? '') . ' ' . ($t->phone ?? '')) }}"
             style="transition-delay:{{ ($loop->index % 8) * 0.05 }}s">

            <div class="tc-card-top" style="background:{{ $colors[$i % count($colors)] }}18;">
                <div class="tc-avatar" style="background:{{ $colors[$i % count($colors)] }};">
                    {{ mb_substr($t->name ?? 'T', 0, 1, 'UTF-8') }}
                </div>
            </div>

            <div class="tc-card-body">
                <div class="tc-name">{{ $t->name }}</div>
                <div class="tc-subject" style="background:{{ $colors[$i % count($colors)] }};">
                   {{ $t->subject ?? 'មិនទាន់កំណត់' }}
                </div>

                <div class="tc-info">
                    <div class="tc-info-row">
                        <i class="fas fa-envelope"></i>
                        <span>{{ $t->email }}</span>
                    </div>
                    <div class="tc-info-row">
                        <i class="fas fa-phone"></i>
                        <span>{{ $t->phone }}</span>
                    </div>
                    @if(!empty($t->address))
                    <div class="tc-info-row">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $t->address }}</span>
                    </div>
                    @endif
                </div>

                <div class="tc-acts">
                    <a href="{{ route('teachers.edit', $t->id) }}" class="tc-act tc-act-edit">
                        <i class="fas fa-pen"></i> Edit
                    </a>
                    <a href="{{ route('teachers.delete', $t->id) }}"
                       class="tc-act tc-act-del"
                       onclick="return confirm('លុបគ្រូ &quot;{{ addslashes($t->name) }}&quot; មែនទេ?')">
                        <i class="fas fa-trash"></i> លុប
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="tc-empty">
            <div class="ei">📭</div>
            <p>មិន​ទាន់​មាន​គ្រូ —
               <a href="{{ route('teachers.add') }}" style="color:#1a237e;font-weight:700;">
                   + បន្ថែម​គ្រូ​ដំបូង
               </a>
            </p>
        </div>
        @endforelse

        <div class="tc-empty" id="tcEmpty" style="display:none;">
            <div class="ei">🔍</div>
            <p>រក​មិន​ឃើញ — សូម​ព្យាយាម​ពាក្យ​ផ្សេង</p>
        </div>
    </div>

</div>

<script>
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('show'); io.unobserve(e.target); }
        });
    }, { threshold: 0.08 });
    document.querySelectorAll('.tc-card').forEach(c => io.observe(c));

    function tcFilter() {
        const q = document.getElementById('tcSearch').value.toLowerCase().trim();
        const cards = [...document.querySelectorAll('#tcGrid .tc-card')];
        let vis = 0;
        cards.forEach(c => {
            const ok = !q || (c.dataset.name || '').includes(q);
            c.classList.toggle('hidden', !ok);
            if (ok) { if (!c.classList.contains('show')) c.classList.add('show'); vis++; }
        });
        document.getElementById('tcVis').textContent = vis;
        document.getElementById('tcEmpty').style.display = vis === 0 ? 'block' : 'none';
    }
</script>

@endsection