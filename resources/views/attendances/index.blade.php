@extends('layouts.master')
@section('title', 'វត្តមាន')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="fas fa-clipboard-check me-2 text-primary"></i>វត្តមានសិស្ស</h4>
    <a href="{{ route('attendances.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> កត់វត្តមាន
    </a>
</div>

{{-- Filter --}}
<form method="GET" class="row g-2 mb-4">
    <div class="col-md-4">
        <select name="class_id" class="form-select" onchange="this.form.submit()">
            <option value="">-- ជ្រើសថ្នាក់ --</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ $selectedClass == $class->id ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <input type="date" name="date" class="form-control" value="{{ $selectedDate }}" onchange="this.form.submit()">
    </div>
</form>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>សិស្ស</th>
                    <th>ថ្នាក់</th>
                    <th>ថ្ងៃ</th>
                    <th>វត្តមាន</th>
                    <th>កំណត់ចំណាំ</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $i => $att)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $att->student->name ?? '-' }}</td>
                    <td>{{ $att->schoolClass->name ?? '-' }}</td>
                    <td>{{ $att->date }}</td>
                    <td>
                        @if($att->status === 'present')
                            <span class="badge bg-success">Present</span>
                        @elseif($att->status === 'absent')
                            <span class="badge bg-danger">Absent</span>
                        @else
                            <span class="badge bg-warning text-dark">Late</span>
                        @endif
                    </td>
                    <td>{{ $att->note ?? '-' }}</td>
                    <td>
                        <form method="POST" action="{{ route('attendances.destroy', $att->id) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('លុបទេ?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4 text-muted">មិនមានទិន្នន័យ</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
