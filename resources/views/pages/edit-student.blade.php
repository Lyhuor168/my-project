 @extends('layouts.master')

@section('title', 'កែប្រែសិស្ស - Edit Student')

@section('content')
<style>
    .as-wrap { max-width: 700px; margin: 0 auto; padding: 2.5rem 2rem 4rem; }

    .as-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(26,35,126,0.08); }
    .as-header-left { display: flex; align-items: center; gap: 14px; }
    .as-icon  { width: 52px; height: 52px; border-radius: 16px; background: linear-gradient(135deg,#e65100,#f57c00); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; box-shadow: 0 6px 18px rgba(230,81,0,0.25); }
    .as-title { font-size: 1.5rem; font-weight: 700; color: #1a237e; margin: 0; }
    .as-sub   { font-size: 0.8rem; color: #6b7280; margin-top: 2px; }
    .as-bread { font-size: 0.78rem; color: #9ca3af; margin-bottom: 4px; }
    .as-bread a { color: #3949ab; text-decoration: none; }

    .as-card { background: #fff; border-radius: 18px; border: 1px solid rgba(26,35,126,0.07); box-shadow: 0 4px 24px rgba(26,35,126,0.06); overflow: hidden; margin-bottom: 1.25rem; }
    .as-card-head { padding: 1.1rem 1.5rem; border-bottom: 1px solid rgba(26,35,126,0.07); display: flex; align-items: center; gap: 10px; background: #fafbff; }
    .as-card-head h5 { font-size: 0.95rem; font-weight: 700; color: #1a237e; margin: 0; }
    .step-b { width: 26px; height: 26px; border-radius: 50%; background: #e65100; color: #fff; font-size: 0.72rem; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .as-card-body { padding: 1.5rem; }

    .as-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    @media(max-width:560px){ .as-row-2 { grid-template-columns: 1fr; } }

    .as-field { display: flex; flex-direction: column; gap: 5px; margin-bottom: 1rem; }
    .as-field:last-child { margin-bottom: 0; }
    .as-field label { font-size: 0.75rem; font-weight: 700; color: #374151; letter-spacing: 0.06em; text-transform: uppercase; display: flex; align-items: center; gap: 5px; }
    .as-field label .req  { color: #e11d48; }
    .as-field label .hint { font-size: 0.65rem; font-weight: 400; color: #9ca3af; text-transform: none; letter-spacing: 0; }

    .as-input, .as-select {
        padding: 10px 13px; background: #f8faff;
        border: 1.5px solid rgba(26,35,126,0.1); border-radius: 10px;
        font-family: 'Kantumruy Pro','Outfit',sans-serif; font-size: 0.875rem; color: #111827;
        transition: border-color 0.2s, box-shadow 0.2s; width: 100%;
    }
    .as-input:focus, .as-select:focus { outline: none; border-color: #e65100; box-shadow: 0 0 0 3px rgba(230,81,0,0.1); background: #fff; }
    .as-input.is-invalid, .as-select.is-invalid { border-color: #e11d48; }

    .iw { position: relative; }
    .iw .fi { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.85rem; pointer-events: none; }
    .iw:focus-within .fi { color: #e65100; }
    .iw .as-input, .iw .as-select { padding-left: 34px; }

    .as-err { font-size: 0.72rem; color: #e11d48; margin-top: 3px; }

    /* Score bar */
    .score-preview { display: flex; align-items: center; gap: 10px; margin-top: 6px; }
    .score-bar-wrap { flex: 1; height: 8px; background: #e8eaf6; border-radius: 4px; overflow: hidden; }
    .score-bar-fill { height: 100%; border-radius: 4px; transition: width 0.3s, background 0.3s; }
    .score-lbl { font-size: 0.78rem; font-weight: 700; min-width: 40px; }

    /* Gender radio */
    .gender-row { display: flex; gap: 10px; flex-wrap: wrap; }
    .gender-opt { display: none; }
    .gender-lbl { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: 50px; border: 1.5px solid rgba(26,35,126,0.12); background: #f8faff; font-size: 0.85rem; font-weight: 600; cursor: pointer; color: #374151; transition: all 0.15s; user-select: none; }
    .gender-lbl:hover { border-color: #e65100; color: #e65100; }
    .gender-opt:checked + .gender-lbl { background: #e65100; border-color: #e65100; color: #fff; }

    /* Buttons */
    .as-submit-row { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .btn-update { display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg,#e65100,#f57c00); color: #fff; border: none; border-radius: 12px; padding: 12px 28px; font-family: 'Kantumruy Pro','Outfit',sans-serif; font-size: 0.9rem; font-weight: 700; cursor: pointer; box-shadow: 0 6px 20px rgba(230,81,0,0.3); transition: opacity 0.15s, transform 0.12s; }
    .btn-update:hover { opacity: 0.9; transform: translateY(-1px); }
    .btn-back { display: inline-flex; align-items: center; gap: 7px; background: transparent; color: #374151; border: 1.5px solid rgba(26,35,126,0.1); border-radius: 12px; padding: 11px 20px; font-family: 'Kantumruy Pro','Outfit',sans-serif; font-size: 0.875rem; font-weight: 600; text-decoration: none; transition: all 0.15s; }
    .btn-back:hover { border-color: #1a237e; color: #1a237e; background: #e8eaf6; }

    .as-alert-err { padding: 0.9rem 1.25rem; border-radius: 12px; font-size: 0.87rem; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }

    /* Student info badge */
    .st-id-badge { display: inline-flex; align-items: center; gap: 6px; background: #e8eaf6; color: #1a237e; font-size: 0.75rem; font-weight: 700; padding: 4px 12px; border-radius: 20px; margin-bottom: 1rem; }
</style>

<div class="as-wrap">

    @if($errors->any())
        <div class="as-alert-err">
            <i class="fas fa-exclamation-triangle"></i>
            មានបញ្ហា {{ $errors->count() }} ចំណុច — សូមពិនិត្យម្ដងទៀត
        </div>
    @endif

    {{-- Header --}}
    <div class="as-header">
        <div class="as-header-left">
            <div class="as-icon"><i class="fas fa-user-edit"></i></div>
            <div>
                <div class="as-bread">
                    <a href="/">Home</a> /
                    <a href="{{ route('students.index') }}">Students</a> /
                    <span>Edit</span>
                </div>
                <h1 class="as-title">កែប្រែព័ត៌មានសិស្ស</h1>
                <div class="as-sub">Edit student: <strong>{{ $student->name }}</strong></div>
            </div>
        </div>
        <a href="{{ route('students.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> ត្រឡប់ក្រោយ
        </a>
    </div>

    {{-- Student ID badge --}}
    <div class="st-id-badge">
        <i class="fas fa-id-card"></i> Student ID: #{{ $student->id }}
    </div>

    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Personal Info --}}
        <div class="as-card">
            <div class="as-card-head">
                <div class="step-b">1</div>
                <h5>ព័ត៌មានផ្ទាល់ខ្លួន — Personal Info</h5>
            </div>
            <div class="as-card-body">

                {{-- Name --}}
                <div class="as-field">
                    <label>ឈ្មោះ <span class="req">*</span> <span class="hint">/ Full Name</span></label>
                    <div class="iw">
                        <i class="fas fa-user fi"></i>
                        <input type="text" name="name"
                            class="as-input @error('name') is-invalid @enderror"
                            value="{{ old('name', $student->name) }}"
                            placeholder="ឈ្មោះ​សិស្ស"/>
                    </div>
                    @error('name') <div class="as-err">{{ $message }}</div> @enderror
                </div>

                {{-- Email --}}
                <div class="as-field">
                    <label>Email <span class="req">*</span></label>
                    <div class="iw">
                        <i class="fas fa-envelope fi"></i>
                        <input type="email" name="email"
                            class="as-input @error('email') is-invalid @enderror"
                            value="{{ old('email', $student->email) }}"
                            placeholder="example@school.edu"/>
                    </div>
                    @error('email') <div class="as-err">{{ $message }}</div> @enderror
                </div>

                {{-- Age + DOB --}}
                <div class="as-row-2">
                    <div class="as-field">
                        <label>អាយុ <span class="req">*</span> <span class="hint">/ Age</span></label>
                        <div class="iw">
                            <i class="fas fa-birthday-cake fi"></i>
                            <input type="number" name="age"
                                class="as-input @error('age') is-invalid @enderror"
                                value="{{ old('age', $student->age) }}"
                                min="5" max="100"/>
                        </div>
                        @error('age') <div class="as-err">{{ $message }}</div> @enderror
                    </div>
                    <div class="as-field">
                        <label>ថ្ងៃខែឆ្នាំ <span class="req">*</span></label>
                        <div class="iw">
                            <i class="fas fa-calendar fi"></i>
                            <input type="date" name="date_of_birth"
                                class="as-input @error('date_of_birth') is-invalid @enderror"
                                value="{{ old('date_of_birth', \Carbon\Carbon::parse($student->date_of_birth)->format('Y-m-d')) }}"/>
                        </div>
                        @error('date_of_birth') <div class="as-err">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Gender --}}
                <div class="as-field">
                    <label>ភេទ <span class="req">*</span> <span class="hint">/ Gender</span></label>
                    <div class="gender-row">
                        @php $currentGender = old('gender', $student->gender); @endphp

                        <input type="radio" name="gender" id="g_male"   class="gender-opt" value="male"
                            {{ $currentGender == 'male'   ? 'checked' : '' }}>
                        <label for="g_male"   class="gender-lbl">👦 ប្រុស</label>

                        <input type="radio" name="gender" id="g_female" class="gender-opt" value="female"
                            {{ $currentGender == 'female' ? 'checked' : '' }}>
                        <label for="g_female" class="gender-lbl">👧 ស្រី</label>

                        <input type="radio" name="gender" id="g_other"  class="gender-opt" value="other"
                            {{ $currentGender == 'other'  ? 'checked' : '' }}>
                        <label for="g_other"  class="gender-lbl">⚧ Other</label>
                    </div>
                    @error('gender') <div class="as-err">{{ $message }}</div> @enderror
                </div>

            </div>
        </div>

        {{-- Score --}}
        <div class="as-card">
            <div class="as-card-head">
                <div class="step-b">2</div>
                <h5>ពិន្ទុ — Score</h5>
            </div>
            <div class="as-card-body">
                <div class="as-field">
                    <label>ពិន្ទុ <span class="req">*</span> <span class="hint">/ Score (0–100)</span></label>
                    <div class="iw">
                        <i class="fas fa-star fi"></i>
                        <input type="number" name="score" id="scoreInput"
                            class="as-input @error('score') is-invalid @enderror"
                            value="{{ old('score', $student->score) }}"
                            min="0" max="100" step="0.01"
                            oninput="updateScore(this.value)"/>
                    </div>
                    @error('score') <div class="as-err">{{ $message }}</div> @enderror
                    <div class="score-preview">
                        <div class="score-bar-wrap">
                            <div class="score-bar-fill" id="scoreBar"
                                 style="width:{{ old('score',$student->score) }}%;
                                        background:{{ $student->score >= 80 ? '#059669' : ($student->score >= 50 ? '#d97706' : '#dc2626') }};"></div>
                        </div>
                        <span class="score-lbl" id="scoreLabel"
                              style="color:{{ $student->score >= 80 ? '#059669' : ($student->score >= 50 ? '#d97706' : '#dc2626') }};">
                            {{ old('score',$student->score) }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="as-submit-row">
            <button type="submit" class="btn-update">
                <i class="fas fa-save"></i> រក្សាទុកការកែប្រែ
            </button>
            <a href="{{ route('students.index') }}" class="btn-back">
                <i class="fas fa-times"></i> លុបចោល
            </a>
        </div>

    </form>
</div>

<script>
    function updateScore(v) {
        const bar   = document.getElementById('scoreBar');
        const label = document.getElementById('scoreLabel');
        const val   = Math.min(100, Math.max(0, parseFloat(v) || 0));
        bar.style.width = val + '%';
        label.textContent = val + '%';
        if      (val >= 80) { bar.style.background = '#059669'; label.style.color = '#059669'; }
        else if (val >= 50) { bar.style.background = '#d97706'; label.style.color = '#d97706'; }
        else                { bar.style.background = '#dc2626'; label.style.color = '#dc2626'; }
    }
</script>

@endsection 