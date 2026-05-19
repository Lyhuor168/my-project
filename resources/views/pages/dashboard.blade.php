@extends('layouts.master')

@section('title', 'Dashboard - School Management')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
    .stat-card {
        background: white;
        border-radius: 14px;
        border: 1px solid #E2E8F0;
        padding: 22px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(0,0,0,0.08); }
    .stat-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; }
    .stat-card.blue::before   { background: #2563EB; }
    .stat-card.purple::before { background: #7C3AED; }
    .stat-card.green::before  { background: #059669; }
    .stat-card.orange::before { background: #D97706; }
    .stat-card.teal::before   { background: #0891B2; }

    .stat-icon { width:46px; height:46px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:20px; margin-bottom:16px; }
    .stat-icon.blue   { background:#EFF6FF; color:#2563EB; }
    .stat-icon.purple { background:#F5F3FF; color:#7C3AED; }
    .stat-icon.green  { background:#ECFDF5; color:#059669; }
    .stat-icon.orange { background:#FFFBEB; color:#D97706; }
    .stat-icon.teal   { background:#ECFEFF; color:#0891B2; }

    .stat-value { font-size:30px; font-weight:800; color:#0F172A; line-height:1; font-family:'DM Mono',monospace; margin-bottom:4px; }
    .stat-label { font-size:13px; color:#64748B; font-weight:500; margin-bottom:14px; }
    .stat-badge { display:inline-flex; align-items:center; gap:4px; font-size:12px; font-weight:600; padding:3px 8px; border-radius:20px; }
    .stat-badge.up   { background:#ECFDF5; color:#059669; }
    .stat-badge.info { background:#ECFEFF; color:#0891B2; }

    [data-theme='dark'] .stat-card { background:#2d2d2d; border-color:#333; }
    [data-theme='dark'] .stat-value { color:#f1f5f9; }
    [data-theme='dark'] .stat-label { color:#94a3b8; }

    .section-card { background:white; border-radius:14px; border:1px solid #E2E8F0; overflow:hidden; }
    [data-theme='dark'] .section-card { background:#2d2d2d; border-color:#333; }

    .section-header { padding:18px 24px; border-bottom:1px solid #E2E8F0; display:flex; align-items:center; justify-content:space-between; }
    [data-theme='dark'] .section-header { border-color:#333; }
    .section-header h5 { font-size:15px; font-weight:700; margin:0; }
    .section-header p  { font-size:12px; color:#64748B; margin:2px 0 0; }

    .chart-bars { display:flex; align-items:flex-end; gap:8px; height:150px; padding:10px 24px 0; }
    .chart-bar-group { flex:1; display:flex; flex-direction:column; align-items:center; gap:6px; height:100%; justify-content:flex-end; }
    .bar-wrap { width:100%; display:flex; gap:3px; align-items:flex-end; height:130px; }
    .bar { flex:1; border-radius:4px 4px 0 0; animation:growUp 1s ease forwards; transform-origin:bottom; }
    .bar.students { background:#2563EB; }
    .bar.teachers { background:#7C3AED; }
    .bar-label { font-size:10px; color:#64748B; text-align:center; }
    .chart-legend { display:flex; gap:20px; padding:14px 24px; border-top:1px solid #E2E8F0; }
    [data-theme='dark'] .chart-legend { border-color:#333; }
    .legend-item { display:flex; align-items:center; gap:8px; font-size:12px; color:#64748B; }
    .legend-dot { width:10px; height:10px; border-radius:3px; }

    .activity-item { display:flex; align-items:flex-start; gap:14px; padding:13px 24px; border-bottom:1px solid #F1F5F9; transition:background 0.15s; }
    .activity-item:last-child { border-bottom:none; }
    .activity-item:hover { background:#F8FAFC; }
    [data-theme='dark'] .activity-item:hover { background:#333; }
    .activity-icon { width:36px; height:36px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:15px; flex-shrink:0; }
    .activity-text { font-size:13px; font-weight:500; line-height:1.4; }
    .activity-text span { font-weight:700; }
    .activity-time { font-size:11.5px; color:#64748B; margin-top:3px; }

    .custom-table { width:100%; border-collapse:collapse; }
    .custom-table thead th { padding:12px 20px; font-size:11px; font-weight:700; color:#64748B; text-transform:uppercase; letter-spacing:0.8px; background:#F8FAFC; border-bottom:1px solid #E2E8F0; }
    [data-theme='dark'] .custom-table thead th { background:#222; border-color:#333; color:#94a3b8; }
    .custom-table tbody tr { border-bottom:1px solid #F1F5F9; transition:background 0.15s; }
    .custom-table tbody tr:hover { background:#FAFBFF; }
    .custom-table tbody tr:last-child { border-bottom:none; }
    [data-theme='dark'] .custom-table tbody tr:hover { background:#333; }
    .custom-table tbody td { padding:13px 20px; font-size:13.5px; vertical-align:middle; }

    .student-avatar { width:34px; height:34px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:700; color:white; flex-shrink:0; }
    .status-badge { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:20px; font-size:11.5px; font-weight:600; }
    .status-badge::before { content:''; width:6px; height:6px; border-radius:50%; }
    .status-badge.active   { background:#ECFDF5; color:#065F46; }
    .status-badge.active::before   { background:#10B981; }
    .status-badge.inactive { background:#FEF2F2; color:#991B1B; }
    .status-badge.inactive::before { background:#EF4444; }
    .status-badge.pending  { background:#FFFBEB; color:#92400E; }
    .status-badge.pending::before  { background:#F59E0B; }

    .btn-view { padding:6px 14px; border-radius:7px; border:1px solid #E2E8F0; background:transparent; font-size:12px; font-weight:600; color:#64748B; text-decoration:none; display:inline-flex; align-items:center; gap:5px; transition:all 0.2s; }
    .btn-view:hover { background:#F8FAFC; color:#0F172A; }

    @keyframes growUp { from { transform:scaleY(0); } to { transform:scaleY(1); } }
</style>
@endsection

@section('content')

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl">
        <div class="stat-card blue">
            <div class="stat-icon blue"><i class="fas fa-users"></i></div>
            <div class="stat-value">{{ $totalStudents ?? '0' }}</div>
            <div class="stat-label">សិស្សទាំងអស់</div>
            <span class="stat-badge up"><i class="fas fa-arrow-up"></i> +12% ខែនេះ</span>
        </div>
    </div>
    <div class="col-6 col-xl">
        <div class="stat-card purple">
            <div class="stat-icon purple"><i class="fas fa-chalkboard-teacher"></i></div>
            <div class="stat-value">{{ $totalTeachers ?? '0' }}</div>
            <div class="stat-label">គ្រូបង្រៀន</div>
            <span class="stat-badge up"><i class="fas fa-arrow-up"></i> +3 ថ្មី</span>
        </div>
    </div>
    <div class="col-6 col-xl">
        <div class="stat-card green">
            <div class="stat-icon green"><i class="fas fa-book-open"></i></div>
            <div class="stat-value">{{ $totalCourses ?? '0' }}</div>
            <div class="stat-label">មុខវិជ្ជា</div>
            <span class="stat-badge up"><i class="fas fa-check"></i> Active</span>
        </div>
    </div>
    <div class="col-6 col-xl">
        <div class="stat-card orange">
            <div class="stat-icon orange"><i class="fas fa-chalkboard"></i></div>
            <div class="stat-value">{{ $totalClasses ?? '0' }}</div>
            <div class="stat-label">ថ្នាក់រៀន</div>
            <span class="stat-badge up"><i class="fas fa-arrow-up"></i> ឆ្នាំ 2026</span>
        </div>
    </div>
    <div class="col-6 col-xl">
        <div class="stat-card teal">
            <div class="stat-icon teal"><i class="fas fa-calendar-alt"></i></div>
            <div class="stat-value">{{ $totalSchedules ?? '0' }}</div>
            <div class="stat-label">កាលវិភាគ</div>
            <span class="stat-badge info"><i class="fas fa-calendar-check"></i> សប្តាហ៍នេះ</span>
        </div>
    </div>
</div>

{{-- CHART + ACTIVITY --}}
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="section-card">
            <div class="section-header">
                <div>
                    <h5>📊 ស្ថិតិសិស្ស និងគ្រូ</h5>
                    <p>សរុបប្រចាំខែ ឆ្នាំ 2026</p>
                </div>
            </div>
            <div class="chart-bars">
                @php
                    $months = ['មករា','កុម្ភៈ','មីនា','មេសា','ឧសភា','មិថុនា','កក្កដា','សីហា','កញ្ញា','តុលា','វិច្ឆិកា','ធ្នូ'];
                    $sts = [180,195,210,225,230,235,238,240,242,245,247,248];
                    $tcs = [25,26,27,28,29,30,30,31,31,32,32,32];
                    $maxS = max($sts);
                @endphp
                @foreach($months as $i => $month)
                <div class="chart-bar-group">
                    <div class="bar-wrap">
                        <div class="bar students" style="height:{{ ($sts[$i]/$maxS)*120 }}px;animation-delay:{{ $i*0.05 }}s"></div>
                        <div class="bar teachers" style="height:{{ ($tcs[$i]/max($tcs))*75 }}px;animation-delay:{{ $i*0.05+0.3 }}s"></div>
                    </div>
                    <div class="bar-label">{{ mb_substr($month,0,3) }}</div>
                </div>
                @endforeach
            </div>
            <div class="chart-legend">
                <div class="legend-item"><div class="legend-dot" style="background:#2563EB"></div> សិស្ស</div>
                <div class="legend-item"><div class="legend-dot" style="background:#7C3AED"></div> គ្រូបង្រៀន</div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="section-card h-100">
            <div class="section-header">
                <div><h5>🔔 សកម្មភាពថ្មីៗ</h5><p>ថ្ងៃនេះ</p></div>
            </div>
            <div class="activity-item">
                <div class="activity-icon" style="background:#EFF6FF;color:#2563EB"><i class="fas fa-user-plus"></i></div>
                <div><div class="activity-text"><span>សិស្សថ្មី</span> បានចុះឈ្មោះ</div><div class="activity-time">🕐 ២ នាទីមុន</div></div>
            </div>
            <div class="activity-item">
                <div class="activity-icon" style="background:#F5F3FF;color:#7C3AED"><i class="fas fa-book"></i></div>
                <div><div class="activity-text"><span>មុខវិជ្ជាថ្មី</span> បានបន្ថែម</div><div class="activity-time">🕐 ១៥ នាទីមុន</div></div>
            </div>
            <div class="activity-item">
                <div class="activity-icon" style="background:#ECFDF5;color:#059669"><i class="fas fa-user-check"></i></div>
                <div><div class="activity-text"><span>គ្រូថ្មី</span> បានចូលបម្រើការ</div><div class="activity-time">🕐 ១ ម៉ោងមុន</div></div>
            </div>
            <div class="activity-item">
                <div class="activity-icon" style="background:#ECFEFF;color:#0891B2"><i class="fas fa-calendar-check"></i></div>
                <div><div class="activity-text"><span>កាលវិភាគ</span> បានធ្វើបច្ចុប្បន្នភាព</div><div class="activity-time">🕐 ២ ម៉ោងមុន</div></div>
            </div>
            <div class="activity-item">
                <div class="activity-icon" style="background:#FEF2F2;color:#DC2626"><i class="fas fa-exclamation-triangle"></i></div>
                <div><div class="activity-text"><span>ថ្លៃសិក្សា</span> មិនទាន់បង់</div><div class="activity-time">🕐 ៣ ម៉ោងមុន</div></div>
            </div>
        </div>
    </div>
</div>

{{-- RECENT STUDENTS --}}
<div class="section-card">
    <div class="section-header">
        <div><h5>👥 សិស្សចុះឈ្មោះថ្មីៗ</h5><p>បង្ហាញចុងក្រោយ 10 នាក់</p></div>
        <a href="/students" class="btn-view">មើលទាំងអស់ <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>#</th><th>សិស្ស</th><th>ថ្នាក់</th><th>ទូរស័ព្ទ</th><th>ចុះឈ្មោះ</th><th>ស្ថានភាព</th><th>សកម្មភាព</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentStudents ?? [] as $student)
                <tr>
                    <td style="color:#64748B;font-family:'DM Mono',monospace;font-size:12px;">#{{ str_pad($student->id,4,'0',STR_PAD_LEFT) }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div class="student-avatar" style="background:hsl({{ $loop->index*40 }},70%,50%)">{{ strtoupper(substr($student->name,0,1)) }}</div>
                            <div>
                                <div style="font-weight:600;">{{ $student->name }}</div>
                                <div style="font-size:11.5px;color:#64748B;">{{ $student->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $student->class ?? 'គ្មាន' }}</td>
                    <td style="font-family:'DM Mono',monospace;font-size:13px;">{{ $student->phone ?? '-' }}</td>
                    <td style="color:#64748B;font-size:12.5px;">{{ $student->created_at->format('d/m/Y') }}</td>
                    <td><span class="status-badge active">សកម្ម</span></td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="/students/{{ $student->id }}/edit" style="width:28px;height:28px;border-radius:6px;background:#EFF6FF;color:#2563EB;display:flex;align-items:center;justify-content:center;font-size:13px;text-decoration:none;"><i class="fas fa-pencil-alt"></i></a>
                            <a href="#" style="width:28px;height:28px;border-radius:6px;background:#FEF2F2;color:#DC2626;display:flex;align-items:center;justify-content:center;font-size:13px;text-decoration:none;"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                @empty
                @php
                    $samples = [
                        ['name'=>'សុខ ដារា','email'=>'dara@school.com','class'=>'ថ្នាក់ទី១២','phone'=>'012 345 678','status'=>'active','color'=>'#2563EB'],
                        ['name'=>'ចាន់ សុផា','email'=>'sopha@school.com','class'=>'ថ្នាក់ទី១១','phone'=>'098 765 432','status'=>'active','color'=>'#7C3AED'],
                        ['name'=>'លឹម វណ្ណា','email'=>'vanna@school.com','class'=>'ថ្នាក់ទី១០','phone'=>'016 123 456','status'=>'pending','color'=>'#059669'],
                        ['name'=>'ហេង ស្រីលក្ខណ៍','email'=>'sreylak@school.com','class'=>'ថ្នាក់ទី១២','phone'=>'077 888 999','status'=>'active','color'=>'#D97706'],
                        ['name'=>'ពៅ មករា','email'=>'makara@school.com','class'=>'ថ្នាក់ទី១១','phone'=>'085 222 333','status'=>'inactive','color'=>'#DC2626'],
                        ['name'=>'ស្រី សុវណ្ណ','email'=>'suvann@school.com','class'=>'ថ្នាក់ទី១០','phone'=>'010 123 456','status'=>'pending','color'=>'#059669'],
                    ];
                @endphp
                @foreach($samples as $i => $s)
                <tr>
                    <td style="color:#64748B;font-family:'DM Mono',monospace;font-size:12px;">#{{ str_pad($i+1,4,'0',STR_PAD_LEFT) }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div class="student-avatar" style="background:{{ $s['color'] }}">{{ mb_substr($s['name'],0,1) }}</div>
                            <div>
                                <div style="font-weight:600;">{{ $s['name'] }}</div>
                                <div style="font-size:11.5px;color:#64748B;">{{ $s['email'] }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $s['class'] }}</td>
                    <td style="font-family:'DM Mono',monospace;font-size:13px;">{{ $s['phone'] }}</td>
                    <td style="color:#64748B;font-size:12.5px;">{{ date('d/m/Y') }}</td>
                    <td><span class="status-badge {{ $s['status'] }}">{{ $s['status']==='active'?'សកម្ម':($s['status']==='pending'?'រង់ចាំ':'អសកម្ម') }}</span></td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="#" style="width:28px;height:28px;border-radius:6px;background:#EFF6FF;color:#2563EB;display:flex;align-items:center;justify-content:center;font-size:13px;text-decoration:none;"><i class="fas fa-pencil-alt"></i></a>
                            <a href="#" style="width:28px;height:28px;border-radius:6px;background:#FEF2F2;color:#DC2626;display:flex;align-items:center;justify-content:center;font-size:13px;text-decoration:none;"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                @endforeach
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.querySelectorAll('.stat-value').forEach(el => {
        const target = parseInt(el.textContent.replace(/\D/g,''));
        if (isNaN(target) || target === 0) return;
        let current = 0;
        const step = target / 50;
        const timer = setInterval(() => {
            current = Math.min(current + step, target);
            el.textContent = Math.floor(current);
            if (current >= target) clearInterval(timer);
        }, 30);
    });
</script>
@endsection
