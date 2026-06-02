@extends('layouts.master')
@section('title', 'របាយការណ៍ប្រចាំថ្ងៃ')
@section('content')

<style>
.dr-wrap { max-width: 1100px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }

.dr-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(26,35,126,0.08); }
.dr-header-left { display: flex; align-items: center; gap: 14px; }
.dr-icon { width: 52px; height: 52px; border-radius: 16px; background: linear-gradient(135deg,#00695c,#00897b); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; box-shadow: 0 6px 18px rgba(0,105,92,0.28); }
.dr-title { font-size: 1.4rem; font-weight: 700; color: #1a237e; margin: 0; }
.dr-sub { font-size: 0.8rem; color: #6b7280; margin-top: 2px; }
.dr-breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 0.75rem; color: #9ca3af; margin-bottom: 4px; }
.dr-breadcrumb a { color: #3949ab; text-decoration: none; }

.dr-btn { display: inline-flex; align-items: center; gap: 7px; border-radius: 10px; padding: 9px 18px; font-size: 0.85rem; font-weight: 600; text-decoration: none; cursor: pointer; border: none; font-family: 'Kantumruy Pro','Outfit',sans-serif; transition: all 0.15s; }
.dr-btn-primary { background: linear-gradient(135deg,#1a237e,#3949ab); color: #fff; box-shadow: 0 4px 14px rgba(26,35,126,0.25); }
.dr-btn-primary:hover { opacity: 0.9; color: #fff; }
.dr-btn-outline { background: #fff; color: #374151; border: 1.5px solid rgba(26,35,126,0.15); }
.dr-btn-outline:hover { border-color: #1a237e; color: #1a237e; background: #e8eaf6; }

.dr-filter-card { background: #fff; border-radius: 16px; border: 1px solid rgba(26,35,126,0.07); box-shadow: 0 4px 20px rgba(26,35,126,0.05); padding: 1.25rem 1.5rem; margin-bottom: 1.5rem; display: flex; align-items: flex-end; gap: 1rem; flex-wrap: wrap; }
.dr-filter-field { display: flex; flex-direction: column; gap: 5px; min-width: 160px; }
.dr-filter-field label { font-size: 0.72rem; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.05em; }
.dr-select, .dr-input { padding: 9px 12px; background: #f8faff; border: 1.5px solid rgba(26,35,126,0.1); border-radius: 10px; font-family: 'Kantumruy Pro','Outfit',sans-serif; font-size: 0.875rem; color: #111827; }
.dr-select:focus, .dr-input:focus { outline: none; border-color: #1a237e; }

.dr-stat-row { display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem; margin-bottom: 1.5rem; }
@media (max-width: 600px) { .dr-stat-row { grid-template-columns: repeat(2,1fr); } }
.dr-stat { background: #fff; border-radius: 14px; border: 1px solid rgba(26,35,126,0.07); padding: 1.1rem; text-align: center; box-shadow: 0 2px 12px rgba(26,35,126,0.04); }
.dr-stat-num { font-size: 1.6rem; font-weight: 800; margin-bottom: 2px; }
.dr-stat-lbl { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; }
.s-present .dr-stat-num { color: #2e7d32; } .s-present .dr-stat-lbl { color: #4caf50; }
.s-absent  .dr-stat-num { color: #c62828; } .s-absent  .dr-stat-lbl { color: #e57373; }
.s-late    .dr-stat-num { color: #f57f17; } .s-late    .dr-stat-lbl { color: #ffb300; }
.s-excused .dr-stat-num { color: #1a237e; } .s-excused .dr-stat-lbl { color: #3949ab; }

.dr-card { background: #fff; border-radius: 16px; border: 1px solid rgba(26,35,126,0.07); box-shadow: 0 4px 20px rgba(26,35,126,0.05); overflow: hidden; }
.dr-card-head { padding: 1rem 1.5rem; background: #fafbff; border-bottom: 1px solid rgba(26,35,126,0.07); display: flex; align-items: center; justify-content: space-between; }
.dr-card-head h5 { font-size: 0.9rem; font-weight: 700; color: #1a237e; margin: 0; }

.dr-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
.dr-table th { padding: 11px 14px; background: #fafbff; font-size: 0.72rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid rgba(26,35,126,0.08); text-align: left; }
.dr-table td { padding: 11px 14px; border-bottom: 1px solid rgba(26,35,126,0.05); color: #374151; vertical-align: middle; }
.dr-table tr:last-child td { border-bottom: none; }
.dr-table tr:hover td { background: #fafbff; }

.badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 700; }
.badge-present { background: #e8f5e9; color: #2e7d32; }
.badge-absent  { background: #ffebee; color: #c62828; }
.badge-late    { background: #fff8e1; color: #f57f17; }
.badge-excused { background: #e8eaf6; color: #1a237e; }

.dr-empty { text-align: center; padding: 3rem; color: #9ca3af; font-size: 0.875rem; }
.dr-alert { padding: 0.9rem 1.25rem; border-radius: 12px; font-size: 0.87rem; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; }
.dr-alert-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
</style>

<div class="dr-wrap">

    @if(session('success'))
        <div class="dr-alert dr-alert-success">✅ {{ session('success') }}</div>
    @endif

    {{-- Header --}}
    <div class="dr-header">
        <div class="dr-header-left">
            <div class="dr-icon">📊</div>
            <div>
                <div class="dr-breadcrumb">
                    <a href="/">Home</a> /
                    <a href="{{ route('attendances.index') }}">Attendances</a> /
                    <span>Daily Report</span>
                </div>
                <h1 class="dr-title">របាយការណ៍ប្រចាំថ្ងៃ</h1>
                <div class="dr-sub">Daily Attendance Report — {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}</div>
            </div>
        </div>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('attendances.create') }}" class="dr-btn dr-btn-primary">+ កត់វត្តមាន</a>
            <a href="{{ route('attendances.index') }}" class="dr-btn dr-btn-outline">← ត្រឡប់</a>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('attendances.daily') }}">
        <div class="dr-filter-card">
            <div class="dr-filter-field">
                <label>ថ្ងៃ / Date</label>
                <input type="date" name="date" class="dr-input" value="{{ $selectedDate }}"/>
            </div>
            <div class="dr-filter-field">
                <label>ថ្នាក់ / Class</label>
                <select name="class_id" class="dr-select">
                    <option value="">ទាំងអស់</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $selectedClass == $class->id ? 'selected':'' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="dr-btn dr-btn-primary">🔍 ស្វែងរក</button>
            <a href="{{ route('attendances.daily') }}" class="dr-btn dr-btn-outline">↺ Reset</a>
        </div>
    </form>

    {{-- Stats --}}
    <div class="dr-stat-row">
        <div class="dr-stat s-present">
            <div class="dr-stat-num">{{ $summary['present'] }}</div>
            <div class="dr-stat-lbl">Present</div>
        </div>
        <div class="dr-stat s-absent">
            <div class="dr-stat-num">{{ $summary['absent'] }}</div>
            <div class="dr-stat-lbl">Absent</div>
        </div>
        <div class="dr-stat s-late">
            <div class="dr-stat-num">{{ $summary['late'] }}</div>
            <div class="dr-stat-lbl">Late</div>
        </div>
        <div class="dr-stat s-excused">
            <div class="dr-stat-num">{{ $summary['excused'] }}</div>
            <div class="dr-stat-lbl">Excused</div>
        </div>
    </div>

    {{-- Table --}}
    <div class="dr-card">
        <div class="dr-card-head">
            <h5>📋 បញ្ជីវត្តមាន — {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}</h5>
            <span style="font-size:0.8rem;color:#6b7280;">{{ $attendances->count() }} កំណត់ត្រា</span>
        </div>
        @if($attendances->isEmpty())
            <div class="dr-empty">⚠️ មិនទាន់មានវត្តមានសម្រាប់ថ្ងៃនេះ</div>
        @else
            <table class="dr-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>សិស្ស</th>
                        <th>ថ្នាក់</th>
                        <th>ស្ថានភាព</th>
                        <th>កំណត់ចំណាំ</th>
                        <th>សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $i => $att)
                    <tr>
                        <td style="color:#9ca3af;">{{ $i + 1 }}</td>
                        <td>
                            <div style="font-weight:600;color:#111827;">{{ $att->student->name ?? '—' }}</div>
                        </td>
                        <td>{{ $att->schoolClass->name ?? '—' }}</td>
                        <td><span class="badge badge-{{ $att->status }}">{{ strtoupper($att->status) }}</span></td>
                        <td style="color:#6b7280;">{{ $att->note ?? '—' }}</td>
                        <td>
                            <a href="{{ route('attendances.edit', $att) }}"
                               style="font-size:0.78rem;color:#3949ab;text-decoration:none;font-weight:600;">✏️ កែ</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>
@endsection
