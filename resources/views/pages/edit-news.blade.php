@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="fw-bold">កែប្រែព័ត៌មាន (Edit News)</h4>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 border-end">
                        <h5 class="text-primary mb-3">ភាសាខ្មែរ</h5>
                        <div class="mb-3">
                            <label class="form-label">ចំណងជើង</label>
                            <input type="text" name="title_km" class="form-control" value="{{ $news->title_km }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ខ្លឹមសារ</label>
                            <textarea name="content_km" class="form-control" rows="8">{{ $news->content_km }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="text-primary mb-3">English Version</h5>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title_en" class="form-control" value="{{ $news->title_en }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea name="content_en" class="form-control" rows="8">{{ $news->content_en }}</textarea>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">រូបភាពបច្ចុប្បន្ន</label>
                        @if($news->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $news->image) }}" width="120" class="rounded border">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control">
                        <small class="text-muted">ទុកចំហរ ប្រសិនបើមិនចង់ប្តូររូបភាព</small>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">ប្រភេទព័ត៌មាន</label>
                        <select name="category" class="form-select">
                            <option value="announcement" {{ $news->category == 'announcement' ? 'selected' : '' }}>ការប្រកាស</option>
                            <option value="event" {{ $news->category == 'event' ? 'selected' : '' }}>ព្រឹត្តិការណ៍</option>
                            <option value="holiday" {{ $news->category == 'holiday' ? 'selected' : '' }}>ថ្ងៃឈប់សម្រាក</option>
                        </select>
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="is_published" id="publishSwitch" {{ $news->is_published ? 'checked' : '' }}>
                            <label class="form-check-label" for="publishSwitch">បោះពុម្ពផ្សាយ</label>
                        </div>
                    </div>
                </div>

                <div class="mt-5 text-end">
                    <a href="{{ url('/news') }}" class="btn btn-light px-4 me-2">ត្រឡប់ក្រោយ</a>
                    <button type="submit" class="btn btn-info px-5 text-white">ធ្វើបច្ចុប្បន្នភាព (Update)</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection