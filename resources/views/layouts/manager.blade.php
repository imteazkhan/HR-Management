<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Manager Dashboard - HR Management')</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/manager-dashboard.css') }}">
    
    @yield('styles')
</head>
<body>
    <!-- Mobile Header -->
    <div class="mobile-header d-lg-none">
        <button class="mobile-toggle" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        <div class="ms-2">
            <span class="fw-bold">@yield('page-title', 'Manager Dashboard')</span>
        </div>
        <div class="ms-auto">
            <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('logout.confirm') }}"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </div>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="p-3">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-briefcase"></i> iK soft
            </a>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}" href="{{ route('manager.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('manager.team') ? 'active' : '' }}" href="{{ route('manager.team') }}"><i class="bi bi-people"></i> My Team</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('manager.attendance') ? 'active' : '' }}" href="{{ route('manager.attendance') }}"><i class="bi bi-person-badge"></i> Team Attendance</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('manager.leave-requests') ? 'active' : '' }}" href="{{ route('manager.leave-requests') }}"><i class="bi bi-calendar-event"></i> Leave Approvals</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('manager.performance') ? 'active' : '' }}" href="{{ route('manager.performance') }}"><i class="bi bi-graph-up"></i> Team Performance</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('manager.reports') ? 'active' : '' }}" href="{{ route('manager.reports') }}"><i class="bi bi-clipboard-data"></i> Reports</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('manager.messages') ? 'active' : '' }}" href="{{ route('manager.messages') }}"><i class="bi bi-chat-dots"></i> Team Messages</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('manager.notifications') ? 'active' : '' }}" href="{{ route('manager.notifications') }}"><i class="bi bi-bell"></i> Notifications</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('manager.settings') ? 'active' : '' }}" href="{{ route('manager.settings') }}"><i class="bi bi-gear"></i> Settings</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 d-none d-lg-flex">
            <h2><i class="@yield('page-icon', 'bi bi-speedometer2')"></i> @yield('page-title', 'Manager Dashboard')</h2>
            <div class="d-flex align-items-center">
                <span class="me-3 d-none d-md-inline">Welcome, {{ Auth::user()->name }}!</span>
                <span class="me-3 d-none d-md-inline">|| {{ now()->format('l, F j, Y') }}</span>
                <span class="me-3 d-none d-lg-inline current-time"></span>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout.confirm') }}"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Mobile Welcome Message -->
        <div class="d-lg-none mb-3">
            <h4 class="mb-1">@yield('page-title', 'Manager Dashboard')</h4>
            <p class="text-muted mb-0">@yield('page-description', 'Manage your team effectively')</p>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/manager-dashboard.js') }}"></script>
    
    @yield('scripts')
</body>
</html>