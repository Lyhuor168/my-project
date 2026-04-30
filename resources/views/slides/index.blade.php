@extends('layouts.master')
@section('title', 'គ្រប់គ្រង Slides')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="fas fa-images me-2 text-primary"></i>គ្រប់គ្រង Slides</h4>
    <a href="{{ route('slides.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> បន្ថែម Slide
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-3">
    @forelse($slides as $slide)
    <div class="col-md-4 d-flex">
        <div class="card shadow-sm w-100" style="border-radius:12px;overflow:hidden;">
            <div style="height:200px;overflow:hidden;">
                <img src="{{ Storage::url($slide->image_path) }}"
                     class="w-100 h-100"
                     style="object-fit:cover;">
            </div>
            <div class="card-body d-flex flex-column" style="min-height:130px;">
                <h6 class="fw-bold mb-1" style="min-height:24px;">{{ $slide->title ?? 'គ្មានចំណងជើង' }}</h6>
                <p class="text-muted small flex-grow-1 mb-2" style="min-height:40px;">{{ $slide->subtitle ?? '-' }}</p>
                <div class="d-flex justify-content-between align-items-center mt-auto">
                    <span class="badge {{ $slide->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $slide->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    <div class="d-flex gap-2">
                        <a href="{{ route('slides.edit', $slide->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('slides.destroy', $slide->id) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('លុបទេ?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">មិនមាន Slides ទេ — បន្ថែមមួយ!</div>
    </div>
    @endforelse
</div>
@endsection
