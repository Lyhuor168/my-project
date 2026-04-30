@extends('layouts.master')
@section('title', 'បន្ថែម Slide')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i>បន្ថែម Slide ថ្មី</h4>
    <a href="{{ route('slides.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> ត្រឡប់
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form method="POST" action="{{ route('slides.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">ចំណងជើង</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="ចំណងជើង Slide">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">លំដាប់</label>
                    <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">អត្ថបទខ្លី</label>
                    <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle') }}" placeholder="អត្ថបទខ្លី">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">រូបភាព <span class="text-danger">*</span></label>
                    <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this)" required>
                    <img id="preview" src="#" class="mt-2 rounded" style="display:none;max-height:200px;">
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                        <label class="form-check-label" for="is_active">Active (បង្ហាញ)</label>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> រក្សាទុក
                </button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
@endsection
