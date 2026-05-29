@extends("layouts.master")
@section("title", "My Requests")
@section("content")
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">📋សំណើវត្តមានរបស់ខ្ញុំ</h4>
    <a href="{{ route("attendance-requests.create") }}" class="btn btn-primary">➕ Submit Request</a>
</div>
<div class="card shadow-sm" style="border-radius:14px;border:none;">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr><th>#</th><th>ថ្ងៃ</th><th>ថ្នាក់</th><th>មូលហេតុ</th><th>Status</th><th>កំណត់ចំណាំ</th></tr>
            </thead>
            <tbody>
                @forelse($requests as $i => $req)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $req->date->format("d/m/Y") }}</td>
                    <td>{{ $req->schoolClass->name ?? "-" }}</td>
                    <td>{{ $req->reason }}</td>
                    <td>
                        @if($req->status === "pending")
                            <span class="badge bg-warning text-dark">⏳ Pending</span>
                        @elseif($req->status === "approved")
                            <span class="badge bg-success">✅ Approved</span>
                        @else
                            <span class="badge bg-danger">❌ Rejected</span>
                        @endif
                    </td>
                    <td>{{ $req->note ?? "-" }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">មិនទាន់មានសំណើ</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection