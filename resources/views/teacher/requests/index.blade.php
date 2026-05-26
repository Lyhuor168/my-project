@extends("layouts.master")
@section("title", "Review Requests")
@section("content")
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">📬Review Attendance Requests</h4>
</div>
<div class="card shadow-sm" style="border-radius:14px;border:none;">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr><th>#</th><th>សិស្ស</th><th>ថ្នាក់</th><th>ថ្ងៃ</th><th>មូលហេតុ</th><th>Status</th><th>Action</th></tr>
            </thead>
            <tbody>
                @forelse($requests as $i => $req)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $req->student->name ?? "-" }}</td>
                    <td>{{ $req->schoolClass->name ?? "-" }}</td>
                    <td>{{ $req->date->format("d/m/Y") }}</td>
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
                    <td>
                        @if($req->status === "pending")
                        <form method="POST" action="{{ route("teacher.requests.approve", $req->id) }}" style="display:inline;">
                            @csrf
                            <button class="btn btn-sm btn-success">✅</button>
                        </form>
                        <form method="POST" action="{{ route("teacher.requests.reject", $req->id) }}" style="display:inline;">
                            @csrf
                            <input type="hidden" name="note" value="Rejected by teacher">
                            <button class="btn btn-sm btn-danger">❌</button>
                        </form>
                        @else
                            <span class="text-muted small">Reviewed</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">មិនទាន់មានសំណើ</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection