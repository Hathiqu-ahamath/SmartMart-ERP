<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SmartMart ERP') - SmartMart ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600;700&family=Fira+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @stack('styles')
    <style>
        :root {
            --primary: #7C3AED;
            --primary-dark: #5B21B6;
            --primary-light: #A78BFA;
            --primary-bg: #FAF5FF;
            --accent: #F97316;
            --accent-hover: #EA580C;
            --sidebar-bg: #1E1B2E;
            --sidebar-hover: rgba(124, 58, 237, 0.15);
            --sidebar-active: rgba(124, 58, 237, 0.25);
            --body-bg: #F5F3FF;
            --card-bg: #ffffff;
            --border-color: #E5E7EB;
            --text-primary: #1F2937;
            --text-secondary: #6B7280;
            --text-muted: #9CA3AF;
            --sidebar-width: 260px;

            /* ─── Motion Design — Corporate Personality ─── */
            --ease-snappy: cubic-bezier(0.2, 0, 0, 1);
            --ease-standard: cubic-bezier(0.4, 0, 0.2, 1);
            --ease-entrance: cubic-bezier(0.05, 0.7, 0.1, 1);
            --ease-exit: cubic-bezier(0.3, 0, 1, 1);
            --duration-micro: 150ms;
            --duration-standard: 250ms;
            --duration-entrance: 400ms;
            --duration-slow: 600ms;
            --motion-transition: 250ms var(--ease-snappy);
        }

        /* ─── Reduced Motion ─── */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* ─── Keyframes ─── */
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeSlideDown {
            from { opacity: 0; transform: translateY(-16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeSlideRight {
            from { opacity: 0; transform: translateX(-8px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }
        @keyframes badgePulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.15); }
        }
        @keyframes countUp {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ─── Base ─── */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Fira Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--body-bg);
            overflow-x: hidden;
            color: var(--text-primary);
        }
        code, .code, pre, .badge-code { font-family: 'Fira Code', monospace; }
        .wrapper { display: flex; min-height: 100vh; }

        /* ─── Sidebar ─── */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            color: #fff;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: left var(--duration-standard) var(--ease-snappy);
            animation: fadeSlideRight var(--duration-entrance) var(--ease-entrance) both;
        }
        .sidebar .brand {
            padding: 20px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }
        .sidebar .brand h4 {
            margin: 0;
            font-weight: 700;
            font-size: 1.15rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar .brand h4 i { color: var(--primary-light); }
        .sidebar .brand small { opacity: 0.5; font-size: 0.7rem; display: block; margin-top: 2px; }
        .sidebar .nav { flex: 1; overflow-y: auto; padding: 8px 0; }
        .sidebar .nav-item { width: 100%; }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.55);
            padding: 10px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all var(--duration-standard) var(--ease-snappy);
            border-left: 3px solid transparent;
            text-decoration: none;
            margin: 1px 12px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 400;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background: var(--sidebar-hover);
            border-left-color: transparent;
        }
        .sidebar .nav-link.active {
            color: #fff;
            background: var(--sidebar-active);
            border-left-color: var(--primary-light);
            font-weight: 500;
        }
        .sidebar .nav-link i { width: 20px; text-align: center; font-size: 1rem; flex-shrink: 0; }
        .sidebar .nav-link .badge { margin-left: auto; }
        .sidebar .nav-header {
            padding: 16px 24px 6px;
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(255,255,255,0.25);
            font-weight: 600;
        }
        .sidebar .nav-link .badge.bg-danger {
            animation: badgePulse 2s var(--ease-snappy) infinite;
        }

        /* ─── Content ─── */
        .content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 20px 30px;
            min-height: 100vh;
            animation: fadeIn var(--duration-entrance) var(--ease-entrance) both;
        }
        .navbar-top {
            background: var(--card-bg);
            padding: 12px 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: -20px -30px 20px -30px;
            border-bottom: 1px solid var(--border-color);
        }
        .navbar-top .page-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
        }
        .navbar-top .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.875rem;
        }
        .navbar-top .user-info a {
            color: var(--text-primary);
            transition: color var(--duration-micro) var(--ease-snappy);
        }
        .navbar-top .user-info a:hover { color: var(--primary); }

        /* ─── Cards ─── */
        .stats-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            transition: all var(--duration-standard) var(--ease-snappy);
            border: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
        }
        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(124, 58, 237, 0.1);
            border-color: var(--primary-light);
        }
        .stats-card .icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            color: #fff;
        }
        .stats-card .label { font-size: 0.8rem; color: var(--text-secondary); margin-top: 10px; font-weight: 500; }
        .stats-card .value { font-size: 1.6rem; font-weight: 700; color: var(--text-primary); }

        /* ─── Entrance stagger (applied via JS) ─── */
        .stagger-enter { opacity: 0; transform: translateY(12px); }
        .stagger-enter.active {
            animation: fadeSlideUp var(--duration-entrance) var(--ease-entrance) both;
        }

        /* ─── Tables ─── */
        .table-container {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            border: 1px solid var(--border-color);
            transition: box-shadow var(--duration-standard) var(--ease-snappy);
        }
        .table-container:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
        .table th {
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            border-bottom: 2px solid var(--border-color);
        }
        .table td {
            vertical-align: middle;
            font-size: 0.875rem;
        }
        .table-hover tbody tr {
            transition: background-color var(--duration-micro) var(--ease-snappy);
        }
        .table-hover tbody tr:hover { background-color: var(--primary-bg); }

        /* ─── Badges ─── */
        .badge-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        /* ─── Forms ─── */
        .form-control, .form-select {
            border-radius: 8px;
            border: 1.5px solid var(--border-color);
            padding: 10px 14px;
            font-size: 0.875rem;
            transition: all var(--duration-micro) var(--ease-snappy);
            font-family: 'Fira Sans', sans-serif;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.12);
        }
        .form-label { font-weight: 500; font-size: 0.8rem; color: var(--text-primary); margin-bottom: 4px; }

        /* ─── Buttons ─── */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            padding: 8px 18px;
            transition: all var(--duration-standard) var(--ease-snappy);
            cursor: pointer;
        }
        .btn:active { transform: scale(0.97); }
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3); }
        .btn-primary:active { transform: scale(0.97) translateY(0); }
        .btn-outline-primary { color: var(--primary); border-color: var(--primary); }
        .btn-outline-primary:hover { background: var(--primary); border-color: var(--primary); }
        .btn-warning { background: var(--accent); border-color: var(--accent); color: #fff; }
        .btn-warning:hover { background: var(--accent-hover); border-color: var(--accent-hover); color: #fff; transform: translateY(-1px); }
        .btn-warning:active { transform: scale(0.97) translateY(0); }
        .btn-outline-danger { transition: all var(--duration-micro) var(--ease-snappy); }
        .btn-outline-danger:hover { transform: translateY(-1px); }
        .btn-outline-danger:active { transform: scale(0.97); }
        .btn-sm { padding: 5px 12px; font-size: 0.8rem; }

        /* ─── Alerts ─── */
        .alert {
            border-radius: 10px;
            border: none;
            font-size: 0.875rem;
            animation: fadeSlideDown var(--duration-slow) var(--ease-entrance) both;
        }
        .alert-success { background: #ECFDF5; color: #065F46; }
        .alert-danger { background: #FEF2F2; color: #991B1B; }
        .alert-warning { background: #FFF7ED; color: #9A3412; }
        .alert-info { background: var(--primary-bg); color: #5B21B6; }

        /* ─── Misc ─── */
        .alert-badge {
            position: absolute;
            top: 0;
            right: 0;
            transform: translate(25%, -25%);
            font-size: 0.6rem;
            padding: 2px 6px;
        }
        .cursor-pointer { cursor: pointer; }

        /* ─── Low stock badge pulse ─── */
        .badge.bg-danger:not(.badge-status) {
            animation: badgePulse 2s var(--ease-snappy) infinite;
        }

        /* ─── Scrollbar ─── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.15); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.25); }

        @media (max-width: 768px) {
            .sidebar { left: calc(var(--sidebar-width) * -1); }
            .sidebar.show { left: 0; }
            .content { margin-left: 0; padding: 16px; }
            .navbar-top { margin: -16px -16px 16px -16px; padding: 10px 16px; }
            .navbar-top .page-title { font-size: 1rem; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        @include('layouts.sidebar')
        <div class="content">
            <div class="navbar-top">
                <div class="page-title">@yield('page-title', 'Dashboard')</div>
                <div class="user-info">
                    <a href="{{ route('profile.show') }}" class="text-decoration-none text-dark me-3 d-flex align-items-center gap-2">
                        @if(auth()->user()->profile_picture)
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="" class="rounded-circle" style="width: 28px; height: 28px; object-fit: cover;">
                        @else
                            <i class="bi bi-person-circle fs-5"></i>
                        @endif
                        {{ auth()->user()->name }}
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                    </form>
                </div>
            </div>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // ─── Staggered entrance for cards ───
        var staggerEls = document.querySelectorAll('.stats-card, .table-container:not(.navbar-top)');
        staggerEls.forEach(function(el, i) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(12px)';
            setTimeout(function() {
                el.style.transition = 'opacity 400ms cubic-bezier(0.05,0.7,0.1,1), transform 400ms cubic-bezier(0.05,0.7,0.1,1)';
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, 60 + i * 80);
        });

        // ─── Alert auto-dismiss after 5s ───
        document.querySelectorAll('.alert-dismissible').forEach(function(alert) {
            setTimeout(function() {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });
    </script>
    @stack('scripts')
</body>
</html>
