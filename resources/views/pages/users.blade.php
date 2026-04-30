@extends('layouts.master')
@section('title', 'Users — គ្រប់គ្រង​គណនី')
@section('content')
<style>
.us-wrap{max-width:1100px;margin:0 auto;padding:2.5rem 2rem 4rem}
/* Header */
.us-header{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:2rem;padding-bottom:1.25rem;border-bottom:1px solid rgba(26,35,126,.08)}
.us-header-left{display:flex;align-items:center;gap:14px}
.us-icon{width:50px;height:50px;border-radius:15px;background:linear-gradient(135deg,#1a237e,#3949ab);color:#fff;display:flex;align-items:center;justify-content:center;font-size:1.3rem;box-shadow:0 5px 16px rgba(26,35,126,.25)}
.us-title{font-size:1.4rem;font-weight:700;color:#1a237e;margin:0}
.us-sub{font-size:.78rem;color:#6b7280;margin-top:2px}
.us-bread{font-size:.75rem;color:#9ca3af;margin-bottom:3px}
.us-bread a{color:#3949ab;text-decoration:none}
/* Add button */
.btn-add{display:inline-flex;align-items:center;gap:7px;background:linear-gradient(135deg,#1a237e,#3949ab);color:#fff;border:none;border-radius:10px;padding:10px 20px;font-family:'Kantumruy Pro','Outfit',sans-serif;font-size:.875rem;font-weight:700;cursor:pointer;box-shadow:0 5px 18px rgba(26,35,126,.25);transition:opacity .15s,transform .1s;text-decoration:none}
.btn-add:hover{opacity:.9;transform:translateY(-1px);color:#fff}
/* Stats */
.us-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.75rem}
@media(max-width:600px){.us-stats{grid-template-columns:1fr}}
.us-stat{background:#fff;border-radius:14px;padding:1.1rem 1.25rem;border:1px solid rgba(26,35,126,.07);text-align:center;box-shadow:0 3px 12px rgba(26,35,126,.05)}
.us-stat .num{font-size:1.8rem;font-weight:700;color:var(--c,#1a237e);font-family:Georgia,serif;line-height:1}
.us-stat .lbl{font-size:.7rem;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.08em;margin-top:4px}
/* Alert */
.us-alert{padding:.85rem 1.2rem;border-radius:10px;font-size:.84rem;font-weight:600;margin-bottom:1.5rem;display:flex;align-items:center;gap:8px}
.alert-ok{background:#e8f5e9;color:#2e7d32;border:1px solid #a5d6a7}
.alert-err{background:#ffebee;color:#c62828;border:1px solid #ef9a9a}
/* Table card */
.us-card{background:#fff;border-radius:18px;border:1px solid rgba(26,35,126,.07);box-shadow:0 4px 20px rgba(26,35,126,.06);overflow:hidden}
.us-card-head{padding:1rem 1.5rem;border-bottom:1px solid rgba(26,35,126,.07);background:#fafbff;display:flex;align-items:center;gap:10px}
.us-card-head h5{font-size:.92rem;font-weight:700;color:#1a237e;margin:0;flex:1}
/* Search */
.us-srch-wrap{position:relative;width:210px}
.us-srch-wrap i{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:.8rem;pointer-events:none}
.us-srch{width:100%;padding:7px 10px 7px 28px;background:#f4f7fc;border:1.5px solid rgba(26,35,126,.09);border-radius:8px;font-family:'Kantumruy Pro','Outfit',sans-serif;font-size:.82rem;color:#111827}
.us-srch:focus{outline:none;border-color:#1a237e}
/* Table */
table.us-tbl{width:100%;border-collapse:collapse;font-size:.84rem}
table.us-tbl thead tr{background:linear-gradient(135deg,#1a237e,#283593);color:#fff}
table.us-tbl th{padding:11px 14px;font-size:.7rem;font-weight:700;letter-spacing:.07em;text-transform:uppercase;text-align:left;border:none}
table.us-tbl tbody tr{border-bottom:1px solid rgba(26,35,126,.05);transition:background .12s}
table.us-tbl tbody tr:last-child{border-bottom:none}
table.us-tbl tbody tr:hover{background:#f8faff}
table.us-tbl td{padding:11px 14px;color:#374151;vertical-align:middle}
table.us-tbl tr.hidden-row{display:none}
/* Avatar */
.us-avatar{width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.82rem;color:#fff;flex-shrink:0}
.us-name-cell{display:flex;align-items:center;gap:10px}
.us-name-cell .name{font-weight:700;color:#1a237e}
.us-name-cell .email{font-size:.72rem;color:#6b7280}
/* Badges */
.role-badge{display:inline-flex;align-items:center;gap:4px;font-size:.67rem;font-weight:700;padding:3px 10px;border-radius:20px}
.role-admin{background:#e8eaf6;color:#1a237e}
.role-user{background:#e0f2f1;color:#00695c}
.me-badge{background:#fff3e0;color:#e65100;font-size:.62rem;font-weight:700;padding:2px 7px;border-radius:20px;margin-left:4px}
/* Action buttons */
.us-act{width:30px;height:30px;border-radius:8px;border:1px solid rgba(26,35,126,.1);background:#f8faff;display:inline-flex;align-items:center;justify-content:center;font-size:.78rem;cursor:pointer;text-decoration:none;color:#374151;transition:all .15s}
.us-act:hover{background:#ffebee;color:#c62828;border-color:#ef9a9a}
.del-form{display:none}

/* ═══ MODAL ═══ */
.modal-bg{position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:9999;display:none;align-items:center;justify-content:center;padding:1rem;backdrop-filter:blur(3px)}
.modal-bg.open{display:flex}
.modal-box{background:#fff;border-radius:20px;width:100%;max-width:500px;box-shadow:0 20px 60px rgba(0,0,0,.2);animation:mIn .28s cubic-bezier(.22,1,.36,1) both}
@keyframes mIn{from{opacity:0;transform:translateY(20px) scale(.97)}to{opacity:1;transform:none}}
.modal-head{padding:1.25rem 1.5rem;border-bottom:1px solid rgba(26,35,126,.08);display:flex;align-items:center;gap:10px}
.modal-head h4{font-size:1rem;font-weight:700;color:#1a237e;margin:0;flex:1}
.modal-close{width:30px;height:30px;border:none;background:#f4f7fc;border-radius:8px;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#6b7280;font-size:.85rem;transition:background .15s}
.modal-close:hover{background:#ffebee;color:#c62828}
.modal-body{padding:1.5rem}
.modal-foot{padding:1rem 1.5rem;border-top:1px solid rgba(26,35,126,.07);display:flex;gap:.75rem;justify-content:flex-end}
/* Modal fields */
.mf{display:flex;flex-direction:column;gap:5px;margin-bottom:1rem}
.mf label{font-size:.7rem;font-weight:800;color:#374151;letter-spacing:.09em;text-transform:uppercase}
.iw{position:relative}
.iw .fi{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:.82rem;pointer-events:none;transition:color .18s}
.iw:focus-within .fi{color:#1a237e}
.m-input,.m-select{width:100%;padding:10px 12px 10px 34px;background:#f8faff;border:1.5px solid rgba(26,35,126,.1);border-radius:10px;font-family:'Kantumruy Pro','Outfit',sans-serif;font-size:.875rem;color:#111827;transition:border-color .2s}
.m-input::placeholder{color:#9ca3af}
.m-input:focus,.m-select:focus{outline:none;border-color:#1a237e;box-shadow:0 0 0 3px rgba(26,35,126,.1);background:#fff}
.m-input.is-invalid{border-color:#e11d48}
.m-err{font-size:.7rem;color:#e11d48;margin-top:3px}
/* Str bar */
.str-bar{height:4px;background:rgba(26,35,126,.08);border-radius:4px;overflow:hidden;margin-top:5px}
.str-fill{height:100%;border-radius:4px;width:0;transition:width .3s,background .3s}
.str-lbl{font-size:.68rem;margin-top:3px}
/* Buttons */
.btn-save{display:inline-flex;align-items:center;gap:7px;background:linear-gradient(135deg,#1a237e,#3949ab);color:#fff;border:none;border-radius:10px;padding:10px 22px;font-family:'Kantumruy Pro','Outfit',sans-serif;font-size:.875rem;font-weight:700;cursor:pointer;box-shadow:0 5px 18px rgba(26,35,126,.25);transition:opacity .15s}
.btn-save:hover{opacity:.9}
.btn-cancel{display:inline-flex;align-items:center;gap:6px;background:#f4f7fc;border:1.5px solid rgba(26,35,126,.12);border-radius:10px;padding:9px 18px;font-family:'Kantumruy Pro','Outfit',sans-serif;font-size:.875rem;font-weight:600;color:#374151;cursor:pointer;transition:background .15s}
.btn-cancel:hover{background:#e8eaf6}
/* Empty */
.us-empty{text-align:center;padding:3rem;color:#9ca3af}
</style>

<div class="us-wrap">

@if(session('success'))
<div class="us-alert alert-ok"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="us-alert alert-err"><i class="fas fa-times-circle"></i> {{ session('error') }}</div>
@endif

{{-- Header --}}
<div class="us-header">
    <div class="us-header-left">
        <div class="us-icon"><i class="fas fa-users-cog"></i></div>
        <div>
            <div class="us-bread"><a href="/">Home</a> / Users</div>
            <h1 class="us-title">គ្រប់គ្រង​ Users</h1>
            <div class="us-sub">Manage all registered accounts</div>
        </div>
    </div>
    <button class="btn-add" onclick="openModal()">
        <i class="fas fa-user-plus"></i> Add User
    </button>
</div>

{{-- Stats --}}
<div class="us-stats">
    <div class="us-stat" style="--c:#1a237e">
        <div class="num">{{ count($users) }}</div>
        <div class="lbl">👤 Users​ សរុប</div>
    </div>
    <div class="us-stat" style="--c:#059669">
        <div class="num">{{ $users->where('email_verified_at','!=',null)->count() }}</div>
        <div class="lbl">✅ Verified</div>
    </div>
    <div class="us-stat" style="--c:#e65100">
        <div class="num">{{ $users->whereNull('email_verified_at')->count() }}</div>
        <div class="lbl">⏳ Unverified</div>
    </div>
</div>

{{-- Table --}}
<div class="us-card">
    <div class="us-card-head">
        <i class="fas fa-list" style="color:#1a237e"></i>
        <h5>តារាង​ Users</h5>
        <div class="us-srch-wrap">
            <i class="fas fa-search"></i>
            <input type="text" class="us-srch" id="usSearch" placeholder="ស្វែងរក..." oninput="usFilter()"/>
        </div>
    </div>
    <div style="overflow-x:auto">
        <table class="us-tbl">
            <thead>
                <tr>
                    <th style="width:36px">#</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Verified</th>
                    <th>បង្កើត</th>
                    <th style="width:80px">សកម្មភាព</th>
                </tr>
            </thead>
            <tbody id="usBody">
                @php $colors=['#1a237e','#1565c0','#00695c','#6a1b9a','#e65100','#c62828']; @endphp
                @forelse($users as $i => $u)
                @php $bg=$colors[$i%count($colors)]; $isMe=Auth::id()===$u->id; @endphp
                <tr data-name="{{ strtolower($u->name.' '.$u->email) }}">
                    <td style="color:#9ca3af;font-size:.78rem">{{ $i+1 }}</td>
                    <td>
                        <div class="us-name-cell">
                            <div class="us-avatar" style="background:{{ $bg }}">{{ mb_substr($u->name,0,1,'UTF-8') }}</div>
                            <div>
                                <div class="name">
                                    {{ $u->name }}
                                    @if($isMe)<span class="me-badge">You</span>@endif
                                </div>
                                <div class="email">{{ $u->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="role-badge {{ $u->role==='admin' ? 'role-admin' : 'role-user' }}">
                            {{ $u->role==='admin' ? '👑 Admin' : '👤 User' }}
                        </span>
                    </td>
                    <td>
                        @if($u->email_verified_at)
                            <span style="color:#059669;font-size:.75rem;font-weight:700">✅ Verified</span>
                        @else
                            <span style="color:#9ca3af;font-size:.75rem">⏳ Pending</span>
                        @endif
                    </td>
                    <td style="font-size:.78rem;color:#6b7280">
                        {{ $u->created_at?->format('d/m/Y') ?? '—' }}
                    </td>
                    <td>
                        @if(!$isMe)
                        <button class="us-act"
                            title="លុប"
                            onclick="confirmDelete('{{ addslashes($u->name) }}', '{{ $u->id }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                        <form id="del_{{ $u->id }}" class="del-form"
                              action="{{ route('users.destroy', $u->id) }}" method="POST">
                            @csrf @method('DELETE')
                        </form>
                        @else
                        <span style="font-size:.7rem;color:#9ca3af">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="us-empty">📭 មិន​ ទាន់​ មាន User</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</div>{{-- /.us-wrap --}}


{{-- ═══════════════ ADD USER MODAL ═══════════════ --}}
<div class="modal-bg" id="addModal" onclick="handleOverlay(event)">
    <div class="modal-box">
        <div class="modal-head">
            <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#1a237e,#3949ab);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.95rem">
                <i class="fas fa-user-plus"></i>
            </div>
            <h4>Add User​ ថ្មី</h4>
            <button class="modal-close" onclick="closeModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('users.store') }}" id="addForm">
            @csrf
            <div class="modal-body">

                {{-- Name --}}
                <div class="mf">
                    <label>ឈ្មោះ *</label>
                    <div class="iw">
                        <i class="fas fa-user fi"></i>
                        <input type="text" name="name" class="m-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                               value="{{ old('name') }}" placeholder="ឈ្មោះ​ ពេញ" required/>
                    </div>
                    @error('name')<div class="m-err">{{ $message }}</div>@enderror
                </div>

                {{-- Email --}}
                <div class="mf">
                    <label>Email *</label>
                    <div class="iw">
                        <i class="fas fa-envelope fi"></i>
                        <input type="email" name="email" class="m-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                               value="{{ old('email') }}" placeholder="user@email.com" required/>
                    </div>
                    @error('email')<div class="m-err">{{ $message }}</div>@enderror
                </div>

                {{-- Role --}}
                <div class="mf">
                    <label>Role</label>
                    <div class="iw">
                        <i class="fas fa-shield-alt fi"></i>
                        <select name="role" class="m-select">
                            <option value="user" {{ old('role')=='user'?'selected':'' }}>👤 User</option>
                            <option value="admin" {{ old('role')=='admin'?'selected':'' }}>👑 Admin</option>
                        </select>
                    </div>
                </div>

                {{-- Password --}}
                <div class="mf">
                    <label>Password *</label>
                    <div class="iw">
                        <i class="fas fa-lock fi"></i>
                        <input type="password" name="password" id="mPw" class="m-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                               placeholder="Min. 8 characters" required oninput="pwStr(this.value)"/>
                    </div>
                    <div class="str-bar"><div class="str-fill" id="strFill"></div></div>
                    <div class="str-lbl" id="strLbl" style="color:#9ca3af"></div>
                    @error('password')<div class="m-err">{{ $message }}</div>@enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mf" style="margin-bottom:0">
                    <label>Confirm Password *</label>
                    <div class="iw">
                        <i class="fas fa-lock fi"></i>
                        <input type="password" name="password_confirmation" class="m-input"
                               placeholder="Repeat password" required/>
                    </div>
                </div>

            </div>
            <div class="modal-foot">
                <button type="button" class="btn-cancel" onclick="closeModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn-save">
                    <i class="fas fa-user-plus"></i> Add User
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ═══ Delete confirm modal ═══ --}}
<div class="modal-bg" id="delModal" onclick="handleDelOverlay(event)">
    <div class="modal-box" style="max-width:400px">
        <div class="modal-head">
            <div style="width:36px;height:36px;border-radius:10px;background:#ffebee;color:#c62828;display:flex;align-items:center;justify-content:center;font-size:.95rem">
                <i class="fas fa-trash"></i>
            </div>
            <h4 style="color:#c62828">លុប User</h4>
            <button class="modal-close" onclick="closeDelModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body" style="padding:1.5rem">
            <p style="font-size:.9rem;color:#374151;margin:0">
                អ្នក​ ប្រាកដ​ ចង់​ លុប User <b id="delName" style="color:#c62828"></b> មែន​ ទេ?
            </p>
            <p style="font-size:.78rem;color:#9ca3af;margin-top:.5rem">
                ⚠️ Action​ នេះ​ មិន​ អាច​ undo​ បាន
            </p>
        </div>
        <div class="modal-foot">
            <button type="button" class="btn-cancel" onclick="closeDelModal()">
                <i class="fas fa-times"></i> Cancel
            </button>
            <button type="button" class="btn-save" id="delConfirmBtn"
                    style="background:linear-gradient(135deg,#c62828,#e53935);box-shadow:0 5px 18px rgba(198,40,40,.25)">
                <i class="fas fa-trash"></i> លុប
            </button>
        </div>
    </div>
</div>

<script>
/* ── Modal open/close ── */
function openModal(){
    document.getElementById('addModal').classList.add('open');
    document.body.style.overflow='hidden';
}
function closeModal(){
    document.getElementById('addModal').classList.remove('open');
    document.body.style.overflow='';
}
function handleOverlay(e){
    if(e.target===document.getElementById('addModal')) closeModal();
}

/* ── Delete modal ── */
let pendingDelId = null;
function confirmDelete(name, id){
    pendingDelId = id;
    document.getElementById('delName').textContent = '"' + name + '"';
    document.getElementById('delConfirmBtn').onclick = () => {
        document.getElementById('del_' + id).submit();
    };
    document.getElementById('delModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeDelModal(){
    document.getElementById('delModal').classList.remove('open');
    document.body.style.overflow = '';
}
function handleDelOverlay(e){
    if(e.target===document.getElementById('delModal')) closeDelModal();
}

/* ── Password strength ── */
function pwStr(v){
    const f=document.getElementById('strFill'),l=document.getElementById('strLbl');
    if(!v){f.style.width='0';l.textContent='';return;}
    let s=0;
    if(v.length>=8)s++; if(v.length>=12)s++;
    if(/[A-Z]/.test(v))s++; if(/[0-9]/.test(v))s++;
    if(/[^A-Za-z0-9]/.test(v))s++;
    const lv=[{w:'16%',bg:'#f87171',t:'Very weak'},{w:'32%',bg:'#fb923c',t:'Weak'},{w:'55%',bg:'#fbbf24',t:'Fair'},{w:'78%',bg:'#34d399',t:'Strong'},{w:'100%',bg:'#22d3ee',t:'Very strong'}][Math.min(s,4)];
    f.style.width=lv.w; f.style.background=lv.bg;
    l.textContent=lv.t; l.style.color=lv.bg;
}

/* ── Search filter ── */
function usFilter(){
    const q=document.getElementById('usSearch').value.toLowerCase().trim();
    document.querySelectorAll('#usBody tr[data-name]').forEach(r=>{
        r.classList.toggle('hidden-row', q && !r.dataset.name.includes(q));
    });
}

/* ── Auto-open modal if validation errors ── */
@if($errors->any())
    window.addEventListener('DOMContentLoaded', () => openModal());
@endif
</script>
@endsection