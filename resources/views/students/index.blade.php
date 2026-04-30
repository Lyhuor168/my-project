@extends('layouts.master')
@section('title', 'សិស្សទាំងអស់')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold"><i class="fas fa-user-graduate me-2 text-primary"></i>សិស្សទាំងអស់</h4>
    <a href="{{ route('students.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> បន្ថែមសិស្ស
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>ឈ្មោះ</th>
                    <th>ភេទ</th>
                    <th>ថ្នាក់</th>
                    <th>លេខទូរស័ព្ទ</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $i => $student)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->gender ?? '-' }}</td>
                    <td>{{ $student->schoolClass->name ?? '-' }}</td>
                    <td>{{ $student->phone ?? '-' }}</td>
                    <td>
                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('students.destroy', $student->id) }}" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('លុបទេ?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">មិនមានសិស្ស</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
