@extends('layouts.master')

@section('title', 'បន្ថែមសៀវភៅ - Add Book')

@section('content')

<style>
    .bk-wrap { max-width: 720px; margin: 0 auto; padding: 2.5rem 2rem 4rem; font-family: 'Kantumruy Pro', sans-serif; }

    .bk-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(26,35,126,0.08); }
    .bk-icon { width: 52px; height: 52px; border-radius: 16px; background: linear-gradient(135deg,#1565c0,#1e88e5); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; box-shadow: 0 6px 18px rgba(21,101,192,0.25); }
    .bk-title { font-size: 1.5rem; font-weight: 700; color: #1a237e; margin: 0; }
    .bk-bread a { color: #3949ab; text-decoration: none; font-size: 0.8rem; }

    .bk-card { background: #fff; border-radius: 18px; border: 1px solid rgba(26,35,126,0.07); box-shadow: 0 4px 24px rgba(26,35,126,0.06); overflow: hidden; margin-bottom: 1.25rem; }
    .bk-card-head { padding: 1.1rem 1.5rem; border-bottom: 1px solid rgba(26,35,126,0.07); display: flex; align-items: center; gap: 10px; background: #fafbff; }
    .bk-card-head h5 { font-size: 0.95rem; font-weight: 700; color: #1a237e; margin: 0; }
    .step-b { width: 26px; height: 26px; border-radius: 50%; background: #1565c0; color: #fff; font-size: 0.72rem; font-weight: 800; display: flex; align-items: center; justify-content: center; }
    .bk-card-body { padding: 1.5rem; }

    .bk-field { margin-bottom: 1.2rem; }
    .bk-field label { font-size: 0.8rem; font-weight: 700; color: #374151; display: block; margin-bottom: 6px; }
    .bk-input { width: 100%; padding: 12px 15px; background: #f8faff; border: 1.5px solid rgba(26,35,126,0.1); border-radius: 10px; font-size: 0.9rem; transition: 0.2s; box-sizing: border-box; }
    .bk-input:focus { outline: none; border-color: #1565c0; box-shadow: 0 0 0 3px rgba(21,101,192,0.1); background: #fff; }
    .bk-input.is-invalid { border-color: #e11d48; }
    .bk-err { font-size: 0.75rem; color: #e11d48; margin-top: 4px; }

    .bk-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
    @media(max-width:560px){ .bk-row-2 { grid-template-columns: 1fr; } }

    .bk-alert-err { padding: 1rem; background: #fff5f5; border-left: 5px solid #e11d48; color: #c53030; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600; }

    .btn-add { background: linear-gradient(135deg,#1565c0,#1e88e5); color: #fff; border: none; border-radius: 12px; padding: 12px 30px; font-weight: 700; cursor: pointer; box-shadow: 0 6px 20px rgba(21,101,192,0.3); transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; font-size: 0.95rem; }
    .btn-add:hover { transform: translateY(-2px); opacity: 0.9; }
    .btn-back { background: #f3f4f6; color: #374151; padding: 11px 20px; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 5px; }

    /* Image Preview */
    .img-preview-box { width: 100%; height: 160px; border: 2px dashed rgba(21,101,192,0.3); border-radius: 12px; display: flex; align-items: center; justify-content: center; background: #f8faff; cursor: pointer; overflow: hidden; position: relative; }
    .img-preview-box img { width: 100%; height: 100%; object-fit: cover; display: none; }
    .img-preview-box span { color: #9ca3af; font-size: 0.85rem; }
</style>

<div class="bk-wrap">

    @if($errors->any())
        <div class="bk-alert-err">
            ❌ មានបញ្ហា {{ $errors->count() }} ចំណុច — សូមពិនិត្យម្ដងទៀត
        </div>
    @endif

    {{-- Header --}}
    <div class="bk-header">
        <div style="display:flex; align-items:center; gap:15px;">
            <div class="bk-icon">📚</div>
            <div>
                <div class="bk-bread">
                    <a href="/">Home</a> /
                    <a href="{{ route('shop') }}">Shop</a> /
                    <span>បន្ថែមសៀវភៅ</span>
                </div>
                <h1 class="bk-title">បន្ថែមសៀវភៅថ្មី</h1>
                <div style="color:#6b7280; font-size:0.85rem;">Add new book to shop</div>
            </div>
        </div>
        <a href="{{ route('shop') }}" class="btn-back">⬅ ត្រឡប់ក្រោយ</a>
    </div>

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- BOOK INFO --}}
        <div class="bk-card">
            <div class="bk-card-head">
                <div class="step-b">1</div>
                <h5>ព័ត៌មានសៀវភៅ — Book Info</h5>
            </div>
            <div class="bk-card-body">

                <div class="bk-field">
                    <label>ឈ្មោះសៀវភៅ *</label>
                    <input type="text" name="title" class="bk-input @error('title') is-invalid @enderror"
                        placeholder="ឧ. Learn Web Development" value="{{ old('title') }}">
                    @error('title') <div class="bk-err">{{ $message }}</div> @enderror
                </div>

                <div class="bk-field">
                    <label>អ្នកនិពន្ធ *</label>
                    <input type="text" name="author" class="bk-input @error('author') is-invalid @enderror"
                        placeholder="ឧ. សុខ វិជ្ជា" value="{{ old('author') }}">
                    @error('author') <div class="bk-err">{{ $message }}</div> @enderror
                </div>

                <div class="bk-row-2">
                    <div class="bk-field">
                        <label>ប្រភេទ *</label>
                        <select name="category" class="bk-input @error('category') is-invalid @enderror">
                            <option value="">-- ជ្រើសរើស --</option>
                            @php
                                $categories = ['Web Development','Database','Networking','UI/UX Design','Graphic Design','Cybersecurity','AI & ML','Mobile App','IT Support','Digital Marketing','Algorithm','OS Concepts'];
                            @endphp
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category') <div class="bk-err">{{ $message }}</div> @enderror
                    </div>

                    <div class="bk-field">
                        <label>ភាសា</label>
                        <select name="language" class="bk-input @error('language') is-invalid @enderror">
                            <option value="khmer" {{ old('language')=='khmer'?'selected':'' }}>🇰🇭 ភាសាខ្មែរ</option>
                            <option value="english" {{ old('language')=='english'?'selected':'' }}>🇺🇸 English</option>
                            <option value="both" {{ old('language')=='both'?'selected':'' }}>🌐 ទាំងពីរ</option>
                        </select>
                        @error('language') <div class="bk-err">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="bk-field">
                    <label>អំពីសៀវភៅ</label>
                    <textarea name="description" class="bk-input @error('description') is-invalid @enderror"
                        rows="3" placeholder="សរសេរពីអ្វីដែលសៀវភៅនេះបង្រៀន...">{{ old('description') }}</textarea>
                    @error('description') <div class="bk-err">{{ $message }}</div> @enderror
                </div>

            </div>
        </div>

        {{-- PRICE & STOCK --}}
        <div class="bk-card">
            <div class="bk-card-head">
                <div class="step-b">2</div>
                <h5>តម្លៃ និង ចំនួន — Price & Stock</h5>
            </div>
            <div class="bk-card-body">
                <div class="bk-row-2">
                    <div class="bk-field">
                        <label>តម្លៃ (រៀល) *</label>
                        <input type="number" name="price" class="bk-input @error('price') is-invalid @enderror"
                            placeholder="ឧ. 15000" value="{{ old('price') }}" min="0">
                        @error('price') <div class="bk-err">{{ $message }}</div> @enderror
                    </div>

                    <div class="bk-field">
                        <label>ចំនួននៅក្នុងស្តុក *</label>
                        <input type="number" name="stock" class="bk-input @error('stock') is-invalid @enderror"
                            placeholder="ឧ. 50" value="{{ old('stock') }}" min="0">
                        @error('stock') <div class="bk-err">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- IMAGE --}}
        <div class="bk-card">
            <div class="bk-card-head">
                <div class="step-b">3</div>
                <h5>រូបភាពសៀវភៅ — Book Cover</h5>
            </div>
            <div class="bk-card-body">
                <div class="bk-field">
                    <label>រូបភាព</label>
                    <div class="img-preview-box" onclick="document.getElementById('imgInput').click()">
                        <img id="imgPreview" src="" alt="preview">
                        <span id="imgText">📷 ចុចដើម្បីជ្រើសរូបភាព</span>
                    </div>
                    <input type="file" id="imgInput" name="image" accept="image/*" style="display:none"
                        onchange="previewImage(this)">
                    @error('image') <div class="bk-err">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- SUBMIT --}}
        <div style="display:flex; gap:10px; margin-top:1rem;">
            <button type="submit" class="btn-add">📚 បន្ថែមសៀវភៅ</button>
            <a href="{{ route('shop') }}" class="btn-back" style="background:#eee;">❌ បោះបង់</a>
        </div>

    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imgPreview');
    const text = document.getElementById('imgText');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
            text.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection
