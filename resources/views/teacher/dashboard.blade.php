@extends('layouts.master')
@section('title', 'Teacher Dashboard')
@section('content')
<style>
.dash-card{background:#fff;border-radius:16px;border:1px solid #E2E8F0;padding:24px;box-shadow:0 4px 20px rgba(0,0,0,0.05);}
.menu-item{display:flex;align-items:center;gap:16px;padding:18px 20px;border-radius:14px;text-decoration:none;color:#1e293b;font-weight:600;font-size:15px;transition:all 0.2s;border:1px solid #E2E8F0;background:#fff;margin-bottom:10px;}
.menu-item:hover{background:#EFF6FF;border-color:#BFDBFE;color:#1D4ED8;transform:translateX(4px);}
.menu-ico{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;}
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">👨‍🏫 Teacher Dashboard</h4>
        <p class="text-muted mb-0 small">{{ now()->format("d/m/Y") }} — សួស្តី <strong>{{ Auth::user()->name }}</strong>!</p>
    </div>
    <a href="{{ route("attendances.create") }}" style="background:#2563EB;color:#fff;padding:10px 24px;border-radius:10px;text-decoration:none;font-weight:700;font-size:14px;">
        ➕ កត់វត្តមាន
    </a>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="dash-card text-center" style="border-top:4px solid #2563EB;">
            <div style="font-size:36px;margin-bottom:8px;">👨‍🎓</div>
            <div style="font-size:2.4rem;font-weight:800;color:#2563EB;line-height:1;">{{ $totalStudents }}</div>
            <div class="text-muted small fw-bold text-uppercase mt-1">សិស្សទាំងអស់</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="dash-card text-center" style="border-top:4px solid #059669;">
            <div style="font-size:36px;margin-bottom:8px;">🏫</div>
            <div style="font-size:2.4rem;font-weight:800;color:#059669;line-height:1;">{{ $totalClasses }}</div>
            <div class="text-muted small fw-bold text-uppercase mt-1">ថ្នាក់រៀន</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="dash-card text-center" style="border-top:4px solid #7C3AED;">
            <div style="font-size:36px;margin-bottom:8px;">✅</div>
            <div style="font-size:2.4rem;font-weight:800;color:#7C3AED;line-height:1;">{{ $attendanceSummary["present"] }}</div>
            <div class="text-muted small fw-bold text-uppercase mt-1">មានវត្តមានថ្ងៃនេះ</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="dash-card text-center" style="border-top:4px solid #DC2626;">
            <div style="font-size:36px;margin-bottom:8px;">❌</div>
            <div style="font-size:2.4rem;font-weight:800;color:#DC2626;line-height:1;">{{ $attendanceSummary["absent"] }}</div>
            <div class="text-muted small fw-bold text-uppercase mt-1">អវត្តមានថ្ងៃនេះ</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="dash-card h-100">
            <h6 class="fw-bold text-muted text-uppercase mb-3" style="font-size:11px;letter-spacing:0.1em;">📋 MENU</h6>
            <a href="{{ route("attendances.create") }}" class="menu-item">
                <div class="menu-ico" style="background:#DBEAFE;">📝</div>
                <div>
                    <div>កត់វត្តមាន</div>
                    <div class="text-muted" style="font-size:12px;font-weight:400;">Take attendance</div>
                </div>
            </a>
            <a href="{{ route("attendances.index") }}" class="menu-item">
                <div class="menu-ico" style="background:#D1FAE5;">📋</div>
                <div>
                    <div>មើលវត្តមាន</div>
                    <div class="text-muted" style="font-size:12px;font-weight:400;">View attendance</div>
                </div>
            </a>
            <a href="{{ route("attendances.report") }}" class="menu-item">
                <div class="menu-ico" style="background:#FEF3C7;">🖨️</div>
                <div>
                    <div>Print Reports</div>
                    <div class="text-muted" style="font-size:12px;font-weight:400;">Print attendance report</div>
                </div>
            </a>
            <a href="{{ route("attendances.index") }}" class="menu-item">
                <div class="menu-ico" style="background:#EDE9FE;">📬</div>
                <div>
                    <div>Manage Requests</div>
                    <div class="text-muted" style="font-size:12px;font-weight:400;">Review student requests</div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-8">
        <div class="dash-card h-100">
            <h6 class="fw-bold text-muted text-uppercase mb-3" style="font-size:11px;letter-spacing:0.1em;">📅 វត្តមានថ្ងៃនេះ</h6>
            <table class="table table-hover mb-0">
                <thead style="background:#F8FAFC;">
                    <tr>
                        <th style="font-size:12px;color:#64748B;font-weight:700;">សិស្ស</th>
                        <th style="font-size:12px;color:#64748B;font-weight:700;">ថ្នាក់</th>
                        <th style="font-size:12px;color:#64748B;font-weight:700;">វត្តមាន</th>
                        <th style="font-size:12px;color:#64748B;font-weight:700;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendanceToday as $att)
                    <tr>
                        <td class="fw-bold">{{ $att->student->name ?? "-" }}</td>
                        <td>{{ $att->schoolClass->name ?? "-" }}</td>
                        <td>
                            @if($att->status === "present")
                                <span style="background:#D1FAE5;color:#065F46;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:700;">✅ មានវត្តមាន</span>
                            @elseif($att->status === "absent")
                                <span style="background:#FEE2E2;color:#991B1B;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:700;">❌ អវត្តមាន</span>
                            @else
                                <span style="background:#FEF3C7;color:#92400E;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:700;">⏰ មកយឺត</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route("attendances.edit",$att->id) }}" style="background:#FEF3C7;color:#92400E;padding:6px 14px;border-radius:8px;text-decoration:none;font-size:12px;font-weight:700;">✏️ កែ</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div style="font-size:40px;margin-bottom:8px;">📭</div>
                            <div class="text-muted">មិនទាន់មានវត្តមាន — <a href="{{ route("attendances.create") }}">កត់វត្តមាន</a></div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection