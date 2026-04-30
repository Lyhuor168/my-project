@extends('layouts.master')

@section('title', 'បន្ថែមមុខវិជ្ជា - Add Course')

@section('content')

<style>
    .ac-wrap { max-width: 1100px; margin: 0 auto; padding: 2.5rem 2rem 4rem; }

    .ac-page-header { display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap; margin-bottom: 2rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(26,35,126,0.08); }
    .ac-page-header-left { display: flex; align-items: center; gap: 14px; }
    .ac-page-icon { width: 52px; height: 52px; border-radius: 16px; background: linear-gradient(135deg, #1a237e, #3949ab); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; box-shadow: 0 6px 18px rgba(26,35,126,0.28); flex-shrink: 0; }
    .ac-page-title { font-size: 1.5rem; font-weight: 700; color: #1a237e; margin: 0; }
    .ac-page-sub   { font-size: 0.8rem; color: #6b7280; margin-top: 2px; }
    .ac-breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 0.78rem; color: #9ca3af; }
    .ac-breadcrumb a { color: #3949ab; text-decoration: none; }

    .ac-layout { display: grid; grid-template-columns: 1fr 300px; gap: 1.75rem; align-items: start; }
    @media (max-width: 860px) { .ac-layout { grid-template-columns: 1fr; } .ac-preview-col { order: -1; } }

    .ac-card { background: #fff; border-radius: 18px; border: 1px solid rgba(26,35,126,0.07); box-shadow: 0 4px 24px rgba(26,35,126,0.06); overflow: hidden; margin-bottom: 1.25rem; }
    .ac-card-head { padding: 1.1rem 1.5rem; border-bottom: 1px solid rgba(26,35,126,0.07); display: flex; align-items: center; gap: 10px; background: #fafbff; }
    .ac-card-head h5 { font-size: 0.95rem; font-weight: 700; color: #1a237e; margin: 0; }
    .step-badge { width: 26px; height: 26px; border-radius: 50%; background: #1a237e; color: #fff; font-size: 0.72rem; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .ac-card-body { padding: 1.5rem; }

    .ac-row   { display: grid; gap: 1rem; margin-bottom: 1rem; }
    .ac-row-2 { grid-template-columns: 1fr 1fr; }
    @media (max-width: 580px) { .ac-row-2 { grid-template-columns: 1fr; } }

    .ac-field { display: flex; flex-direction: column; gap: 5px; }
    .ac-field label { font-size: 0.75rem; font-weight: 700; color: #374151; letter-spacing: 0.06em; text-transform: uppercase; display: flex; align-items: center; gap: 5px; }
    .ac-field label .req  { color: #e11d48; }
    .ac-field label .hint { font-size: 0.65rem; font-weight: 400; color: #9ca3af; text-transform: none; letter-spacing: 0; }

    .ac-input, .ac-select, .ac-textarea {
        padding: 10px 13px; background: #f8faff;
        border: 1.5px solid rgba(26,35,126,0.1); border-radius: 10px;
        font-family: 'Kantumruy Pro','Outfit',sans-serif; font-size: 0.875rem; color: #111827;
        transition: border-color 0.2s, box-shadow 0.2s; width: 100%;
    }
    .ac-input::placeholder, .ac-textarea::placeholder { color: #9ca3af; }
    .ac-input:focus, .ac-select:focus, .ac-textarea:focus { outline: none; border-color: #1a237e; box-shadow: 0 0 0 3px rgba(26,35,126,0.1); background: #fff; }
    .ac-input.is-invalid, .ac-select.is-invalid, .ac-textarea.is-invalid { border-color: #e11d48; box-shadow: 0 0 0 3px rgba(225,29,72,0.1); }
    .ac-textarea { resize: vertical; min-height: 90px; }

    .ac-input-icon-wrap { position: relative; }
    .ac-input-icon-wrap .fi { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.85rem; pointer-events: none; }
    .ac-input-icon-wrap:focus-within .fi { color: #1a237e; }
    .ac-input-icon-wrap .ac-input, .ac-input-icon-wrap .ac-select { padding-left: 34px; }

    .ac-err-msg { font-size: 0.72rem; color: #e11d48; margin-top: 3px; }
    .ac-char-count { font-size: 0.68rem; color: #9ca3af; text-align: right; margin-top: 3px; }
    .ac-divider { border: none; border-top: 1px dashed rgba(26,35,126,0.1); margin: 1.25rem 0; }

    .ac-dur-row { display: flex; align-items: center; gap: 8px; }
    .ac-dur-row .unit { font-size: 0.8rem; font-weight: 600; color: #6b7280; white-space: nowrap; }

    .day-check { display: inline-flex; align-items: center; gap: 5px; background: #f8faff; border: 1.5px solid rgba(26,35,126,0.1); border-radius: 8px; padding: 7px 13px; font-size: 0.83rem; font-weight: 600; cursor: pointer; color: #374151; transition: all 0.15s; user-select: none; }
    .day-check input { accent-color: #1a237e; cursor: pointer; }
    .day-check:has(input:checked) { background: #e8eaf6; border-color: #1a237e; color: #1a237e; }

    .ac-color-row { display: flex; gap: 10px; flex-wrap: wrap; }
    .ac-color-swatch { width: 32px; height: 32px; border-radius: 8px; border: 2px solid transparent; cursor: pointer; transition: transform 0.15s, border-color 0.15s; }
    .ac-color-swatch:hover { transform: scale(1.12); }
    .ac-color-swatch.selected { border-color: #111827; transform: scale(1.18); }

    .ac-icon-grid { display: flex; flex-wrap: wrap; gap: 8px; max-height: 130px; overflow-y: auto; }
    .ac-icon-opt { width: 40px; height: 40px; border-radius: 10px; border: 1.5px solid rgba(26,35,126,0.1); background: #f8faff; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; cursor: pointer; transition: all 0.15s; }
    .ac-icon-opt:hover { background: #e8eaf6; border-color: #1a237e; }
    .ac-icon-opt.selected { background: #1a237e; border-color: #1a237e; }

    .ac-submit-row { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; padding-top: 0.5rem; }
    .ac-btn-submit { display: inline-flex; align-items: center; gap: 8px; background: linear-gradient(135deg,#1a237e,#3949ab); color: #fff; border: none; border-radius: 12px; padding: 12px 28px; font-family: 'Kantumruy Pro','Outfit',sans-serif; font-size: 0.9rem; font-weight: 700; cursor: pointer; box-shadow: 0 6px 20px rgba(26,35,126,0.3); transition: opacity 0.15s, transform 0.12s; }
    .ac-btn-submit:hover { opacity: 0.9; transform: translateY(-1px); }
    .ac-btn-reset { display: inline-flex; align-items: center; gap: 7px; background: transparent; color: #6b7280; border: 1.5px solid rgba(26,35,126,0.12); border-radius: 12px; padding: 11px 22px; font-family: 'Kantumruy Pro','Outfit',sans-serif; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.15s; }
    .ac-btn-reset:hover { border-color: #e11d48; color: #e11d48; background: #fff0f3; }
    .ac-btn-back { display: inline-flex; align-items: center; gap: 7px; background: transparent; color: #374151; border: 1.5px solid rgba(26,35,126,0.1); border-radius: 12px; padding: 11px 20px; font-family: 'Kantumruy Pro','Outfit',sans-serif; font-size: 0.875rem; font-weight: 600; text-decoration: none; transition: all 0.15s; }
    .ac-btn-back:hover { border-color: #1a237e; color: #1a237e; background: #e8eaf6; }

    /* Preview */
    .ac-preview-col { display: flex; flex-direction: column; gap: 1.25rem; }
    .ac-preview-card { background: #fff; border-radius: 18px; border: 1px solid rgba(26,35,126,0.07); box-shadow: 0 4px 24px rgba(26,35,126,0.06); overflow: hidden; }
    .ac-preview-bar  { height: 5px; transition: background 0.3s; }
    .ac-preview-head { padding: 1rem 1.25rem 0.75rem; border-bottom: 1px solid rgba(26,35,126,0.06); background: #fafbff; display: flex; align-items: center; justify-content: space-between; }
    .ac-preview-head > span { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: #9ca3af; }
    .ac-preview-live { display: inline-flex; align-items: center; gap: 5px; font-size: 0.65rem; font-weight: 700; color: #059669; }
    .ac-preview-live::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: #059669; animation: ldot 1.5s ease-in-out infinite; }
    @keyframes ldot { 0%,100%{opacity:1} 50%{opacity:0.35} }
    .ac-preview-body { padding: 1.25rem; }
    .ac-prev-icon { width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; margin-bottom: 1rem; transition: background 0.3s; }
    .ac-prev-cat  { font-size: 0.67rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px; transition: color 0.3s; }
    .ac-prev-name { font-size: 1.05rem; font-weight: 700; color: #1a237e; margin-bottom: 6px; line-height: 1.3; min-height: 1.4em; }
    .ac-prev-code { font-size: 0.72rem; font-weight: 600; color: #6b7280; background: #f3f4f6; border-radius: 6px; padding: 2px 9px; display: inline-block; margin-bottom: 10px; }
    .ac-prev-desc { font-size: 0.8rem; color: #6b7280; line-height: 1.65; margin-bottom: 1rem; min-height: 2em; }
    .ac-prev-chips { display: flex; flex-wrap: wrap; gap: 6px; }
    .ac-prev-chip  { font-size: 0.68rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; background: #e8eaf6; color: #1a237e; }

    .ac-tips-card { background: linear-gradient(135deg,#e8eaf6,#c5cae9); border-radius: 16px; padding: 1.25rem 1.4rem; border: 1px solid rgba(26,35,126,0.1); }
    .ac-tips-card h6 { font-size: 0.82rem; font-weight: 700; color: #1a237e; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 7px; }
    .ac-tips-list { list-style: none; padding: 0; margin: 0; }
    .ac-tips-list li { font-size: 0.78rem; color: #3949ab; line-height: 1.6; padding: 3px 0; display: flex; gap: 7px; }
    .ac-tips-list li::before { content: '→'; opacity: 0.5; flex-shrink: 0; }

    .ac-alert { padding: 0.9rem 1.25rem; border-radius: 12px; font-size: 0.87rem; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; }
    .ac-alert-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
    .ac-alert-error   { background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }
</style>

<div class="ac-wrap">

    {{-- Session alerts --}}
    @if(session('success'))
        <div class="ac-alert ac-alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="ac-alert ac-alert-error"><i class="fas fa-exclamation-triangle"></i> មានបញ្ហា {{ $errors->count() }} ចំណុច — សូមពិនិត្យម្ដងទៀត</div>
    @endif

    {{-- Page header --}}
    <div class="ac-page-header">
        <div class="ac-page-header-left">
            <div class="ac-page-icon"><i class="fas fa-plus-circle"></i></div>
            <div>
                <div class="ac-breadcrumb">
                    <a href="/">Home</a> /
                    <a href="{{ route('courses.index') }}">Courses</a> /
                    <span>Add Course</span>
                </div>
                <h1 class="ac-page-title">បន្ថែមមុខវិជ្ជាថ្មី</h1>
                <div class="ac-page-sub">Add a new course to the school system</div>
            </div>
        </div>
        <a href="{{ route('courses.index') }}" class="ac-btn-back">
            <i class="fas fa-arrow-left"></i> ត្រឡប់ក្រោយ
        </a>
    </div>

    <div class="ac-layout">

        {{-- ════ FORM ════ --}}
        <form action="{{ route('courses.store') }}" method="POST" id="courseForm">
            @csrf

            {{-- Hidden: color + icon --}}
            <input type="hidden" name="color" id="hiddenColor" value="{{ old('color','#1a237e') }}"/>
            <input type="hidden" name="icon"  id="hiddenIcon"  value="{{ old('icon','💻') }}"/>

            {{-- 1 Basic --}}
            <div class="ac-card">
                <div class="ac-card-head"><div class="step-badge">1</div><h5>ព័ត៌មានមូលដ្ឋាន — Basic Information</h5></div>
                <div class="ac-card-body">

                    <div class="ac-field" style="margin-bottom:1rem;">
                        <label>ឈ្មោះមុខវិជ្ជា <span class="req">*</span> <span class="hint">/ Course Name</span></label>
                        <div class="ac-input-icon-wrap">
                            <i class="fas fa-book-open fi"></i>
                            <input type="text" name="name" id="courseName"
                                class="ac-input @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="e.g. Web Development..."
                                maxlength="80" oninput="liveUpdate(); countChar(this,'nc',80)"/>
                        </div>
                        <div class="ac-char-count"><span id="nc">{{ strlen(old('name','')) }}</span>/80</div>
                        @error('name') <div class="ac-err-msg">{{ $message }}</div> @enderror
                    </div>

                    <div class="ac-row ac-row-2">
                        <div class="ac-field">
                            <label>លេខកូដ <span class="req">*</span> <span class="hint">/ Code</span></label>
                            <div class="ac-input-icon-wrap">
                                <i class="fas fa-hashtag fi"></i>
                                <input type="text" name="code" id="courseCode"
                                    class="ac-input @error('code') is-invalid @enderror"
                                    value="{{ old('code') }}" placeholder="WEB-101"
                                    maxlength="20" oninput="liveUpdate()" style="text-transform:uppercase"/>
                            </div>
                            @error('code') <div class="ac-err-msg">{{ $message }}</div> @enderror
                        </div>
                        <div class="ac-field">
                            <label>ប្រភេទ <span class="req">*</span> <span class="hint">/ Category</span></label>
                            <select name="category" id="courseCategory"
                                class="ac-select @error('category') is-invalid @enderror"
                                onchange="liveUpdate()">
                                <option value="">-- ជ្រើស --</option>
                                @foreach(['Web Development','Database','Networking','UI/UX Design','Graphic Design','Cybersecurity','AI & ML','Mobile App','IT Support','Digital Marketing','Algorithm','OS Concepts'] as $c)
                                    <option value="{{ $c }}" {{ old('category') == $c ? 'selected':'' }}>{{ $c }}</option>
                                @endforeach
                            </select>
                            @error('category') <div class="ac-err-msg">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="ac-field">
                        <label>ការពិពណ៌នា <span class="hint">/ Description</span></label>
                        <textarea name="description" id="courseDesc"
                            class="ac-textarea @error('description') is-invalid @enderror"
                            placeholder="ពិពណ៌នា..." maxlength="300"
                            oninput="liveUpdate(); countChar(this,'dc',300)">{{ old('description') }}</textarea>
                        <div class="ac-char-count"><span id="dc">{{ strlen(old('description','')) }}</span>/300</div>
                        @error('description') <div class="ac-err-msg">{{ $message }}</div> @enderror
                    </div>

                </div>
            </div>

            {{-- 2 Schedule --}}
            <div class="ac-card">
                <div class="ac-card-head"><div class="step-badge">2</div><h5>ការរៀបចំ — Schedule & Details</h5></div>
                <div class="ac-card-body">

                    <div class="ac-row ac-row-2">
                        <div class="ac-field">
                            <label>គ្រូបង្រៀន <span class="req">*</span></label>
                            <div class="ac-input-icon-wrap">
                                <i class="fas fa-chalkboard-teacher fi"></i>
                                <select name="teacher" class="ac-select @error('teacher') is-invalid @enderror" style="padding-left:34px;" onchange="liveUpdate()">
                                    <option value="">-- ជ្រើស --</option>
                                    @foreach(['លោក លីហួ','អ្នកគ្រូ សុភា','លោក ចាន់ត្រា','លោក ហេង បូរ៉ា','អ្នកគ្រូ ម៉ែន ច័ន្ទ','លោក វង់ ពីរោះ'] as $t)
                                        <option value="{{ $t }}" {{ old('teacher')==$t?'selected':'' }}>{{ $t }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('teacher') <div class="ac-err-msg">{{ $message }}</div> @enderror
                        </div>
                        <div class="ac-field">
                            <label>កម្រិត <span class="hint">/ Level</span></label>
                            <select name="level" id="courseLevel" class="ac-select" onchange="liveUpdate()">
                                <option value="">-- ជ្រើស --</option>
                                @foreach(['Beginner','Intermediate','Advanced','All Levels'] as $l)
                                    <option value="{{ $l }}" {{ old('level')==$l?'selected':'' }}>{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="ac-row ac-row-2">
                        <div class="ac-field">
                            <label>ថ្ងៃចាប់ផ្ដើម <span class="req">*</span></label>
                            <div class="ac-input-icon-wrap">
                                <i class="fas fa-calendar-alt fi"></i>
                                <input type="date" name="start_date"
                                    class="ac-input @error('start_date') is-invalid @enderror"
                                    value="{{ old('start_date') }}"/>
                            </div>
                            @error('start_date') <div class="ac-err-msg">{{ $message }}</div> @enderror
                        </div>
                        <div class="ac-field">
                            <label>ថ្ងៃបញ្ចប់</label>
                            <div class="ac-input-icon-wrap">
                                <i class="fas fa-calendar-check fi"></i>
                                <input type="date" name="end_date" class="ac-input" value="{{ old('end_date') }}"/>
                            </div>
                            @error('end_date') <div class="ac-err-msg">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="ac-row ac-row-2">
                        <div class="ac-field">
                            <label>រយៈពេល <span class="hint">/ Hours</span></label>
                            <div class="ac-dur-row">
                                <input type="number" name="duration" id="courseDuration" class="ac-input"
                                    value="{{ old('duration') }}" placeholder="0" min="1" oninput="liveUpdate()"/>
                                <span class="unit">ម៉ោង</span>
                            </div>
                        </div>
                        <div class="ac-field">
                            <label>Max Students</label>
                            <div class="ac-input-icon-wrap">
                                <i class="fas fa-users fi"></i>
                                <input type="number" name="max_students" id="maxStudents" class="ac-input"
                                    value="{{ old('max_students') }}" placeholder="30" min="1" oninput="liveUpdate()"/>
                            </div>
                        </div>
                    </div>

                    <div class="ac-field" style="margin-bottom:1rem;">
                        <label>ថ្ងៃរៀន <span class="hint">/ Days</span></label>
                        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:4px;">
                            @foreach(['ច','អ','ពុ','ព្រ','សុ','ស'] as $d)
                                <label class="day-check">
                                    <input type="checkbox" name="days[]" value="{{ $d }}"
                                        {{ in_array($d, old('days',[])) ? 'checked':'' }}>{{ $d }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <hr class="ac-divider"/>

                    <div class="ac-row ac-row-2">
                        <div class="ac-field">
                            <label>ម៉ោងចាប់</label>
                            <div class="ac-input-icon-wrap">
                                <i class="fas fa-clock fi"></i>
                                <input type="time" name="time_start" id="timeStart" class="ac-input"
                                    value="{{ old('time_start') }}" oninput="liveUpdate()"/>
                            </div>
                        </div>
                        <div class="ac-field">
                            <label>ម៉ោងបញ្ចប់</label>
                            <div class="ac-input-icon-wrap">
                                <i class="fas fa-clock fi"></i>
                                <input type="time" name="time_end" id="timeEnd" class="ac-input"
                                    value="{{ old('time_end') }}" oninput="liveUpdate()"/>
                            </div>
                        </div>
                    </div>

                    <div class="ac-field">
                        <label>បន្ទប់រៀន</label>
                        <div class="ac-input-icon-wrap">
                            <i class="fas fa-door-open fi"></i>
                            <input type="text" name="room" id="courseRoom" class="ac-input"
                                value="{{ old('room') }}" placeholder="e.g. A101, Lab-B"
                                oninput="liveUpdate()"/>
                        </div>
                    </div>

                </div>
            </div>

            {{-- 3 Appearance --}}
            <div class="ac-card">
                <div class="ac-card-head"><div class="step-badge">3</div><h5>រូបរាង — Appearance</h5></div>
                <div class="ac-card-body">

                    <div class="ac-field" style="margin-bottom:1.1rem;">
                        <label>ពណ៌ <span class="hint">/ Color</span></label>
                        <div class="ac-color-row">
                            @php $colors = ['#1a237e','#1565c0','#00695c','#e65100','#6a1b9a','#c62828','#2e7d32','#0277bd']; @endphp
                            @foreach($colors as $clr)
                                <div class="ac-color-swatch {{ old('color','#1a237e') == $clr ? 'selected':'' }}"
                                     style="background:{{ $clr }};"
                                     data-color="{{ $clr }}"
                                     onclick="pickColor(this,'{{ $clr }}')"></div>
                            @endforeach
                        </div>
                    </div>

                    <div class="ac-field">
                        <label>រូបតំណាង <span class="hint">/ Icon</span></label>
                        <div class="ac-icon-grid">
                            @php $icons = ['💻','🌐','🗄️','🔌','🎨','🖌️','🔒','🤖','📱','🛠️','📣','📐','🖥️','📚','📊','🎓']; @endphp
                            @foreach($icons as $ico)
                                <div class="ac-icon-opt {{ old('icon','💻') == $ico ? 'selected':'' }}"
                                     data-icon="{{ $ico }}"
                                     onclick="pickIcon(this,'{{ $ico }}')">{{ $ico }}</div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

            {{-- Submit --}}
            <div class="ac-submit-row">
                <button type="submit" class="ac-btn-submit">
                    <i class="fas fa-save"></i> រក្សាទុក
                </button>
                <button type="reset" class="ac-btn-reset" onclick="setTimeout(liveUpdate,50)">
                    <i class="fas fa-undo"></i> សម្អាត
                </button>
                <a href="{{ route('courses.index') }}" class="ac-btn-back">
                    <i class="fas fa-times"></i> លុបចោល
                </a>
            </div>

        </form>

        {{-- ════ PREVIEW ════ --}}
        <div class="ac-preview-col">
            <div class="ac-preview-card">
                <div class="ac-preview-bar" id="pBar" style="background:#1a237e;"></div>
                <div class="ac-preview-head">
                    <span>Live Preview</span>
                    <span class="ac-preview-live">LIVE</span>
                </div>
                <div class="ac-preview-body">
                    <div class="ac-prev-icon" id="pIcon" style="background:#1a237e;">💻</div>
                    <div class="ac-prev-cat"  id="pCat"  style="color:#1a237e;">ប្រភេទ</div>
                    <div class="ac-prev-name" id="pName">ឈ្មោះមុខវិជ្ជា</div>
                    <div class="ac-prev-code" id="pCode">CODE-000</div>
                    <div class="ac-prev-desc" id="pDesc">ការពិពណ៌នា...</div>
                    <div class="ac-prev-chips">
                        <span class="ac-prev-chip" id="pLevel">🎯 Level</span>
                        <span class="ac-prev-chip" id="pTime"  style="display:none">🕐</span>
                        <span class="ac-prev-chip" id="pRoom"  style="display:none">🏫</span>
                        <span class="ac-prev-chip" id="pMax"   style="display:none">👥</span>
                    </div>
                </div>
            </div>

            <div class="ac-tips-card">
                <h6><i class="fas fa-lightbulb"></i> ការណែនាំ</h6>
                <ul class="ac-tips-list">
                    <li>Code ត្រូវតែ unique (e.g. WEB-101)</li>
                    <li>ជ្រើស Icon ហើយ Color ដែលសម</li>
                    <li>ការពិពណ៌នា > ៣ ល</li>
                    <li>ថ្ងៃបញ្ចប់ >= ថ្ងៃចាប់ផ្ដើម</li>
                    <li>Run: <code>php artisan migrate</code></li>
                </ul>
            </div>
        </div>

    </div>
</div>

<script>
let selColor = '{{ old('color','#1a237e') }}';
let selIcon  = '{{ old('icon','💻') }}';

function pickColor(el, c) {
    document.querySelectorAll('.ac-color-swatch').forEach(s => s.classList.remove('selected'));
    el.classList.add('selected');
    selColor = c;
    document.getElementById('hiddenColor').value = c;
    liveUpdate();
}

function pickIcon(el, i) {
    document.querySelectorAll('.ac-icon-opt').forEach(o => o.classList.remove('selected'));
    el.classList.add('selected');
    selIcon = i;
    document.getElementById('hiddenIcon').value = i;
    liveUpdate();
}

function countChar(el, id, max) {
    const el2 = document.getElementById(id);
    el2.textContent = el.value.length;
    el2.style.color = el.value.length > max * 0.9 ? '#e11d48' : '#9ca3af';
}

function liveUpdate() {
    const get = id => { const el = document.getElementById(id); return el ? el.value : ''; };
    const name = get('courseName')   || 'ឈ្មោះមុខវិជ្ជា';
    const code = (get('courseCode')  || 'CODE-000').toUpperCase();
    const cat  = document.getElementById('courseCategory')?.value || 'ប្រភេទ';
    const desc = get('courseDesc')   || 'ការពិពណ៌នា...';
    const lvl  = document.getElementById('courseLevel')?.value || '';
    const ts   = get('timeStart');
    const te   = get('timeEnd');
    const room = get('courseRoom');
    const max  = get('maxStudents');

    document.getElementById('pName').textContent  = name;
    document.getElementById('pCode').textContent  = code;
    document.getElementById('pCat').textContent   = cat;
    document.getElementById('pDesc').textContent  = desc;
    document.getElementById('pLevel').textContent = lvl ? '🎯 ' + lvl : '🎯 Level';

    const te2 = document.getElementById('pTime');
    if (ts || te) { te2.textContent = '🕐 ' + (ts||'--') + '–' + (te||'--'); te2.style.display = ''; }
    else te2.style.display = 'none';

    const re = document.getElementById('pRoom');
    if (room) { re.textContent = '🏫 ' + room; re.style.display = ''; }
    else re.style.display = 'none';

    const me = document.getElementById('pMax');
    if (max) { me.textContent = '👥 ' + max; me.style.display = ''; }
    else me.style.display = 'none';

    document.getElementById('pBar').style.background  = selColor;
    document.getElementById('pIcon').style.background = selColor;
    document.getElementById('pCat').style.color        = selColor;
    document.getElementById('pIcon').textContent       = selIcon;
}

liveUpdate();
</script>

@endsection