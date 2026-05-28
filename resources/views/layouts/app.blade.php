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

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fc;
            overflow-x: hidden;
        }
        .sidebar {
            min-width: 260px;
            max-width: 260px;
            background-color: #1e1e2d;
            color: #a2a3b7;
            min-height: 100vh;
            transition: all 0.3s;
            z-index: 100;
        }
        .sidebar .nav-link {
            color: #a2a3b7;
            padding: 12px 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
            border-radius: 6px;
            margin: 4px 15px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.05);
        }
        .sidebar .nav-link.active {
            color: #ffffff;
            background-color: #4f46e5;
        }
        .sidebar-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 15px 30px 5px;
            color: #494b66;
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
            border-bottom: 1px solid #e3e6f0;
            padding: 15px 30px;
            height: 64px;
        }
        .app-content {
            padding: 30px;
            background-color: #f8f9fc;
            flex-grow: 1;
        }
    </style>
</head>
<body class="d-flex">

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column shrink-0">
        <div class="p-4 border-bottom border-secondary border-opacity-10 d-flex align-items-center">
            <div class="bg-primary rounded-3 text-white d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; background-color: #4f46e5 !important;">
                <i class="fa-solid fa-list-check"></i>
            </div>
            <span class="fs-4 fw-bold text-white tracking-wide">TaskFlow</span>
        </div>

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
                <a href="{{ route('teams.index') }}" class="nav-link {{ request()->routeIs('teams.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-people-group me-3"></i>
                    Nhóm làm việc
                </a>
            </li>
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

        @if(auth()->user()->role === 'admin')
            <div class="sidebar-heading text-danger">Quản trị</div>
            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users-gear me-3"></i>
                        Quản lý User
                    </a>
                </li>
            </ul>
        @endif

        <div class="sidebar-heading">Hệ thống</div>
        <ul class="nav flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-gear me-3"></i>
                    Cài đặt hồ sơ
                </a>
            </li>
        </ul>

        <!-- User profile section -->
        <div class="p-4 border-top border-secondary border-opacity-10">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 36px; height: 36px; background-color: #4f46e5 !important;">
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
                <!-- Notifications quick view -->
                <a href="{{ route('notifications.index') }}" class="position-relative p-2 text-secondary hover-text-primary me-4">
                    <i class="fa-solid fa-bell fs-5"></i>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    @endif
                </a>

                <!-- Quick create task button -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaskModal" style="background-color: #4f46e5 !important; border-color: #4f46e5 !important;">
                    <i class="fa-solid fa-plus me-1"></i> Tạo task
                </button>
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