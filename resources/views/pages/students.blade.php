@extends('layouts.master')

@section('title', 'បញ្ជីសិស្ស - Students')

@section('content')
<style>
    .st-wrap { max-width: 1200px; margin: 0 auto; padding: 2.5rem 2rem 4rem; }

    /* Header */
    .st-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(26,35,126,0.08); }
    .st-header-left { display: flex; align-items: center; gap: 14px; }
    .st-icon { width: 52px; height: 52px; border-radius: 16px; background: linear-gradient(135deg,#1a237e,#3949ab); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; box-shadow: 0 6px 18px rgba(26,35,126,0.25); }
    .st-title { font-size: 1.5rem; font-weight: 700; color: #1a237e; margin: 0; }
    .st-sub   { font-size: 0.8rem; color: #6b7280; margin-top: 2px; }
    .st-bread { font-size: 0.78rem; color: #9ca3af; margin-bottom: 4px; }
    .st-bread a { color: #3949ab; text-decoration: none; }

    .btn-add { display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg,#1a237e,#3949ab); color: #fff; border: none; border-radius: 12px; padding: 11px 22px; font-size: 0.875rem; font-weight: 700; text-decoration: none; box-shadow: 0 5px 18px rgba(26,35,126,0.28); transition: opacity 0.15s, transform 0.12s; }
    .btn-add:hover { opacity: 0.9; transform: translateY(-1px); color: #fff; }

    /* Alert */
    .st-alert { padding: 0.9rem 1.25rem; border-radius: 12px; font-size: 0.87rem; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; }
    .st-alert-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }

    /* Stats row */
    .st-stats { display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem; margin-bottom: 1.75rem; }
    @media(max-width:640px){ .st-stats { grid-template-columns: repeat(2,1fr); } }
    .st-stat { background: #fff; border-radius: 14px; padding: 1.1rem 1.25rem; border: 1px solid rgba(26,35,126,0.07); text-align: center; }
    .st-stat .num { font-size: 1.8rem; font-weight: 700; color: var(--c,#1a237e); font-family: Georgia,serif; line-height: 1; }
    .st-stat .lbl { font-size: 0.72rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.08em; margin-top: 4px; }

    /* Toolbar */
    .st-toolbar { display: flex; align-items: center; gap: 0.9rem; flex-wrap: wrap; background: #fff; border-radius: 14px; padding: 0.9rem 1.25rem; border: 1px solid rgba(26,35,126,0.07); box-shadow: 0 3px 14px rgba(26,35,126,0.05); margin-bottom: 1.5rem; }
    .st-srch-wrap { position: relative; flex: 1; min-width: 180px; }
    .st-srch-wrap svg { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); width: 14px; height: 14px; color: #9ca3af; pointer-events: none; }
    .st-srch { width: 100%; padding: 9px 12px 9px 33px; background: #f4f7fc; border: 1.5px solid rgba(26,35,126,0.09); border-radius: 9px; font-family: 'Kantumruy Pro','Outfit',sans-serif; font-size: 0.86rem; color: #111827; transition: border-color 0.18s; }
    .st-srch:focus { outline: none; border-color: #1a237e; background: #fff; }

    .st-fil { padding: 7px 14px; border-radius: 50px; font-size: 0.78rem; font-weight: 700; cursor: pointer; border: 1.5px solid rgba(26,35,126,0.1); background: transparent; color: #6b7280; font-family: 'Kantumruy Pro','Outfit',sans-serif; transition: all 0.15s; }
    .st-fil:hover  { border-color: #1a237e; color: #1a237e; background: #e8eaf6; }
    .st-fil.active { background: #1a237e; border-color: #1a237e; color: #fff; }
    .st-count { font-size: 0.77rem; color: #6b7280; white-space: nowrap; margin-left: auto; }
    .st-count strong { color: #1a237e; }

    /* Table card */
    .st-table-card { background: #fff; border-radius: 18px; border: 1px solid rgba(26,35,126,0.07); box-shadow: 0 4px 20px rgba(26,35,126,0.06); overflow: hidden; }
    .st-table-head { padding: 1rem 1.5rem; border-bottom: 1px solid rgba(26,35,126,0.07); display: flex; align-items: center; gap: 10px; background: #fafbff; }
    .st-table-head h5 { font-size: 0.95rem; font-weight: 700; color: #1a237e; margin: 0; }

    table.st-tbl { width: 100%; border-collapse: collapse; font-size: 0.855rem; }
    table.st-tbl thead tr { background: linear-gradient(135deg,#1a237e,#283593); color: #fff; }
    table.st-tbl th { padding: 12px 16px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase; text-align: left; border: none; white-space: nowrap; }
    table.st-tbl th:last-child { text-align: center; }
    table.st-tbl tbody tr { border-bottom: 1px solid rgba(26,35,126,0.06); transition: background 0.15s; }
    table.st-tbl tbody tr:last-child { border-bottom: none; }
    table.st-tbl tbody tr:hover { background: #f8faff; }
    table.st-tbl td { padding: 12px 16px; color: #374151; vertical-align: middle; }

    /* Avatar */
    .st-avatar { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; color: #fff; flex-shrink: 0; }

    /* Name cell */
    .st-name-cell { display: flex; align-items: center; gap: 10px; }
    .st-name-cell .name { font-weight: 700; color: #1a237e; }
    .st-name-cell .email { font-size: 0.75rem; color: #6b7280; }

    /* Gender badge */
    .g-badge { display: inline-flex; align-items: center; gap: 4px; font-size: 0.7rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
    .g-male   { background: #dbeafe; color: #1d4ed8; }
    .g-female { background: #fce7f3; color: #be185d; }
    .g-other  { background: #e0f2fe; color: #0369a1; }

    /* Score bar */
    .st-score-wrap { display: flex; align-items: center; gap: 8px; }
    .st-score-bar  { flex: 1; height: 6px; background: #e8eaf6; border-radius: 4px; overflow: hidden; min-width: 60px; }
    .st-score-fill { height: 100%; border-radius: 4px; }
    .st-score-num  { font-weight: 700; font-size: 0.82rem; width: 36px; text-align: right; }

    /* Action buttons */
    .st-acts { display: flex; align-items: center; justify-content: center; gap: 6px; }
    .st-act  { width: 30px; height: 30px; border-radius: 8px; border: 1px solid rgba(26,35,126,0.1); background: #f8faff; display: flex; align-items: center; justify-content: center; font-size: 0.78rem; cursor: pointer; text-decoration: none; color: #374151; transition: all 0.15s; }
    .st-act:hover { background: #e8eaf6; color: #1a237e; border-color: #1a237e; }
    .st-act.del:hover { background: #ffebee; color: #c62828; border-color: #ef9a9a; }
    .del-form { display: none; }

    /* Empty */
    .st-empty { text-align: center; padding: 3rem; color: #9ca3af; }
    .st-empty .ei { font-size: 2.5rem; margin-bottom: 0.75rem; }

    /* Hidden row */
    .hidden-row { display: none; }

    @media(max-width:640px){ .st-toolbar { flex-direction: column; align-items: stretch; } .st-count { margin-left: 0; } }
</style>

<div class="st-wrap">

    @if(session('success'))
        <div class="st-alert st-alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    {{-- Header --}}
    <div class="st-header">
        <div class="st-header-left">
            <div class="st-icon"><i class="fas fa-user-graduate"></i></div>
            <div>
                <div class="st-bread"><a href="/">Home</a> / <span>Students</span></div>
                <h1 class="st-title">បញ្ជីសិស្ស</h1>
                <div class="st-sub">All students in the school system</div>
            </div>
        </div>
        <a href="{{ route('students.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> បន្ថែមសិស្ស
        </a>
    </div>

    {{-- Stats --}}
    @php
        $total  = count($students);
        $male   = $students->where('gender','male')->count();
        $female = $students->where('gender','female')->count();
        $avgScore = $total ? round($students->avg('score'), 1) : 0;
    @endphp
    <div class="st-stats">
        <div class="st-stat" style="--c:#1a237e;">
            <div class="num">{{ $total }}</div><div class="lbl">សិស្សសរុប</div>
        </div>
        <div class="st-stat" style="--c:#1d4ed8;">
            <div class="num">{{ $male }}</div><div class="lbl">👦 ប្រុស</div>
        </div>
        <div class="st-stat" style="--c:#be185d;">
            <div class="num">{{ $female }}</div><div class="lbl">👧 ស្រី</div>
        </div>
        <div class="st-stat" style="--c:#059669;">
            <div class="num">{{ $avgScore }}</div><div class="lbl">⭐ Avg Score</div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="st-toolbar">
        <div class="st-srch-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" class="st-srch" id="stSearch"
                placeholder="ស្វែងរកឈ្មោះ, Email, អាយុ..."
                oninput="stFilter()"/>
        </div>
        <div style="display:flex;gap:7px;flex-wrap:wrap;">
            <button class="st-fil active" data-g="all"    onclick="stGender(this,'all')">🗂 ទាំងអស់</button>
            <button class="st-fil"        data-g="male"   onclick="stGender(this,'male')">👦 ប្រុស</button>
            <button class="st-fil"        data-g="female" onclick="stGender(this,'female')">👧 ស្រី</button>
            <button class="st-fil"        data-g="other"  onclick="stGender(this,'other')">⚧ other</button>
        </div>
        <div class="st-count">
            <strong id="stVis">{{ $total }}</strong> / <strong>{{ $total }}</strong> នាក់
        </div>
    </div>

    {{-- Table --}}
    <div class="st-table-card">
        <div class="st-table-head">
            <i class="fas fa-list" style="color:#1a237e;"></i>
            <h5>តារាងសិស្ស</h5>
        </div>
        <div style="overflow-x:auto;">
            <table class="st-tbl" id="stTable">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>ឈ្មោះ / Name</th>
                        <th>អាយុ</th>
                        <th>ថ្ងៃខែឆ្នាំ</th>
                        <th>ភេទ</th>
                        <th>ពិន្ទុ / Score</th>
                        <th>សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody id="stBody">
                @forelse($students as $i => $s)
                    @php
                        $colors = ['#1a237e','#1565c0','#00695c','#6a1b9a','#e65100','#c62828'];
                        $bg = $colors[$i % count($colors)];
                        $initial = mb_substr($s->name, 0, 1, 'UTF-8');
                        $scoreColor = $s->score >= 80 ? '#059669' : ($s->score >= 50 ? '#d97706' : '#dc2626');
                    @endphp
                    <tr data-name="{{ strtolower($s->name . ' ' . $s->email) }}"
                        data-gender="{{ $s->gender }}">
                        <td style="color:#9ca3af;font-size:0.8rem;">{{ $i + 1 }}</td>
                        <td>
                            <div class="st-name-cell">
                                <div class="st-avatar" style="background:{{ $bg }};">{{ $initial }}</div>
                                <div>
                                    <div class="name">{{ $s->name }}</div>
                                    <div class="email">{{ $s->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $s->age }} ឆ្នាំ</td>
                        <td>{{ \Carbon\Carbon::parse($s->date_of_birth)->format('d/m/Y') }}</td>
                        <td>
                            @if($s->gender == 'male')
                                <span class="g-badge g-male">👦 ប្រុស</span>
                            @elseif($s->gender == 'female')
                                <span class="g-badge g-female">👧 ស្រី</span>
                            @else
                                <span class="g-badge g-other">⚧ Other</span>
                            @endif
                        </td>
                        <td>
                            <div class="st-score-wrap">
                                <div class="st-score-bar">
                                    <div class="st-score-fill"
                                         style="width:{{ $s->score }}%;background:{{ $scoreColor }};"></div>
                                </div>
                                <span class="st-score-num" style="color:{{ $scoreColor }};">
                                    {{ $s->score }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="st-acts">
                                <a href="{{ route('students.edit', $s->id) }}"
                                   class="st-act" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button class="st-act del" title="Delete"
                                    onclick="stDel({{ $s->id }},'{{ addslashes($s->name) }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="stDel{{ $s->id }}" class="del-form"
                                      action="{{ route('students.destroy', $s->id) }}"
                                      method="POST">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="st-empty">
                                <div class="ei">📭</div>
                                <p>មិនទាន់មានសិស្ស —
                                   <a href="{{ route('students.create') }}"
                                      style="color:#1a237e;font-weight:700;">
                                       + បន្ថែមសិស្សដំបូង
                                   </a>
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- No results --}}
        <div class="st-empty" id="stEmpty" style="display:none;">
            <div class="ei">🔍</div>
            <p>រកមិនឃើញ — សូមព្យាយាមពាក្យផ្សេង</p>
        </div>
    </div>

</div>

<script>
    let activeGender = 'all';

    function stGender(btn, g) {
        activeGender = g;
        document.querySelectorAll('.st-fil').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        stFilter();
    }

    function stFilter() {
        const q    = document.getElementById('stSearch').value.toLowerCase().trim();
        const rows = [...document.querySelectorAll('#stBody tr[data-name]')];
        let   vis  = 0;

        rows.forEach(r => {
            const name   = r.dataset.name   || '';
            const gender = r.dataset.gender || '';
            const ok = (activeGender === 'all' || gender === activeGender) && (!q || name.includes(q));
            r.classList.toggle('hidden-row', !ok);
            if (ok) vis++;
        });

        document.getElementById('stVis').textContent = vis;
        document.getElementById('stEmpty').style.display = vis === 0 ? 'block' : 'none';
    }

    function stDel(id, name) {
        if (confirm('តើអ្នកចង់លុបសិស្ស "' + name + '" មែនទេ?\nការលុបនេះមិនអាចត្រឡប់វិញបានទេ!')) {
            document.getElementById('stDel' + id).submit();
        }
    }
</script>

@endsection