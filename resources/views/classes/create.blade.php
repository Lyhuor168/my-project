@extends('layouts.dashboard')
@section('content')
<div class="card border-0 shadow-sm" style="max-width:600px;margin:0 auto;">
    <div class="card-body p-4">
        <h4 class="fw-bold mb-4"><i class="fas fa-plus-circle me-2 text-primary"></i>បង្កើត Class ថ្មី</h4>
        <form method="POST" action="{{ route('classes.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-600">ឈ្មោះថ្នាក់</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. IT A, Grade 12B" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-600">Code ថ្នាក់</label>
                <input type="text" name="code" class="form-control" placeholder="e.g. ITA, G12B" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-600">ការពិពណ៌នា</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-4">
                <label class="form-label fw-600">ចំនួនសិស្សអតិបរមា</label>
                <input type="number" name="max_students" class="form-control" value="30" min="1" required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>រក្សាទុក</button>
                <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">បោះបង់</a>
            </div>
        </form>
    </div>
</div>
@endsection
