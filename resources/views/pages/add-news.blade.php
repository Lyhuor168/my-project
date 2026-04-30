@extends('layouts.master') @section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="fw-bold">បន្ថែមព័ត៌មានថ្មី (Add New News)</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/news') }}">បញ្ជីព័ត៌មាន</a></li>
                <li class="breadcrumb-item active" aria-current="page">បន្ថែមថ្មី</li>
            </ol>
        </nav>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 border-end">
                        <h5 class="text-primary mb-3"><i class="bi bi-flag-fill"></i> ភាសាខ្មែរ</h5>
                        <div class="mb-3">
                            <label class="form-label">ចំណងជើង (Khmer Title)</label>
                            <input type="text" name="title_km" class="form-control" placeholder="បញ្ចូលចំណងជើង..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ខ្លឹមសារព័ត៌មាន (Khmer Content)</label>
                            <textarea name="content_km" class="form-control" rows="8" placeholder="សរសេរខ្លឹមសារនៅទីនេះ..."></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="text-primary mb-3"><i class="bi bi-geo-alt-fill"></i> English Version</h5>
                        <div class="mb-3">
                            <label class="form-label">Title (English)</label>
                            <input type="text" name="title_en" class="form-control" placeholder="Enter title..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content (English)</label>
                            <textarea name="content_en" class="form-control" rows="8" placeholder="Write content here..."></textarea>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">រូបភាពតំណាង (Featured Image)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">ទំហំដែលណែនាំ៖ 1200x600px</small>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">ប្រភេទព័ត៌មាន (Category)</label>
                        <select name="category" class="form-select">
                            <option value="announcement">ការប្រកាស (Announcement)</option>
                            <option value="event">ព្រឹត្តិការណ៍ (Event)</option>
                            <option value="holiday">ថ្ងៃឈប់សម្រាក (Holiday)</option>
                        </select>
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="is_published" id="publishSwitch" checked>
                            <label class="form-check-label" for="publishSwitch">បោះពុម្ពផ្សាយភ្លាមៗ (Publish Now)</label>
                        </div>
                    </div>
                </div>

                <div class="mt-5 text-end">
                    <a href="{{ url('/news') }}" class="btn btn-light px-4 me-2">បោះបង់</a>
                    <button type="submit" class="btn btn-primary px-5">រក្សាទុកព័ត៌មាន</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection