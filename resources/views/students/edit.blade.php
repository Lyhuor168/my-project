@extends('layouts.master')
@section('title', 'កែសិស្ស')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="fas fa-user-edit me-2 text-warning"></i>កែព័ត៌មានសិស្ស</h4>
    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">
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
        <form method="POST" action="{{ route('students.update', $student->id) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">ឈ្មោះ</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $student->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">ភេទ</label>
                    <select name="gender" class="form-select">
                        <option value="">-- ជ្រើស --</option>
                        <option value="male" {{ $student->gender=='male' ? 'selected' : '' }}>ប្រុស</option>
                        <option value="female" {{ $student->gender=='female' ? 'selected' : '' }}>ស្រី</option>
                        <option value="other" {{ $student->gender=='other' ? 'selected' : '' }}>ផ្សេងៗ</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">ថ្នាក់</label>
                    <select name="class_id" class="form-select" required>
                        <option value="">-- ជ្រើសថ្នាក់ --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $student->class_id==$class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">លេខទូរស័ព្ទ</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $student->phone) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">អ៊ីម៉ែល</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">ថ្ងៃខែឆ្នាំកំណើត</label>
                    <input type="date" name="dob" class="form-control" value="{{ old('dob', $student->dob) }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">អាសយដ្ឋាន</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address', $student->address) }}</textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save me-1"></i> រក្សាទុក
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
