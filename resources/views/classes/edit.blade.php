@extends('layouts.dashboard')
@section('content')
<div class="card border-0 shadow-sm" style="max-width:600px;margin:0 auto;">
    <div class="card-body p-4">
        <h4 class="fw-bold mb-4"><i class="fas fa-edit me-2 text-warning"></i>កែ Class</h4>
        <form method="POST" action="{{ route('classes.update', $class->id) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">ឈ្មោះថ្នាក់</label>
                <input type="text" name="name" class="form-control" value="{{ $class->name }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Code ថ្នាក់</label>
                <input type="text" name="code" class="form-control" value="{{ $class->code }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">ការពិពណ៌នា</label>
                <textarea name="description" class="form-control" rows="3">{{ $class->description }}</textarea>
            </div>
            <div class="mb-4">
                <label class="form-label">ចំនួនសិស្សអតិបរមា</label>
                <input type="number" name="max_students" class="form-control" value="{{ $class->max_students }}" required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="fas fa-save me-2"></i>រក្សាទុក</button>
                <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">បោះបង់</a>
            </div>
        </form>
    </div>
</div>
@endsection
