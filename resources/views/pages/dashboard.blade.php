<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AttendTrack — Admin Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      background: #0d0f14;
      font-family: 'DM Sans', sans-serif;
      color: #e8eaf0;
      min-height: 100vh;
    }

    /* ── Sidebar ─────────────────────────────────── */
    .sidebar {
      position: fixed; left: 0; top: 0;
      width: 220px; height: 100%;
      background: #111318;
      border-right: 0.5px solid #23262f;
      display: flex; flex-direction: column;
      padding: 24px 0; z-index: 10;
    }
    .logo { padding: 0 20px 28px; border-bottom: 0.5px solid #23262f; margin-bottom: 16px; }
    .logo-text { font-family: 'Syne', sans-serif; font-size: 17px; font-weight: 700; color: #fff; letter-spacing: .3px; }
    .logo-sub  { font-size: 11px; color: #6b7280; margin-top: 2px; letter-spacing: .6px; }

    .nav-section { font-size: 10px; letter-spacing: 1.2px; color: #3d4254; padding: 16px 20px 6px; font-weight: 500; }
    .nav-item {
      display: flex; align-items: center; gap: 10px;
      padding: 10px 20px; font-size: 13.5px; color: #8a8fa8;
      cursor: pointer; transition: all .15s;
      border-left: 2px solid transparent; margin: 1px 0;
    }
    .nav-item:hover  { color: #e8eaf0; background: #1a1d26; }
    .nav-item.active { color: #a78bfa; border-left: 2px solid #a78bfa; background: #1a1520; }
    .nav-icon { width: 16px; height: 16px; opacity: .8; flex-shrink: 0; }

    .sidebar-footer {
      margin-top: auto; padding: 16px 20px;
      border-top: 0.5px solid #23262f;
    }
    .sidebar-profile { display: flex; align-items: center; gap: 10px; }

    /* ── Main ────────────────────────────────────── */
    .main { margin-left: 220px; padding: 28px 32px; }

    /* Top bar */
    .topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; }
    .page-title { font-family: 'Syne', sans-serif; font-size: 22px; font-weight: 600; color: #fff; }
    .page-sub   { font-size: 13px; color: #6b7280; margin-top: 3px; }
    .topbar-right { display: flex; align-items: center; gap: 12px; }

    .lang-toggle { display: flex; background: #1a1d26; border: 0.5px solid #2a2d38; border-radius: 8px; overflow: hidden; }
    .lang-btn { padding: 6px 12px; font-size: 12px; cursor: pointer; color: #6b7280; transition: .15s; font-family: 'DM Sans', sans-serif; }
    .lang-btn.active { background: #252836; color: #a78bfa; }

    .notif-btn {
      width: 34px; height: 34px; border-radius: 8px;
      background: #1a1d26; border: 0.5px solid #2a2d38;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; position: relative;
    }
    .notif-dot {
      width: 7px; height: 7px; background: #a78bfa;
      border-radius: 50%; position: absolute; top: 7px; right: 7px;
    }
    .avatar {
      width: 34px; height: 34px; border-radius: 50%;
      background: linear-gradient(135deg, #a78bfa, #7c3aed);
      display: flex; align-items: center; justify-content: center;
      font-size: 13px; font-weight: 600; color: #fff; flex-shrink: 0;
    }

    /* ── Stat Cards ──────────────────────────────── */
    .stats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin-bottom: 24px; }
    .stat-card { background: #111318; border: 0.5px solid #1e2130; border-radius: 14px; padding: 20px 20px 16px; }
    .stat-label { font-size: 12px; color: #6b7280; letter-spacing: .4px; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between; }
    .stat-badge { font-size: 10px; padding: 3px 8px; border-radius: 20px; font-weight: 500; }
    .badge-up   { background: #0d2e1a; color: #34d399; }
    .badge-down { background: #2e1010; color: #f87171; }
    .badge-warn { background: #2a1e00; color: #fbbf24; }
    .stat-number { font-family: 'Syne', sans-serif; font-size: 28px; font-weight: 700; color: #fff; line-height: 1; }
    .stat-footer { font-size: 11.5px; color: #4b5268; margin-top: 8px; }
    .stat-bar  { height: 3px; background: #1e2130; border-radius: 2px; margin-top: 14px; overflow: hidden; }
    .stat-fill { height: 100%; border-radius: 2px; }

    /* ── Mid Grid ────────────────────────────────── */
    .mid-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
    .card { background: #111318; border: 0.5px solid #1e2130; border-radius: 14px; padding: 20px; }
    .card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
    .card-title  { font-family: 'Syne', sans-serif; font-size: 14px; font-weight: 600; color: #e8eaf0; }
    .card-action { font-size: 12px; color: #a78bfa; cursor: pointer; }

    /* Bar chart */
    .chart-legend { display: flex; gap: 12px; align-items: center; }
    .legend-chip  { display: flex; align-items: center; gap: 5px; font-size: 11.5px; color: #6b7280; }
    .chip-box     { display: inline-block; width: 8px; height: 8px; border-radius: 2px; }

    .chart-area { height: 160px; display: flex; align-items: flex-end; gap: 8px; padding-bottom: 4px; }
    .bar-group  { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 4px; }
    .bar-wrap   { width: 100%; display: flex; gap: 3px; align-items: flex-end; height: 140px; }
    .bar        { border-radius: 4px 4px 0 0; flex: 1; }
    .bar-label  { font-size: 10px; color: #4b5268; margin-top: 4px; }

    /* Donut */
    .donut-wrap { display: flex; align-items: center; gap: 24px; }
    .legend     { display: flex; flex-direction: column; gap: 10px; flex: 1; }
    .legend-item{ display: flex; align-items: center; gap: 8px; font-size: 13px; }
    .legend-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
    .legend-lbl { color: #8a8fa8; font-size: 12.5px; flex: 1; }
    .legend-val { font-weight: 500; color: #e8eaf0; font-size: 13px; }

    /* ── Bottom Grid ─────────────────────────────── */
    .bottom-grid { display: grid; grid-template-columns: 1.4fr 1fr; gap: 16px; }

    /* Table */
    .att-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .att-table th { text-align: left; padding: 8px 10px; font-size: 11px; color: #4b5268; letter-spacing: .5px; font-weight: 500; border-bottom: 0.5px solid #1e2130; }
    .att-table td { padding: 10px 10px; border-bottom: 0.5px solid #151820; color: #b0b4c8; vertical-align: middle; }
    .att-table tr:last-child td { border-bottom: none; }
    .att-table tr:hover td { background: #161923; }
    .status-badge { display: inline-block; padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 500; }
    .s-present { background: #0d2418; color: #4ade80; }
    .s-absent  { background: #2e1010; color: #f87171; }
    .s-late    { background: #2a1e00; color: #fbbf24; }
    .avatar-sm { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600; color: #fff; flex-shrink: 0; }
    .student-cell { display: flex; align-items: center; gap: 10px; }
    .stu-name   { color: #e0e2ec; }

    /* Progress bars */
    .progress-row { display: flex; flex-direction: column; gap: 10px; margin-top: 4px; }
    .prog-item    { display: flex; flex-direction: column; gap: 5px; }
    .prog-top     { display: flex; justify-content: space-between; font-size: 12.5px; }
    .prog-name    { color: #8a8fa8; }
    .prog-pct     { color: #e8eaf0; font-weight: 500; }
    .prog-bar     { height: 5px; background: #1e2130; border-radius: 3px; overflow: hidden; }
    .prog-fill    { height: 100%; border-radius: 3px; }

    /* Activity feed */
    .activity-list { display: flex; flex-direction: column; gap: 4px; }
    .activity-item { display: flex; align-items: flex-start; gap: 10px; padding: 8px 0; border-bottom: 0.5px solid #151820; }
    .activity-item:last-child { border-bottom: none; }
    .act-dot  { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; margin-top: 4px; }
    .act-text { font-size: 12.5px; color: #8a8fa8; line-height: 1.5; }
    .act-time { font-size: 11px; color: #3d4254; margin-top: 2px; }

    .side-cards { display: flex; flex-direction: column; gap: 16px; }
  </style>
</head>
<body>

<!-- ══ SIDEBAR ══════════════════════════════════════════════════════════ -->
<div class="sidebar">
  <div class="logo">
    <div class="logo-text">AttendTrack</div>
    <div class="logo-sub">ADMIN PORTAL</div>
  </div>

  <div class="nav-section">MAIN</div>

  <div class="nav-item active">
    <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
      <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
      <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
    </svg>
    Dashboard
  </div>
  <div class="nav-item">
    <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
      <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
      <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
    </svg>
    Students
  </div>
  <div class="nav-item">
    <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
      <path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
    </svg>
    Attendance
  </div>
  <div class="nav-item">
    <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
      <rect x="3" y="4" width="18" height="18" rx="2"/>
      <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
    </svg>
    Schedule
  </div>

  <div class="nav-section">MANAGE</div>

  <div class="nav-item">
    <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
      <path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>
    </svg>
    Classes
  </div>
  <div class="nav-item">
    <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
      <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
      <polyline points="14 2 14 8 20 8"/>
    </svg>
    Reports
  </div>
  <div class="nav-item">
    <svg class="nav-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
      <circle cx="12" cy="12" r="3"/>
      <path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/>
    </svg>
    Settings
  </div>

  <div class="sidebar-footer">
    <div class="sidebar-profile">
      <div class="avatar" style="width:32px;height:32px;font-size:12px;">A</div>
      <div>
        <div style="font-size:13px;font-weight:500;color:#e0e2ec;">Admin User</div>
        <div style="font-size:11px;color:#4b5268;">admin@school.edu</div>
      </div>
    </div>
  </div>
</div>

<!-- ══ MAIN CONTENT ══════════════════════════════════════════════════════ -->
<div class="main">

  <!-- Top bar -->
  <div class="topbar">
    <div>
      <div class="page-title">Overview Dashboard</div>
      <div class="page-sub">Friday, April 24, 2026 — Academic Year 2025–2026</div>
    </div>
    <div class="topbar-right">
      <div class="lang-toggle">
        <div class="lang-btn active" onclick="setLang('en',this)">EN</div>
        <div class="lang-btn" onclick="setLang('km',this)">ខ្មែរ</div>
      </div>
      <div class="notif-btn">
        <svg width="15" height="15" fill="none" stroke="#8a8fa8" stroke-width="1.8" viewBox="0 0 24 24">
          <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
          <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
        </svg>
        <div class="notif-dot"></div>
      </div>
      <div class="avatar">A</div>
    </div>
  </div>

  <!-- Stat cards -->
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-label"><span data-en="Total Students" data-km="សិស្សទាំងអស់">Total Students</span> <span class="stat-badge badge-up">+12</span></div>
      <div class="stat-number">1,248</div>
      <div class="stat-footer" data-en="Across 24 classes" data-km="ក្នុង 24 ថ្នាក់">Across 24 classes</div>
      <div class="stat-bar"><div class="stat-fill" style="width:82%;background:#a78bfa;"></div></div>
    </div>
    <div class="stat-card">
      <div class="stat-label"><span data-en="Present Today" data-km="មានវត្តមានថ្ងៃនេះ">Present Today</span> <span class="stat-badge badge-up">↑ 3%</span></div>
      <div class="stat-number">1,091</div>
      <div class="stat-footer" data-en="87.4% attendance rate" data-km="អត្រាចូលរៀន 87.4%">87.4% attendance rate</div>
      <div class="stat-bar"><div class="stat-fill" style="width:87%;background:#34d399;"></div></div>
    </div>
    <div class="stat-card">
      <div class="stat-label"><span data-en="Absent Today" data-km="អវត្តមានថ្ងៃនេះ">Absent Today</span> <span class="stat-badge badge-down">↑ 5</span></div>
      <div class="stat-number">107</div>
      <div class="stat-footer" data-en="8.6% of total students" data-km="8.6% នៃសិស្សទាំងអស់">8.6% of total students</div>
      <div class="stat-bar"><div class="stat-fill" style="width:9%;background:#f87171;"></div></div>
    </div>
    <div class="stat-card">
      <div class="stat-label"><span data-en="Late Arrivals" data-km="មកយឺត">Late Arrivals</span> <span class="stat-badge badge-warn">–2</span></div>
      <div class="stat-number">50</div>
      <div class="stat-footer" data-en="4.0% late rate" data-km="អត្រាយឺត 4.0%">4.0% late rate</div>
      <div class="stat-bar"><div class="stat-fill" style="width:4%;background:#fbbf24;"></div></div>
    </div>
  </div>

  <!-- Mid row -->
  <div class="mid-grid">

    <!-- Bar chart -->
    <div class="card">
      <div class="card-header">
        <div class="card-title" data-en="Weekly Attendance" data-km="វត្តមានប្រចាំសប្តាហ៍">Weekly Attendance</div>
        <div class="chart-legend">
          <div class="legend-chip"><span class="chip-box" style="background:#a78bfa;"></span><span data-en="Present" data-km="មានវត្តមាន">Present</span></div>
          <div class="legend-chip"><span class="chip-box" style="background:#3d2000;border:1px solid #fbbf24;"></span><span data-en="Absent" data-km="អវត្តមាន">Absent</span></div>
        </div>
      </div>
      <div class="chart-area">
        <div class="bar-group">
          <div class="bar-wrap">
            <div class="bar" style="height:72%;background:#6d4fc2;"></div>
            <div class="bar" style="height:9%;background:#3d2000;border:1px solid #92400e;"></div>
          </div>
          <div class="bar-label" data-en="Mon" data-km="ច">Mon</div>
        </div>
        <div class="bar-group">
          <div class="bar-wrap">
            <div class="bar" style="height:85%;background:#7c5fd1;"></div>
            <div class="bar" style="height:7%;background:#3d2000;border:1px solid #92400e;"></div>
          </div>
          <div class="bar-label" data-en="Tue" data-km="អ">Tue</div>
        </div>
        <div class="bar-group">
          <div class="bar-wrap">
            <div class="bar" style="height:78%;background:#6d4fc2;"></div>
            <div class="bar" style="height:11%;background:#3d2000;border:1px solid #92400e;"></div>
          </div>
          <div class="bar-label" data-en="Wed" data-km="ព">Wed</div>
        </div>
        <div class="bar-group">
          <div class="bar-wrap">
            <div class="bar" style="height:90%;background:#a78bfa;"></div>
            <div class="bar" style="height:6%;background:#3d2000;border:1px solid #92400e;"></div>
          </div>
          <div class="bar-label" data-en="Thu" data-km="ព្រ">Thu</div>
        </div>
        <div class="bar-group">
          <div class="bar-wrap">
            <div class="bar" style="height:87%;background:#8b70e8;"></div>
            <div class="bar" style="height:8%;background:#3d2000;border:1px solid #92400e;"></div>
          </div>
          <div class="bar-label" data-en="Fri" data-km="សុ">Fri</div>
        </div>
      </div>
    </div>

    <!-- Donut chart -->
    <div class="card">
      <div class="card-header">
        <div class="card-title" data-en="Today's Summary" data-km="សង្ខេបថ្ងៃនេះ">Today's Summary</div>
        <div class="card-action" data-en="Details →" data-km="លម្អិត →">Details →</div>
      </div>
      <div class="donut-wrap">
        <svg width="120" height="120" viewBox="0 0 120 120" style="flex-shrink:0;">
          <circle cx="60" cy="60" r="44" fill="none" stroke="#1e2130" stroke-width="14"/>
          <circle cx="60" cy="60" r="44" fill="none" stroke="#a78bfa" stroke-width="14"
            stroke-dasharray="241 35" stroke-linecap="round" transform="rotate(-90 60 60)"/>
          <circle cx="60" cy="60" r="44" fill="none" stroke="#f87171" stroke-width="14"
            stroke-dasharray="30 246" stroke-linecap="round" stroke-dashoffset="-241" transform="rotate(-90 60 60)"/>
          <circle cx="60" cy="60" r="44" fill="none" stroke="#fbbf24" stroke-width="14"
            stroke-dasharray="14 262" stroke-linecap="round" stroke-dashoffset="-271" transform="rotate(-90 60 60)"/>
          <text x="60" y="56" text-anchor="middle" font-size="18" font-weight="700"
            fill="#fff" font-family="Syne,sans-serif">87%</text>
          <text x="60" y="70" text-anchor="middle" font-size="10"
            fill="#6b7280" font-family="DM Sans,sans-serif">present</text>
        </svg>
        <div class="legend">
          <div class="legend-item">
            <div class="legend-dot" style="background:#a78bfa;"></div>
            <span class="legend-lbl" data-en="Present" data-km="មានវត្តមាន">Present</span>
            <span class="legend-val">1,091</span>
          </div>
          <div class="legend-item">
            <div class="legend-dot" style="background:#f87171;"></div>
            <span class="legend-lbl" data-en="Absent" data-km="អវត្តមាន">Absent</span>
            <span class="legend-val">107</span>
          </div>
          <div class="legend-item">
            <div class="legend-dot" style="background:#fbbf24;"></div>
            <span class="legend-lbl" data-en="Late" data-km="មកយឺត">Late</span>
            <span class="legend-val">50</span>
          </div>
          <div class="legend-item">
            <div class="legend-dot" style="background:#4b5268;"></div>
            <span class="legend-lbl" data-en="Excused" data-km="មានការអនុញ្ញាត">Excused</span>
            <span class="legend-val">12</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom row -->
  <div class="bottom-grid">

    <!-- Attendance table -->
    <div class="card">
      <div class="card-header">
        <div class="card-title" data-en="Recent Attendance" data-km="វត្តមានថ្មីៗ">Recent Attendance</div>
        <div class="card-action" data-en="View all →" data-km="មើលទាំងអស់ →">View all →</div>
      </div>
      <table class="att-table">
        <thead>
          <tr>
            <th data-en="STUDENT" data-km="សិស្ស">STUDENT</th>
            <th data-en="CLASS" data-km="ថ្នាក់">CLASS</th>
            <th data-en="TIME" data-km="ម៉ោង">TIME</th>
            <th data-en="STATUS" data-km="ស្ថានភាព">STATUS</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><div class="student-cell">
              <div class="avatar-sm" style="background:#6d4fc2;">SK</div>
              <span class="stu-name">Sopheak Kong</span>
            </div></td>
            <td>Grade 10-A</td><td>07:48</td>
            <td><span class="status-badge s-present" data-en="Present" data-km="មានវត្តមាន">Present</span></td>
          </tr>
          <tr>
            <td><div class="student-cell">
              <div class="avatar-sm" style="background:#0f5e56;">RN</div>
              <span class="stu-name">Ratanak Noun</span>
            </div></td>
            <td>Grade 11-B</td><td>08:12</td>
            <td><span class="status-badge s-late" data-en="Late" data-km="យឺត">Late</span></td>
          </tr>
          <tr>
            <td><div class="student-cell">
              <div class="avatar-sm" style="background:#7c1d2a;">CS</div>
              <span class="stu-name">Chanmoly Sak</span>
            </div></td>
            <td>Grade 9-C</td><td>—</td>
            <td><span class="status-badge s-absent" data-en="Absent" data-km="អវត្តមាន">Absent</span></td>
          </tr>
          <tr>
            <td><div class="student-cell">
              <div class="avatar-sm" style="background:#3b4e0a;">VP</div>
              <span class="stu-name">Virak Phal</span>
            </div></td>
            <td>Grade 10-B</td><td>07:51</td>
            <td><span class="status-badge s-present" data-en="Present" data-km="មានវត្តមាន">Present</span></td>
          </tr>
          <tr>
            <td><div class="student-cell">
              <div class="avatar-sm" style="background:#4a2d00;">LT</div>
              <span class="stu-name">Leakhena Tep</span>
            </div></td>
            <td>Grade 12-A</td><td>08:05</td>
            <td><span class="status-badge s-present" data-en="Present" data-km="មានវត្តមាន">Present</span></td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Right side cards -->
    <div class="side-cards">

      <!-- Class progress -->
      <div class="card">
        <div class="card-header">
          <div class="card-title" data-en="Class Attendance Rate" data-km="អត្រាចូលរៀនតាមថ្នាក់">Class Attendance Rate</div>
        </div>
        <div class="progress-row">
          <div class="prog-item">
            <div class="prog-top"><span class="prog-name">Grade 12-A</span><span class="prog-pct">96%</span></div>
            <div class="prog-bar"><div class="prog-fill" style="width:96%;background:#a78bfa;"></div></div>
          </div>
          <div class="prog-item">
            <div class="prog-top"><span class="prog-name">Grade 10-B</span><span class="prog-pct">91%</span></div>
            <div class="prog-bar"><div class="prog-fill" style="width:91%;background:#7c5fd1;"></div></div>
          </div>
          <div class="prog-item">
            <div class="prog-top"><span class="prog-name">Grade 11-A</span><span class="prog-pct">84%</span></div>
            <div class="prog-bar"><div class="prog-fill" style="width:84%;background:#6d4fc2;"></div></div>
          </div>
          <div class="prog-item">
            <div class="prog-top"><span class="prog-name">Grade 9-C</span><span class="prog-pct">72%</span></div>
            <div class="prog-bar"><div class="prog-fill" style="width:72%;background:#fbbf24;"></div></div>
          </div>
        </div>
      </div>

      <!-- Activity feed -->
      <div class="card">
        <div class="card-header">
          <div class="card-title" data-en="Recent Activity" data-km="សកម្មភាពថ្មីៗ">Recent Activity</div>
        </div>
        <div class="activity-list">
          <div class="activity-item">
            <div class="act-dot" style="background:#34d399;"></div>
            <div>
              <div class="act-text" data-en="Grade 10-A attendance marked by Mr. Dara" data-km="វត្តមានថ្នាក់ 10-A ត្រូវបានកត់ត្រាដោយ លោក ដារា">Grade 10-A attendance marked by Mr. Dara</div>
              <div class="act-time" data-en="2 min ago" data-km="២ នាទីមុន">2 min ago</div>
            </div>
          </div>
          <div class="activity-item">
            <div class="act-dot" style="background:#f87171;"></div>
            <div>
              <div class="act-text" data-en="Absence alert sent for Chanmoly Sak" data-km="សេចក្តីជូនដំណឹងអវត្តមានបានផ្ញើសម្រាប់ ចាន់មុលី សាក់">Absence alert sent for Chanmoly Sak</div>
              <div class="act-time" data-en="15 min ago" data-km="១៥ នាទីមុន">15 min ago</div>
            </div>
          </div>
          <div class="activity-item">
            <div class="act-dot" style="background:#a78bfa;"></div>
            <div>
              <div class="act-text" data-en="New student enrolled in Grade 11-B" data-km="សិស្សថ្មីត្រូវបានចុះឈ្មោះក្នុងថ្នាក់ 11-B">New student enrolled in Grade 11-B</div>
              <div class="act-time" data-en="1 hr ago" data-km="១ ម៉ោងមុន">1 hr ago</div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</div>

<script>
  function setLang(lang, el) {
    document.querySelectorAll('.lang-btn').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    document.querySelectorAll('[data-en]').forEach(node => {
      node.textContent = lang === 'km' ? node.dataset.km : node.dataset.en;
    });
  }

  document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', function() {
      document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
      this.classList.add('active');
    });
  });
</script>

</body>
</html> 

