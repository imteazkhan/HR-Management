<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Leave Management - HR Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        .table th {
            background: #2c3e50;
            color: white;
            font-weight: 500;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .badge-pending {
            background: #ffc107;
            color: #212529;
        }
        .badge-approved {
            background: #198754;
            color: white;
        }
        .badge-rejected {
            background: #dc3545;
            color: white;
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
            .table-responsive {
                font-size: 0.85rem;
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
            <span class="fw-bold">Admin</span>
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
                <a class="nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}" href="{{ route('superadmin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            
            <!-- Employee Management Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person"></i> Employee Management
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('superadmin.employees') }}">All Employees</a></li>
                    <li><a class="dropdown-item" href="{{ route('superadmin.departments') }}">Departments</a></li>
                    <li><a class="dropdown-item" href="{{ route('superadmin.designations') }}">Designations</a></li>
                    <li><a class="dropdown-item" href="{{ route('superadmin.user-roles') }}">User Roles</a></li>
                </ul>
            </li>
            
            <!-- Attendance Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-calendar-check"></i> Attendance
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('admin.attendance.index') }}">Admin Attendance</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.attendance.biometric') }}">Biometric Attendance</a></li>
                </ul>
            </li>
            
            <!-- Loans Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-cash"></i> Loans
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('admin.loans.office') }}">Office Loans</a></li>
                    <li><a class="dropdown-item" href="{{ route('employee.loans.personal') }}">Personal Loans</a></li>
                </ul>
            </li>
            
            <!-- Leaves Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-calendar-x"></i> Leaves
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('employee.leaves.index') }}">Employee Leaves</a></li>
                    <li><a class="dropdown-item active" href="#">Admin Leaves</a></li>
                </ul>
            </li>
            
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.payroll') ? 'active' : '' }}" href="{{ route('superadmin.payroll') }}"><i class="bi bi-cash-stack"></i> Payroll Management</a></li>
            
            <!-- Time Management Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-clock"></i> Time Management
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('employee.timesheet.index') }}">Time Sheet</a></li>
                    <li><a class="dropdown-item" href="{{ route('employee.schedule.index') }}">Schedule</a></li>
                    <li><a class="dropdown-item" href="{{ route('employee.overtime.index') }}">Overtime</a></li>
                </ul>
            </li>
            
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.holidays.index') ? 'active' : '' }}" href="{{ route('superadmin.holidays.index') }}"><i class="bi bi-calendar-heart"></i> Holidays</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.warnings.index') ? 'active' : '' }}" href="{{ route('admin.warnings.index') }}"><i class="bi bi-exclamation-triangle"></i> Warnings</a></li>
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
            <h2><i class="bi bi-journal-text text-primary"></i> Leave Management</h2>
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

        <!-- Leave Stats -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card stat-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Requests</h6>
                            <h2>126</h2>
                        </div>
                        <i class="bi bi-journal-text fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-2 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Pending Approval</h6>
                            <h2>24</h2>
                        </div>
                        <i class="bi bi-hourglass-split fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-3 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Approved</h6>
                            <h2>87</h2>
                        </div>
                        <i class="bi bi-check-circle fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-4 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Rejected</h6>
                            <h2>15</h2>
                        </div>
                        <i class="bi bi-x-circle fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leave Management -->
        <div class="row g-3 g-md-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><i class="bi bi-journal-text"></i> Leave Requests</h5>
                            <button type="button" class="btn btn-sm btn-outline-light" data-bs-toggle="modal" data-bs-target="#addLeavePolicyModal">
                                <i class="bi bi-plus-circle"></i> Add Leave Policy
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filters -->
                        <div class="row mb-4">
                            <div class="col-md-2 mb-2">
                                <select class="form-select">
                                    <option selected>All Departments</option>
                                    <option>IT Department</option>
                                    <option>Human Resources</option>
                                    <option>Marketing</option>
                                    <option>Finance</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <select class="form-select">
                                    <option selected>All Types</option>
                                    <option>Annual Leave</option>
                                    <option>Sick Leave</option>
                                    <option>Casual Leave</option>
                                    <option>Maternity Leave</option>
                                    <option>Paternity Leave</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <select class="form-select">
                                    <option selected>All Status</option>
                                    <option>Pending</option>
                                    <option>Approved</option>
                                    <option>Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <input type="text" class="form-control" placeholder="Employee name...">
                            </div>
                            <div class="col-md-2 mb-2">
                                <input type="date" class="form-control" placeholder="From date">
                            </div>
                            <div class="col-md-2 mb-2">
                                <button class="btn btn-primary w-100"><i class="bi bi-search"></i> Filter</button>
                            </div>
                        </div>

                        <!-- Leaves Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Department</th>
                                        <th>Leave Type</th>
                                        <th>Dates</th>
                                        <th>Days</th>
                                        <th>Reason</th>
                                        <th>Applied On</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=John+Doe&size=32&background=0D8ABC&color=fff" class="rounded-circle me-2" width="32" height="32">
                                                <div>
                                                    <div class="fw-bold">John Doe</div>
                                                    <div class="text-muted small">Software Engineer</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>IT Department</td>
                                        <td>Annual Leave</td>
                                        <td>2024-05-15 to 2024-05-17</td>
                                        <td>3</td>
                                        <td>Vacation</td>
                                        <td>2024-05-01</td>
                                        <td><span class="status-badge badge-pending">Pending</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item text-success" href="#"><i class="bi bi-check-circle me-2"></i>Approve</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-x-circle me-2"></i>Reject</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=Jane+Smith&size=32&background=0D8ABC&color=fff" class="rounded-circle me-2" width="32" height="32">
                                                <div>
                                                    <div class="fw-bold">Jane Smith</div>
                                                    <div class="text-muted small">Marketing Specialist</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Marketing</td>
                                        <td>Sick Leave</td>
                                        <td>2024-03-10 to 2024-03-12</td>
                                        <td>3</td>
                                        <td>Medical Appointment</td>
                                        <td>2024-03-08</td>
                                        <td><span class="status-badge badge-approved">Approved</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item text-success" href="#"><i class="bi bi-check-circle me-2"></i>Approve</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-x-circle me-2"></i>Reject</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=Robert+Johnson&size=32&background=0D8ABC&color=fff" class="rounded-circle me-2" width="32" height="32">
                                                <div>
                                                    <div class="fw-bold">Robert Johnson</div>
                                                    <div class="text-muted small">Financial Analyst</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Finance</td>
                                        <td>Casual Leave</td>
                                        <td>2024-04-01 to 2024-04-01</td>
                                        <td>1</td>
                                        <td>Personal Work</td>
                                        <td>2024-03-28</td>
                                        <td><span class="status-badge badge-rejected">Rejected</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item text-success" href="#"><i class="bi bi-check-circle me-2"></i>Approve</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-x-circle me-2"></i>Reject</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=Emily+Williams&size=32&background=0D8ABC&color=fff" class="rounded-circle me-2" width="32" height="32">
                                                <div>
                                                    <div class="fw-bold">Emily Williams</div>
                                                    <div class="text-muted small">HR Manager</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Human Resources</td>
                                        <td>Maternity Leave</td>
                                        <td>2024-06-01 to 2024-08-31</td>
                                        <td>92</td>
                                        <td>Maternity</td>
                                        <td>2024-05-15</td>
                                        <td><span class="status-badge badge-approved">Approved</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item text-success" href="#"><i class="bi bi-check-circle me-2"></i>Approve</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-x-circle me-2"></i>Reject</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=Michael+Brown&size=32&background=0D8ABC&color=fff" class="rounded-circle me-2" width="32" height="32">
                                                <div>
                                                    <div class="fw-bold">Michael Brown</div>
                                                    <div class="text-muted small">IT Manager</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>IT Department</td>
                                        <td>Annual Leave</td>
                                        <td>2024-07-15 to 2024-07-25</td>
                                        <td>11</td>
                                        <td>Family Trip</td>
                                        <td>2024-07-01</td>
                                        <td><span class="status-badge badge-pending">Pending</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item text-success" href="#"><i class="bi bi-check-circle me-2"></i>Approve</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-x-circle me-2"></i>Reject</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Leaves pagination">
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

    <!-- Add Leave Policy Modal -->
    <div class="modal fade" id="addLeavePolicyModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add Leave Policy</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="policyName" class="form-label">Policy Name</label>
                                <input type="text" class="form-control" id="policyName" placeholder="e.g., Annual Leave Policy" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="department" class="form-label">Department</label>
                                <select class="form-select" id="department" required>
                                    <option value="">Select Department</option>
                                    <option value="all">All Departments</option>
                                    <option value="it">IT Department</option>
                                    <option value="hr">Human Resources</option>
                                    <option value="marketing">Marketing</option>
                                    <option value="finance">Finance</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="leaveType" class="form-label">Leave Type</label>
                                <select class="form-select" id="leaveType" required>
                                    <option value="">Select Leave Type</option>
                                    <option value="annual">Annual Leave</option>
                                    <option value="sick">Sick Leave</option>
                                    <option value="casual">Casual Leave</option>
                                    <option value="maternity">Maternity Leave</option>
                                    <option value="paternity">Paternity Leave</option>
                                    <option value="unpaid">Unpaid Leave</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="daysAllowed" class="form-label">Days Allowed</label>
                                <input type="number" class="form-control" id="daysAllowed" placeholder="e.g., 20" min="0" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="carryForward" class="form-label">Carry Forward</label>
                                <select class="form-select" id="carryForward">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="maxCarryForward" class="form-label">Max Carry Forward Days</label>
                                <input type="number" class="form-control" id="maxCarryForward" placeholder="e.g., 5" min="0">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="policyDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="policyDescription" rows="3" placeholder="Describe the leave policy..."></textarea>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="isActive" checked>
                            <label class="form-check-label" for="isActive">
                                Policy is Active
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Policy</button>
                    </div>
                </form>
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
        });
    </script>
</body>
</html>