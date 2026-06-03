@extends("layouts.master")
@section("title", "Review Requests")
@section("content")
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold">📬 Review Attendance Requests</h4>
</div>
<div class="card shadow-sm" style="border-radius:14px;border:none;">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>សិស្ស</th>
                    <th>ថ្នាក់</th>
                    <th>ថ្ងៃ</th>
                    <th>មូលហេតុ</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $i => $req)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td><strong>{{ $req->student->name ?? "-" }}</strong></td>
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
                        @if($req->review_note)
                            <div class="text-muted small mt-1">📝 {{ $req->review_note }}</div>
                        @endif
                    </td>
                    <td>
                        @if($req->status === "pending")
                        <button class="btn btn-sm btn-outline-primary mb-1" onclick="document.getElementById('form-{{ $req->id }}').classList.toggle('d-none')">
                            ✏️ Review
                        </button>
                        <div id="form-{{ $req->id }}" class="d-none mt-2" style="min-width:220px;">
                            <form method="POST" action="{{ route('attendance-requests.review', $req->id) }}">
                                @csrf
                                <input type="text" name="review_note" class="form-control form-control-sm mb-2" placeholder="មូលហេតុ / កំណត់ចំណាំ...">
                                <div class="d-flex gap-1">
                                    <button type="submit" name="action" value="approved" class="btn btn-sm btn-success">✅ Approve</button>
                                    <button type="submit" name="action" value="rejected" class="btn btn-sm btn-danger">❌ Reject</button>
                                </div>
                            </form>
                        </div>
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
