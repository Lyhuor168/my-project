@extends('layouts.master')
@section('title', 'កត់វត្តមាន')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="fas fa-plus-circle me-2 text-primary"></i>កត់វត្តមានសិស្ស</h4>
    <a href="{{ route('attendances.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> ត្រឡប់
    </a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <label class="form-label fw-semibold">ថ្នាក់</label>
                <select name="class_id" class="form-select" onchange="this.form.submit()" required>
                    <option value="">-- ជ្រើសថ្នាក់ --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $selectedClass == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">ថ្ងៃ</label>
                <input type="date" name="date" class="form-control" value="{{ $date }}" onchange="this.form.submit()">
            </div>
        </form>
    </div>
</div>

@if($students->count() > 0)
<form method="POST" action="{{ route('attendances.store') }}">
    @csrf
    <input type="hidden" name="class_id" value="{{ $selectedClass }}">
    <input type="hidden" name="date" value="{{ $date }}">

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>ឈ្មោះសិស្ស</th>
                        <th>Present</th>
                        <th>Absent</th>
                        <th>Late</th>
                        <th>កំណត់ចំណាំ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $i => $student)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $student->name }}</td>
                        <td>
                            <input type="radio" name="attendance[{{ $student->id }}]"
                                value="present" checked class="form-check-input">
                        </td>
                        <td>
                            <input type="radio" name="attendance[{{ $student->id }}]"
                                value="absent" class="form-check-input">
                        </td>
                        <td>
                            <input type="radio" name="attendance[{{ $student->id }}]"
                                value="late" class="form-check-input">
                        </td>
                        <td>
                            <input type="text" name="notes[{{ $student->id }}]"
                                class="form-control form-control-sm" placeholder="កំណត់ចំណាំ...">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> រក្សាទុក
        </button>
    </div>
</form>
@elseif($selectedClass)
    <div class="alert alert-warning">គ្មានសិស្សក្នុងថ្នាក់នេះ!</div>
@else
    <div class="alert alert-info">សូមជ្រើសថ្នាក់ជាមុនសិន</div>
@endif
@endsection
