@extends('layouts.master')
@section('title', 'ព័ត៌មានសិស្ស - ' . $student->name)
@section('content')

<style>
.sv-wrap { max-width: 1000px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }

.sv-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(26,35,126,0.08); }
.sv-header-left { display: flex; align-items: center; gap: 14px; }
.sv-avatar { width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg,#1a237e,#3949ab); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; font-weight: 700; flex-shrink: 0; box-shadow: 0 6px 18px rgba(26,35,126,0.28); }
.sv-title { font-size: 1.4rem; font-weight: 700; color: #1a237e; margin: 0; }
.sv-sub { font-size: 0.8rem; color: #6b7280; margin-top: 2px; }
.sv-breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 0.75rem; color: #9ca3af; margin-bottom: 4px; }
.sv-breadcrumb a { color: #3949ab; text-decoration: none; }
.sv-actions { display: flex; gap: 8px; flex-wrap: wrap; }

.sv-btn { display: inline-flex; align-items: center; gap: 7px; border-radius: 10px; padding: 9px 18px; font-size: 0.85rem; font-weight: 600; text-decoration: none; cursor: pointer; border: none; font-family: 'Kantumruy Pro','Outfit',sans-serif; transition: all 0.15s; }
.sv-btn-primary { background: linear-gradient(135deg,#1a237e,#3949ab); color: #fff; box-shadow: 0 4px 14px rgba(26,35,126,0.25); }
.sv-btn-primary:hover { opacity: 0.9; transform: translateY(-1px); color: #fff; }
.sv-btn-outline { background: #fff; color: #374151; border: 1.5px solid rgba(26,35,126,0.15); }
.sv-btn-outline:hover { border-color: #1a237e; color: #1a237e; background: #e8eaf6; }
.sv-btn-danger { background: #fff; color: #dc2626; border: 1.5px solid rgba(220,38,38,0.2); }
.sv-btn-danger:hover { background: #fef2f2; border-color: #dc2626; }

.sv-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
@media (max-width: 700px) { .sv-grid { grid-template-columns: 1fr; } }

.sv-card { background: #fff; border-radius: 16px; border: 1px solid rgba(26,35,126,0.07); box-shadow: 0 4px 20px rgba(26,35,126,0.05); overflow: hidden; }
.sv-card-head { padding: 1rem 1.5rem; background: #fafbff; border-bottom: 1px solid rgba(26,35,126,0.07); display: flex; align-items: center; gap: 8px; }
.sv-card-head h5 { font-size: 0.9rem; font-weight: 700; color: #1a237e; margin: 0; }
.sv-card-body { padding: 1.5rem; }

.sv-info-row { display: flex; align-items: flex-start; gap: 12px; padding: 10px 0; border-bottom: 1px solid rgba(26,35,126,0.05); }
.sv-info-row:last-child { border-bottom: none; }
.sv-info-icon { width: 32px; height: 32px; border-radius: 8px; background: #e8eaf6; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; flex-shrink: 0; }
.sv-info-label { font-size: 0.72rem; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 2px; }
.sv-info-value { font-size: 0.875rem; color: #111827; font-weight: 500; }

.sv-stat-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 10px; }
@media (max-width: 500px) { .sv-stat-grid { grid-template-columns: repeat(2,1fr); } }
.sv-stat { text-align: center; padding: 14px 8px; border-radius: 12px; }
.sv-stat-num { font-size: 1.5rem; font-weight: 800; margin-bottom: 2px; }
.sv-stat-lbl { font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; }
.stat-present { background: #e8f5e9; } .stat-present .sv-stat-num { color: #2e7d32; } .stat-present .sv-stat-lbl { color: #4caf50; }
.stat-absent  { background: #ffebee; } .stat-absent  .sv-stat-num { color: #c62828; } .stat-absent  .sv-stat-lbl { color: #e57373; }
.stat-late    { background: #fff8e1; } .stat-late    .sv-stat-num { color: #f57f17; } .stat-late    .sv-stat-lbl { color: #ffb300; }
.stat-excused { background: #e8eaf6; } .stat-excused .sv-stat-num { color: #1a237e; } .stat-excused .sv-stat-lbl { color: #3949ab; }

.sv-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 700; }
.badge-present { background: #e8f5e9; color: #2e7d32; }
.badge-absent  { background: #ffebee; color: #c62828; }
.badge-late    { background: #fff8e1; color: #f57f17; }
.badge-excused { background: #e8eaf6; color: #1a237e; }
.badge-male    { background: #e3f2fd; color: #1565c0; }
.badge-female  { background: #fce4ec; color: #880e4f; }
.badge-other   { background: #f3f4f6; color: #374151; }

.sv-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
.sv-table th { padding: 10px 12px; background: #fafbff; font-size: 0.72rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid rgba(26,35,126,0.08); text-align: left; }
.sv-table td { padding: 10px 12px; border-bottom: 1px solid rgba(26,35,126,0.05); color: #374151; vertical-align: middle; }
.sv-table tr:last-child td { border-bottom: none; }
.sv-table tr:hover td { background: #fafbff; }
.sv-empty { text-align: center; padding: 2rem; color: #9ca3af; font-size: 0.875rem; }

.sv-rate-bar { height: 6px; background: #e8eaf6; border-radius: 3px; margin-top: 6px; overflow: hidden; }
.sv-rate-fill { height: 100%; border-radius: 3px; background: linear-gradient(90deg,#1a237e,#3949ab); transition: width 0.6s ease; }

.sv-alert { padding: 0.9rem 1.25rem; border-radius: 12px; font-size: 0.87rem; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; }
.sv-alert-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
</style>

<div class="sv-wrap">

    @if(session('success'))
        <div class="sv-alert sv-alert-success">✅ {{ session('success') }}</div>
    @endif

    {{-- Header --}}
    <div class="sv-header">
        <div class="sv-header-left">
            <div class="sv-avatar">{{ mb_substr($student->name, 0, 1) }}</div>
            <div>
                <div class="sv-breadcrumb">
                    <a href="/">Home</a> /
                    <a href="{{ route('students.index') }}">Students</a> /
                    <span>{{ $student->name }}</span>
                </div>
                <h1 class="sv-title">{{ $student->name }}</h1>
                <div class="sv-sub">{{ $student->schoolClass->name ?? 'មិនមានថ្នាក់' }} · ID #{{ $student->id }}</div>
            </div>
        </div>
        <div class="sv-actions">
            <a href="{{ route('students.edit', $student) }}" class="sv-btn sv-btn-primary">✏️ កែប្រែ</a>
            <a href="{{ route('students.index') }}" class="sv-btn sv-btn-outline">← ត្រឡប់</a>
            <form action="{{ route('students.destroy', $student) }}" method="POST" onsubmit="return confirm('លុប {{ $student->name }}?')">
                @csrf @method('DELETE')
                <button type="submit" class="sv-btn sv-btn-danger">🗑️ លុប</button>
            </form>
        </div>
    </div>

    {{-- Stats --}}
    @php
        $attendances = $student->attendances()->latest()->get();
        $total    = $attendances->count();
        $present  = $attendances->where('status','present')->count();
        $absent   = $attendances->where('status','absent')->count();
        $late     = $attendances->where('status','late')->count();
        $excused  = $attendances->where('status','excused')->count();
        $rate     = $total > 0 ? round(($present / $total) * 100) : 0;
    @endphp

    <div class="sv-card" style="margin-bottom:1.25rem;">
        <div class="sv-card-head"><h5>📊 វត្តមានសង្ខេប</h5></div>
        <div class="sv-card-body">
            <div class="sv-stat-grid">
                <div class="sv-stat stat-present">
                    <div class="sv-stat-num">{{ $present }}</div>
                    <div class="sv-stat-lbl">Present</div>
                </div>
                <div class="sv-stat stat-absent">
                    <div class="sv-stat-num">{{ $absent }}</div>
                    <div class="sv-stat-lbl">Absent</div>
                </div>
                <div class="sv-stat stat-late">
                    <div class="sv-stat-num">{{ $late }}</div>
                    <div class="sv-stat-lbl">Late</div>
                </div>
                <div class="sv-stat stat-excused">
                    <div class="sv-stat-num">{{ $excused }}</div>
                    <div class="sv-stat-lbl">Excused</div>
                </div>
            </div>
            <div style="margin-top:1rem;">
                <div style="display:flex;justify-content:space-between;font-size:0.8rem;font-weight:600;color:#374151;">
                    <span>អត្រាវត្តមាន</span>
                    <span style="color:{{ $rate >= 80 ? '#2e7d32' : ($rate >= 60 ? '#f57f17' : '#c62828') }}">{{ $rate }}%</span>
                </div>
                <div class="sv-rate-bar"><div class="sv-rate-fill" style="width:{{ $rate }}%"></div></div>
            </div>
        </div>
    </div>

    <div class="sv-grid">
        {{-- Info --}}
        <div class="sv-card">
            <div class="sv-card-head"><h5>👤 ព័ត៌មានផ្ទាល់ខ្លួន</h5></div>
            <div class="sv-card-body">
                <div class="sv-info-row">
                    <div class="sv-info-icon">📛</div>
                    <div><div class="sv-info-label">ឈ្មោះ</div><div class="sv-info-value">{{ $student->name }}</div></div>
                </div>
                <div class="sv-info-row">
                    <div class="sv-info-icon">⚥</div>
                    <div>
                        <div class="sv-info-label">ភេទ</div>
                        <div class="sv-info-value">
                            <span class="sv-badge badge-{{ $student->gender ?? 'other' }}">
                                {{ $student->gender == 'male' ? '👦 ប្រុស' : ($student->gender == 'female' ? '👧 ស្រី' : 'មិនបញ្ជាក់') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="sv-info-row">
                    <div class="sv-info-icon">🎂</div>
                    <div>
                        <div class="sv-info-label">ថ្ងៃខួបកំណើត</div>
                        <div class="sv-info-value">
                            {{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d M Y') : '—' }}
                        </div>
                    </div>
                </div>
                <div class="sv-info-row">
                    <div class="sv-info-icon">📧</div>
                    <div><div class="sv-info-label">អ៊ីមែល</div><div class="sv-info-value">{{ $student->email ?? '—' }}</div></div>
                </div>
                <div class="sv-info-row">
                    <div class="sv-info-icon">📞</div>
                    <div><div class="sv-info-label">ទូរស័ព្ទ</div><div class="sv-info-value">{{ $student->phone ?? '—' }}</div></div>
                </div>
                <div class="sv-info-row">
                    <div class="sv-info-icon">🏠</div>
                    <div><div class="sv-info-label">អាសយដ្ឋាន</div><div class="sv-info-value">{{ $student->address ?? '—' }}</div></div>
                </div>
                <div class="sv-info-row">
                    <div class="sv-info-icon">🏫</div>
                    <div><div class="sv-info-label">ថ្នាក់</div><div class="sv-info-value">{{ $student->schoolClass->name ?? '—' }}</div></div>
                </div>
            </div>
        </div>

        {{-- Recent attendance --}}
        <div class="sv-card">
            <div class="sv-card-head"><h5>📅 វត្តមានថ្មីៗ</h5></div>
            <div class="sv-card-body" style="padding:0;">
                @if($attendances->isEmpty())
                    <div class="sv-empty">⚠️ មិនទាន់មានវត្តមាន</div>
                @else
                    <table class="sv-table">
                        <thead>
                            <tr>
                                <th>ថ្ងៃ</th>
                                <th>ស្ថានភាព</th>
                                <th>កំណត់ចំណាំ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances->take(10) as $att)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($att->date)->format('d M Y') }}</td>
                                <td><span class="sv-badge badge-{{ $att->status }}">{{ strtoupper($att->status) }}</span></td>
                                <td style="color:#9ca3af;">{{ $att->note ?? '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($attendances->count() > 10)
                        <div style="padding:10px 12px;font-size:0.78rem;color:#9ca3af;border-top:1px solid rgba(26,35,126,0.05);">
                            + {{ $attendances->count() - 10 }} កំណត់ត្រាទៀត
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

</div>
@endsection