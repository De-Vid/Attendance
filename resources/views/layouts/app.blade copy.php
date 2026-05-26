<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'ប្រព័ន្ធគ្រប់គ្រង')</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0/dist/css/adminlte.min.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

    <style>
    body {
        font-family: 'Kantumruy Pro', sans-serif;
        background: #f4f6f9;
    }

    .app-wrapper {
        min-height: 100vh;
    }

    /* SIDEBAR */
    .app-sidebar {
        background: #343a40 !important;
        border-right: 1px solid rgba(255, 255, 255, .05);
    }

    .sidebar-brand {
        height: 65px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid rgba(255, 255, 255, .08);
    }

    .brand-link {
        text-decoration: none;
        font-size: 1.4rem;
        font-weight: 600;
    }

    .sidebar-menu .nav-link {
        color: #c2c7d0;
        border-radius: 8px;
        margin: 4px 10px;
        padding: .75rem 1rem;
        transition: .2s;
    }

    .sidebar-menu .nav-link:hover {
        background: #007bff;
        color: white;
    }

    .sidebar-menu .nav-link.active {
        background: #007bff;
        color: white;
    }

    .sidebar-menu .nav-icon {
        margin-right: 10px;
    }

    /* TOPBAR */
    .app-header {
        background: white;
        border-bottom: 1px solid #dee2e6;
    }

    .navbar {
        height: 60px;
    }

    /* CONTENT */
    .app-main {
        background: #f4f6f9;
        min-height: calc(100vh - 60px);
    }

    /* CARD */
    .dashboard-card {
        border: none;
        border-radius: 6px;
        color: white;
        overflow: hidden;
        position: relative;
        transition: .2s;
    }

    .dashboard-card:hover {
        transform: translateY(-2px);
    }

    .dashboard-card .icon {
        position: absolute;
        right: 20px;
        top: 20px;
        font-size: 60px;
        opacity: .15;
    }

    .dashboard-card .count {
        font-size: 2rem;
        font-weight: 700;
    }

    .dashboard-card .title {
        font-size: 1rem;
        margin-top: 5px;
    }

    .bg-dark-card {
        background: #343a40;
    }

    .bg-red-card {
        background: #dc3545;
    }

    .bg-yellow-card {
        background: #ffc107;
        color: #222;
    }

    .bg-green-card {
        background: #28a745;
    }

    .bg-blue-card {
        background: #007bff;
    }

    .bg-gray-card {
        background: #6c757d;
    }

    .bg-info-card {
        background: #17a2b8;
    }
    </style>

    @stack('styles')
</head>

<body class="layout-fixed sidebar-expand-lg">

    <div class="app-wrapper">

        <!-- NAVBAR -->
        <nav class="app-header navbar navbar-expand">

            <div class="container-fluid">

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#">
                            <i class="fas fa-bars"></i>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">

                    @auth

                    <li class="nav-item me-2">
                        <span class="nav-link">
                            <span class="fw-bold">{{ Auth::user()->name }}</span>
                        </span>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </li>

                    @endauth

                </ul>

            </div>

        </nav>

        <!-- SIDEBAR -->
        <aside class="app-sidebar shadow" data-bs-theme="dark">

            <div class="sidebar-brand">
                <a href="#" class="brand-link text-white">
                    <span class="fw-bold">{{ Auth::user()->name }}</span>
                </a>
            </div>

            <div class="sidebar-wrapper">

                <nav class="mt-3">

                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview">

                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p class="fw-bold">Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('employees.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p class="fw-bold">Employees</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('positions.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-briefcase"></i>
                                <p class="fw-bold">Positions</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('attendance-settings.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-clock"></i>
                                <p class="fw-bold">Set Time</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('attendance_types.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-clock"></i>
                                <p class="fw-bold">Time Work</p>
                            </a>
                        </li>

                    </ul>

                </nav>

            </div>

        </aside>

        <!-- MAIN -->
        <main class="app-main p-4">

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            @yield('content')

        </main>

    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- AdminLTE -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0/dist/js/adminlte.min.js"></script>

    @stack('scripts')

</body>

</html>