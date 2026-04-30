<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'School System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@300;400;600;700&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Kantumruy Pro', sans-serif; margin: 0; padding: 0; }
        .main-navbar { background: #1a237e; height: 60px; }
    </style>
    @yield('styles')
</head>
<body>
<nav class="main-navbar navbar navbar-expand-lg sticky-top" style="background:#fff;border-bottom:1px solid #e5e7eb;height:auto;padding:0 1.5rem;">
    <div class="container-fluid" style="gap:2rem;">
        <a class="navbar-brand fw-bold" href="/" style="color:#1a237e;display:flex;align-items:center;gap:10px;">
            <div style="background:#1a237e;width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-graduation-cap" style="color:#fff;font-size:16px;"></i>
            </div>
            <span style="font-size:1rem;font-weight:800;color:#1a237e;">SCHOOL SYSTEM</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-auto align-items-center gap-1">
                <li class="nav-item"><a class="nav-link" href="/" style="color:#374151;font-weight:600;font-size:0.9rem;padding:8px 14px;border-radius:6px;">ទំព័រដើម</a></li>
                <li class="nav-item"><a class="nav-link" href="/services" style="color:#374151;font-weight:600;font-size:0.9rem;padding:8px 14px;border-radius:6px;">សេវាកម្ម</a></li>
                <li class="nav-item"><a class="nav-link" href="/class" style="color:#374151;font-weight:600;font-size:0.9rem;padding:8px 14px;border-radius:6px;">ថ្នាក់រៀន</a></li>
                <li class="nav-item"><a class="nav-link" href="/shop" style="color:#374151;font-weight:600;font-size:0.9rem;padding:8px 14px;border-radius:6px;">ហាង</a></li>
                <li class="nav-item"><a class="nav-link" href="/about-us" style="color:#374151;font-weight:600;font-size:0.9rem;padding:8px 14px;border-radius:6px;">អំពីយើង</a></li>
                <li class="nav-item"><a class="nav-link" href="/contact-us" style="color:#374151;font-weight:600;font-size:0.9rem;padding:8px 14px;border-radius:6px;">ទំនាក់ទំនង</a></li>
                @auth
                <li class="nav-item"><a class="nav-link" href="/dashboard" style="color:#1565c0;font-weight:700;font-size:0.9rem;padding:8px 14px;border-radius:6px;background:#e8eaf6;">Dashboard</a></li>
                @endauth
            </ul>
            <ul class="navbar-nav align-items-center gap-2">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" style="color:#374151;font-size:0.85rem;font-weight:600;display:flex;align-items:center;gap:6px;padding:6px 10px;border:1px solid #e5e7eb;border-radius:6px;">
                        <span>🇰🇭</span> <span>{{ session('locale','kh') == 'en' ? 'English' : 'ខ្មែរ' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="border-radius:8px;border:1px solid #e5e7eb;">
                        <li><a class="dropdown-item" href="{{ route('lang.switch','kh') }}" style="font-size:0.85rem;">🇰🇭 ខ្មែរ</a></li>
                        <li><a class="dropdown-item" href="{{ route('lang.switch','en') }}" style="font-size:0.85rem;">🇺🇸 English</a></li>
                    </ul>
                </li>
                @guest
                <li class="nav-item">
                    <a href="{{ route('login') }}" style="color:#374151;font-weight:600;font-size:0.88rem;padding:8px 16px;border:1px solid #e5e7eb;border-radius:6px;text-decoration:none;">ចូល</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('register') }}" style="background:#1a237e;color:#fff;font-weight:700;font-size:0.88rem;padding:8px 18px;border-radius:6px;text-decoration:none;">ចុះឈ្មោះ →</a>
                </li>
                @endguest
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" style="color:#374151;font-size:0.88rem;font-weight:600;display:flex;align-items:center;gap:8px;padding:5px 10px;border:1px solid #e5e7eb;border-radius:6px;">
                        <div style="width:28px;height:28px;border-radius:50%;background:#1a237e;display:flex;align-items:center;justify-content:center;color:#fff;font-size:12px;font-weight:700;">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="border-radius:8px;border:1px solid #e5e7eb;">
                        <li><a class="dropdown-item" href="/profile" style="font-size:0.88rem;"><i class="fas fa-user me-2 text-muted"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" style="font-size:0.88rem;"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@yield('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>

</html>
