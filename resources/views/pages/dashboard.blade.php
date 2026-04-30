@extends('layouts.master')

@section('title', 'Dashboard - School Management')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
    :root {
        --primary: #2563EB;
        --primary-light: #EFF6FF;
        --secondary: #7C3AED;
        --success: #059669;
        --warning: #D97706;
        --danger: #DC2626;
        --teal: #0891B2;
        --dark: #0F172A;
        --gray: #64748B;
        --light-bg: #F8FAFC;
        --card-border: #E2E8F0;
        --sidebar-bg: #0F172A;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: var(--light-bg);
        color: var(--dark);
        min-height: 100vh;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
        position: fixed;
        left: 0; top: 0;
        width: 260px;
        height: 100vh;
        background: var(--sidebar-bg);
        padding: 0;
        z-index: 100;
        overflow-y: auto;
        transition: all 0.3s ease;
    }

    .sidebar-brand {
        padding: 24px 24px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sidebar-brand .brand-icon {
        width: 40px; height: 40px;
        background: var(--primary);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
    }

    .sidebar-brand .brand-name {
        color: white;
        font-size: 16px;
        font-weight: 700;
        line-height: 1.2;
    }

    .sidebar-brand .brand-sub {
        color: rgba(255,255,255,0.4);
        font-size: 11px;
        font-weight: 500;
    }

    .sidebar-nav { padding: 16px 12px; }

    .nav-label {
        color: rgba(255,255,255,0.3);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 12px 12px 6px;
    }

    .nav-item { margin-bottom: 2px; }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        border-radius: 8px;
        color: rgba(255,255,255,0.55);
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
    }

    .nav-link:hover {
        background: rgba(255,255,255,0.07);
        color: white;
    }

    .nav-link.active {
        background: var(--primary);
        color: white;
        box-shadow: 0 4px 12px rgba(37,99,235,0.4);
    }

    .nav-link i { font-size: 16px; width: 20px; text-align: center; }

    /* ===== MAIN CONTENT ===== */
    .main-content {
        margin-left: 260px;
        min-height: 100vh;
        padding: 0;
    }

    /* ===== TOPBAR ===== */
    .topbar {
        background: white;
        border-bottom: 1px solid var(--card-border);
        padding: 16px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 50;
    }

    .topbar-title h1 {
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
    }

    .topbar-title p {
        font-size: 13px;
        color: var(--gray);
        margin-top: 2px;
    }

    .topbar-actions { display: flex; align-items: center; gap: 12px; }

    .btn-icon {
        width: 38px; height: 38px;
        border-radius: 8px;
        border: 1px solid var(--card-border);
        background: white;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        color: var(--gray);
        transition: all 0.2s;
        position: relative;
    }

    .btn-icon:hover { background: var(--light-bg); color: var(--dark); }

    .badge-dot {
        position: absolute;
        top: 6px; right: 6px;
        width: 8px; height: 8px;
        background: var(--danger);
        border-radius: 50%;
        border: 2px solid white;
    }

    .avatar {
        width: 38px; height: 38px;
        border-radius: 8px;
        background: var(--primary);
        display: flex; align-items: center; justify-content: center;
        color: white;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
    }

    /* ===== PAGE BODY ===== */
    .page-body { padding: 28px 32px; }

    /* ===== STAT CARDS ===== */
    .stat-card {
        background: white;
        border-radius: 14px;
        border: 1px solid var(--card-border);
        padding: 22px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.08);
        border-color: transparent;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
    }

    .stat-card.blue::before   { background: var(--primary); }
    .stat-card.purple::before { background: var(--secondary); }
    .stat-card.green::before  { background: var(--success); }
    .stat-card.orange::before { background: var(--warning); }
    .stat-card.teal::before   { background: var(--teal); }

    .stat-icon {
        width: 46px; height: 46px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
        margin-bottom: 16px;
    }

    .stat-icon.blue   { background: #EFF6FF; color: var(--primary); }
    .stat-icon.purple { background: #F5F3FF; color: var(--secondary); }
    .stat-icon.green  { background: #ECFDF5; color: var(--success); }
    .stat-icon.orange { background: #FFFBEB; color: var(--warning); }
    .stat-icon.teal   { background: #ECFEFF; color: var(--teal); }

    .stat-value {
        font-size: 30px;
        font-weight: 800;
        color: var(--dark);
        line-height: 1;
        font-family: 'DM Mono', monospace;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 13px;
        color: var(--gray);
        font-weight: 500;
        margin-bottom: 14px;
    }

    .stat-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 20px;
    }

    .stat-badge.up   { background: #ECFDF5; color: var(--success); }
    .stat-badge.down { background: #FEF2F2; color: var(--danger); }
    .stat-badge.info { background: #ECFEFF; color: var(--teal); }

    /* ===== SECTION CARDS ===== */
    .section-card {
        background: white;
        border-radius: 14px;
        border: 1px solid var(--card-border);
        overflow: hidden;
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    .section-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--card-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .section-header h5 {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .section-header p {
        font-size: 12px;
        color: var(--gray);
        margin: 2px 0 0;
    }

    .btn-sm-outline {
        padding: 6px 14px;
        border-radius: 7px;
        border: 1px solid var(--card-border);
        background: transparent;
        font-size: 12px;
        font-weight: 600;
        color: var(--gray);
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 5px;
    }

    .btn-sm-outline:hover {
        background: var(--light-bg);
        color: var(--dark);
        border-color: #CBD5E1;
    }

    /* ===== TABLE ===== */
    .custom-table { width: 100%; border-collapse: collapse; }

    .custom-table thead th {
        padding: 12px 24px;
        font-size: 11px;
        font-weight: 700;
        color: var(--gray);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        background: var(--light-bg);
        border-bottom: 1px solid var(--card-border);
    }

    .custom-table tbody tr {
        border-bottom: 1px solid #F1F5F9;
        transition: background 0.15s;
    }

    .custom-table tbody tr:hover { background: #FAFBFF; }
    .custom-table tbody tr:last-child { border-bottom: none; }

    .custom-table tbody td {
        padding: 14px 24px;
        font-size: 13.5px;
        color: var(--dark);
        vertical-align: middle;
    }

    .student-avatar {
        width: 34px; height: 34px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 13px;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
    }

    .student-name { font-weight: 600; font-size: 13.5px; }
    .student-id   { font-size: 11.5px; color: var(--gray); font-family: 'DM Mono', monospace; }

    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }

    .status-badge::before {
        content: '';
        width: 6px; height: 6px;
        border-radius: 50%;
    }

    .status-badge.active   { background: #ECFDF5; color: #065F46; }
    .status-badge.active::before   { background: #10B981; }
    .status-badge.inactive { background: #FEF2F2; color: #991B1B; }
    .status-badge.inactive::before { background: #EF4444; }
    .status-badge.pending  { background: #FFFBEB; color: #92400E; }
    .status-badge.pending::before  { background: #F59E0B; }

    /* ===== CHART AREA ===== */
    .chart-container { padding: 24px; }

    .chart-bars {
        display: flex;
        align-items: flex-end;
        gap: 10px;
        height: 160px;
        padding-top: 10px;
    }

    .chart-bar-group {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        height: 100%;
        justify-content: flex-end;
    }

    .bar-wrap {
        width: 100%;
        display: flex;
        gap: 3px;
        align-items: flex-end;
        height: 140px;
    }

    .bar {
        flex: 1;
        border-radius: 4px 4px 0 0;
        transition: all 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        animation: growUp 1s ease forwards;
        transform-origin: bottom;
    }

    .bar.students { background: var(--primary); }
    .bar.teachers { background: var(--secondary); }

    .bar-label {
        font-size: 11px;
        color: var(--gray);
        font-weight: 500;
        text-align: center;
    }

    .chart-legend {
        display: flex;
        gap: 20px;
        padding: 16px 24px;
        border-top: 1px solid var(--card-border);
    }

    .legend-item {
        display: flex; align-items: center; gap: 8px;
        font-size: 12px; color: var(--gray); font-weight: 500;
    }

    .legend-dot {
        width: 10px; height: 10px;
        border-radius: 3px;
    }

    /* ===== ACTIVITY ===== */
    .activity-list { padding: 8px 0; }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 14px 24px;
        transition: background 0.15s;
    }

    .activity-item:hover { background: var(--light-bg); }

    .activity-icon {
        width: 36px; height: 36px;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }

    .activity-content { flex: 1; }

    .activity-text {
        font-size: 13px;
        color: var(--dark);
        font-weight: 500;
        line-height: 1.4;
    }

    .activity-text span { font-weight: 700; }

    .activity-time {
        font-size: 11.5px;
        color: var(--gray);
        margin-top: 3px;
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes growUp {
        from { transform: scaleY(0); }
        to   { transform: scaleY(1); }
    }

    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
    .delay-5 { animation-delay: 0.5s; }
    .delay-6 { animation-delay: 0.6s; }
    .delay-7 { animation-delay: 0.7s; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .sidebar { transform: translateX(-260px); }
        .sidebar.open { transform: translateX(0); }
        .main-content { margin-left: 0; }
        .page-body { padding: 20px 16px; }
        .topbar { padding: 14px 16px; }
    }
</style>
@endsection

@section('content')
<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">🏫</div>
        <div>
            <div class="brand-name">SchoolMS</div>
            <div class="brand-sub">Management System</div>
        </div>
    </div>

    <div class="sidebar-nav">
        <div class="nav-label">Main Menu</div>

        <div class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link active">
                <i class="bi bi-grid-1x2-fill"></i> ទំព័រដើម
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('students.index') }}" class="nav-link">
                <i class="bi bi-people-fill"></i> សិស្ស
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('teachers.index') }}" class="nav-link">
                <i class="bi bi-person-workspace"></i> គ្រូបង្រៀន
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('courses.index') }}" class="nav-link">
                <i class="bi bi-book-fill"></i> មុខវិជ្ជា
            </a>
        </div>

        <div class="nav-label">Management</div>

        {{-- ✅ Schedule - Updated with route --}}
        <div class="nav-item">
            <a href="{{ route('schedules.index') }}" class="nav-link {{ request()->routeIs('schedules.*') ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i> Schedule
            </a>
        </div>
        <div class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-bar-chart-fill"></i> របាយការណ៍
            </a>
        </div>
        <div class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-images"></i> Gallery
            </a>
        </div>
        <div class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-newspaper"></i> ព័ត៌មាន
            </a>
        </div>

        <div class="nav-label">System</div>

        <div class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-people"></i> អ្នកប្រើប្រាស់
            </a>
        </div>
        <div class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-gear-fill"></i> ការកំណត់
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="nav-link">
                <i class="bi bi-box-arrow-left"></i> ចេញ
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-title">
            <h1>Dashboard</h1>
            <p>សូមស្វាគមន៍មក, {{ auth()->user()->name ?? 'Admin' }}! 👋</p>
        </div>
        <div class="topbar-actions">
            <div class="btn-icon">
                <i class="bi bi-search"></i>
            </div>
            <div class="btn-icon">
                <i class="bi bi-bell"></i>
                <span class="badge-dot"></span>
            </div>
            <div class="avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
        </div>
    </div>

    <!-- PAGE BODY -->
    <div class="page-body">

        <!-- STAT CARDS -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-xl">
                <div class="stat-card blue delay-1">
                    <div class="stat-icon blue">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="stat-value">{{ $stats['students'] }}</div>
                    <div class="stat-label">សិស្សទាំងអស់</div>
                    <span class="stat-badge up">
                        <i class="bi bi-arrow-up-short"></i> +12% ខែនេះ
                    </span>
                </div>
            </div>

            <div class="col-6 col-xl">
                <div class="stat-card purple delay-2">
                    <div class="stat-icon purple">
                        <i class="bi bi-person-workspace"></i>
                    </div>
                    <div class="stat-value">{{ $stats['teachers'] }}</div>
                    <div class="stat-label">គ្រូបង្រៀន</div>
                    <span class="stat-badge up">
                        <i class="bi bi-arrow-up-short"></i> +3 ថ្មី
                    </span>
                </div>
            </div>

            <div class="col-6 col-xl">
                <div class="stat-card green delay-3">
                    <div class="stat-icon green">
                        <i class="bi bi-book-fill"></i>
                    </div>
                    <div class="stat-value">{{ $stats['courses'] }}</div>
                    <div class="stat-label">មុខវិជ្ជា</div>
                    <span class="stat-badge up">
                        <i class="bi bi-arrow-up-short"></i> Active
                    </span>
                </div>
            </div>

            <div class="col-6 col-xl">
                <div class="stat-card orange delay-4">
                    <div class="stat-icon orange">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <div class="stat-value">{{ $stats['users'] }}</div>
                    <div class="stat-label">ថ្នាក់រៀន</div>
                    <span class="stat-badge up">
                        <i class="bi bi-arrow-up-short"></i> ឆ្នាំ 2026
                    </span>
                </div>
            </div>

            {{-- ✅ NEW: Schedule stat card --}}
            <div class="col-6 col-xl">
                <div class="stat-card teal delay-5">
                    <div class="stat-icon teal">
                        <i class="bi bi-calendar3"></i>
                    </div>
                    <div class="stat-value">{{ $totalSchedules ?? '0' }}</div>
                    <div class="stat-label">Schedule</div>
                    <span class="stat-badge info">
                        <i class="bi bi-calendar-check"></i> សប្តាហ៍នេះ
                    </span>
                </div>
            </div>
        </div>

        <!-- CHART + ACTIVITY -->
        <div class="row g-3 mb-4">

            <!-- CHART -->
            <div class="col-lg-8">
                <div class="section-card delay-5">
                    <div class="section-header">
                        <div>
                            <h5>📊 ស្ថិតិសិស្ស និងគ្រូ</h5>
                            <p>សរុបប្រចាំខែ ឆ្នាំ 2026</p>
                        </div>
                        <a href="#" class="btn-sm-outline">
                            <i class="bi bi-download"></i> Export
                        </a>
                    </div>
                    <div class="chart-container">
                        <div class="chart-bars" id="chartBars">
                            @php
                                $months = ['មករា','កុម្ភៈ','មីនា','មេសា','ឧសភា','មិថុនា','កក្កដា','សីហា','កញ្ញា','តុលា','វិច្ឆិកា','ធ្នូ'];
                                $students = array_fill(0, 12, $stats['students']);
                                $teachers = array_fill(0, 12, $stats['teachers']);
                                $maxStudents = max($students);
                            @endphp

                            @foreach($months as $i => $month)
                            <div class="chart-bar-group">
                                <div class="bar-wrap">
                                    <div class="bar students"
                                         style="height: {{ ($maxStudents > 0 ? ($students[$i]/$maxStudents)*130 : 0) }}px; animation-delay: {{ $i * 0.05 }}s">
                                    </div>
                                    <div class="bar teachers"
                                         style="height: {{ max($teachers) > 0 ? ($teachers[$i]/max($teachers))*80 : 0 }}px; animation-delay: {{ $i * 0.05 + 0.3 }}s">
                                    </div>
                                </div>
                                <div class="bar-label">{{ substr($month, 0, 3) }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="chart-legend">
                        <div class="legend-item">
                            <div class="legend-dot" style="background: var(--primary)"></div>
                            សិស្ស
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background: var(--secondary)"></div>
                            គ្រូបង្រៀន
                        </div>
                    </div>
                </div>
            </div>

            <!-- RECENT ACTIVITY -->
            <div class="col-lg-4">
                <div class="section-card delay-6" style="height: 100%;">
                    <div class="section-header">
                        <div>
                            <h5>🔔 សកម្មភាពថ្មីៗ</h5>
                            <p>ថ្ងៃនេះ</p>
                        </div>
                    </div>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon" style="background:#EFF6FF; color:var(--primary)">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text"><span>សិស្សថ្មី</span> បានចុះឈ្មោះ</div>
                                <div class="activity-time">🕐 ២ នាទីមុន</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon" style="background:#F5F3FF; color:var(--secondary)">
                                <i class="bi bi-book-fill"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text"><span>មុខវិជ្ជាថ្មី</span> បានបន្ថែម</div>
                                <div class="activity-time">🕐 ១៥ នាទីមុន</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon" style="background:#ECFDF5; color:var(--success)">
                                <i class="bi bi-person-check-fill"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text"><span>គ្រូថ្មី</span> បានចូលបម្រើការ</div>
                                <div class="activity-time">🕐 ១ ម៉ោងមុន</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon" style="background:#ECFEFF; color:var(--teal)">
                                <i class="bi bi-calendar-check-fill"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text"><span>Schedule</span> បានធ្វើបច្ចុប្បន្នភាព</div>
                                <div class="activity-time">🕐 ២ ម៉ោងមុន</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon" style="background:#FEF2F2; color:var(--danger)">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-text"><span>ថ្លៃសិក្សា</span> មិនទាន់បង់</div>
                                <div class="activity-time">🕐 ៣ ម៉ោងមុន</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RECENT STUDENTS TABLE -->
        <div class="section-card delay-7">
            <div class="section-header">
                <div>
                    <h5>👥 សិស្សចុះឈ្មោះថ្មីៗ</h5>
                    <p>បង្ហាញចុងក្រោយ 10 នាក់</p>
                </div>
                <a href="{{ route('students.index') }}" class="btn-sm-outline">
                    មើលទាំងអស់ <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>សិស្ស</th>
                            <th>ថ្នាក់</th>
                            <th>ទូរស័ព្ទ</th>
                            <th>ចុះឈ្មោះ</th>
                            <th>ស្ថានភាព</th>
                            <th>សកម្មភាព</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentStudents ?? [] as $student)
                        <tr>
                            <td style="color: var(--gray); font-family: 'DM Mono', monospace; font-size: 12px;">
                                #{{ str_pad($student->id, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div class="student-avatar" style="background: hsl({{ $loop->index * 40 }}, 70%, 50%)">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="student-name">{{ $student->name }}</div>
                                        <div class="student-id">{{ $student->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $student->schoolClass->name ?? 'គ្មាន' }}</td>
                            <td style="font-family: 'DM Mono', monospace; font-size: 13px;">{{ $student->phone ?? '-' }}</td>
                            <td style="color: var(--gray); font-size: 12.5px;">{{ $student->created_at->format('d/m/Y') }}</td>
                            <td><span class="status-badge active">សកម្ម</span></td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="{{ route('students.edit', $student->id) }}"
                                       style="width:28px;height:28px;border-radius:6px;background:#EFF6FF;color:var(--primary);display:flex;align-items:center;justify-content:center;font-size:13px;text-decoration:none;">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <a href="#"
                                       style="width:28px;height:28px;border-radius:6px;background:#FEF2F2;color:var(--danger);display:flex;align-items:center;justify-content:center;font-size:13px;text-decoration:none;">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
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
                            <td style="color: var(--gray); font-family: 'DM Mono', monospace; font-size: 12px;">
                                #{{ str_pad($i + 1, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div class="student-avatar" style="background: {{ $s['color'] }}">
                                        {{ mb_substr($s['name'], 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="student-name">{{ $s['name'] }}</div>
                                        <div class="student-id">{{ $s['email'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $s['class'] }}</td>
                            <td style="font-family: 'DM Mono', monospace; font-size: 13px;">{{ $s['phone'] }}</td>
                            <td style="color: var(--gray); font-size: 12.5px;">{{ date('d/m/Y') }}</td>
                            <td>
                                <span class="status-badge {{ $s['status'] }}">
                                    {{ $s['status'] === 'active' ? 'សកម្ម' : ($s['status'] === 'pending' ? 'រង់ចាំ' : 'អសកម្ម') }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="#" style="width:28px;height:28px;border-radius:6px;background:#EFF6FF;color:var(--primary);display:flex;align-items:center;justify-content:center;font-size:13px;text-decoration:none;">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <a href="#" style="width:28px;height:28px;border-radius:6px;background:#FEF2F2;color:var(--danger);display:flex;align-items:center;justify-content:center;font-size:13px;text-decoration:none;">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div><!-- /page-body -->
</div><!-- /main-content -->
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Animate stat numbers
    document.querySelectorAll('.stat-value').forEach(el => {
        const target = parseInt(el.textContent.replace(/\D/g, ''));
        if (isNaN(target)) return;
        let current = 0;
        const step = target / 50;
        const timer = setInterval(() => {
            current = Math.min(current + step, target);
            el.textContent = Math.floor(current);
            if (current >= target) clearInterval(timer);
        }, 30);
    });

    // Mobile sidebar toggle
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            document.getElementById('sidebar').classList.remove('open');
        }
    });
</script>
@endsection