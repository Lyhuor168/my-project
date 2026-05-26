@extends('layouts.master')
@section('title', 'Print Report')
@section('content')
<style>
.report-card{background:#fff;border-radius:16px;border:1px solid #E2E8F0;padding:24px;box-shadow:0 4px 20px rgba(0,0,0,0.05);}
.pct-badge{display:inline-block;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:700;}
@media print{.no-print{display:none!important;}.report-card{box-shadow:none;border:none;}}
</style>

<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <h4 class="fw-bold">📊Print Report — វត្តមានសិស្ស</h4>
    <button onclick="window.print()" class="btn btn-dark px-4">
        🖨️Print PDF
    </button>
</div>

{{-- Filter --}}
<div class="report-card mb-4 no-print">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label fw-bold small text-muted text-uppercase">ថ្នាក់</label>
            <select name="class_id" class="form-select">
                <option value="">-- ថ្នាក់ទាំងអស់ --</option>
                @foreach($classes as $class)
                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-bold small text-muted text-uppercase">ខែ</label>
            <select name="month" class="form-select">
                @foreach(range(1,12) as $m)
                <option value="{{ $m }}" {{ request('month', date('n')) == $m ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($m)->format('m') }} — {{ ['មករា','កុម្ភៈ','មីនា','មេសា','ឧសភា','មិថុនា','កក្កដា','សីហា','កញ្ញា','តុលា','វិច្ឆិកា','ធ្នូ'][$m-1] }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary px-4">
                🔍 ស្វែងរក
            </button>
        </div>
    </form>
</div>

{{-- Print Header --}}
<div class="text-center mb-4" style="display:none;" id="printHeader">
    <h3 class="fw-bold">SCHOOL SYSTEM</h3>
    <p class="text-muted">របាយការណ៍វត្តមានសិស្ស — {{ now()->format('d/m/Y') }}</p>
    <hr>
</div>

{{-- Summary Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="report-card text-center" style="border-top:4px solid #2563EB;">
            <div style="font-size:2rem;font-weight:800;color:#2563EB;">{{ $summary['present'] }}</div>
            <div class="text-muted small fw-bold text-uppercase">Present</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="report-card text-center" style="border-top:4px solid #DC2626;">
            <div style="font-size:2rem;font-weight:800;color:#DC2626;">{{ $summary['absent'] }}</div>
            <div class="text-muted small fw-bold text-uppercase">Absent</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="report-card text-center" style="border-top:4px solid #D97706;">
            <div style="font-size:2rem;font-weight:800;color:#D97706;">{{ $summary['late'] }}</div>
            <div class="text-muted small fw-bold text-uppercase">Late</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="report-card text-center" style="border-top:4px solid #059669;">
            <div style="font-size:2rem;font-weight:800;color:#059669;">{{ $summary['excused'] }}</div>
            <div class="text-muted small fw-bold text-uppercase">Excused</div>
        </div>
    </div>
</div>

{{-- Per Student Report --}}
<div class="report-card">
    <h6 class="fw-bold text-muted text-uppercase mb-3" style="font-size:11px;letter-spacing:0.1em;">
        👥 វត្តមានតាមសិស្ស
    </h6>
    <table class="table table-hover mb-0" id="reportTable">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>សិស្ស</th>
                <th>ថ្នាក់</th>
                <th class="text-center">Present</th>
                <th class="text-center">Absent</th>
                <th class="text-center">Late</th>
                <th class="text-center">%</th>
            </tr>
        </thead>
        <tbody>
            @php
                $studentStats = $attendances->groupBy('student_id');
            @endphp
            @forelse($studentStats as $studentId => $records)
            @php
                $present = $records->where('status','present')->count();
                $absent  = $records->where('status','absent')->count();
                $late    = $records->where('status','late')->count();
                $total   = $records->count();
                $pct     = $total > 0 ? round($present / $total * 100) : 0;
                $student = $records->first()->student;
                $class   = $records->first()->schoolClass;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="fw-bold">{{ $student->name ?? '-' }}</td>
                <td>{{ $class->name ?? '-' }}</td>
                <td class="text-center text-success fw-bold">{{ $present }}</td>
                <td class="text-center text-danger fw-bold">{{ $absent }}</td>
                <td class="text-center text-warning fw-bold">{{ $late }}</td>
                <td class="text-center">
                    <span class="pct-badge" style="background:{{ $pct>=80?'#D1FAE5':($pct>=60?'#FEF3C7':'#FEE2E2') }};color:{{ $pct>=80?'#065F46':($pct>=60?'#92400E':'#991B1B') }}">
                        {{ $pct }}%
                    </span>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted py-4">មិនទាន់មានទិន្នន័យ</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
window.onbeforeprint = function() {
    document.getElementById('printHeader').style.display = 'block';
}
window.onafterprint = function() {
    document.getElementById('printHeader').style.display = 'none';
}
</script>
@endsection