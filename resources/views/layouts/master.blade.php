<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="google" content="notranslate"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'School System')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

    {{-- Bootstrap & Font Awesome --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@300;400;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet"/>

    <style>
        :root {
            --primary-blue: #1a237e;
            --bg-light: #f4f7fc;
            --sidebar-width: 260px;
        }

        /* Dark Mode Colors */
        [data-theme='dark'] {
            --bg-light: #121212;
            --sidebar-bg: #1e1e1e;
            --text-color: #e0e0e0;
            --card-bg: #2d2d2d;
            --border-color: #333;
        }

        body {
            font-family: 'Kantumruy Pro', 'Outfit', sans-serif;
            background: var(--bg-light);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            transition: background 0.3s;
        }

        [data-theme='dark'] body { color: var(--text-color); }

        .navbar { background: var(--primary-blue) !important; box-shadow: 0 2px 12px rgba(0,0,0,0.1); height: 60px; }
        .layout-body { display: flex; flex: 1; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: #fff;
            min-height: calc(100vh - 60px);
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
            position: sticky;
            top: 60px;
            height: calc(100vh - 60px);
            overflow-y: auto;
            flex-shrink: 0;
            transition: background 0.3s;
        }

        [data-theme='dark'] .sidebar { background: var(--sidebar-bg); border-right: 1px solid var(--border-color); }

        .sidebar-label { padding: 20px 20px 10px; font-size: 11px; font-weight: 700; color: #9ca3af; text-transform: uppercase; }
        .sidebar-divider { height: 1px; background: #eee; margin: 10px 20px; }
        [data-theme='dark'] .sidebar-divider { background: var(--border-color); }

        .sidebar a {
            display: flex; align-items: center; gap: 12px; padding: 12px 20px;
            color: #4b5563; text-decoration: none; font-size: 14px;
            transition: 0.2s; border-left: 4px solid transparent;
        }

        [data-theme='dark'] .sidebar a { color: #bbb; }

        .sidebar a:hover, .sidebar a.active {
            background: #e8eaf6; color: var(--primary-blue);
            border-left-color: var(--primary-blue); font-weight: 600;
        }

        [data-theme='dark'] .sidebar a:hover,
        [data-theme='dark'] .sidebar a.active {
            background: #333; color: #fff; border-left-color: #3f51b5;
        }

        .sidebar a.logout-link { color: #e11d48; }
        .sidebar a.logout-link:hover { background: #fff0f3; border-left-color: #e11d48; color: #e11d48; }

        .main-content { flex: 1; padding: 25px; background: inherit; }
        footer { background: var(--primary-blue); color: #fff; padding: 15px; text-align: center; font-size: 13px; }

        @media (max-width: 768px) {
            .sidebar { position: fixed; left: -260px; z-index: 1000; transition: 0.3s; }
            .sidebar.open { left: 0; }
            .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999; }
            .sidebar-overlay.show { display: block; }
        }
    </style>
    @yield('styles')

<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container-fluid">
        <button class="btn btn-outline-light me-2 d-md-none" onclick="toggleSidebar()">
            ☰
        </button>
        <a class="navbar-brand fw-bold" href="/">
            🎓SCHOOL SYSTEM
        </a>

        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto align-items-center">

                {{-- Language Switcher --}}
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        🌐 {{ app()->getLocale() == 'km' ? 'ភាសាខ្មែរ' : 'English' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item" href="{{ url('lang/km') }}">ភាសាខ្មែរ</a></li>
                        <li><a class="dropdown-item" href="{{ url('lang/en') }}">English</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active fw-semibold' : '' }}" href="/">
                        🏠 Home
                    </a>
                </li>
                    
                @auth
                {{-- Dashboard link in navbar --}}
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dashboard*') ? 'active fw-semibold' : '' }}" href="/dashboard">
                        📊 Dashboard
                    </a>
                </li>

                {{-- User dropdown --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                        <span style="width:30px;height:30px;border-radius:50%;background:rgba(255,255,255,0.2);display:inline-flex;align-items:center;justify-content:center;font-size:0.85rem;font-weight:700;">
                            {{ mb_substr(Auth::user()->name, 0, 1, 'UTF-8') }}
                        </span>
                        <span class="d-none d-lg-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="min-width:200px;">
                        <li>
                            <div style="padding:10px 18px 6px;">
                                <div style="font-size:0.88rem;font-weight:700;color:#1a237e;">{{ Auth::user()->name }}</div>
                                <div style="font-size:0.75rem;color:#6b7280;">{{ Auth::user()->email }}</div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider my-1"/></li>
                        <li>
                            <a class="dropdown-item" href="/profile">
                                🪪 Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/users">
                                ⚙️ Users
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"/></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    🚪 Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        🔑 Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}"
                       style="background:rgba(255,255,255,0.15);border-radius:8px;padding:0.4rem 1rem!important;">
                        ➕ Register
                    </a>
                </li>
                @endauth

                {{-- Dark Mode Toggle --}}
                <li class="nav-item">
                    <button id="themeToggle" class="ms-2" onclick="toggleTheme()"
                        style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.2);color:white;padding:5px 12px;border-radius:8px;cursor:pointer;">
                        🌙
                    </button>
                </li>

            </ul>
        </div>
    </div>
</nav>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<div class="layout-body">

    {{-- SIDEBAR --}}
    <aside class="sidebar" id="mainSidebar">

        {{-- Auth user info --}}
        @auth
        <div style="padding:14px 16px 10px;border-bottom:1px solid #f0f0f0;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#1a237e,#3949ab);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.9rem;flex-shrink:0;">
                    {{ mb_substr(Auth::user()->name, 0, 1, 'UTF-8') }}
                </div>
                <div style="min-width:0;">
                    <div style="font-size:0.83rem;font-weight:700;color:#1a237e;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ Auth::user()->name }}
                    </div>
                    <div style="font-size:0.7rem;color:#9ca3af;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ Auth::user()->email }}
                    </div>
                </div>
            </div>
        </div>
        @endauth


        {{-- ✅ Dashboard — Auth only --}}
        @auth
        <a href="/dashboard" class="{{ Request::is('dashboard*') ? 'active' : '' }}">
            📊 Dashboard
        </a>
        @endauth

        @if(Auth::check() && Auth::user()->role === 'admin')
        <a href="/teachers" class="{{ Request::is('teachers*') ? 'active' : '' }}">
            👨‍🏫 Teachers
        </a>
        <a href="/students" class="{{ Request::is('students*') ? 'active' : '' }}">
            👨‍🎓 Students
        </a>
        <a href="/classes" class="{{ Request::is('classes*') ? 'active' : '' }}">
            🏫 Class Schedule
        </a>
        @endif
        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'teacher')
        <a href="/courses" class="{{ Request::is('courses*') ? 'active' : '' }}">
            📚 Courses
        </a>
        @endif

        @if(Auth::user()->role === 'admin')
        <a href="/shop" class="{{ Request::is('shop*') ? 'active' : '' }}">
            🛍️ Shop
        </a>
        @endif

        @if(Auth::user()->role === 'student')
        <a href="{{ route('attendance-requests.create') }}" class="{{ Request::is('requests/create*') ? 'active' : '' }}">
            📨 Submit Request
        </a>
        <a href="{{ route('attendance-requests.my') }}" class="{{ Request::is('requests*') ? 'active' : '' }}">
            📋 My Requests
        </a>
        <a href="{{ route('attendance-requests.index') }}" class="{{ Request::is('student/attendance*') ? 'active' : '' }}">
            📅 Attendance History
        </a>
        @endif

        @if(Auth::user()->role === 'teacher')
        <a href="{{ route('attendances.create') }}" class="{{ Request::is('attendances/create*') ? 'active' : '' }}">
            📝 Take Attendance
        </a>
        <a href="{{ route('attendances.report') }}" class="{{ Request::is('attendances/report*') ? 'active' : '' }}">
            🖨️ Print Reports
        </a>
        <a href="{{ route('attendances.index') }}" class="{{ Request::is('teacher/requests*') ? 'active' : '' }}">
            📬 Manage Requests
        </a>
        @endif

        @auth
        <a href="/profile" class="{{ Request::is('profile*') ? 'active' : '' }}">
            👤 Profile
        </a>
        @if(Auth::user()->role === 'admin')
        <a href="/users" class="{{ Request::is('users*') ? 'active' : '' }}">
            ⚙️ Manage Users
        </a>
        @endif
        <a href="#" class="logout-link"
           onclick="document.getElementById('sidebarLogout').submit();return false;">
            🚪 Logout
        </a>
        <form id="sidebarLogout" method="POST" action="{{ route('logout') }}" style="display:none;">@csrf</form>
        @else
        <a href="{{ route('login') }}">
            🔑 Login
        </a>
        <a href="{{ route('register') }}">
            ➕ Register
        </a>
        @endauth

    </aside>

    {{-- MAIN CONTENT --}}
    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                ✅ {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                ⚠️ {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<footer>
    © 2026 Student Management System | Developed by <strong>Lyhuo</strong>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        document.getElementById('mainSidebar').classList.toggle('open');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    }

    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        const btn = document.getElementById('themeToggle');
        if (btn) btn.innerHTML = theme === 'dark' ? '☀️' : '🌙';
        localStorage.setItem('theme', theme);
    }

    function toggleTheme() {
        const current = document.documentElement.getAttribute('data-theme');
        applyTheme(current === 'dark' ? 'light' : 'dark');
    }

    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        applyTheme(savedTheme);
    } else {
        const hour = new Date().getHours();
        applyTheme((hour >= 18 || hour < 6) ? 'dark' : 'light');
    }
</script>

@yield('scripts')
</body>
</html>
