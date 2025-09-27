<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Database Management - HR Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
        .table {
            border-collapse: separate;
            border-spacing: 0 8px;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            /* transform: scale(1.01); */
            transition: all 0.2s ease;
        }
        .database-icon, .tool-icon, .backup-icon {
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
        .database-icon.bg-primary { background: linear-gradient(135deg, #667eea, #764ba2); }
        .database-icon.bg-success { background: linear-gradient(135deg, #43e97b, #38f9d7); }
        .database-icon.bg-info { background: linear-gradient(135deg, #4facfe, #00f2fe); }
        .database-icon.bg-warning { background: linear-gradient(135deg, #f093fb, #f5576c); }
        .tool-icon.bg-primary { background: linear-gradient(135deg, #667eea, #764ba2); }
        .tool-icon.bg-success { background: linear-gradient(135deg, #43e97b, #38f9d7); }
        .tool-icon.bg-warning { background: linear-gradient(135deg, #f093fb, #f5576c); }
        .backup-item .border:hover {
            border-color: #007bff !important;
            box-shadow: 0 2px 8px rgba(0,123,255,0.15);
            transform: scale(1.01);
        }
        .progress {
            height: 6px;
            border-radius: 3px;
        }
        .database-tool {
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .database-tool:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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
            .card-body {
                padding: 1rem;
            }
            .col-lg-3, .col-lg-4, .col-lg-8 {
                margin-bottom: 15px;
            }
            .database-icon, .tool-icon {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
        }
        @media (max-width: 575.98px) {
            .main-content {
                padding: 10px;
            }
            .card {
                margin-bottom: 15px;
            }
            .btn {
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
            }
            .table {
                font-size: 0.85rem;
            }
            .database-icon, .tool-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
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
<<<<<<< HEAD
            
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
            
=======
>>>>>>> f37dbbf8b1009745044820acded90aff98423c3f
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
            <h2><i class="bi bi-database text-primary"></i> Database Management</h2>
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

        <!-- Database Status Overview -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card stat-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Tables</h6>
                            <h2>{{ $databaseStats['total_tables'] }}</h2>
                            <small class="text-white-50">All tables healthy</small>
                        </div>
                        <i class="bi bi-database-fill fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-2 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Records</h6>
                            <h2>{{ $databaseStats['total_records'] }}</h2>
                            <small class="text-white-50">Active data</small>
                        </div>
                        <i class="bi bi-files fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-3 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Database Size</h6>
                            <h2>{{ $databaseStats['database_size'] }}</h2>
                            <small class="text-white-50">68% capacity</small>
                        </div>
                        <i class="bi bi-hdd-stack fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-4 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Connection Status</h6>
                            <h2>{{ $databaseStats['connection_status'] }}</h2>
                            <small class="text-white-50">Healthy connection</small>
                        </div>
                        <i class="bi bi-wifi fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Database Tables Overview -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Database Tables</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Table Name</th>
                                        <th>Records</th>
                                        <th>Size</th>
                                        <th>Last Updated</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="fade-in-up">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-table me-2 text-primary"></i>
                                                <strong>users</strong>
                                            </div>
                                        </td>
                                        <td>{{ $databaseStats['total_records'] - 100 }}</td>
                                        <td>245 KB</td>
                                        <td>{{ now()->subMinutes(15)->format('M d, H:i') }}</td>
                                        <td><span class="badge bg-success rounded-pill">Healthy</span></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary pulse-animation" onclick="viewTable('users')">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-success pulse-animation" onclick="refreshTable('users')">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="fade-in-up">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-table me-2 text-primary"></i>
                                                <strong>leave_requests</strong>
                                            </div>
                                        </td>
                                        <td>45</td>
                                        <td>89 KB</td>
                                        <td>{{ now()->subHours(2)->format('M d, H:i') }}</td>
                                        <td><span class="badge bg-success rounded-pill">Healthy</span></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary pulse-animation" onclick="viewTable('leave_requests')">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-success pulse-animation" onclick="refreshTable('leave_requests')">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="fade-in-up">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-table me-2 text-primary"></i>
                                                <strong>attendance</strong>
                                            </div>
                                        </td>
                                        <td>320</td>
                                        <td>156 KB</td>
                                        <td>{{ now()->subHours(1)->format('M d, H:i') }}</td>
                                        <td><span class="badge bg-success rounded-pill">Healthy</span></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary pulse-animation" onclick="viewTable('attendance')">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-success pulse-animation" onclick="refreshTable('attendance')">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="fade-in-up">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-table me-2 text-primary"></i>
                                                <strong>departments</strong>
                                            </div>
                                        </td>
                                        <td>8</td>
                                        <td>12 KB</td>
                                        <td>{{ now()->subDays(3)->format('M d, H:i') }}</td>
                                        <td><span class="badge bg-success rounded-pill">Healthy</span></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary pulse-animation" onclick="viewTable('departments')">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-success pulse-animation" onclick="refreshTable('departments')">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup Management -->
            <div class="row g-3 g-md-4 mb-4">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Recent Backups</h5>
                        </div>
                        <div class="card-body">
                            <div class="backup-item fade-in-up">
                                <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="backup-icon me-3">
                                            <i class="bi bi-archive-fill text-success"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Full Database Backup</h6>
                                            <small class="text-muted">{{ $databaseStats['last_backup'] }}</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-success rounded-pill me-2">{{ $databaseStats['backup_size'] }}</span>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary pulse-animation" onclick="downloadBackup('full')">
                                                <i class="bi bi-download"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary pulse-animation" onclick="restoreBackup('full')">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger pulse-animation" onclick="deleteBackup('full')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="backup-item fade-in-up">
                                <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="backup-icon me-3">
                                            <i class="bi bi-archive-fill text-info"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Scheduled Backup</h6>
                                            <small class="text-muted">{{ now()->subDays(7)->format('M d, Y H:i:s') }}</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-info rounded-pill me-2">1.6 MB</span>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary pulse-animation" onclick="downloadBackup('scheduled')">
                                                <i class="bi bi-download"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary pulse-animation" onclick="restoreBackup('scheduled')">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger pulse-animation" onclick="deleteBackup('scheduled')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="backup-item fade-in-up">
                                <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="backup-icon me-3">
                                            <i class="bi bi-archive-fill text-warning"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Manual Backup</h6>
                                            <small class="text-muted">{{ now()->subDays(14)->format('M d, Y H:i:s') }}</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-warning rounded-pill me-2">1.4 MB</span>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary pulse-animation" onclick="downloadBackup('manual')">
                                                <i class="bi bi-download"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary pulse-animation" onclick="restoreBackup('manual')">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger pulse-animation" onclick="deleteBackup('manual')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Database Tools</h5>
                            <button type="button" class="btn btn-sm btn-success pulse-animation" onclick="createBackup()">
                                <i class="bi bi-download"></i> Create Backup
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="database-tool mb-3 fade-in-up">
                                <div class="text-center">
                                    <div class="tool-icon bg-primary mb-2">
                                        <i class="bi bi-speedometer2"></i>
                                    </div>
                                    <h6>Optimize Database</h6>
                                    <p class="text-muted small">Optimize all tables for better performance</p>
                                    <button class="btn btn-outline-primary btn-sm pulse-animation" onclick="optimizeDatabase()">
                                        Optimize Now
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <div class="database-tool mb-3 fade-in-up">
                                <div class="text-center">
                                    <div class="tool-icon bg-success mb-2">
                                        <i class="bi bi-check-circle"></i>
                                    </div>
                                    <h6>Repair Tables</h6>
                                    <p class="text-muted small">Check and repair database tables</p>
                                    <button class="btn btn-outline-success btn-sm pulse-animation" onclick="repairTables()">
                                        Check & Repair
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <div class="database-tool fade-in-up">
                                <div class="text-center">
                                    <div class="tool-icon bg-warning mb-2">
                                        <i class="bi bi-trash"></i>
                                    </div>
                                    <h6>Clean Up</h6>
                                    <p class="text-muted small">Remove old logs and temporary data</p>
                                    <button class="btn btn-outline-warning btn-sm pulse-animation" onclick="cleanupDatabase()">
                                        Clean Up
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Database Configuration -->
            <div class="row g-3 g-md-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Database Configuration</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label class="form-label">Database Engine</label>
                                    <p class="fw-bold">MySQL 8.0</p>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label class="form-label">Character Set</label>
                                    <p class="fw-bold">utf8mb4_unicode_ci</p>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label class="form-label">Max Connections</label>
                                    <p class="fw-bold">151</p>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label class="form-label">Query Cache</label>
                                    <p class="fw-bold text-success">Enabled</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="form-label">Performance Metrics</label>
                                    <div class="mt-2">
                                        <div class="d-flex justify-content-between">
                                            <small>Query Time</small>
                                            <small>0.23ms avg</small>
                                        </div>
                                        <div class="progress mb-2">
                                            <div class="progress-bar bg-success" style="width: 25%"></div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <small>Connection Pool</small>
                                            <small>45/151 used</small>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-primary" style="width: 30%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label">Storage Information</label>
                                    <div class="mt-2">
                                        <div class="d-flex justify-content-between">
                                            <small>Used Space</small>
                                            <small>{{ $databaseStats['database_size'] }}</small>
                                        </div>
                                        <div class="progress mb-2">
                                            <div class="progress-bar bg-info" style="width: 68%"></div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <small>Index Size</small>
                                            <small>0.8 MB</small>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" style="width: 35%"></div>
                                        </div>
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

            // Database Actions
            window.performDatabaseAction = function(action, successMessage) {
                const btn = event.target;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i> Working...';
                btn.disabled = true;
                btn.classList.remove('pulse-animation');
                
                // Simulate database action (replace with actual AJAX call)
                setTimeout(() => {
                    btn.innerHTML = '<i class="bi bi-check-circle"></i> Complete';
                    btn.classList.add('btn-success');
                    
                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.classList.remove('btn-success');
                        btn.classList.add('pulse-animation');
                        btn.disabled = false;
                    }, 2000);
                }, 3000);
            };

            window.createBackup = function() {
                performDatabaseAction('Create Backup', 'Backup created successfully!');
            };

            window.optimizeDatabase = function() {
                performDatabaseAction('Optimize Database', 'Database optimized successfully!');
            };

            window.repairTables = function() {
                performDatabaseAction('Repair Tables', 'All tables checked and repaired!');
            };

            window.cleanupDatabase = function() {
                performDatabaseAction('Database Cleanup', 'Database cleanup completed!');
            };

            window.viewTable = function(tableName) {
                console.log(`Viewing table: ${tableName}`);
                // Replace with actual table view logic (e.g., AJAX call or redirect)
            };

            window.refreshTable = function(tableName) {
                performDatabaseAction(`Refresh Table ${tableName}`, `Table ${tableName} refreshed successfully!`);
            };

            window.downloadBackup = function(backupType) {
                console.log(`Downloading ${backupType} backup`);
                // Replace with actual download logic (e.g., AJAX call or file download)
            };

            window.restoreBackup = function(backupType) {
                performDatabaseAction(`Restore ${backupType} Backup`, `${backupType} backup restored successfully!`);
            };

            window.deleteBackup = function(backupType) {
                performDatabaseAction(`Delete ${backupType} Backup`, `${backupType} backup deleted successfully!`);
            };

            // Export Database Button
            document.querySelector('.btn-outline-secondary').addEventListener('click', function() {
                console.log('Exporting database...');
                // Replace with actual export logic (e.g., AJAX call or file download)
            });
        });
    </script>
</body>
</html>