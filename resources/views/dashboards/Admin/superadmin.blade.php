<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Super Admin Dashboard - HR Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Ensure Bootstrap takes priority over any conflicting styles -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"></noscript>
    <style>
        body { 
            background: #f8f9fa; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar { 
            background: #2c3e50; 
            min-height: 100vh; 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 250px; 
            z-index: 1000;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link { 
            color: #ecf0f1; 
            padding: 12px 20px; 
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 2px 8px;
        }
        .sidebar .nav-link:hover { 
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: #fff;
            transform: translateX(5px);
        }
        .sidebar .nav-link.active { 
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: #fff;
        }
        .sidebar .nav-link i { 
            width: 20px; 
            margin-right: 10px;
        }
        .main-content { 
            margin-left: 250px; 
            padding: 20px;
            transition: all 0.3s ease;
        }
        .mobile-header {
            display: none;
            background: #2c3e50;
            color: white;
            padding: 15px;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        .mobile-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
        }
        .card { 
            border: none; 
            border-radius: 15px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.08); 
            transition: all 0.3s ease;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .card:hover { 
          transform: translateY(-1px); 
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }
        .stat-card { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white;
        }
        .stat-card-2 { 
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); 
            color: white;
        }
        .stat-card-3 { 
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); 
            color: white;
        }
        .stat-card-4 { 
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); 
            color: white;
        }
        .navbar-brand { 
            font-weight: 700; 
            font-size: 1.5rem; 
            color: #fff !important;
        }
        .recent-activity { 
            max-height: 400px; 
            overflow-y: auto;
        }
        .activity-item { 
            padding: 15px 0; 
            border-bottom: 1px solid #eee;
        }
        .activity-item:last-child { 
            border-bottom: none;
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        
        /* Button Animations */
        .btn {
            transition: all 0.2s ease;
            border-radius: 8px;
        }
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .btn:active {
            transform: translateY(0);
        }
        
        /* Progress Bars */
        .progress {
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
        }
        .progress-bar {
            transition: width 1s ease-in-out;
        }
        
        /* Mobile Responsive */
        @media (max-width: 991.98px) {
            .sidebar { 
                transform: translateX(-100%); 
                transition: transform 0.3s ease;
            }
            .sidebar.show { 
                transform: translateX(0);
            }
            .main-content { 
                margin-left: 0;
                padding: 15px;
            }
            .mobile-header {
                display: flex;
                justify-content: between;
                align-items: center;
            }
            .sidebar-overlay.show {
                display: block;
            }
        }
        
        @media (max-width: 767.98px) {
            .stat-card h2 {
                font-size: 1.5rem;
            }
            .card-body {
                padding: 1rem;
            }
            .activity-item {
                padding: 10px 0;
            }
            .activity-item i {
                display: none;
            }
            .col-lg-3 {
                margin-bottom: 15px;
            }
        }
        
        @media (max-width: 575.98px) {
            .main-content {
                padding: 10px;
            }
            .card {
                margin-bottom: 15px;
            }
            .stat-card h6 {
                font-size: 0.8rem;
            }
            .stat-card h2 {
                font-size: 1.2rem;
            }
            .btn {
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
            }
        }
        
        /* Animations */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        /* Animations */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>
<body>
    <!-- Mobile Header -->
    <div class="mobile-header d-lg-none">
        <button class="mobile-toggle" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        <div class="ms-2">
            <span class="fw-bold">Super Admin</span>
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
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}" href="{{ route('superadmin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.employees') ? 'active' : '' }}" href="{{ route('superadmin.employees') }}"><i class="bi bi-people"></i> Employees</a></li>

            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.designations') ? 'active' : '' }}" href="{{ route('superadmin.designations') }}"><i class="bi bi-award"></i> Designations</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.departments') ? 'active' : '' }}" href="{{ route('superadmin.departments') }}"><i class="bi bi-building"></i> Departments</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.user-roles') ? 'active' : '' }}" href="{{ route('superadmin.user-roles') }}"><i class="bi bi-person-badge"></i> User Roles</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.payroll') ? 'active' : '' }}" href="{{ route('superadmin.payroll') }}"><i class="bi bi-cash-stack"></i> Payroll Management</a></li>

            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.attendance.index') ? 'active' : '' }}" href="{{ route('superadmin.attendance.index') }}"><i class="bi bi-calendar-check"></i> Attendance</a></li>

            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.analytics') ? 'active' : '' }}" href="{{ route('superadmin.analytics') }}"><i class="bi bi-graph-up"></i> Analytics</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.security') ? 'active' : '' }}" href="{{ route('superadmin.security') }}"><i class="bi bi-shield-check"></i> System Security</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.settings') ? 'active' : '' }}" href="{{ route('superadmin.settings') }}"><i class="bi bi-gear"></i> System Settings</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.database') ? 'active' : '' }}" href="{{ route('superadmin.database') }}"><i class="bi bi-database"></i> Database</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 d-none d-lg-flex">
            <h2><i class="bi bi-shield-fill-check text-primary"></i> Super Admin Dashboard</h2>
            <div class="d-flex align-items-center">
                <span class="me-3 d-none d-md-inline">Welcome, {{ Auth::user()->name }}!</span>
                <span class="me-3 d-none d-xl-inline">{{ now()->format('l, F j, Y') }}</span>
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
            <h4 class="mb-1">Welcome back, {{ Auth::user()->name }}!</h4>
            <p class="text-muted mb-0">System Administrator</p>
        </div>

        <!-- Key Metrics -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card stat-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Employees</h6>
                            <h2>{{ $stats['employees'] ?? 150 }}</h2>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-2 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Departments</h6>
                            <h2>{{ $stats['departments'] ?? 8 }}</h2>
                        </div>
                        <i class="bi bi-building fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-3 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Active Today</h6>
                            <h2>{{ $stats['attendance_today'] ?? 142 }}</h2>
                        </div>
                        <i class="bi bi-calendar-check fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-4 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Monthly Payroll</h6>
                            <h2>BDT {{ $stats['payroll_today'] ?? '485K' }}</h2>
                        </div>
                        <i class="bi bi-cash fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Tabs -->
        <ul class="nav nav-tabs mb-4" id="attendanceTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">
                    <i class="bi bi-speedometer2"></i> Overview
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="admin-attendance-tab" data-bs-toggle="tab" data-bs-target="#admin-attendance" type="button" role="tab" aria-controls="admin-attendance" aria-selected="false">
                    <i class="bi bi-person-badge"></i> Admin Attendance
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="employee-attendance-tab" data-bs-toggle="tab" data-bs-target="#employee-attendance" type="button" role="tab" aria-controls="employee-attendance" aria-selected="false">
                    <i class="bi bi-people"></i> Employee Attendance
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="manager-attendance-tab" data-bs-toggle="tab" data-bs-target="#manager-attendance" type="button" role="tab" aria-controls="manager-attendance" aria-selected="false">
                    <i class="bi bi-person-check"></i> Manager Attendance
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mb-4" id="attendanceTabContent">
            <!-- Overview Tab -->
            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                <div class="row g-3 g-md-4">
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Total Attendance</h6>
                                    <h2>{{ $attendanceStats['total_employees'] ?? 0 }}</h2>
                                </div>
                                <i class="bi bi-people fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card-2 p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Present Today</h6>
                                    <h2>{{ $attendanceStats['employee_present_today'] ?? 0 }}</h2>
                                </div>
                                <i class="bi bi-calendar-check fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card-3 p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Absent Today</h6>
                                    <h2>{{ $attendanceStats['employee_absent_today'] ?? 0 }}</h2>
                                </div>
                                <i class="bi bi-calendar-x fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card-4 p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Attendance Rate</h6>
                                    <h2>{{ $attendanceStats['employee_attendance_rate'] ?? 0 }}%</h2>
                                </div>
                                <i class="bi bi-graph-up fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Attendance Tab -->
            <div class="tab-pane fade" id="admin-attendance" role="tabpanel" aria-labelledby="admin-attendance-tab">
                <div class="row g-3 g-md-4">
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Total Admins</h6>
                                    <h2>{{ $attendanceStats['total_admins'] ?? 0 }}</h2>
                                </div>
                                <i class="bi bi-person-badge fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card-2 p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Present Today</h6>
                                    <h2>{{ $attendanceStats['admin_present_today'] ?? 0 }}</h2>
                                </div>
                                <i class="bi bi-calendar-check fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card-3 p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Absent Today</h6>
                                    <h2>{{ $attendanceStats['admin_absent_today'] ?? 0 }}</h2>
                                </div>
                                <i class="bi bi-calendar-x fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card-4 p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Attendance Rate</h6>
                                    <h2>{{ $attendanceStats['admin_attendance_rate'] ?? 0 }}%</h2>
                                </div>
                                <i class="bi bi-graph-up fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employee Attendance Tab -->
            <div class="tab-pane fade" id="employee-attendance" role="tabpanel" aria-labelledby="employee-attendance-tab">
                <div class="row g-3 g-md-4">
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Total Employees</h6>
                                    <h2>{{ $attendanceStats['total_employees'] ?? 0 }}</h2>
                                </div>
                                <i class="bi bi-people fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card-2 p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Present Today</h6>
                                    <h2>{{ $attendanceStats['employee_present_today'] ?? 0 }}</h2>
                                </div>
                                <i class="bi bi-calendar-check fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card-3 p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Absent Today</h6>
                                    <h2>{{ $attendanceStats['employee_absent_today'] ?? 0 }}</h2>
                                </div>
                                <i class="bi bi-calendar-x fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card-4 p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Attendance Rate</h6>
                                    <h2>{{ $attendanceStats['employee_attendance_rate'] ?? 0 }}%</h2>
                                </div>
                                <i class="bi bi-graph-up fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manager Attendance Tab -->
            <div class="tab-pane fade" id="manager-attendance" role="tabpanel" aria-labelledby="manager-attendance-tab">
                <div class="row g-3 g-md-4">
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Total Managers</h6>
                                    <h2>{{ $attendanceStats['total_managers'] ?? 0 }}</h2>
                                </div>
                                <i class="bi bi-person-check fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card-2 p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Present Today</h6>
                                    <h2>{{ $attendanceStats['manager_present_today'] ?? 0 }}</h2>
                                </div>
                                <i class="bi bi-calendar-check fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card-3 p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Absent Today</h6>
                                    <h2>{{ $attendanceStats['manager_absent_today'] ?? 0 }}</h2>
                                </div>
                                <i class="bi bi-calendar-x fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card-4 p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Attendance Rate</h6>
                                    <h2>{{ $attendanceStats['manager_attendance_rate'] ?? 0 }}%</h2>
                                </div>
                                <i class="bi bi-graph-up fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Administration -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="bi bi-shield-check"></i> System Administration</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center p-3 border rounded h-100">
                                    <i class="bi bi-people-fill fs-2 text-success me-3 d-none d-lg-block"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">User Management</h6>
                                        <p class="text-muted mb-2 small">Manage all users and roles</p>
                                        <button class="btn btn-sm btn-success w-100">Manage Users</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center p-3 border rounded h-100">
                                    <i class="bi bi-building fs-2 text-info me-3 d-none d-lg-block"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Department Setup</h6>
                                        <p class="text-muted mb-2 small">Configure departments</p>
                                        <button class="btn btn-sm btn-info w-100">Configure</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center p-3 border rounded h-100">
                                    <i class="bi bi-cash-stack fs-2 text-warning me-3 d-none d-lg-block"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Payroll Control</h6>
                                        <p class="text-muted mb-2 small">Master payroll settings</p>
                                        <button class="btn btn-sm btn-warning w-100">Control</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center p-3 border rounded h-100">
                                    <i class="bi bi-gear-fill fs-2 text-danger me-3 d-none d-lg-block"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">System Settings</h6>
                                        <p class="text-muted mb-2 small">Global system configuration</p>
                                        <button class="btn btn-sm btn-outline-danger w-100">Settings</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Manager Data Management -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5><i class="bi bi-database"></i> Manager Data Management</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center p-3 border rounded h-100">
                                    <i class="bi bi-chat-dots fs-2 text-primary me-3 d-none d-lg-block"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Messages</h6>
                                        <p class="text-muted mb-2 small">Manage system messages</p>
                                        <a href="{{ route('superadmin.manager-data.messages') }}" class="btn btn-sm btn-primary w-100">Manage</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center p-3 border rounded h-100">
                                    <i class="bi bi-bell fs-2 text-warning me-3 d-none d-lg-block"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Notifications</h6>
                                        <p class="text-muted mb-2 small">Manage user notifications</p>
                                        <a href="{{ route('superadmin.manager-data.notifications') }}" class="btn btn-sm btn-warning w-100">Manage</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center p-3 border rounded h-100">
                                    <i class="bi bi-people fs-2 text-success me-3 d-none d-lg-block"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Team Members</h6>
                                        <p class="text-muted mb-2 small">Manage team assignments</p>
                                        <a href="{{ route('superadmin.manager-data.team-members') }}" class="btn btn-sm btn-success w-100">Manage</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center p-3 border rounded h-100">
                                    <i class="bi bi-graph-up fs-2 text-info me-3 d-none d-lg-block"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Performance</h6>
                                        <p class="text-muted mb-2 small">Manage performance reviews</p>
                                        <a href="{{ route('superadmin.manager-data.performance-reviews') }}" class="btn btn-sm btn-info w-100">Manage</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center p-3 border rounded h-100">
                                    <i class="bi bi-gear-fill fs-2 text-secondary me-3 d-none d-lg-block"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Manager Settings</h6>
                                        <p class="text-muted mb-2 small">Manage manager preferences</p>
                                        <a href="{{ route('superadmin.manager-data.manager-settings') }}" class="btn btn-sm btn-secondary w-100">Manage</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row g-3 g-md-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header"><h5><i class="bi bi-clock-history"></i> System Activity</h5></div>
                    <div class="card-body recent-activity">
                        @if(isset($recentActivities) && count($recentActivities) > 0)
                            @foreach($recentActivities as $activity)
                                <div class="activity-item">
                                    <i class="bi bi-{{ $activity['icon'] }} text-{{ $activity['color'] }} me-3"></i> 
                                    {!! $activity['message'] !!} 
                                    <small class="text-muted d-block">{{ $activity['time'] }}</small>
                                </div>
                            @endforeach
                        @else
                            <div class="activity-item">
                                <i class="bi bi-info-circle text-info me-3"></i> 
                                No recent activities to display 
                                <small class="text-muted d-block">Just now</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header"><h5><i class="bi bi-graph-up"></i> System Overview</h5></div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3"><span>System Health</span><span class="badge bg-success">Excellent</span></div>
                        <div class="d-flex justify-content-between mb-3"><span>Active Users</span><span class="badge bg-info">{{ $stats['employees'] ?? 0 }}/150</span></div>
                        <div class="d-flex justify-content-between mb-3"><span>Pending Approvals</span><span class="badge bg-warning">7</span></div>
                        <div class="d-flex justify-content-between"><span>Database Size</span><span class="text-success fw-bold">2.4 GB</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
<script>
    // Ensure Bootstrap is loaded before executing
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile sidebar toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });
        }
        
        // Close sidebar when overlay is clicked
        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }
        
        // Initialize all Bootstrap tooltips and popovers
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
        
        // Handle attendance tab navigation
        const tabTriggerList = [].slice.call(document.querySelectorAll('#attendanceTabs button'))
        tabTriggerList.forEach(function (tabTrigger) {
            tabTrigger.addEventListener('click', function (event) {
                event.preventDefault();
                const tabTriggerEl = event.target;
                const tabPaneId = tabTriggerEl.getAttribute('data-bs-target');
                
                // Remove active class from all tabs and panes
                document.querySelectorAll('#attendanceTabs button').forEach(function(tab) {
                    tab.classList.remove('active');
                });
                document.querySelectorAll('.tab-pane').forEach(function(pane) {
                    pane.classList.remove('show', 'active');
                });
                
                // Add active class to clicked tab
                tabTriggerEl.classList.add('active');
                
                // Show the corresponding pane
                const tabPane = document.querySelector(tabPaneId);
                if (tabPane) {
                    tabPane.classList.add('show', 'active');
                }
            });
        });
    });
</script>
</body>
</html>
