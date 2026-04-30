@extends('layouts.master')

@section('title', 'កែប្រែគ្រូ - Edit Teacher')

@section('content')

<style>
    .as-wrap { max-width: 700px; margin: 0 auto; padding: 2.5rem 2rem 4rem; font-family: 'Kantumruy Pro', sans-serif; }
    
    .as-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(26,35,126,0.08); }
    .as-icon { width: 52px; height: 52px; border-radius: 16px; background: linear-gradient(135deg,#e65100,#f57c00); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; box-shadow: 0 6px 18px rgba(230,81,0,0.25); }
    .as-title { font-size: 1.5rem; font-weight: 700; color: #1a237e; margin: 0; }
    .as-bread a { color: #3949ab; text-decoration: none; font-size: 0.8rem; }
    
    .as-card { background: #fff; border-radius: 18px; border: 1px solid rgba(26,35,126,0.07); box-shadow: 0 4px 24px rgba(26,35,126,0.06); overflow: hidden; margin-bottom: 1.25rem; }
    .as-card-head { padding: 1.1rem 1.5rem; border-bottom: 1px solid rgba(26,35,126,0.07); display: flex; align-items: center; gap: 10px; background: #fafbff; }
    .as-card-head h5 { font-size: 0.95rem; font-weight: 700; color: #1a237e; margin: 0; }
    .step-b { width: 26px; height: 26px; border-radius: 50%; background: #e65100; color: #fff; font-size: 0.72rem; font-weight: 800; display: flex; align-items: center; justify-content: center; }
    .as-card-body { padding: 1.5rem; }

    .as-field { margin-bottom: 1.2rem; }
    .as-field label { font-size: 0.8rem; font-weight: 700; color: #374151; display: block; margin-bottom: 6px; }
    .as-input { width: 100%; padding: 12px 15px; background: #f8faff; border: 1.5px solid rgba(26,35,126,0.1); border-radius: 10px; font-size: 0.9rem; transition: 0.2s; }
    .as-input:focus { outline: none; border-color: #e65100; box-shadow: 0 0 0 3px rgba(230,81,0,0.1); background: #fff; }
    .as-input.is-invalid { border-color: #e11d48; }
    .as-err { font-size: 0.75rem; color: #e11d48; margin-top: 4px; }

    .as-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
    @media(max-width:560px){ .as-row-2 { grid-template-columns: 1fr; } }

    .gender-group { display: flex; gap: 15px; margin-top: 5px; }
    .gender-group label { background: #f1f3f9; padding: 8px 15px; border-radius: 50px; cursor: pointer; transition: 0.2s; border: 1px solid transparent; }
    .gender-group input { margin-right: 5px; cursor: pointer; }

    .btn-update { background: linear-gradient(135deg,#e65100,#f57c00); color: #fff; border: none; border-radius: 12px; padding: 12px 30px; font-weight: 700; cursor: pointer; box-shadow: 0 6px 20px rgba(230,81,0,0.3); transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; }
    .btn-update:hover { transform: translateY(-2px); opacity: 0.9; }
    .btn-back { background: #f3f4f6; color: #374151; padding: 11px 20px; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 5px; }
    
    .as-alert-err { padding: 1rem; background: #fff5f5; border-left: 5px solid #e11d48; color: #c53030; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; }
    .st-id-badge { display: inline-block; background: #e8eaf6; color: #1a237e; font-size: 0.75rem; font-weight: 700; padding: 5px 12px; border-radius: 20px; margin-bottom: 1rem; }
</style>

<div class="as-wrap">

    @if($errors->any())
        <div class="as-alert-err">
            ❌ មានបញ្ហា {{ $errors->count() }} ចំណុច — សូមពិនិត្យម្ដងទៀត
        </div>
    @endif

    {{-- Header --}}
    <div class="as-header">
        <div class="as-header-left">
            <div class="as-icon">✏️</div>
            <div style="margin-left: 15px;">
                <div class="as-bread">
                    <a href="/">Home</a> /
                    <a href="{{ route('teachers.index') }}">Teacher</a> /
                    <span>Edit</span>
                </div>
                <h1 class="as-title">កែប្រែព័ត៌មានលោកគ្រូ</h1>
                <div class="as-sub" style="color: #6b7280; font-size: 0.85rem;">
                    Edit Teacher: <strong>{{ $teacher->name ?? '' }}</strong>
                </div>
            </div>
        </div>
        <a href="{{ route('teachers.index') }}" class="btn-back">⬅ ត្រឡប់ក្រោយ</a>
    </div>

    <div class="st-id-badge">🪪 Teacher ID: #{{ $teacher->id }}</div>

    <form action="{{ route('teachers.update', $teacher->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- PERSONAL INFO --}}
        <div class="as-card">
            <div class="as-card-head">
                <div class="step-b">1</div>
                <h5>ព័ត៌មានផ្ទាល់ខ្លួន — Personal Info</h5>
            </div>

            <div class="as-card-body">
                <div class="as-field">
                    <label>ឈ្មោះ *</label>
                    <input type="text" name="name" class="as-input @error('name') is-invalid @enderror"
                        value="{{ old('name', $teacher->name ?? '') }}">
                    @error('name') <div class="as-err">{{ $message }}</div> @enderror
                </div>

                <div class="as-field">
                    <label>Email *</label>
                    <input type="email" name="email" class="as-input @error('email') is-invalid @enderror"
                        value="{{ old('email', $teacher->email ?? '') }}">
                    @error('email') <div class="as-err">{{ $message }}</div> @enderror
                </div>

                <div class="as-row-2">
                    {{-- ✅ អាយុ — បាន fix input tag --}}
                    <div class="as-field">
                        <label>អាយុ *</label>
                        <input type="number" name="age" class="as-input @error('age') is-invalid @enderror"
                            value="{{ old('age', $teacher->age ?? '') }}" min="18" max="100">
                        @error('age') <div class="as-err">{{ $message }}</div> @enderror
                    </div>

                    <div class="as-field">
                        <label>ថ្ងៃខែឆ្នាំ *</label>
                        <input type="date" name="date_of_birth" class="as-input @error('date_of_birth') is-invalid @enderror"
                            value="{{ old('date_of_birth', $teacher->date_of_birth ? date('Y-m-d', strtotime($teacher->date_of_birth)) : '') }}">
                        @error('date_of_birth') <div class="as-err">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="as-field">
                    <label>ភេទ *</label>
                    <div class="gender-group">
                        @php $g = old('gender', $teacher->gender ?? ''); @endphp
                        <label><input type="radio" name="gender" value="male" {{ $g=='male'?'checked':'' }}> <span>👦 ប្រុស</span></label>
                        <label><input type="radio" name="gender" value="female" {{ $g=='female'?'checked':'' }}> <span>👧 ស្រី</span></label>
                        <label><input type="radio" name="gender" value="other" {{ $g=='other'?'checked':'' }}> <span>⚧ Other</span></label>
                    </div>
                    @error('gender') <div class="as-err">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- WORK INFO --}}
        <div class="as-card">
            <div class="as-card-head">
                <div class="step-b">2</div>
                <h5>ព័ត៌មានការងារ — Work Info</h5>
            </div>

            <div class="as-card-body">
                <div class="as-row-2">
                    <div class="as-field">
                        <label>លេខទូរស័ព្ទ *</label>
                        <input type="text" name="phone" class="as-input @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $teacher->phone ?? '') }}">
                        @error('phone') <div class="as-err">{{ $message }}</div> @enderror
                    </div>

                    <div class="as-field">
                        <label>មុខវិជ្ជា *</label>
                        <select name="subject" class="as-input @error('subject') is-invalid @enderror">
                            <option value="">-- ជ្រើសរើស --</option>
                            @php
                                $subjects = [
                                    'Web Development', 'Database', 'Networking', 'UI/UX Design', 
                                    'Graphic Design', 'Cybersecurity', 'AI & ML', 'Mobile App', 
                                    'IT Support', 'Digital Marketing', 'Algorithm', 'OS Concepts'
                                ];
                                $selectedSubject = old('subject', $teacher->subject ?? '');
                            @endphp
                            @foreach($subjects as $item)
                                <option value="{{ $item }}" {{ $selectedSubject == $item ? 'selected' : '' }}>
                                    {{ $item }}
                                </option>
                            @endforeach
                        </select>
                        @error('subject') <div class="as-err">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- SUBMIT --}}
        <div class="as-submit-row" style="display: flex; gap: 10px; margin-top: 1rem;">
            <button type="submit" class="btn-update">💾 រក្សាទុកការកែប្រែ</button>
            <a href="{{ route('teachers.index') }}" class="btn-back" style="background: #eee;">❌ បោះបង់</a>
        </div>
    </form>
</div>

@endsection