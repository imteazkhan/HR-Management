<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>System Analytics - HR Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"></noscript>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js" defer></script>
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
        .sidebar .dropdown-menu {
            background: #34495e;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 0;
            margin: 0.5rem 0 0 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .sidebar .dropdown-item {
            color: #ecf0f1;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
        }
        .sidebar .dropdown-item:hover {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: #fff;
        }
        .sidebar .dropdown-toggle::after {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
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
        .btn {
            /* transition: all 0.3s ease; */
            border-radius: 8px;
        }
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .btn:active {
            transform: translateY(0);
        }
        .progress {
            height: 8px;
            border-radius: 4px;
        }
        .list-group-item {
            border: none;
            border-bottom: 1px solid #dee2e6;
            transition: all 0.2s ease;
        }
        .list-group-item:hover {
            background-color: #f8f9fa;
            transform: scale(1.01); /* Changed from transform: scale(1.02); */
        }
        .analytics-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            color: white;
            font-size: 1.5rem;
        }
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
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.employees') ? 'active' : '' }}" href="{{ route('superadmin.employees') }}"><i class="bi bi-people"></i> All Employees</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.departments') ? 'active' : '' }}" href="{{ route('superadmin.departments') }}"><i class="bi bi-building"></i> Departments</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.user-roles') ? 'active' : '' }}" href="{{ route('superadmin.user-roles') }}"><i class="bi bi-person-badge"></i> User Roles</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.payroll') ? 'active' : '' }}" href="{{ route('superadmin.payroll') }}"><i class="bi bi-cash-stack"></i> Payroll Management</a></li>
            
            <!-- HRM Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-workspace"></i>
                    HRM
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('hrm.designations.index') }}">Designations</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.attendance.admin.index') }}">Admin Attendance</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.attendance.employee.index') }}">Employee Attendance</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.attendance.biometric.index') }}">Biometric Attendance</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.loans.office.index') }}">Office Loan</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.loans.personal.index') }}">Personal Loan</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.leaves.employee.index') }}">Employee Leaves</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.leaves.admin.index') }}">Admin Leaves</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.holidays.index') }}">Holidays</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.timesheets.index') }}">Time Sheet</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.schedules.index') }}">Schedule</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.overtime.index') }}">Overtime</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.warnings.index') }}">Warnings</a></li>
                </ul>
            </li>
            
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
            <h2><i class="bi bi-graph-up text-primary"></i> System Analytics</h2>
            <div class="d-flex align-items-center">
                <span class="me-3 d-none d-md-inline">Welcome, {{ Auth::user()->name }}!</span>
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

        <!-- Analytics Overview -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card stat-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Users</h6>
                            <h2>{{ $analytics['total_users'] }}</h2>
                            <small class="text-white-50">
                                <i class="bi bi-arrow-up"></i> +{{ $analytics['new_users_this_month'] }} this month
                            </small>
                        </div>
                        <i class="bi bi-people-fill fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-2 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Active Sessions</h6>
                            <h2>{{ $analytics['active_sessions'] }}</h2>
                            <small class="text-white-50">
                                <i class="bi bi-clock"></i> Real-time
                            </small>
                        </div>
                        <i class="bi bi-activity fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-3 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">System Uptime</h6>
                            <h2>{{ $analytics['system_uptime'] }}</h2>
                            <small class="text-white-50">
                                <i class="bi bi-check-circle"></i> Excellent
                            </small>
                        </div>
                        <i class="bi bi-server fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-4 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Storage Used</h6>
                            <h2>{{ $analytics['storage_used'] }}</h2>
                            <small class="text-white-50">
                                <i class="bi bi-exclamation-triangle"></i> 68% capacity
                            </small>
                        </div>
                        <i class="bi bi-hdd-stack fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">User Activity Trends</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="activityChart" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">User Roles Distribution</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="rolesChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Performance Metrics -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">System Performance</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">CPU Usage</label>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" style="width: 65%"></div>
                                </div>
                                <small class="text-muted">65% - Normal</small>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Memory Usage</label>
                                <div class="progress">
                                    <div class="progress-bar bg-warning" style="width: 78%"></div>
                                </div>
                                <small class="text-muted">78% - High</small>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Disk I/O</label>
                                <div class="progress">
                                    <div class="progress-bar bg-success" style="width: 45%"></div>
                                </div>
                                <small class="text-muted">45% - Good</small>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Network</label>
                                <div class="progress">
                                    <div class="progress-bar bg-info" style="width: 32%"></div>
                                </div>
                                <small class="text-muted">32% - Good</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Recent System Events</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-start fade-in-up">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Backup Completed</div>
                                    <small class="text-muted">System backup finished successfully</small>
                                </div>
                                <span class="badge bg-success rounded-pill">Success</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-start fade-in-up">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Security Scan</div>
                                    <small class="text-muted">No threats detected</small>
                                </div>
                                <span class="badge bg-primary rounded-pill">Info</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-start fade-in-up">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">System Update</div>
                                    <small class="text-muted">Update available</small>
                                </div>
                                <span class="badge bg-warning rounded-pill">Warning</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-start fade-in-up">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Database Optimization</div>
                                    <small class="text-muted">Query performance improved</small>
                                </div>
                                <span class="badge bg-info rounded-pill">Optimized</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Backup Status -->
        <div class="row g-3 g-md-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Backup & Recovery</h5>
                        <button type="button" class="btn btn-sm btn-success pulse-animation" onclick="initiateBackup()">
                            <i class="bi bi-shield-check"></i> Create Backup
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="display-6 text-success mb-2">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </div>
                                    <h6>Backup Status</h6>
                                    <p class="text-muted">{{ $analytics['backup_status'] }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="display-6 text-primary mb-2">
                                        <i class="bi bi-clock-fill"></i>
                                    </div>
                                    <h6>Last Backup</h6>
                                    <p class="text-muted">{{ $analytics['last_backup'] }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="display-6 text-info mb-2">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </div>
                                    <h6>Next Scheduled</h6>
                                    <p class="text-muted">{{ date('Y-m-d H:i:s', strtotime('+1 day')) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script>
        // Ensure Bootstrap and Chart.js are loaded before executing
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
            
            // Success/Error Message Auto-hide
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                if (!alert.classList.contains('alert-permanent')) {
                    setTimeout(function() {
                        alert.style.transition = 'opacity 0.5s';
                        alert.style.opacity = '0';
                        setTimeout(function() {
                            alert.remove();
                        }, 500);
                    }, 5000);
                }
            });

            // Backup Button Functionality
            window.initiateBackup = function() {
                const btn = event.target;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i> Creating...';
                btn.disabled = true;
                btn.classList.remove('pulse-animation');
                
                // Simulate backup process (replace with actual AJAX call to route)
                setTimeout(() => {
                    btn.innerHTML = '<i class="bi bi-check-circle"></i> Backup Complete';
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-outline-success');
                    
                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.classList.remove('btn-outline-success');
                        btn.classList.add('btn-success');
                        btn.classList.add('pulse-animation');
                        btn.disabled = false;
                    }, 2000);
                }, 3000);
            };

            // Chart.js for User Activity Trends
            const activityChart = document.getElementById('activityChart');
            if (activityChart) {
                new Chart(activityChart, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                            label: 'User Activity',
                            data: [100, 150, 200, 180, 250, {{ $analytics['active_sessions'] }}],
                            borderColor: '#4facfe',
                            backgroundColor: 'rgba(79, 172, 254, 0.2)',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            // Chart.js for User Roles Distribution
            const rolesChart = document.getElementById('rolesChart');
            if (rolesChart) {
                new Chart(rolesChart, {
                    type: 'pie',
                    data: {
                        labels: ['Super Admin', 'Manager', 'Employee'],
                        datasets: [{
                            data: [10, 20, {{ $analytics['total_users'] - 30 }}],
                            backgroundColor: ['#e74c3c', '#3498db', '#2ecc71'],
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>