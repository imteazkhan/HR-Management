<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>System Settings - HR Management</title>
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
<<<<<<< HEAD
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
=======
>>>>>>> f37dbbf8b1009745044820acded90aff98423c3f
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
            transition: all 0.2s ease;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .card:hover { 
          transform: translateY(-1px); 
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
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
            /* transform: translateY(-1px); */
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .btn:active {
            transform: translateY(0);
        }
        .notification-setting {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            transition: all 0.2s ease;
        }
        .notification-setting:hover {
            background-color: #f8f9fa;
            transform: scale(1.01);
        }
        .notification-setting:last-child {
            border-bottom: none;
        }
        .maintenance-action {
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .maintenance-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .maintenance-icon {
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
        .maintenance-icon.bg-primary { background: linear-gradient(135deg, #667eea, #764ba2); }
        .maintenance-icon.bg-success { background: linear-gradient(135deg, #43e97b, #38f9d7); }
        .maintenance-icon.bg-warning { background: linear-gradient(135deg, #f093fb, #f5576c); }
        .form-check-input:checked {
            background-color: #28a745;
            border-color: #28a745;
        }
        .working-hours-preview .alert {
            border-radius: 8px;
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
            .col-lg-6, .col-lg-4 {
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
            .btn {
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
            }
            .maintenance-action {
                padding: 15px;
            }
            .maintenance-icon {
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
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
            <h2><i class="bi bi-gear text-primary"></i> System Settings</h2>
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

        <form action="{{ route('superadmin.settings.update') }}" method="POST" id="settingsForm">
            @csrf
            @method('PATCH')

            <!-- General Settings -->
            <div class="row g-3 g-md-4 mb-4">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-gear-fill me-2"></i>General Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="siteName" class="form-label">Site Name</label>
                                <input type="text" class="form-control" id="siteName" name="site_name" value="{{ $settings['site_name'] }}">
                            </div>
                            <div class="mb-3">
                                <label for="companyName" class="form-label">Company Name</label>
                                <input type="text" class="form-control" id="companyName" name="company_name" value="{{ $settings['company_name'] }}">
                            </div>
                            <div class="mb-3">
                                <label for="timezone" class="form-label">Timezone</label>
                                <select class="form-select" id="timezone" name="timezone">
                                    <option value="UTC" {{ $settings['timezone'] === 'UTC' ? 'selected' : '' }}>UTC</option>
                                    <option value="America/New_York" {{ $settings['timezone'] === 'America/New_York' ? 'selected' : '' }}>Eastern Time</option>
                                    <option value="America/Chicago" {{ $settings['timezone'] === 'America/Chicago' ? 'selected' : '' }}>Central Time</option>
                                    <option value="America/Denver" {{ $settings['timezone'] === 'America/Denver' ? 'selected' : '' }}>Mountain Time</option>
                                    <option value="America/Los_Angeles" {{ $settings['timezone'] === 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="currency" class="form-label">Default Currency</label>
                                <select class="form-select" id="currency" name="currency">
                                    <option value="USD" {{ $settings['currency'] === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                    <option value="EUR" {{ $settings['currency'] === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                    <option value="GBP" {{ $settings['currency'] === 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                    <option value="CAD" {{ $settings['currency'] === 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-clock-fill me-2"></i>Working Hours</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="workingHoursStart" class="form-label">Start Time</label>
                                <input type="time" class="form-control" id="workingHoursStart" name="working_hours_start" value="{{ $settings['working_hours_start'] }}">
                            </div>
                            <div class="mb-3">
                                <label for="workingHoursEnd" class="form-label">End Time</label>
                                <input type="time" class="form-control" id="workingHoursEnd" name="working_hours_end" value="{{ $settings['working_hours_end'] }}">
                            </div>
                            <div class="mb-3">
                                <label for="annualLeaveDays" class="form-label">Annual Leave Days</label>
                                <input type="number" class="form-control" id="annualLeaveDays" name="annual_leave_days" value="{{ $settings['annual_leave_days'] }}" min="0" max="365">
                            </div>
                            <div class="working-hours-preview">
                                <div class="alert alert-info fade-in-up">
                                    <small>
                                        <i class="bi bi-info-circle me-1"></i>
                                        Standard working day: {{ $settings['working_hours_start'] }} - {{ $settings['working_hours_end'] }}
                                        ({{ round((strtotime($settings['working_hours_end']) - strtotime($settings['working_hours_start'])) / 3600) }} hours)
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Settings -->
            <div class="row g-3 g-md-4 mb-4">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-envelope-fill me-2"></i>Email Configuration</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="smtpHost" class="form-label">SMTP Host</label>
                                <input type="text" class="form-control" id="smtpHost" name="smtp_host" placeholder="smtp.gmail.com">
                            </div>
                            <div class="mb-3">
                                <label for="smtpPort" class="form-label">SMTP Port</label>
                                <input type="number" class="form-control" id="smtpPort" name="smtp_port" value="587">
                            </div>
                            <div class="mb-3">
                                <label for="smtpUsername" class="form-label">SMTP Username</label>
                                <input type="email" class="form-control" id="smtpUsername" name="smtp_username">
                            </div>
                            <div class="mb-3">
                                <label for="smtpPassword" class="form-label">SMTP Password</label>
                                <input type="password" class="form-control" id="smtpPassword" name="smtp_password">
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm pulse-animation" onclick="testEmailConnection()">
                                <i class="bi bi-send"></i> Test Connection
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-bell-fill me-2"></i>Notification Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="notification-setting fade-in-up">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">Email Notifications</h6>
                                        <small class="text-muted">Send email alerts for important events</small>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="email_notifications" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="notification-setting fade-in-up">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">Leave Request Alerts</h6>
                                        <small class="text-muted">Notify managers of new leave requests</small>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="leave_request_alerts" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="notification-setting fade-in-up">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">System Maintenance</h6>
                                        <small class="text-muted">Alert users about scheduled maintenance</small>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="maintenance_alerts">
                                    </div>
                                </div>
                            </div>
                            <div class="notification-setting fade-in-up">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Payroll Reminders</h6>
                                        <small class="text-muted">Monthly payroll processing reminders</small>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="payroll_reminders" checked>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Preferences -->
            <div class="row g-3 g-md-4 mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-sliders me-2"></i>System Preferences</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 mb-3">
                                    <label for="dateFormat" class="form-label">Date Format</label>
                                    <select class="form-select" id="dateFormat" name="date_format">
                                        <option value="Y-m-d" {{ $settings['date_format'] === 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                        <option value="m/d/Y" {{ $settings['date_format'] === 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                                        <option value="d/m/Y" {{ $settings['date_format'] === 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                                        <option value="M d, Y" {{ $settings['date_format'] === 'M d, Y' ? 'selected' : '' }}>Mon DD, YYYY</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label for="recordsPerPage" class="form-label">Records Per Page</label>
                                    <select class="form-select" id="recordsPerPage" name="records_per_page">
                                        <option value="10" {{ $settings['records_per_page'] == 10 ? 'selected' : '' }}>10</option>
                                        <option value="15" {{ $settings['records_per_page'] == 15 ? 'selected' : '' }}>15</option>
                                        <option value="25" {{ $settings['records_per_page'] == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ $settings['records_per_page'] == 50 ? 'selected' : '' }}>50</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label for="sessionTimeout" class="form-label">Session Timeout (minutes)</label>
                                    <select class="form-select" id="sessionTimeout" name="session_timeout">
                                        <option value="15" {{ $settings['session_timeout'] == 15 ? 'selected' : '' }}>15</option>
                                        <option value="30" {{ $settings['session_timeout'] == 30 ? 'selected' : '' }}>30</option>
                                        <option value="60" {{ $settings['session_timeout'] == 60 ? 'selected' : '' }}>60</option>
                                        <option value="120" {{ $settings['session_timeout'] == 120 ? 'selected' : '' }}>120</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Maintenance -->
            <div class="row g-3 g-md-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-tools me-2"></i>System Maintenance</h5>
                            <button type="button" class="btn btn-sm btn-success pulse-animation" onclick="saveSettings()">
                                <i class="bi bi-check-circle"></i> Save Settings
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 text-center mb-3">
                                    <div class="maintenance-action fade-in-up">
                                        <div class="maintenance-icon bg-primary">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </div>
                                        <h6 class="mt-2">Clear Cache</h6>
                                        <p class="text-muted small">Clear application cache to improve performance</p>
                                        <button type="button" class="btn btn-outline-primary btn-sm pulse-animation" onclick="clearCache()">
                                            Clear Now
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center mb-3">
                                    <div class="maintenance-action fade-in-up">
                                        <div class="maintenance-icon bg-success">
                                            <i class="bi bi-database"></i>
                                        </div>
                                        <h6 class="mt-2">Optimize Database</h6>
                                        <p class="text-muted small">Optimize database tables for better performance</p>
                                        <button type="button" class="btn btn-outline-success btn-sm pulse-animation" onclick="optimizeDatabase()">
                                            Optimize
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center mb-3">
                                    <div class="maintenance-action fade-in-up">
                                        <div class="maintenance-icon bg-warning">
                                            <i class="bi bi-download"></i>
                                        </div>
                                        <h6 class="mt-2">System Backup</h6>
                                        <p class="text-muted small">Create a full system backup</p>
                                        <button type="button" class="btn btn-outline-warning btn-sm pulse-animation" onclick="createBackup()">
                                            Backup Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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

            // Save Settings
            window.saveSettings = function() {
                document.getElementById('settingsForm').submit();
            };

            // Test Email Connection
            window.testEmailConnection = function() {
                const btn = event.target;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i> Testing...';
                btn.disabled = true;
                btn.classList.remove('pulse-animation');
                
                // Simulate email connection test (replace with actual AJAX call)
                setTimeout(() => {
                    btn.innerHTML = '<i class="bi bi-check-circle"></i> Connection Successful';
                    btn.classList.remove('btn-outline-primary');
                    btn.classList.add('btn-outline-success');
                    
                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.classList.remove('btn-outline-success');
                        btn.classList.add('btn-outline-primary');
                        btn.classList.add('pulse-animation');
                        btn.disabled = false;
                    }, 3000);
                }, 2000);
            };

            // Maintenance Actions
            window.performMaintenanceAction = function(action, successMessage) {
                const btn = event.target;
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i> Working...';
                btn.disabled = true;
                btn.classList.remove('pulse-animation');
                
                // Simulate maintenance action (replace with actual AJAX call)
                setTimeout(() => {
                    btn.innerHTML = '<i class="bi bi-check-circle"></i> Done';
                    btn.classList.add('btn-success');
                    
                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.classList.remove('btn-success');
                        btn.classList.add('pulse-animation');
                        btn.disabled = false;
                    }, 2000);
                }, 3000);
            };

            window.clearCache = function() {
                performMaintenanceAction('Clear Cache', 'Cache cleared successfully!');
            };

            window.optimizeDatabase = function() {
                performMaintenanceAction('Optimize Database', 'Database optimized successfully!');
            };

            window.createBackup = function() {
                performMaintenanceAction('Create Backup', 'Backup created successfully!');
            };
        });
    </script>
</body>
</html>