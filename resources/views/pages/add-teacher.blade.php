@extends('layouts.master')

@section('title', 'បន្ថែមគ្រូ - Add Teacher')

@section('content')
<style>
    .at-wrap { max-width: 700px; margin: 0 auto; padding: 2.5rem 2rem 4rem; }

    .at-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(26,35,126,0.08); }
    .at-header-left { display: flex; align-items: center; gap: 14px; }
    .at-icon  { width: 52px; height: 52px; border-radius: 16px; background: linear-gradient(135deg,#1a237e,#3949ab); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; box-shadow: 0 6px 18px rgba(26,35,126,0.25); }
    .at-title { font-size: 1.5rem; font-weight: 700; color: #1a237e; margin: 0; }
    .at-sub   { font-size: 0.8rem; color: #6b7280; margin-top: 2px; }
    .at-bread { font-size: 0.78rem; color: #9ca3af; margin-bottom: 4px; }
    .at-bread a { color: #3949ab; text-decoration: none; }

    .at-card { background: #fff; border-radius: 18px; border: 1px solid rgba(26,35,126,0.07); box-shadow: 0 4px 24px rgba(26,35,126,0.06); overflow: hidden; margin-bottom: 1.25rem; }
    .at-card-head { padding: 1.1rem 1.5rem; border-bottom: 1px solid rgba(26,35,126,0.07); display: flex; align-items: center; gap: 10px; background: #fafbff; }
    .at-card-head h5 { font-size: 0.95rem; font-weight: 700; color: #1a237e; margin: 0; }
    .step-b { width: 26px; height: 26px; border-radius: 50%; background: #1a237e; color: #fff; font-size: 0.72rem; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .at-card-body { padding: 1.5rem; }

    .at-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    @media(max-width:560px){ .at-row-2 { grid-template-columns: 1fr; } }

    .at-field { display: flex; flex-direction: column; gap: 5px; margin-bottom: 1rem; }
    .at-field:last-child { margin-bottom: 0; }
    .at-field label { font-size: 0.75rem; font-weight: 700; color: #374151; letter-spacing: 0.06em; text-transform: uppercase; display: flex; align-items: center; gap: 5px; }
    .at-field label .req  { color: #e11d48; }
    .at-field label .hint { font-size: 0.65rem; font-weight: 400; color: #9ca3af; text-transform: none; letter-spacing: 0; }

    .at-input, .at-select, .at-textarea {
        padding: 10px 13px; background: #f8faff;
        border: 1.5px solid rgba(26,35,126,0.1); border-radius: 10px;
        font-family: 'Kantumruy Pro','Outfit',sans-serif; font-size: 0.875rem; color: #111827;
        transition: border-color 0.2s, box-shadow 0.2s; width: 100%;
    }
    .at-input::placeholder, .at-textarea::placeholder { color: #9ca3af; }
    .at-input:focus, .at-select:focus, .at-textarea:focus { outline: none; border-color: #1a237e; box-shadow: 0 0 0 3px rgba(26,35,126,0.1); background: #fff; }
    .at-input.is-invalid, .at-select.is-invalid, .at-textarea.is-invalid { border-color: #e11d48; }
    .at-textarea { resize: vertical; min-height: 80px; }

    .iw { position: relative; }
    .iw .fi { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.85rem; pointer-events: none; }
    .iw:focus-within .fi { color: #1a237e; }
    .iw .at-input, .iw .at-select { padding-left: 34px; }

    .at-err { font-size: 0.72rem; color: #e11d48; margin-top: 3px; }

    .at-submit-row { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .btn-submit { display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg,#1a237e,#3949ab); color: #fff; border: none; border-radius: 12px; padding: 12px 28px; font-family: 'Kantumruy Pro','Outfit',sans-serif; font-size: 0.9rem; font-weight: 700; cursor: pointer; box-shadow: 0 6px 20px rgba(26,35,126,0.3); transition: opacity 0.15s, transform 0.12s; }
    .btn-submit:hover { opacity: 0.9; transform: translateY(-1px); }
    .btn-back { display: inline-flex; align-items: center; gap: 7px; background: transparent; color: #374151; border: 1.5px solid rgba(26,35,126,0.1); border-radius: 12px; padding: 11px 20px; font-family: 'Kantumruy Pro','Outfit',sans-serif; font-size: 0.875rem; font-weight: 600; text-decoration: none; transition: all 0.15s; }
    .btn-back:hover { border-color: #1a237e; color: #1a237e; background: #e8eaf6; }

    .at-alert-err { padding: 0.9rem 1.25rem; border-radius: 12px; font-size: 0.87rem; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }
</style>

<div class="at-wrap">

    @if($errors->any())
        <div class="at-alert-err">
            <i class="fas fa-exclamation-triangle"></i>
            មានបញ្ហា {{ $errors->count() }} ចំណុច — សូមពិនិត្យម្ដងទៀត
        </div>
    @endif

    {{-- Header --}}
    <div class="at-header">
        <div class="at-header-left">
            <div class="at-icon"><i class="fas fa-user-plus"></i></div>
            <div>
                <div class="at-bread">
                    <a href="/">Home</a> /
                    <a href="{{ route('teachers.index') }}">Teachers</a> /
                    <span>Add Teacher</span>
                </div>
                <h1 class="at-title">បន្ថែមគ្រូថ្មី</h1>
                <div class="at-sub">Add a new teacher to the school system</div>
            </div>
        </div>
        <a href="{{ route('teachers.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> ត្រឡប់ក្រោយ
        </a>
    </div>

    <form action="{{ route('teachers.store') }}" method="POST">
        @csrf

        <div class="at-card">
            <div class="at-card-head">
                <div class="step-b">1</div>
                <h5>ព័ត៌មានគ្រូ — Teacher Information</h5>
            </div>
            <div class="at-card-body">

                {{-- Name --}}
                <div class="at-field">
                    <label>ឈ្មោះ <span class="req">*</span> <span class="hint">/ Full Name</span></label>
                    <div class="iw">
                        <i class="fas fa-user fi"></i>
                        <input type="text" name="name"
                            class="at-input @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="e.g. លោក លីហួ"/>
                    </div>
                    @error('name') <div class="at-err">{{ $message }}</div> @enderror
                </div>

                {{-- Email + Phone --}}
                <div class="at-row-2">
                    <div class="at-field">
                        <label>Email <span class="req">*</span></label>
                        <div class="iw">
                            <i class="fas fa-envelope fi"></i>
                            <input type="email" name="email"
                                class="at-input @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="teacher@school.edu"/>
                        </div>
                        @error('email') <div class="at-err">{{ $message }}</div> @enderror
                    </div>
                    <div class="at-field">
                        <label>ទូរស័ព្ទ <span class="req">*</span> <span class="hint">/ Phone</span></label>
                        <div class="iw">
                            <i class="fas fa-phone fi"></i>
                            <input type="text" name="phone"
                                class="at-input @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}"
                                placeholder="e.g. 012 345 678"/>
                        </div>
                        @error('phone') <div class="at-err">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Subject --}}
                <div class="at-field">
                    <label>មុខវិជ្ជា <span class="req">*</span> <span class="hint">/ Subject</span></label>
                    <div class="iw">
                        <i class="fas fa-book-open fi"></i>
                        <select name="subject"
                            class="at-select @error('subject') is-invalid @enderror">
                            <option value="">-- ជ្រើសមុខវិជ្ជា --</option>
                            @foreach([
                                'Web Development','Database','Networking',
                                'UI/UX Design','Graphic Design','Cybersecurity',
                                'AI & ML','Mobile App','IT Support',
                                'Digital Marketing','Algorithm','OS Concepts',
                                'Mathematics','English','Khmer','Physics','Chemistry'
                            ] as $sub)
                                <option value="{{ $sub }}" {{ old('subject') == $sub ? 'selected':'' }}>
                                    {{ $sub }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('subject') <div class="at-err">{{ $message }}</div> @enderror
                </div>

                {{-- Age + Gender --}}
                <div class="at-row-2">
                    <div class="at-field">
                        <label>អាយុ <span class="req">*</span></label>
                        <input type="number" name="age" class="at-input" value="{{ old('age') }}" placeholder="e.g. 25"/>
                        @error('age') <div class="at-err">{{ $message }}</div> @enderror
                    </div>
                    <div class="at-field">
                        <label>ភេទ <span class="req">*</span></label>
                        <select name="gender" class="at-select">
                            <option value="">-- ជ្រើសភេទ --</option>
                            <option value="Male" {{ old('gender')=='Male'?'selected':'' }}>ប្រុស</option>
                            <option value="Female" {{ old('gender')=='Female'?'selected':'' }}>ស្រី</option>
                        </select>
                        @error('gender') <div class="at-err">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="at-field">
                    <label>ថ្ងៃខែឆ្នាំកំណើត <span class="req">*</span></label>
                    <input type="date" name="date_of_birth" class="at-input" value="{{ old('date_of_birth') }}"/>
                    @error('date_of_birth') <div class="at-err">{{ $message }}</div> @enderror
                </div>
                {{-- Address --}}
                <div class="at-field">
                    <label>អាសយដ្ឋាន <span class="hint">/ Address (optional)</span></label>
                    <div class="iw" style="align-items:flex-start;">
                        <i class="fas fa-map-marker-alt fi" style="top:14px;transform:none;"></i>
                        <textarea name="address"
                            class="at-textarea @error('address') is-invalid @enderror"
                            style="padding-left:34px;"
                            placeholder="e.g. ភ្នំពេញ, កម្ពុជា">{{ old('address') }}</textarea>
                    </div>
                    @error('address') <div class="at-err">{{ $message }}</div> @enderror
                </div>

            </div>
        </div>

        {{-- Submit --}}
        <div class="at-submit-row">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> រក្សាទុកគ្រូ
            </button>
            <a href="{{ route('teachers.index') }}" class="btn-back">
                <i class="fas fa-times"></i> លុបចោល
            </a>
        </div>

    </form>
</div>

@endsection