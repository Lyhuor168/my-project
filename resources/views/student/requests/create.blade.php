@extends("layouts.master")
@section("title", "Submit Attendance Request")
@section("content")
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">📨Submit Attendance Request</h4>
    <a href="{{ route('attendance-requests.my') }}" class="btn btn-outline-secondary">← Back</a>
</div>
<div class="card shadow-sm" style="border-radius:14px;border:none;">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('attendance-requests.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">ថ្នាក់រៀន</label>
                    <select name="class_id" class="form-select" required>
                        <option value="">-- ជ្រើសថ្នាក់ --</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">ថ្ងៃខែ</label>
                    <input type="date" name="date" class="form-control" value="{{ today()->format("Y-m-d") }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">មូលហេតុ</label>
                    <textarea name="reason" class="form-control" rows="4" placeholder="សូមបំពេញមូលហេតុ..." required></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary px-4">📨 ផ្ញើសំណើ</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection