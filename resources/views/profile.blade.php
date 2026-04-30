@extends('layouts.master')
@section('title', 'Profile')

@section('content')
<style>
    .pf-wrap { max-width: 900px; margin: 0 auto; padding: 2.5rem 2rem 4rem; }
    .pf-header { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; margin-bottom:2rem; padding-bottom:1.25rem; border-bottom:1px solid rgba(26,35,126,0.08); }
    .pf-title  { font-size:1.5rem; font-weight:700; color:#1a237e; margin:0; }
    .pf-bread  { font-size:0.78rem; color:#9ca3af; margin-bottom:4px; }
    .pf-bread a { color:#3949ab; text-decoration:none; }

    /* Alert */
    .pf-alert { padding:0.9rem 1.25rem; border-radius:12px; font-size:0.87rem; font-weight:600; margin-bottom:1.5rem; display:flex; align-items:center; gap:10px; }
    .pf-ok  { background:#e8f5e9; color:#2e7d32; border:1px solid #a5d6a7; }
    .pf-err { background:#ffebee; color:#c62828; border:1px solid #ef9a9a; }

    /* Grid */
    .pf-grid { display:grid; grid-template-columns:280px 1fr; gap:1.75rem; align-items:start; }
    @media(max-width:780px){ .pf-grid { grid-template-columns:1fr; } }

    /* Card */
    .pf-card { background:#fff; border-radius:18px; border:1px solid rgba(26,35,126,0.07); box-shadow:0 4px 20px rgba(26,35,126,0.06); overflow:hidden; margin-bottom:1.25rem; }
    .pf-card-head { padding:1rem 1.5rem; border-bottom:1px solid rgba(26,35,126,0.07); background:#fafbff; display:flex; align-items:center; gap:9px; }
    .pf-card-head h5 { font-size:0.92rem; font-weight:700; color:#1a237e; margin:0; }
    .pf-card-body { padding:1.5rem; }

    /* Avatar card */
    .pf-avatar-card { text-align:center; }
    .pf-avatar-ring { width:110px; height:110px; border-radius:50%; margin:0 auto 1rem; position:relative; display:flex; align-items:center; justify-content:center; font-size:2.8rem; font-weight:700; color:#fff; background:linear-gradient(135deg,#1a237e,#3949ab); box-shadow:0 8px 28px rgba(26,35,126,0.28); overflow:hidden; }
    .pf-avatar-ring img { width:100%; height:100%; object-fit:cover; position:absolute; inset:0; }
    .pf-avatar-name  { font-size:1.1rem; font-weight:700; color:#1a237e; margin-bottom:4px; }
    .pf-avatar-email { font-size:0.78rem; color:#6b7280; margin-bottom:1rem; }
    .pf-badge { display:inline-flex; align-items:center; gap:5px; background:#e8eaf6; color:#1a237e; font-size:0.72rem; font-weight:700; padding:4px 12px; border-radius:20px; margin-bottom:1.25rem; }

    /* Photo upload */
    .pf-photo-zone { border:2px dashed rgba(26,35,126,0.18); border-radius:12px; padding:1rem; cursor:pointer; transition:border-color 0.18s; text-align:center; }
    .pf-photo-zone:hover { border-color:#1a237e; }
    .pf-photo-zone input { display:none; }
    .pf-photo-zone p { font-size:0.75rem; color:#9ca3af; margin:6px 0 0; }

    /* Fields */
    .pf-field { display:flex; flex-direction:column; gap:5px; margin-bottom:1rem; }
    .pf-field label { font-size:0.72rem; font-weight:800; color:#374151; letter-spacing:0.09em; text-transform:uppercase; }
    .iw2 { position:relative; }
    .iw2 .fi { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#9ca3af; font-size:0.85rem; pointer-events:none; }
    .iw2:focus-within .fi { color:#1a237e; }
    .pf-input { width:100%; padding:10px 13px 10px 36px; background:#f8faff; border:1.5px solid rgba(26,35,126,0.1); border-radius:10px; font-family:'Kantumruy Pro','Outfit',sans-serif; font-size:0.875rem; color:#111827; transition:border-color 0.2s; }
    .pf-input:focus { outline:none; border-color:#1a237e; box-shadow:0 0 0 3px rgba(26,35,126,0.1); background:#fff; }
    .pf-input.err { border-color:#e11d48; }
    .pf-err-msg { font-size:0.7rem; color:#e11d48; margin-top:2px; }

    /* Buttons */
    .pf-btn { display:inline-flex; align-items:center; gap:7px; padding:10px 22px; border:none; border-radius:10px; font-family:'Kantumruy Pro','Outfit',sans-serif; font-size:0.875rem; font-weight:700; cursor:pointer; transition:opacity 0.15s,transform 0.1s; }
    .pf-btn:hover { opacity:0.9; transform:translateY(-1px); }
    .pf-btn-primary { background:linear-gradient(135deg,#1a237e,#3949ab); color:#fff; box-shadow:0 5px 16px rgba(26,35,126,0.25); }
    .pf-btn-danger  { background:transparent; color:#c62828; border:1.5px solid rgba(198,40,40,0.2); }
    .pf-btn-danger:hover { background:#ffebee; border-color:#c62828; }

    /* Info rows */
    .pf-info-row { display:flex; align-items:center; gap:10px; padding:10px 0; border-bottom:1px solid rgba(26,35,126,0.06); font-size:0.83rem; color:#374151; }
    .pf-info-row:last-child { border-bottom:none; }
    .pf-info-row i { width:18px; text-align:center; color:#6b7280; }
    .pf-info-lbl { color:#9ca3af; font-size:0.72rem; font-weight:700; text-transform:uppercase; min-width:70px; }
</style>

<div class="pf-wrap">

    @if(session('success'))
        <div class="pf-alert pf-ok"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="pf-alert pf-err"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first() }}</div>
    @endif

    <div class="pf-header">
        <div>
            <div class="pf-bread"><a href="/">Home</a> / <span>Profile</span></div>
            <h1 class="pf-title">👤 Profile</h1>
        </div>
    </div>

    <div class="pf-grid">

        {{-- ══ LEFT: AVATAR + PHOTO ══ --}}
        <div>
            {{-- Avatar card --}}
            <div class="pf-card pf-avatar-card">
                <div class="pf-card-body">
                    <div class="pf-avatar-ring">
                        @if($user->profile_photo_path)
                            <img src="{{ Storage::url($user->profile_photo_path) }}" alt="photo"/>
                        @else
                            {{ mb_substr($user->name, 0, 1, 'UTF-8') }}
                        @endif
                    </div>
                    <div class="pf-avatar-name">{{ $user->name }}</div>
                    <div class="pf-avatar-email">{{ $user->email }}</div>
                    <div class="pf-badge">
                        <i class="fas fa-check-circle"></i>
                        @if($user->email_verified_at) Verified @else Unverified @endif
                    </div>

                    {{-- Account info --}}
                    <div style="text-align:left;">
                        <div class="pf-info-row">
                            <i class="fas fa-calendar-alt"></i>
                            <span class="pf-info-lbl">Joined</span>
                            <span>{{ $user->created_at ? $user->created_at->format('d/m/Y') : '—' }}</span>
                        </div>
                        <div class="pf-info-row">
                            <i class="fas fa-id-badge"></i>
                            <span class="pf-info-lbl">User ID</span>
                            <span>#{{ $user->id }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Photo upload --}}
            <div class="pf-card">
                <div class="pf-card-head">
                    <i class="fas fa-camera" style="color:#1a237e;"></i>
                    <h5>ផ្លាស់​ ប្ដូរ​ រូប</h5>
                </div>
                <div class="pf-card-body">
                    <form action="{{ route('profile.photo') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="pf-photo-zone" onclick="document.getElementById('photoInput').click()">
                            <i class="fas fa-cloud-upload-alt" style="font-size:1.5rem;color:#9ca3af;"></i>
                            <p>ចុច​ ដើម្បី​ ជ្រើស​ រូប<br><small>JPG, PNG, WEBP · max 2MB</small></p>
                            <input type="file" id="photoInput" name="photo" accept="image/*"
                                onchange="previewPhoto(this)"/>
                        </div>
                        <div id="photoPreview" style="display:none;margin-top:0.75rem;text-align:center;">
                            <img id="previewImg" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid #1a237e;"/>
                        </div>
                        <button type="submit" class="pf-btn pf-btn-primary" style="width:100%;margin-top:0.75rem;justify-content:center;">
                            <i class="fas fa-upload"></i> Upload Photo
                        </button>
                    </form>
                    @if($user->profile_photo_path)
                    <form action="{{ route('profile.photo.delete') }}" method="POST" style="margin-top:0.5rem;">
                        @csrf @method('DELETE')
                        <button type="submit" class="pf-btn pf-btn-danger" style="width:100%;justify-content:center;"
                            onclick="return confirm('លុប​ រូប​ Profile​ មែន​ទេ?')">
                            <i class="fas fa-trash"></i> លុប​ រូប
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- ══ RIGHT: FORMS ══ --}}
        <div>
            {{-- Update Info --}}
            <div class="pf-card">
                <div class="pf-card-head">
                    <i class="fas fa-user-edit" style="color:#1a237e;"></i>
                    <h5>កែ​ ព័ត៌មាន​ Profile</h5>
                </div>
                <div class="pf-card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="pf-field">
                            <label>ឈ្មោះ *</label>
                            <div class="iw2">
                                <i class="fas fa-user fi"></i>
                                <input type="text" name="name" class="pf-input @error('name') err @enderror"
                                    value="{{ old('name', $user->name) }}" placeholder="Full Name"/>
                            </div>
                            @error('name') <div class="pf-err-msg">{{ $message }}</div> @enderror
                        </div>
                        <div class="pf-field">
                            <label>Email *</label>
                            <div class="iw2">
                                <i class="fas fa-envelope fi"></i>
                                <input type="email" name="email" class="pf-input @error('email') err @enderror"
                                    value="{{ old('email', $user->email) }}" placeholder="your@email.com"/>
                            </div>
                            @error('email') <div class="pf-err-msg">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="pf-btn pf-btn-primary">
                            <i class="fas fa-save"></i> រក្សា​ ទុក
                        </button>
                    </form>
                </div>
            </div>

            {{-- Change Password --}}
            <div class="pf-card">
                <div class="pf-card-head">
                    <i class="fas fa-lock" style="color:#1a237e;"></i>
                    <h5>ប្ដូរ​ Password</h5>
                </div>
                <div class="pf-card-body">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="pf-field">
                            <label>Password​ បច្ចុប្បន្ន *</label>
                            <div class="iw2">
                                <i class="fas fa-lock fi"></i>
                                <input type="password" name="current_password"
                                    class="pf-input @error('current_password') err @enderror"
                                    placeholder="Current password"/>
                            </div>
                            @error('current_password') <div class="pf-err-msg">{{ $message }}</div> @enderror
                        </div>
                        <div class="pf-field">
                            <label>Password​ ថ្មី *</label>
                            <div class="iw2">
                                <i class="fas fa-key fi"></i>
                                <input type="password" name="password"
                                    class="pf-input @error('password') err @enderror"
                                    placeholder="New password (min 8)" id="newPw" oninput="pwStr(this.value)"/>
                            </div>
                            <div id="pwBar" style="height:3px;border-radius:3px;background:#e8eaf6;overflow:hidden;margin-top:4px;display:none;">
                                <div id="pwFill" style="height:100%;border-radius:3px;width:0;transition:width .3s,background .3s;"></div>
                            </div>
                            @error('password') <div class="pf-err-msg">{{ $message }}</div> @enderror
                        </div>
                        <div class="pf-field">
                            <label>បញ្ជាក់​ Password​ ថ្មី *</label>
                            <div class="iw2">
                                <i class="fas fa-key fi"></i>
                                <input type="password" name="password_confirmation"
                                    class="pf-input" placeholder="Confirm new password"/>
                            </div>
                        </div>
                        <button type="submit" class="pf-btn pf-btn-primary">
                            <i class="fas fa-shield-alt"></i> ប្ដូរ​ Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const r = new FileReader();
        r.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('photoPreview').style.display = 'block';
        };
        r.readAsDataURL(input.files[0]);
    }
}
function pwStr(v) {
    const bar = document.getElementById('pwBar');
    const fill = document.getElementById('pwFill');
    if (!v) { bar.style.display='none'; return; }
    bar.style.display='block';
    let s=0;
    if(v.length>=8)s++; if(v.length>=12)s++;
    if(/[A-Z]/.test(v))s++; if(/[0-9]/.test(v))s++; if(/[^A-Za-z0-9]/.test(v))s++;
    const lv=[{w:'16%',bg:'#f87171'},{w:'32%',bg:'#fb923c'},{w:'55%',bg:'#fbbf24'},{w:'78%',bg:'#34d399'},{w:'100%',bg:'#22d3ee'}][Math.min(s,4)];
    fill.style.width=lv.w; fill.style.background=lv.bg;
}
</script>
@endsection