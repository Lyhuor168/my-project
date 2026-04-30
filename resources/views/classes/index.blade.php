@extends('layouts.dashboard')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">ថ្នាក់រៀនទាំងអស់</h4>
    <a href="{{ route('classes.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>បង្កើតថ្នាក់</a>
</div>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="row g-3">
@forelse($classes as $class)
<div class="col-md-4">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold">{{ $class->name }}</h5>
            <span class="badge bg-primary mb-2">{{ $class->code }}</span>
            <p class="text-muted small mb-2">{{ $class->description ?? 'គ្មានការពិពណ៌នា' }}</p>
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small"><i class="fas fa-users me-1"></i>{{ $class->students_count }}/{{ $class->max_students }} សិស្ស</span>
                <div class="d-flex gap-2">
                    <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{ route('classes.destroy', $class->id) }}" onsubmit="return confirm('លុប?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-12"><div class="alert alert-info">មិនទាន់មាន Class ទេ — <a href="{{ route('classes.create') }}">បង្កើតថ្មី</a></div></div>
@endforelse
</div>
@endsection
