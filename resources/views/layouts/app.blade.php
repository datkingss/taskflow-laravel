<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TaskFlow') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts & FontAwesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Vite Assets for Live Reload / HMR -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }
        .sidebar {
            min-width: 260px;
            max-width: 260px;
            background-color: #343a40;
            color: #c2c7d0;
            min-height: 100vh;
            z-index: 100;
        }
        .sidebar .nav-link {
            color: #c2c7d0;
            padding: 10px 15px;
            font-weight: 500;
            display: flex;
            align-items: center;
            border-radius: 4px;
            margin: 2px 10px;
            text-decoration: none;
        }
        .sidebar .nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link.active {
            color: #ffffff;
            background-color: #0d6efd;
        }
        .sidebar-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 12px 25px 4px;
            color: #6c757d;
            font-weight: 700;
        }
        .main-container {
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .app-header {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
            padding: 15px 30px;
            height: 64px;
        }
        .app-content {
            padding: 20px;
            background-color: #f8f9fa;
            flex-grow: 1;
        }
    </style>
</head>
<body class="d-flex">

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column shrink-0">
        <div class="p-4 border-bottom border-secondary border-opacity-10 d-flex align-items-center">
            <div class="bg-primary rounded-3 text-white d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; background-color: #0d6efd !important;">
                <i class="fa-solid fa-list-check"></i>
            </div>
            <span class="fs-4 fw-bold text-white tracking-wide">TaskFlow</span>
        </div>

        @if(auth()->user()->role !== 'admin')
            <div class="sidebar-heading">Tổng quan</div>
            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-house me-3"></i>
                        Trang chủ
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tasks.index') }}" class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-square-check me-3"></i>
                        Công việc
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('calendar.index') }}" class="nav-link {{ request()->routeIs('calendar.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-calendar-days me-3"></i>
                        Lịch
                    </a>
                </li>
            </ul>

            <div class="sidebar-heading">Quản lý</div>
            <ul class="nav flex-column mb-2">

                <li class="nav-item">
                    <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-invoice-dollar me-3"></i>
                        Báo cáo
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('notifications.index') }}" class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }} d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fa-solid fa-bell me-3"></i>
                            Thông báo
                        </div>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="badge bg-danger rounded-pill">{{ auth()->user()->unreadNotifications->count() }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        @endif

        @if(auth()->user()->role === 'admin')
            <div class="sidebar-heading text-danger">Quản trị</div>
            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users-gear me-3"></i>
                        Quản lý User
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.tasks.index') }}" class="nav-link {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-list-check me-3"></i>
                        Quản lý Công việc
                    </a>
                </li>
            </ul>
        @endif



        <!-- User profile section -->
        <div class="p-4 border-top border-secondary border-opacity-10 mt-auto">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 36px; height: 36px; background-color: #0d6efd !important;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="overflow-hidden">
                    <p class="mb-0 text-white fw-semibold text-truncate" style="font-size: 0.9rem;">{{ auth()->user()->name }}</p>
                    <span class="badge bg-secondary text-uppercase" style="font-size: 0.65rem;">
                        {{ auth()->user()->role === 'admin' ? 'Quản trị viên' : 'Thành viên' }}
                    </span>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm w-100 text-start">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Đăng xuất
                </button>
            </form>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Header -->
        <header class="app-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold text-dark">{{ $header ?? 'Dashboard' }}</h4>
            <div class="d-flex align-items-center">
                @if(auth()->user()->role !== 'admin')
                    <!-- Notifications quick view -->
                    <a href="{{ route('notifications.index') }}" class="position-relative p-2 text-secondary hover-text-primary">
                        <i class="fa-solid fa-bell fs-5"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                                <span class="visually-hidden">New alerts</span>
                            </span>
                        @endif
                    </a>
                @endif
            </div>
        </header>

        <!-- Main Content -->
        <main class="app-content">
            <!-- Global Flash Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>

    <!-- Bootstrap 5 Bundle JS (Popper included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>