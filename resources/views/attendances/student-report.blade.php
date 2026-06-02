@extends('layouts.master')
@section('title', 'របាយការណ៍សិស្ស')
@section('content')

<style>
.sr-wrap { max-width: 1000px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }

.sr-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(26,35,126,0.08); }
.sr-header-left { display: flex; align-items: center; gap: 14px; }
.sr-icon { width: 52px; height: 52px; border-radius: 16px; background: linear-gradient(135deg,#6a1b9a,#8e24aa); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; box-shadow: 0 6px 18px rgba(106,27,154,0.28); }
.sr-title { font-size: 1.4rem; font-weight: 700; color: #1a237e; margin: 0; }
.sr-sub { font-size: 0.8rem; color: #6b7280; margin-top: 2px; }
.sr-breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 0.75rem; color: #9ca3af; margin-bottom: 4px; }
.sr-breadcrumb a { color: #3949ab; text-decoration: none; }

.sr-btn { display: inline-flex; align-items: center; gap: 7px; border-radius: 10px; padding: 9px 18px; font-size: 0.85rem; font-weight: 600; text-decoration: none; cursor: pointer; border: none; font-family: 'Kantumruy Pro','Outfit',sans-serif; transition: all 0.15s; }
.sr-btn-primary { background: linear-gradient(135deg,#1a237e,#3949ab); color: #fff; box-shadow: 0 4px 14px rgba(26,35,126,0.25); }
.sr-btn-primary:hover { opacity: 0.9; color: #fff; }
.sr-btn-outline { background: #fff; color: #374151; border: 1.5px solid rgba(26,35,126,0.15); }
.sr-btn-outline:hover { border-color: #1a237e; color: #1a237e; background: #e8eaf6; }

.sr-filter-card { background: #fff; border-radius: 16px; border: 1px solid rgba(26,35,126,0.07); box-shadow: 0 4px 20px rgba(26,35,126,0.05); padding: 1.25rem 1.5rem; margin-bottom: 1.5rem; display: flex; align-items: flex-end; gap: 1rem; flex-wrap: wrap; }
.sr-filter-field { display: flex; flex-direction: column; gap: 5px; min-width: 180px; }
.sr-filter-field label { font-size: 0.72rem; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.05em; }
.sr-select { padding: 9px 12px; background: #f8faff; border: 1.5px solid rgba(26,35,126,0.1); border-radius: 10px; font-family: 'Kantumruy Pro','Outfit',sans-serif; font-size: 0.875rem; color: #111827; }
.sr-select:focus { outline: none; border-color: #1a237e; }

.sr-profile { background: #fff; border-radius: 16px; border: 1px solid rgba(26,35,126,0.07); box-shadow: 0 4px 20px rgba(26,35,126,0.05); padding: 1.5rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; }
.sr-avatar { width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg,#1a237e,#3949ab); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; font-weight: 700; flex-shrink: 0; }
.sr-profile-name { font-size: 1.2rem; font-weight: 700; color: #1a237e; }
.sr-profile-meta { font-size: 0.8rem; color: #6b7280; margin-top: 3px; }

.sr-stat-row { display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem; margin-bottom: 1.5rem; }
@media (max-width: 600px) { .sr-stat-row { grid-template-columns: repeat(2,1fr); } }
.sr-stat { background: #fff; border-radius: 14px; border: 1px solid rgba(26,35,126,0.07); padding: 1.1rem; text-align: center; box-shadow: 0 2px 12px rgba(26,35,126,0.04); }
.sr-stat-num { font-size: 1.6rem; font-weight: 800; margin-bottom: 2px; }
.sr-stat-lbl { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; }
.s-present .sr-stat-num { color: #2e7d32; } .s-present .sr-stat-lbl { color: #4caf50; }
.s-absent  .sr-stat-num { color: #c62828; } .s-absent  .sr-stat-lbl { color: #e57373; }
.s-late    .sr-stat-num { color: #f57f17; } .s-late    .sr-stat-lbl { color: #ffb300; }
.s-excused .sr-stat-num { color: #1a237e; } .s-excused .sr-stat-lbl { color: #3949ab; }

.sr-rate-bar { height: 8px; background: #e8eaf6; border-radius: 4px; margin-top: 8px; overflow: hidden; }
.sr-rate-fill { height: 100%; border-radius: 4px; background: linear-gradient(90deg,#1a237e,#3949ab); }

.sr-card { background: #fff; border-radius: 16px; border: 1px solid rgba(26,35,126,0.07); box-shadow: 0 4px 20px rgba(26,35,126,0.05); overflow: hidden; }
.sr-card-head { padding: 1rem 1.5rem; background: #fafbff; border-bottom: 1px solid rgba(26,35,126,0.07); display: flex; align-items: center; justify-content: space-between; }
.sr-card-head h5 { font-size: 0.9rem; font-weight: 700; color: #1a237e; margin: 0; }

.sr-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
.sr-table th { padding: 11px 14px; background: #fafbff; font-size: 0.72rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid rgba(26,35,126,0.08); text-align: left; }
.sr-table td { padding: 11px 14px; border-bottom: 1px solid rgba(26,35,126,0.05); color: #374151; vertical-align: middle; }
.sr-table tr:last-child td { border-bottom: none; }
.sr-table tr:hover td { background: #fafbff; }

.badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 700; }
.badge-present { background: #e8f5e9; color: #2e7d32; }
.badge-absent  { background: #ffebee; color: #c62828; }
.badge-late    { background: #fff8e1; color: #f57f17; }
.badge-excused { background: #e8eaf6; color: #1a237e; }

.sr-empty { text-align: center; padding: 3rem; color: #9ca3af; font-size: 0.875rem; }
.sr-placeholder { text-align: center; padding: 3rem; color: #9ca3af; }
.sr-placeholder-icon { font-size: 2.5rem; margin-bottom: 0.75rem; }
</style>

<div class="sr-wrap">

    {{-- Header --}}
    <div class="sr-header">
        <div class="sr-header-left">
            <div class="sr-icon">👤</div>
            <div>
                <div class="sr-breadcrumb">
                    <a href="/">Home</a> /
                    <a href="{{ route('attendances.index') }}">Attendances</a> /
                    <span>Student Report</span>
                </div>
                <h1 class="sr-title">របាយការណ៍តាមសិស្ស</h1>
                <div class="sr-sub">Student Attendance History</div>
            </div>
        </div>
        <a href="{{ route('attendances.index') }}" class="sr-btn sr-btn-outline">← ត្រឡប់</a>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('attendances.student-report') }}">
        <div class="sr-filter-card">
            <div class="sr-filter-field">
                <label>ជ្រើសសិស្ស / Student</label>
                <select name="student_id" class="sr-select">
                    <option value="">-- ជ្រើសសិស្ស --</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}" {{ $selectedStudent == $s->id ? 'selected':'' }}>
                            {{ $s->name }} — {{ $s->schoolClass->name ?? '—' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="sr-filter-field" style="min-width:120px;">
                <label>ខែ / Month</label>
                <select name="month" class="sr-select">
                    <option value="">ទាំងអស់</option>
                    @foreach(range(1,12) as $m)
                        <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected':'' }}>
                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="sr-btn sr-btn-primary">🔍 ស្វែងរក</button>
            <a href="{{ route('attendances.student-report') }}" class="sr-btn sr-btn-outline">↺ Reset</a>
        </div>
    </form>

    @if($selectedStudentModel)

        {{-- Profile --}}
        <div class="sr-profile">
            <div class="sr-avatar">{{ mb_substr($selectedStudentModel->name, 0, 1) }}</div>
            <div>
                <div class="sr-profile-name">{{ $selectedStudentModel->name }}</div>
                <div class="sr-profile-meta">
                    ថ្នាក់: {{ $selectedStudentModel->schoolClass->name ?? '—' }} ·
                    ភេទ: {{ $selectedStudentModel->gender == 'male' ? 'ប្រុស' : ($selectedStudentModel->gender == 'female' ? 'ស្រី' : '—') }} ·
                    Email: {{ $selectedStudentModel->email ?? '—' }}
                </div>
            </div>
            <div style="margin-left:auto;">
                <a href="{{ route('students.show', $selectedStudentModel) }}" class="sr-btn sr-btn-outline" style="font-size:0.8rem;">👤 មើលប្រវត្តិ</a>
            </div>
        </div>

        {{-- Stats --}}
        @php
            $total   = $attendances->count();
            $present = $attendances->where('status','present')->count();
            $absent  = $attendances->where('status','absent')->count();
            $late    = $attendances->where('status','late')->count();
            $excused = $attendances->where('status','excused')->count();
            $rate    = $total > 0 ? round(($present / $total) * 100) : 0;
        @endphp

        <div class="sr-stat-row">
            <div class="sr-stat s-present">
                <div class="sr-stat-num">{{ $present }}</div>
                <div class="sr-stat-lbl">Present</div>
            </div>
            <div class="sr-stat s-absent">
                <div class="sr-stat-num">{{ $absent }}</div>
                <div class="sr-stat-lbl">Absent</div>
            </div>
            <div class="sr-stat s-late">
                <div class="sr-stat-num">{{ $late }}</div>
                <div class="sr-stat-lbl">Late</div>
            </div>
            <div class="sr-stat s-excused">
                <div class="sr-stat-num">{{ $excused }}</div>
                <div class="sr-stat-lbl">Excused</div>
            </div>
        </div>

        {{-- Rate bar --}}
        <div style="background:#fff;border-radius:14px;border:1px solid rgba(26,35,126,0.07);padding:1rem 1.5rem;margin-bottom:1.5rem;box-shadow:0 2px 12px rgba(26,35,126,0.04);">
            <div style="display:flex;justify-content:space-between;font-size:0.85rem;font-weight:600;color:#374151;margin-bottom:6px;">
                <span>អត្រាវត្តមានសរុប ({{ $total }} ថ្ងៃ)</span>
                <span style="color:{{ $rate >= 80 ? '#2e7d32' : ($rate >= 60 ? '#f57f17' : '#c62828') }}">{{ $rate }}%</span>
            </div>
            <div class="sr-rate-bar"><div class="sr-rate-fill" style="width:{{ $rate }}%"></div></div>
        </div>

        {{-- History table --}}
        <div class="sr-card">
            <div class="sr-card-head">
                <h5>📅 ប្រវត្តិវត្តមាន</h5>
                <span style="font-size:0.8rem;color:#6b7280;">{{ $total }} កំណត់ត្រា</span>
            </div>
            @if($attendances->isEmpty())
                <div class="sr-empty">⚠️ មិនទាន់មានវត្តមាន</div>
            @else
                <table class="sr-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ថ្ងៃ</th>
                            <th>ថ្នាក់</th>
                            <th>ស្ថានភាព</th>
                            <th>កំណត់ចំណាំ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $i => $att)
                        <tr>
                            <td style="color:#9ca3af;">{{ $i + 1 }}</td>
                            <td style="font-weight:500;">{{ \Carbon\Carbon::parse($att->date)->format('d M Y') }}</td>
                            <td>{{ $att->schoolClass->name ?? '—' }}</td>
                            <td><span class="badge badge-{{ $att->status }}">{{ strtoupper($att->status) }}</span></td>
                            <td style="color:#6b7280;">{{ $att->note ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    @else
        {{-- Placeholder --}}
        <div class="sr-card">
            <div class="sr-placeholder">
                <div class="sr-placeholder-icon">👆</div>
                <div style="font-size:0.95rem;font-weight:600;color:#374151;margin-bottom:6px;">ជ្រើសសិស្សម្នាក់</div>
                <div style="font-size:0.82rem;color:#9ca3af;">ជ្រើសសិស្សពី dropdown ខាងលើ ហើយចុច ស្វែងរក</div>
            </div>
        </div>
    @endif

</div>
@endsection