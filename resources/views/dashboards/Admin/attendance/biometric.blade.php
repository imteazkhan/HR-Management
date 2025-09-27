<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biometric Attendance - HR Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { 
            background: #f8f9fa; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar { 
            background: linear-gradient(180deg, #4e73df 0%, #2e59d9 100%);
            color: white;
            min-height: 100vh; 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 250px; 
            z-index: 1000;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link { 
            color: rgba(255, 255, 255, 0.8);
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
        .dropdown-menu {
            background-color: #2e59d9;
            border: none;
        }
        
        .dropdown-item {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
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
            transition: all 0.3s ease;
            border-radius: 8px;
        }
        .btn:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .btn:active {
            transform: translateY(0);
        }
        .progress {
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
        }
        .progress-bar {
            transition: width 1s ease-in-out;
        }
        .biometric-device {
            background: #f8f9fc;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
            border: 1px solid #e3e6f0;
        }
        .device-icon {
            font-size: 3rem;
            color: #4e73df;
            margin-bottom: 15px;
        }
        .device-status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 500;
        }
        .status-connected {
            background: #1cc88a;
            color: white;
        }
        .status-disconnected {
            background: #e74a3b;
            color: white;
        }
        .fingerprint-display {
            height: 200px;
            background: #2e59d9;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin: 20px 0;
            position: relative;
            overflow: hidden;
        }
        .fingerprint-circle {
            width: 150px;
            height: 150px;
            border: 3px dashed rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s infinite;
        }
        .fingerprint-icon {
            font-size: 4rem;
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
            <li class="nav-item">
                <a class="nav-link" href="{{ route('superadmin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            
            <!-- Employee Management Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-people"></i>
                    Employee Management
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('superadmin.employees') }}">All Employees</a></li>
                    <li><a class="dropdown-item" href="{{ route('superadmin.departments') }}">Departments</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.designations.index') }}">Designations</a></li>
                </ul>
            </li>
            
            <!-- Attendance Management Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-calendar-check"></i>
                    Attendance
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('hrm.attendance.admin.index') }}">Admin Attendance</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.attendance.employee.index') }}">Employee Attendance</a></li>
                    <li><a class="dropdown-item active" href="{{ route('hrm.attendance.biometric.index') }}">Biometric Attendance</a></li>
                </ul>
            </li>
            
            <!-- Loan Management Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-cash-stack"></i>
                    Loans
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('hrm.loans.office.index') }}">Office Loan</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.loans.personal.index') }}">Personal Loan</a></li>
                </ul>
            </li>
            
            <!-- Leave Management Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-calendar-x"></i>
                    Leaves
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('hrm.leaves.employee.index') }}">Employee Leaves</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.leaves.admin.index') }}">Admin Leaves</a></li>
                </ul>
            </li>
            
            <!-- Holiday Management -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('hrm.holidays.index') }}">
                    <i class="bi bi-calendar-heart"></i>
                    Holidays
                </a>
            </li>
            
            <!-- Time Management Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-clock"></i>
                    Time Management
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('hrm.timesheets.index') }}">Time Sheet</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.schedules.index') }}">Schedule</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.overtime.index') }}">Overtime</a></li>
                </ul>
            </li>
            
            <!-- Warning Management -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('hrm.warnings.index') }}">
                    <i class="bi bi-exclamation-triangle"></i>
                    Warnings
                </a>
            </li>
            
            <!-- Other Admin Functions -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-gear"></i>
                    Admin Functions
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('superadmin.user-roles') }}">User Roles</a></li>
                    <li><a class="dropdown-item" href="{{ route('superadmin.payroll') }}">Payroll Management</a></li>
                    <li><a class="dropdown-item" href="{{ route('superadmin.analytics') }}">Analytics</a></li>
                    <li><a class="dropdown-item" href="{{ route('superadmin.security') }}">System Security</a></li>
                    <li><a class="dropdown-item" href="{{ route('superadmin.settings') }}">System Settings</a></li>
                    <li><a class="dropdown-item" href="{{ route('superadmin.database') }}">Database</a></li>
                </ul>
            </li>
            
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
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 d-none d-lg-flex">
            <h2><i class="bi bi-fingerprint text-primary"></i> Biometric Attendance</h2>
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

        <!-- Biometric Stats -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card stat-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Devices</h6>
                            <h2>5</h2>
                        </div>
                        <i class="bi bi-laptop fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-2 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Active Devices</h6>
                            <h2>4</h2>
                        </div>
                        <i class="bi bi-check-circle fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-3 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Today's Scans</h6>
                            <h2>172</h2>
                        </div>
                        <i class="bi bi-fingerprint fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-4 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Success Rate</h6>
                            <h2>98.2%</h2>
                        </div>
                        <i class="bi bi-graph-up fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biometric Devices -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-md-6 col-lg-4">
                <div class="biometric-device">
                    <div class="device-icon">
                        <i class="bi bi-fingerprint"></i>
                    </div>
                    <h5>Main Entrance Scanner</h5>
                    <p class="text-muted">Building A, Floor 1</p>
                    <span class="device-status status-connected">Connected</span>
                    <div class="mt-3">
                        <button class="btn btn-sm btn-outline-primary">View Logs</button>
                        <button class="btn btn-sm btn-outline-secondary ms-2">Settings</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="biometric-device">
                    <div class="device-icon">
                        <i class="bi bi-fingerprint"></i>
                    </div>
                    <h5>Back Entrance Scanner</h5>
                    <p class="text-muted">Building A, Floor 1</p>
                    <span class="device-status status-connected">Connected</span>
                    <div class="mt-3">
                        <button class="btn btn-sm btn-outline-primary">View Logs</button>
                        <button class="btn btn-sm btn-outline-secondary ms-2">Settings</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="biometric-device">
                    <div class="device-icon">
                        <i class="bi bi-fingerprint"></i>
                    </div>
                    <h5>Office Floor Scanner</h5>
                    <p class="text-muted">Building A, Floor 3</p>
                    <span class="device-status status-connected">Connected</span>
                    <div class="mt-3">
                        <button class="btn btn-sm btn-outline-primary">View Logs</button>
                        <button class="btn btn-sm btn-outline-secondary ms-2">Settings</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fingerprint Scanner Simulation -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="bi bi-fingerprint"></i> Fingerprint Scanner</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="fingerprint-display">
                            <div class="fingerprint-circle">
                                <div class="fingerprint-icon">
                                    <i class="bi bi-fingerprint"></i>
                                </div>
                            </div>
                        </div>
                        <h4>Place Your Finger on the Scanner</h4>
                        <p class="text-muted">Position your finger correctly for accurate scanning</p>
                        <div class="mt-4">
                            <button class="btn btn-primary btn-lg">
                                <i class="bi bi-fingerprint"></i> Start Scan
                            </button>
                            <button class="btn btn-outline-secondary btn-lg ms-3">
                                <i class="bi bi-arrow-repeat"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Scans -->
        <div class="row g-3 g-md-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><i class="bi bi-table"></i> Recent Biometric Scans</h5>
                            <div>
                                <button class="btn btn-sm btn-light me-2">
                                    <i class="bi bi-download"></i> Export
                                </button>
                                <button class="btn btn-sm btn-light">
                                    <i class="bi bi-printer"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Employee ID</th>
                                        <th>Device</th>
                                        <th>Scan Time</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=John+Smith&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                <span>John Smith</span>
                                            </div>
                                        </td>
                                        <td>EMP-0012</td>
                                        <td>Main Entrance</td>
                                        <td>09:00:12 AM</td>
                                        <td><span class="badge bg-success">Success</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">View</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=Sarah+Johnson&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                <span>Sarah Johnson</span>
                                            </div>
                                        </td>
                                        <td>EMP-0045</td>
                                        <td>Back Entrance</td>
                                        <td>09:01:35 AM</td>
                                        <td><span class="badge bg-success">Success</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">View</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=Michael+Brown&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                <span>Michael Brown</span>
                                            </div>
                                        </td>
                                        <td>EMP-0078</td>
                                        <td>Office Floor</td>
                                        <td>09:02:18 AM</td>
                                        <td><span class="badge bg-warning">Retry</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">View</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=Emily+Davis&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                <span>Emily Davis</span>
                                            </div>
                                        </td>
                                        <td>EMP-0023</td>
                                        <td>Main Entrance</td>
                                        <td>09:03:42 AM</td>
                                        <td><span class="badge bg-success">Success</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">View</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=Robert+Wilson&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                <span>Robert Wilson</span>
                                            </div>
                                        </td>
                                        <td>EMP-0056</td>
                                        <td>Back Entrance</td>
                                        <td>09:05:07 AM</td>
                                        <td><span class="badge bg-success">Success</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">View</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Attendance records pagination">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
            
            // Simulate fingerprint scan
            const scanButton = document.querySelector('.btn-primary');
            if (scanButton) {
                scanButton.addEventListener('click', function() {
                    const fingerprintCircle = document.querySelector('.fingerprint-circle');
                    fingerprintCircle.style.animation = 'none';
                    setTimeout(() => {
                        fingerprintCircle.style.animation = 'pulse 0.5s';
                    }, 10);
                    
                    // Show success message after delay
                    setTimeout(() => {
                        alert('Fingerprint scan successful!');
                    }, 1500);
                });
            }
        });
    </script>
</body>
</html>