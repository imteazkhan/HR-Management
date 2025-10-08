<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Attendance - HR Management</title>
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
        
        /* Pagination Styles */
        .pagination {
            margin-bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .pagination .page-link {
            border-radius: 6px;
            margin: 0 2px;
            border: 1px solid #dee2e6;
            color: #495057;
            transition: all 0.2s ease;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.25;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
        }
        .pagination .page-link:hover {
            background-color: #e9ecef;
            border-color: #adb5bd;
            color: #495057;
            transform: translateY(-1px);
            text-decoration: none;
        }
        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            font-weight: 500;
        }
        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
            cursor: not-allowed;
        }
        .pagination .page-item.disabled .page-link:hover {
            transform: none;
            background-color: #fff;
        }
        
        /* Fix pagination arrow symbols */
        .pagination .page-link[aria-label="Previous"],
        .pagination .page-link[aria-label="Next"] {
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }
        
        /* Custom pagination navigation styling */
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        /* Bootstrap icon styling in pagination */
        .pagination .page-link i {
            font-size: 0.75rem;
            vertical-align: middle;
        }
        
        .pagination .page-item:first-child .page-link i {
            margin-right: 0.25rem;
        }
        
        .pagination .page-item:last-child .page-link i {
            margin-left: 0.25rem;
        }
        
        /* Responsive pagination */
        @media (max-width: 768px) {
            .pagination {
                font-size: 0.8rem;
                flex-wrap: wrap;
                gap: 2px;
            }
            .pagination .page-link {
                padding: 0.4rem 0.6rem;
                font-size: 0.8rem;
                min-width: 32px;
                height: 32px;
            }
            .pagination .page-link[aria-label="Previous"],
            .pagination .page-link[aria-label="Next"] {
                font-size: 0.7rem;
                padding: 0.4rem 0.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .pagination {
                font-size: 0.75rem;
            }
            .pagination .page-link {
                padding: 0.35rem 0.5rem;
                font-size: 0.75rem;
                min-width: 28px;
                height: 28px;
                margin: 0 1px;
            }
            .pagination .page-link[aria-label="Previous"],
            .pagination .page-link[aria-label="Next"] {
                font-size: 0.65rem;
                padding: 0.35rem 0.4rem;
            }
            /* Hide some page numbers on very small screens */
            .pagination .page-item:not(.active):not(:first-child):not(:last-child):not(:nth-child(2)):not(:nth-last-child(2)) {
                display: none;
            }
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
            <h2><i class="bi bi-calendar-check text-primary"></i> Attendance Management</h2>
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
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual" type="button" role="tab" aria-controls="manual" aria-selected="false">
                    <i class="bi bi-pencil-square"></i> Manual Attendance
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="records-tab" data-bs-toggle="tab" data-bs-target="#records" type="button" role="tab" aria-controls="records" aria-selected="false">
                    <i class="bi bi-table"></i> Attendance Records
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="attendanceTabContent">
            <!-- Overview Tab -->
            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                <!-- Attendance Stats -->
                <div class="row g-3 g-md-4 mb-4">
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

                <!-- Filters and Actions -->
                <div class="row g-3 g-md-4 mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5><i class="bi bi-funnel"></i> Filter & Actions</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label for="dateFilter" class="form-label">Date</label>
                                        <input type="date" class="form-control" id="dateFilter" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="departmentFilter" class="form-label">Department</label>
                                        <select class="form-select" id="departmentFilter">
                                            <option value="">All Departments</option>
                                            @if(isset($departments))
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            @else
                                                <option value="1">IT Department</option>
                                                <option value="2">Human Resources</option>
                                                <option value="3">Marketing</option>
                                                <option value="4">Finance</option>
                                                <option value="5">Operations</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="statusFilter" class="form-label">Status</label>
                                        <select class="form-select" id="statusFilter">
                                            <option value="">All Statuses</option>
                                            <option value="present">Present</option>
                                            <option value="absent">Absent</option>
                                            <option value="late">Late</option>
                                            <option value="leave">On Leave</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button class="btn btn-primary w-100" id="applyFiltersBtn">
                                            <i class="bi bi-search"></i> Apply Filters
                                        </button>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <button class="btn btn-success" id="exportReportBtn">
                                                    <i class="bi bi-download"></i> Export Report
                                                </button>
                                                <button class="btn btn-info ms-2" id="printReportBtn">
                                                    <i class="bi bi-printer"></i> Print
                                                </button>
                                            </div>
                                            <div>
                                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#manualAttendanceModal">
                                                    <i class="bi bi-clock-history"></i> Manual Attendance
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Table -->
                <div class="row g-3 g-md-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5><i class="bi bi-table"></i> Attendance Records - <span id="currentDateDisplay">{{ date('F j, Y') }}</span></h5>
                                    <div>
                                        <button class="btn btn-sm btn-light me-2" id="exportTableBtn">
                                            <i class="bi bi-download"></i> Export
                                        </button>
                                        <button class="btn btn-sm btn-light" id="printTableBtn">
                                            <i class="bi bi-printer"></i> Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="attendanceTable">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="selectAllCheckbox">
                                                    </div>
                                                </th>
                                                <th>Employee</th>
                                                <th>Department</th>
                                                <th>Status</th>
                                                <th>Clock In</th>
                                                <th>Clock Out</th>
                                                <th>Hours Worked</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($attendanceRecords))
                                                @foreach($attendanceRecords as $record)
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input row-checkbox" type="checkbox" data-id="{{ $record->id }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($record->employee_name ?? 'Employee') }}&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                                <span>{{ $record->employee_name ?? 'Unknown Employee' }}</span>
                                                            </div>
                                                        </td>
                                                        <td>{{ $record->department ?? 'Unknown Department' }}</td>
                                                        <td>
                                                            @if($record->status == 'present')
                                                                <span class="badge bg-success">Present</span>
                                                            @elseif($record->status == 'absent')
                                                                <span class="badge bg-danger">Absent</span>
                                                            @elseif($record->status == 'late')
                                                                <span class="badge bg-warning">Late</span>
                                                            @elseif($record->status == 'half_day')
                                                                <span class="badge bg-info">Half Day</span>
                                                            @elseif($record->status == 'on_leave')
                                                                <span class="badge bg-secondary">On Leave</span>
                                                            @else
                                                                <span class="badge bg-secondary">{{ ucfirst($record->status ?? 'N/A') }}</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $record->check_in ? \Carbon\Carbon::parse($record->check_in)->format('h:i A') : '-' }}</td>
                                                        <td>{{ $record->check_out ? \Carbon\Carbon::parse($record->check_out)->format('h:i A') : '-' }}</td>
                                                        <td>{{ $record->total_hours ? round($record->total_hours / 60, 2) . ' hrs' : '0 hrs' }}</td>
                                                        <td>
                                                            <button class="btn btn-sm btn-outline-primary view-record" data-id="{{ $record->id }}">
                                                                <i class="bi bi-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-warning edit-record" data-id="{{ $record->id }}">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <!-- Static data as fallback -->
                                                <!-- <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input row-checkbox" type="checkbox" data-id="1">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="https://ui-avatars.com/api/?name=John+Smith&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                            <span>John Smith</span>
                                                        </div>
                                                    </td>
                                                    <td>IT Department</td>
                                                    <td><span class="badge bg-success">Present</span></td>
                                                    <td>09:00 AM</td>
                                                    <td>-</td>
                                                    <td>3.5 hrs</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary view-record" data-id="1">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-warning edit-record" data-id="1">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                    </td>
                                                </tr> -->
                                               
                                                <!-- <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="https://ui-avatars.com/api/?name=Christopher+Anderson&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                            <span>Christopher Anderson</span>
                                                        </div>
                                                    </td>
                                                    <td>Operations</td>
                                                    <td><span class="badge bg-success">Present</span></td>
                                                    <td>09:05 AM</td>
                                                    <td>-</td>
                                                    <td>3.6 hrs</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary view-record" data-id="9">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-warning edit-record" data-id="9">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                    </td>
                                                </tr> -->
                                                <!-- <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input row-checkbox" type="checkbox" data-id="10">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="https://ui-avatars.com/api/?name=Amanda+Thomas&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                            <span>Amanda Thomas</span>
                                                        </div>
                                                    </td>
                                                    <td>Human Resources</td>
                                                    <td><span class="badge bg-success">Present</span></td>
                                                    <td>08:50 AM</td>
                                                    <td>-</td>
                                                    <td>3.8 hrs</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary view-record" data-id="10">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-warning edit-record" data-id="10">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                    </td>
                                                </tr> -->
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Bulk Actions -->
                                <div class="d-flex justify-content-start align-items-center mt-3">
                                    <div>
                                        <button class="btn btn-sm btn-outline-danger" id="bulkDeleteBtn" disabled>
                                            <i class="bi bi-trash"></i> Delete Selected
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary ms-2" id="bulkEditBtn" disabled>
                                            <i class="bi bi-pencil"></i> Edit Selected
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Overview Pagination -->
                                <nav aria-label="Overview attendance pagination" class="mt-4">
                                    <ul class="pagination justify-content-center mb-0">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                <i class="bi bi-chevron-left"></i> Previous
                                            </a>
                                        </li>
                                        <li class="page-item active">
                                            <a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">
                                                Next <i class="bi bi-chevron-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Attendance Tab -->
            <div class="tab-pane fade" id="admin-attendance" role="tabpanel" aria-labelledby="admin-attendance-tab">
                <div class="row g-3 g-md-4 mb-4">
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

                <div class="row g-3 g-md-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5><i class="bi bi-table"></i> Admin Attendance Records - {{ date('F j, Y') }}</h5>
                                    <div>
                                        <button class="btn btn-sm btn-light me-2" id="exportAdminTableBtn">
                                            <i class="bi bi-download"></i> Export
                                        </button>
                                        <button class="btn btn-sm btn-light" id="printAdminTableBtn">
                                            <i class="bi bi-printer"></i> Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Admin Filters -->
                                <div class="row g-3 mb-4">
                                    <div class="col-md-3">
                                        <label for="adminDateFilter" class="form-label">Date</label>
                                        <input type="date" class="form-control" id="adminDateFilter" value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="adminDepartmentFilter" class="form-label">Department</label>
                                        <select class="form-select" id="adminDepartmentFilter">
                                            <option value="">All Departments</option>
                                            @if(isset($departments))
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            @else
                                                <option value="1">IT Department</option>
                                                <option value="2">Human Resources</option>
                                                <option value="3">Finance</option>
                                                <option value="4">Operations</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="adminStatusFilter" class="form-label">Status</label>
                                        <select class="form-select" id="adminStatusFilter">
                                            <option value="">All Statuses</option>
                                            <option value="present">Present</option>
                                            <option value="absent">Absent</option>
                                            <option value="late">Late</option>
                                            <option value="on_leave">On Leave</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button class="btn btn-primary w-100" id="applyAdminFiltersBtn">
                                            <i class="bi bi-search"></i> Apply Filters
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover" id="adminAttendanceTable">
                                        <thead>
                                            <tr>
                                                <th>Admin</th>
                                                <th>Department</th>
                                                <th>Status</th>
                                                <th>Clock In</th>
                                                <th>Clock Out</th>
                                                <th>Hours Worked</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($adminAttendanceRecords) && count($adminAttendanceRecords) > 0)
                                                @foreach($adminAttendanceRecords as $record)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($record->employee_name ?? 'Admin') }}&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                                <span>{{ $record->employee_name ?? 'Unknown Admin' }}</span>
                                                            </div>
                                                        </td>
                                                        <td>{{ $record->department ?? 'Unknown Department' }}</td>
                                                        <td>
                                                            @if($record->status == 'present')
                                                                <span class="badge bg-success">Present</span>
                                                            @elseif($record->status == 'absent')
                                                                <span class="badge bg-danger">Absent</span>
                                                            @elseif($record->status == 'late')
                                                                <span class="badge bg-warning">Late</span>
                                                            @elseif($record->status == 'half_day')
                                                                <span class="badge bg-info">Half Day</span>
                                                            @elseif($record->status == 'on_leave')
                                                                <span class="badge bg-secondary">On Leave</span>
                                                            @else
                                                                <span class="badge bg-secondary">{{ ucfirst($record->status ?? 'N/A') }}</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $record->check_in ? \Carbon\Carbon::parse($record->check_in)->format('h:i A') : '-' }}</td>
                                                        <td>{{ $record->check_out ? \Carbon\Carbon::parse($record->check_out)->format('h:i A') : '-' }}</td>
                                                        <td>{{ $record->total_hours ? round($record->total_hours / 60, 2) . ' hrs' : '0 hrs' }}</td>
                                                        <td>
                                                            <button class="btn btn-sm btn-outline-primary view-admin-record" data-id="{{ $record->id }}" title="View Details">
                                                                <i class="bi bi-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-warning edit-admin-record" data-id="{{ $record->id }}" title="Edit Record">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <!-- Fallback data when no records exist -->
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="https://ui-avatars.com/api/?name=John+Admin&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                            <span>John Admin</span>
                                                        </div>
                                                    </td>
                                                    <td>IT Department</td>
                                                    <td><span class="badge bg-success">Present</span></td>
                                                    <td>09:00 AM</td>
                                                    <td>-</td>
                                                    <td>3.5 hrs</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary view-admin-record" data-id="1" title="View Details">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-warning edit-admin-record" data-id="1" title="Edit Record">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="https://ui-avatars.com/api/?name=Sarah+Admin&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                            <span>Sarah Admin</span>
                                                        </div>
                                                    </td>
                                                    <td>Human Resources</td>
                                                    <td><span class="badge bg-success">Present</span></td>
                                                    <td>08:45 AM</td>
                                                    <td>-</td>
                                                    <td>3.8 hrs</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary view-admin-record" data-id="2" title="View Details">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-warning edit-admin-record" data-id="2" title="Edit Record">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="https://ui-avatars.com/api/?name=Mike+Admin&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                            <span>Mike Admin</span>
                                                        </div>
                                                    </td>
                                                    <td>Finance</td>
                                                    <td><span class="badge bg-danger">Absent</span></td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>0 hrs</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary view-admin-record" data-id="3" title="View Details">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-warning edit-admin-record" data-id="3" title="Edit Record">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Admin Attendance Pagination -->
                                <nav aria-label="Admin attendance pagination" class="mt-4">
                                    <ul class="pagination justify-content-center mb-0">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                <i class="bi bi-chevron-left"></i> Previous
                                            </a>
                                        </li>
                                        <li class="page-item active">
                                            <a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">
                                                Next <i class="bi bi-chevron-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employee Attendance Tab -->
            <div class="tab-pane fade" id="employee-attendance" role="tabpanel" aria-labelledby="employee-attendance-tab">
                <div class="row g-3 g-md-4 mb-4">
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

                <div class="row g-3 g-md-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5><i class="bi bi-table"></i> Employee Attendance Records - {{ date('F j, Y') }}</h5>
                                    <div>
                                        <button class="btn btn-sm btn-light me-2" id="exportEmployeeTableBtn">
                                            <i class="bi bi-download"></i> Export
                                        </button>
                                        <button class="btn btn-sm btn-light" id="printEmployeeTableBtn">
                                            <i class="bi bi-printer"></i> Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="employeeAttendanceTable">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Department</th>
                                                <th>Status</th>
                                                <th>Clock In</th>
                                                <th>Clock Out</th>
                                                <th>Hours Worked</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://ui-avatars.com/api/?name=John+Employee&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                        <span>John Employee</span>
                                                    </div>
                                                </td>
                                                <td>IT Department</td>
                                                <td><span class="badge bg-success">Present</span></td>
                                                <td>09:00 AM</td>
                                                <td>-</td>
                                                <td>3.5 hrs</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://ui-avatars.com/api/?name=Sarah+Employee&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                        <span>Sarah Employee</span>
                                                    </div>
                                                </td>
                                                <td>Marketing</td>
                                                <td><span class="badge bg-success">Present</span></td>
                                                <td>08:45 AM</td>
                                                <td>-</td>
                                                <td>3.8 hrs</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://ui-avatars.com/api/?name=Mike+Employee&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                        <span>Mike Employee</span>
                                                    </div>
                                                </td>
                                                <td>Finance</td>
                                                <td><span class="badge bg-danger">Absent</span></td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>0 hrs</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Employee Attendance Pagination -->
                                <nav aria-label="Employee attendance pagination" class="mt-4">
                                    <ul class="pagination justify-content-center mb-0">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                <i class="bi bi-chevron-left"></i> Previous
                                            </a>
                                        </li>
                                        <li class="page-item active">
                                            <a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">
                                                Next <i class="bi bi-chevron-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manager Attendance Tab -->
            <div class="tab-pane fade" id="manager-attendance" role="tabpanel" aria-labelledby="manager-attendance-tab">
                <div class="row g-3 g-md-4 mb-4">
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

                <div class="row g-3 g-md-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5><i class="bi bi-table"></i> Manager Attendance Records - {{ date('F j, Y') }}</h5>
                                    <div>
                                        <button class="btn btn-sm btn-light me-2" id="exportManagerTableBtn">
                                            <i class="bi bi-download"></i> Export
                                        </button>
                                        <button class="btn btn-sm btn-light" id="printManagerTableBtn">
                                            <i class="bi bi-printer"></i> Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="managerAttendanceTable">
                                        <thead>
                                            <tr>
                                                <th>Manager</th>
                                                <th>Department</th>
                                                <th>Status</th>
                                                <th>Clock In</th>
                                                <th>Clock Out</th>
                                                <th>Hours Worked</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://ui-avatars.com/api/?name=John+Manager&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                        <span>John Manager</span>
                                                    </div>
                                                </td>
                                                <td>IT Department</td>
                                                <td><span class="badge bg-success">Present</span></td>
                                                <td>09:00 AM</td>
                                                <td>-</td>
                                                <td>3.5 hrs</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://ui-avatars.com/api/?name=Sarah+Manager&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                        <span>Sarah Manager</span>
                                                    </div>
                                                </td>
                                                <td>Human Resources</td>
                                                <td><span class="badge bg-success">Present</span></td>
                                                <td>08:45 AM</td>
                                                <td>-</td>
                                                <td>3.8 hrs</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://ui-avatars.com/api/?name=Mike+Manager&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                        <span>Mike Manager</span>
                                                    </div>
                                                </td>
                                                <td>Finance</td>
                                                <td><span class="badge bg-danger">Absent</span></td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>0 hrs</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Manager Attendance Pagination -->
                                <nav aria-label="Manager attendance pagination" class="mt-4">
                                    <ul class="pagination justify-content-center mb-0">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                <i class="bi bi-chevron-left"></i> Previous
                                            </a>
                                        </li>
                                        <li class="page-item active">
                                            <a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">
                                                Next <i class="bi bi-chevron-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manual Attendance Tab -->
            <div class="tab-pane fade" id="manual" role="tabpanel" aria-labelledby="manual-tab">
                <div class="row g-3 g-md-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5><i class="bi bi-pencil-square"></i> Manual Attendance Entry</h5>
                            </div>
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Please correct the following errors:</strong>
                                        <ul class="mb-0 mt-2">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <form id="manualAttendanceForm" method="POST" action="{{ route('hrm.attendance.manual-entry') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="employeeSelect" class="form-label">Employee <span class="text-danger">*</span></label>
                                            <select class="form-select" id="employeeSelect" name="employee_id" required>
                                                <option value="">Select Employee</option>
                                                @if(isset($employees))
                                                    @foreach($employees as $employee)
                                                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="1">John Smith - IT Department</option>
                                                    <option value="2">Sarah Lee - Marketing</option>
                                                    <option value="3">Mike Davis - Finance</option>
                                                    <option value="4">Emma Johnson - Human Resources</option>
                                                    <option value="5">Robert Brown - Operations</option>
                                                @endif
                                            </select>
                                            @error('employee_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="attendanceDate" class="form-label">Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="attendanceDate" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                            @error('date')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="attendanceStatus" class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-select" id="attendanceStatus" name="status" required>
                                                <option value="">Select Status</option>
                                                <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>Present</option>
                                                <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                                                <option value="late" {{ old('status') == 'late' ? 'selected' : '' }}>Late</option>
                                                <option value="half_day" {{ old('status') == 'half_day' ? 'selected' : '' }}>Half Day</option>
                                                <option value="on_leave" {{ old('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="departmentSelect" class="form-label">Department</label>
                                            <select class="form-select" id="departmentSelect" name="department_id">
                                                <option value="">Select Department</option>
                                                @if(isset($departments))
                                                    @foreach($departments as $department)
                                                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="1">IT Department</option>
                                                    <option value="2">Human Resources</option>
                                                    <option value="3">Marketing</option>
                                                    <option value="4">Finance</option>
                                                    <option value="5">Operations</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="clockInTime" class="form-label">Clock In Time</label>
                                            <input type="time" class="form-control" id="clockInTime" name="check_in" value="{{ old('check_in') }}">
                                            @error('check_in')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="clockOutTime" class="form-label">Clock Out Time</label>
                                            <input type="time" class="form-control" id="clockOutTime" name="check_out" value="{{ old('check_out') }}">
                                            @error('check_out')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="attendanceNotes" class="form-label">Notes</label>
                                        <textarea class="form-control" id="attendanceNotes" name="notes" rows="3" placeholder="Any additional notes...">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="d-flex justify-content-end">
                                        <button type="reset" class="btn btn-secondary me-2">Reset</button>
                                        <button type="submit" class="btn btn-primary" id="saveAttendanceBtn">
                                            <span class="spinner-border spinner-border-sm d-none" role="status" id="attendanceSpinner"></span>
                                            <span id="attendanceBtnText">Save Attendance</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Manual Entries -->
                <div class="row g-3 g-md-4 mt-2">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Recent Manual Entries</h5>
                                <button class="btn btn-sm btn-light" id="refreshEntriesBtn">
                                    <i class="bi bi-arrow-repeat"></i> Refresh
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="recentEntriesTable">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Clock In</th>
                                                <th>Clock Out</th>
                                                <th>Entered By</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://ui-avatars.com/api/?name=Alex+Johnson&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                        <span>Alex Johnson</span>
                                                    </div>
                                                </td>
                                                <td>Jan 15, 2024</td>
                                                <td><span class="badge bg-success status-badge">Present</span></td>
                                                <td>09:30 AM</td>
                                                <td>05:30 PM</td>
                                                <td>Admin User</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary view-entry" data-id="1">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-warning edit-entry" data-id="1">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger delete-entry" data-id="1">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://ui-avatars.com/api/?name=Mary+Williams&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                        <span>Mary Williams</span>
                                                    </div>
                                                </td>
                                                <td>Jan 14, 2024</td>
                                                <td><span class="badge bg-warning status-badge">Late</span></td>
                                                <td>10:15 AM</td>
                                                <td>06:00 PM</td>
                                                <td>Admin User</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary view-entry" data-id="2">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-warning edit-entry" data-id="2">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger delete-entry" data-id="2">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://ui-avatars.com/api/?name=Tom+Brown&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                        <span>Tom Brown</span>
                                                    </div>
                                                </td>
                                                <td>Jan 14, 2024</td>
                                                <td><span class="badge bg-danger status-badge">Absent</span></td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>Admin User</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary view-entry" data-id="3">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-warning edit-entry" data-id="3">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger delete-entry" data-id="3">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <button class="btn btn-sm btn-outline-secondary" id="prevPageBtn">
                                            <i class="bi bi-chevron-left"></i> Previous
                                        </button>
                                    </div>
                                    <div>
                                        <span class="text-muted">Page 1 of 3</span>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-outline-secondary" id="nextPageBtn">
                                            Next <i class="bi bi-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Records Tab -->
            <div class="tab-pane fade" id="records" role="tabpanel" aria-labelledby="records-tab">
                <div class="row g-3 g-md-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5><i class="bi bi-table"></i> Detailed Attendance Records</h5>
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
                                <!-- Filters -->
                                <form method="GET" action="{{ route('superadmin.attendance.index') }}">
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-2">
                                            <label for="recordsDateFilter" class="form-label">Date</label>
                                            <input type="date" class="form-control" id="recordsDateFilter" name="date" value="{{ request('date') }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="recordsMonthFilter" class="form-label">Month</label>
                                            <select class="form-select" id="recordsMonthFilter" name="month">
                                                <option value="">All Months</option>
                                                <option value="1" {{ request('month') == '1' ? 'selected' : '' }}>January</option>
                                                <option value="2" {{ request('month') == '2' ? 'selected' : '' }}>February</option>
                                                <option value="3" {{ request('month') == '3' ? 'selected' : '' }}>March</option>
                                                <option value="4" {{ request('month') == '4' ? 'selected' : '' }}>April</option>
                                                <option value="5" {{ request('month') == '5' ? 'selected' : '' }}>May</option>
                                                <option value="6" {{ request('month') == '6' ? 'selected' : '' }}>June</option>
                                                <option value="7" {{ request('month') == '7' ? 'selected' : '' }}>July</option>
                                                <option value="8" {{ request('month') == '8' ? 'selected' : '' }}>August</option>
                                                <option value="9" {{ request('month') == '9' ? 'selected' : '' }}>September</option>
                                                <option value="10" {{ request('month') == '10' ? 'selected' : '' }}>October</option>
                                                <option value="11" {{ request('month') == '11' ? 'selected' : '' }}>November</option>
                                                <option value="12" {{ request('month') == '12' ? 'selected' : '' }}>December</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="recordsYearFilter" class="form-label">Year</label>
                                            <select class="form-select" id="recordsYearFilter" name="year">
                                                <option value="">All Years</option>
                                                <option value="2025" {{ request('year') == '2025' ? 'selected' : '' }}>2025</option>
                                                <option value="2024" {{ request('year') == '2024' ? 'selected' : '' }}>2024</option>
                                                <option value="2023" {{ request('year') == '2023' ? 'selected' : '' }}>2023</option>
                                                <option value="2022" {{ request('year') == '2022' ? 'selected' : '' }}>2022</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="recordsDepartmentFilter" class="form-label">Department</label>
                                            <select class="form-select" id="recordsDepartmentFilter" name="department_id">
                                                <option value="">All Departments</option>
                                                <option value="1" {{ request('department_id') == '1' ? 'selected' : '' }}>IT Department</option>
                                                <option value="2" {{ request('department_id') == '2' ? 'selected' : '' }}>Human Resources</option>
                                                <option value="3" {{ request('department_id') == '3' ? 'selected' : '' }}>Marketing</option>
                                                <option value="4" {{ request('department_id') == '4' ? 'selected' : '' }}>Finance</option>
                                                <option value="5" {{ request('department_id') == '5' ? 'selected' : '' }}>Operations</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="recordsStatusFilter" class="form-label">Status</label>
                                            <select class="form-select" id="recordsStatusFilter" name="status">
                                                <option value="">All Statuses</option>
                                                <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
                                                <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                                                <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late</option>
                                                <option value="half_day" {{ request('status') == 'half_day' ? 'selected' : '' }}>Half Day</option>
                                                <option value="on_leave" {{ request('status') == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="recordsEmployeeFilter" class="form-label">Employee</label>
                                            <input type="text" class="form-control" id="recordsEmployeeFilter" name="employee_name" placeholder="Search employee..." value="{{ request('employee_name') }}">
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button class="btn btn-primary w-100" type="submit">
                                                <i class="bi bi-search"></i> Filter
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Clock In</th>
                                                <th>Clock Out</th>
                                                <th>Hours Worked</th>
                                                <th>Entered By</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($attendanceRecords))
                                                @foreach($attendanceRecords as $record)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($record->employee_name) }}&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                                <span>{{ $record->employee_name }}</span>
                                                            </div>
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}</td>
                                                        <td>
                                                            @if($record->status == 'present')
                                                                <span class="badge bg-success">Present</span>
                                                            @elseif($record->status == 'absent')
                                                                <span class="badge bg-danger">Absent</span>
                                                            @elseif($record->status == 'late')
                                                                <span class="badge bg-warning">Late</span>
                                                            @elseif($record->status == 'half_day')
                                                                <span class="badge bg-info">Half Day</span>
                                                            @elseif($record->status == 'on_leave')
                                                                <span class="badge bg-secondary">On Leave</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $record->check_in ? \Carbon\Carbon::parse($record->check_in)->format('h:i A') : '-' }}</td>
                                                        <td>{{ $record->check_out ? \Carbon\Carbon::parse($record->check_out)->format('h:i A') : '-' }}</td>
                                                        <td>{{ $record->total_hours ? round($record->total_hours / 60, 2) . ' hrs' : '-' }}</td>
                                                        <td>{{ $record->is_manual ? 'Manual Entry' : 'System' }}</td>
                                                        <td>
                                                            <button class="btn btn-sm btn-outline-primary view-record" data-id="{{ $record->id }}">
                                                                <i class="bi bi-eye"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-warning edit-record" data-id="{{ $record->id }}">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-danger delete-record" data-id="{{ $record->id }}" data-name="{{ $record->employee_name }}">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <!-- <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="https://ui-avatars.com/api/?name=John+Smith&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                            <span>John Smith</span>
                                                        </div>
                                                    </td>
                                                    <td>Jan 15, 2024</td>
                                                    <td><span class="badge bg-success">Present</span></td>
                                                    <td>09:00 AM</td>
                                                    <td>05:00 PM</td>
                                                    <td>8.0 hrs</td>
                                                    <td>System</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                                        <button class="btn btn-sm btn-outline-warning">Edit</button>
                                                    </td>
                                                </tr> -->
                                                <!-- <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="https://ui-avatars.com/api/?name=Sarah+Lee&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                            <span>Sarah Lee</span>
                                                        </div>
                                                    </td>
                                                    <td>Jan 15, 2024</td>
                                                    <td><span class="badge bg-success">Present</span></td>
                                                    <td>08:45 AM</td>
                                                    <td>05:30 PM</td>
                                                    <td>8.75 hrs</td>
                                                    <td>System</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                                        <button class="btn btn-sm btn-outline-warning">Edit</button>
                                                    </td>
                                                </tr> -->
                                                <!-- <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="https://ui-avatars.com/api/?name=Mike+Davis&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                            <span>Mike Davis</span>
                                                        </div>
                                                    </td>
                                                    <td>Jan 15, 2024</td>
                                                    <td><span class="badge bg-danger">Absent</span></td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td>0 hrs</td>
                                                    <td>System</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                                        <button class="btn btn-sm btn-outline-warning">Edit</button>
                                                    </td>
                                                </tr> -->
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Records Pagination -->
                                <nav aria-label="Attendance records pagination" class="mt-4">
                                    <ul class="pagination justify-content-center mb-0">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                <i class="bi bi-chevron-left"></i> Previous
                                            </a>
                                        </li>
                                        <li class="page-item active">
                                            <a class="page-link" href="#">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">
                                                Next <i class="bi bi-chevron-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Manual Attendance Modal -->
    <div class="modal fade" id="manualAttendanceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Manual Attendance</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('hrm.attendance.manual-entry') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="modalEmployeeSelect" class="form-label">Employee</label>
                            <select class="form-select" id="modalEmployeeSelect" name="employee_id">
                                <option value="">Select Employee</option>
                                @if(isset($employees))
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                @else
                                    <option value="1">John Smith - IT Department</option>
                                    <option value="2">Sarah Lee - Marketing</option>
                                    <option value="3">Mike Davis - Finance</option>
                                    <option value="4">Emma Johnson - Human Resources</option>
                                    <option value="5">Robert Brown - Operations</option>
                                @endif
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modalAttendanceDate" class="form-label">Date</label>
                            <input type="date" class="form-control" id="modalAttendanceDate" name="date" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-3">
                            <label for="modalAttendanceStatus" class="form-label">Status</label>
                            <select class="form-select" id="modalAttendanceStatus" name="status">
                                <option value="present">Present</option>
                                <option value="absent">Absent</option>
                                <option value="late">Late</option>
                                <option value="half_day">Half Day</option>
                                <option value="on_leave">On Leave</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="modalClockInTime" class="form-label">Clock In Time</label>
                                    <input type="time" class="form-control" id="modalClockInTime" name="check_in">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="modalClockOutTime" class="form-label">Clock Out Time</label>
                                    <input type="time" class="form-control" id="modalClockOutTime" name="check_out">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="modalAttendanceNotes" class="form-label">Notes</label>
                            <textarea class="form-control" id="modalAttendanceNotes" name="notes" rows="3" placeholder="Any additional notes..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Attendance</button>
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
            
            // Handle tab navigation
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
            
            // Manual attendance button in overview tab
            const manualAttendanceBtn = document.querySelector('[data-bs-target="#manual"]');
            if (manualAttendanceBtn) {
                manualAttendanceBtn.addEventListener('click', function() {
                    // Switch to manual tab
                    document.querySelectorAll('#attendanceTabs button').forEach(function(tab) {
                        tab.classList.remove('active');
                    });
                    document.querySelectorAll('.tab-pane').forEach(function(pane) {
                        pane.classList.remove('show', 'active');
                    });
                    
                    // Activate the manual tab
                    document.getElementById('manual-tab').classList.add('active');
                    document.getElementById('manual').classList.add('show', 'active');
                });
            }
            
            // Enhanced manual attendance form functionality
            const manualAttendanceForm = document.getElementById('manualAttendanceForm');
            if (manualAttendanceForm) {
                manualAttendanceForm.addEventListener('submit', function(e) {
                    // Form will submit normally to the server
                    // Show loading state
                    const saveBtn = document.getElementById('saveAttendanceBtn');
                    const spinner = document.getElementById('attendanceSpinner');
                    const btnText = document.getElementById('attendanceBtnText');
                    
                    saveBtn.disabled = true;
                    spinner.classList.remove('d-none');
                    btnText.textContent = 'Saving...';
                });
            }
            
            // Refresh recent entries
            function refreshRecentEntries() {
                // In a real app, this would fetch updated data from the server
                console.log('Refreshing recent entries...');
            }
            
            // Refresh button functionality
            const refreshBtn = document.getElementById('refreshEntriesBtn');
            if (refreshBtn) {
                refreshBtn.addEventListener('click', function() {
                    const spinner = document.createElement('span');
                    spinner.className = 'spinner-border spinner-border-sm ms-2';
                    spinner.role = 'status';
                    refreshBtn.innerHTML = 'Refreshing... ';
                    refreshBtn.appendChild(spinner);
                    
                    setTimeout(function() {
                        refreshBtn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Refresh';
                        alert('Entries refreshed successfully!');
                    }, 1000);
                });
            }
            
            // Initial attachment of event listeners for manual attendance entries
            attachEntryEventListeners();
            
            // Manual Attendance Pagination functionality
            let currentPage = 1;
            const totalPages = 3;
            const entriesPerPage = 3;
            
            // Sample data for demonstration
            const sampleEntries = [
                {
                    id: 1,
                    name: 'Alex Johnson',
                    date: 'Jan 15, 2024',
                    status: 'Present',
                    statusClass: 'bg-success',
                    clockIn: '09:30 AM',
                    clockOut: '05:30 PM',
                    enteredBy: 'Admin User'
                },
                {
                    id: 2,
                    name: 'Mary Williams',
                    date: 'Jan 14, 2024',
                    status: 'Late',
                    statusClass: 'bg-warning',
                    clockIn: '10:15 AM',
                    clockOut: '06:00 PM',
                    enteredBy: 'Admin User'
                },
                {
                    id: 3,
                    name: 'Tom Brown',
                    date: 'Jan 14, 2024',
                    status: 'Absent',
                    statusClass: 'bg-danger',
                    clockIn: '-',
                    clockOut: '-',
                    enteredBy: 'Admin User'
                },
                {
                    id: 4,
                    name: 'Sarah Davis',
                    date: 'Jan 13, 2024',
                    status: 'Present',
                    statusClass: 'bg-success',
                    clockIn: '08:45 AM',
                    clockOut: '05:15 PM',
                    enteredBy: 'Admin User'
                },
                {
                    id: 5,
                    name: 'Mike Wilson',
                    date: 'Jan 13, 2024',
                    status: 'Half Day',
                    statusClass: 'bg-info',
                    clockIn: '09:00 AM',
                    clockOut: '01:00 PM',
                    enteredBy: 'Admin User'
                },
                {
                    id: 6,
                    name: 'Emma Thompson',
                    date: 'Jan 12, 2024',
                    status: 'Present',
                    statusClass: 'bg-success',
                    clockIn: '08:30 AM',
                    clockOut: '05:45 PM',
                    enteredBy: 'Admin User'
                },
                {
                    id: 7,
                    name: 'James Miller',
                    date: 'Jan 12, 2024',
                    status: 'Late',
                    statusClass: 'bg-warning',
                    clockIn: '10:30 AM',
                    clockOut: '06:30 PM',
                    enteredBy: 'Admin User'
                },
                {
                    id: 8,
                    name: 'Lisa Garcia',
                    date: 'Jan 11, 2024',
                    status: 'Present',
                    statusClass: 'bg-success',
                    clockIn: '09:15 AM',
                    clockOut: '05:20 PM',
                    enteredBy: 'Admin User'
                },
                {
                    id: 9,
                    name: 'Robert Lee',
                    date: 'Jan 11, 2024',
                    status: 'Absent',
                    statusClass: 'bg-danger',
                    clockIn: '-',
                    clockOut: '-',
                    enteredBy: 'Admin User'
                }
            ];
            
            function updateManualEntriesTable() {
                const tableBody = document.querySelector('#recentEntriesTable tbody');
                const startIndex = (currentPage - 1) * entriesPerPage;
                const endIndex = startIndex + entriesPerPage;
                const pageEntries = sampleEntries.slice(startIndex, endIndex);
                
                // Clear existing rows
                tableBody.innerHTML = '';
                
                // Add new rows
                pageEntries.forEach(entry => {
                    const row = `
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(entry.name)}&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                    <span>${entry.name}</span>
                                </div>
                            </td>
                            <td>${entry.date}</td>
                            <td><span class="badge ${entry.statusClass} status-badge">${entry.status}</span></td>
                            <td>${entry.clockIn}</td>
                            <td>${entry.clockOut}</td>
                            <td>${entry.enteredBy}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary view-entry" data-id="${entry.id}">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning edit-entry" data-id="${entry.id}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-entry" data-id="${entry.id}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });
                
                // Update pagination info
                const pageInfo = document.querySelector('.text-muted');
                if (pageInfo) {
                    pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
                }
                
                // Update button states
                const prevBtn = document.getElementById('prevPageBtn');
                const nextBtn = document.getElementById('nextPageBtn');
                
                if (prevBtn) {
                    prevBtn.disabled = currentPage === 1;
                    if (currentPage === 1) {
                        prevBtn.classList.add('disabled');
                    } else {
                        prevBtn.classList.remove('disabled');
                    }
                }
                
                if (nextBtn) {
                    nextBtn.disabled = currentPage === totalPages;
                    if (currentPage === totalPages) {
                        nextBtn.classList.add('disabled');
                    } else {
                        nextBtn.classList.remove('disabled');
                    }
                }
                
                // Re-attach event listeners for new buttons
                attachEntryEventListeners();
            }
            
            function attachEntryEventListeners() {
                // View entry functionality
                document.querySelectorAll('.view-entry').forEach(button => {
                    button.addEventListener('click', function() {
                        const entryId = this.getAttribute('data-id');
                        showNotification(`Viewing entry #${entryId}`, 'info');
                    });
                });
                
                // Edit entry functionality
                document.querySelectorAll('.edit-entry').forEach(button => {
                    button.addEventListener('click', function() {
                        const entryId = this.getAttribute('data-id');
                        showNotification(`Editing entry #${entryId}`, 'info');
                    });
                });
                
                // Delete entry functionality
                document.querySelectorAll('.delete-entry').forEach(button => {
                    button.addEventListener('click', function() {
                        const entryId = this.getAttribute('data-id');
                        if (confirm('Are you sure you want to delete this attendance entry?')) {
                            showNotification(`Entry #${entryId} deleted successfully!`, 'success');
                            // Remove the entry from sampleEntries array
                            const index = sampleEntries.findIndex(entry => entry.id == entryId);
                            if (index > -1) {
                                sampleEntries.splice(index, 1);
                                // Adjust current page if necessary
                                const maxPage = Math.ceil(sampleEntries.length / entriesPerPage);
                                if (currentPage > maxPage && maxPage > 0) {
                                    currentPage = maxPage;
                                }
                                updateManualEntriesTable();
                            }
                        }
                    });
                });
            }
            
            // Pagination button functionality
            const prevPageBtn = document.getElementById('prevPageBtn');
            const nextPageBtn = document.getElementById('nextPageBtn');
            
            if (prevPageBtn) {
                prevPageBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (currentPage > 1) {
                        currentPage--;
                        updateManualEntriesTable();
                        showNotification(`Loading page ${currentPage}...`, 'info');
                    }
                });
            }
            
            if (nextPageBtn) {
                nextPageBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (currentPage < totalPages) {
                        currentPage++;
                        updateManualEntriesTable();
                        showNotification(`Loading page ${currentPage}...`, 'info');
                    }
                });
            }
            
            // Initialize the table
            updateManualEntriesTable();
            
            // ===== OVERVIEW TAB PAGINATION =====
            let overviewCurrentPage = 1;
            const overviewTotalPages = 4;
            const overviewEntriesPerPage = 5;
            
            const overviewSampleData = [
                { id: 1, name: 'John Smith', department: 'IT Department', status: 'Present', statusClass: 'bg-success', clockIn: '09:00 AM', clockOut: '-', hours: '3.5 hrs' },
                { id: 2, name: 'Sarah Johnson', department: 'Marketing', status: 'Present', statusClass: 'bg-success', clockIn: '08:45 AM', clockOut: '-', hours: '3.8 hrs' },
                { id: 3, name: 'Mike Davis', department: 'Finance', status: 'Late', statusClass: 'bg-warning', clockIn: '10:15 AM', clockOut: '-', hours: '2.2 hrs' },
                { id: 4, name: 'Emma Wilson', department: 'HR', status: 'Present', statusClass: 'bg-success', clockIn: '09:10 AM', clockOut: '-', hours: '3.4 hrs' },
                { id: 5, name: 'Robert Brown', department: 'Operations', status: 'Absent', statusClass: 'bg-danger', clockIn: '-', clockOut: '-', hours: '0 hrs' },
                { id: 6, name: 'Lisa Garcia', department: 'IT Department', status: 'Present', statusClass: 'bg-success', clockIn: '08:30 AM', clockOut: '-', hours: '4.0 hrs' },
                { id: 7, name: 'David Miller', department: 'Marketing', status: 'Present', statusClass: 'bg-success', clockIn: '09:05 AM', clockOut: '-', hours: '3.6 hrs' },
                { id: 8, name: 'Jennifer Lee', department: 'Finance', status: 'Half Day', statusClass: 'bg-info', clockIn: '09:00 AM', clockOut: '01:00 PM', hours: '4.0 hrs' },
                { id: 9, name: 'Christopher Anderson', department: 'Operations', status: 'Present', statusClass: 'bg-success', clockIn: '09:05 AM', clockOut: '-', hours: '3.6 hrs' },
                { id: 10, name: 'Amanda Thomas', department: 'HR', status: 'Present', statusClass: 'bg-success', clockIn: '08:50 AM', clockOut: '-', hours: '3.8 hrs' },
                { id: 11, name: 'James Wilson', department: 'IT Department', status: 'Late', statusClass: 'bg-warning', clockIn: '10:30 AM', clockOut: '-', hours: '2.0 hrs' },
                { id: 12, name: 'Maria Rodriguez', department: 'Marketing', status: 'Present', statusClass: 'bg-success', clockIn: '08:55 AM', clockOut: '-', hours: '3.7 hrs' },
                { id: 13, name: 'Kevin Taylor', department: 'Finance', status: 'Present', statusClass: 'bg-success', clockIn: '09:15 AM', clockOut: '-', hours: '3.3 hrs' },
                { id: 14, name: 'Nicole Martinez', department: 'Operations', status: 'Absent', statusClass: 'bg-danger', clockIn: '-', clockOut: '-', hours: '0 hrs' },
                { id: 15, name: 'Daniel Jackson', department: 'HR', status: 'Present', statusClass: 'bg-success', clockIn: '09:20 AM', clockOut: '-', hours: '3.2 hrs' },
                { id: 16, name: 'Rachel White', department: 'IT Department', status: 'Present', statusClass: 'bg-success', clockIn: '08:40 AM', clockOut: '-', hours: '3.9 hrs' },
                { id: 17, name: 'Steven Harris', department: 'Marketing', status: 'Present', statusClass: 'bg-success', clockIn: '09:00 AM', clockOut: '-', hours: '3.5 hrs' },
                { id: 18, name: 'Michelle Clark', department: 'Finance', status: 'Late', statusClass: 'bg-warning', clockIn: '10:45 AM', clockOut: '-', hours: '1.8 hrs' },
                { id: 19, name: 'Brian Lewis', department: 'Operations', status: 'Present', statusClass: 'bg-success', clockIn: '08:35 AM', clockOut: '-', hours: '4.1 hrs' },
                { id: 20, name: 'Laura Walker', department: 'HR', status: 'Present', statusClass: 'bg-success', clockIn: '09:10 AM', clockOut: '-', hours: '3.4 hrs' }
            ];
            
            function updateOverviewTable() {
                const tableBody = document.querySelector('#attendanceTable tbody');
                if (!tableBody) return;
                
                const startIndex = (overviewCurrentPage - 1) * overviewEntriesPerPage;
                const endIndex = startIndex + overviewEntriesPerPage;
                const pageEntries = overviewSampleData.slice(startIndex, endIndex);
                
                tableBody.innerHTML = '';
                
                pageEntries.forEach(entry => {
                    const row = `
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input row-checkbox" type="checkbox" data-id="${entry.id}">
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(entry.name)}&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                    <span>${entry.name}</span>
                                </div>
                            </td>
                            <td>${entry.department}</td>
                            <td><span class="badge ${entry.statusClass}">${entry.status}</span></td>
                            <td>${entry.clockIn}</td>
                            <td>${entry.clockOut}</td>
                            <td>${entry.hours}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary view-record" data-id="${entry.id}">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning edit-record" data-id="${entry.id}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });
                
                updateOverviewPagination();
                attachOverviewEventListeners();
            }
            
            function updateOverviewPagination() {
                const paginationContainer = document.querySelector('#overview .pagination');
                if (!paginationContainer) return;
                
                let paginationHTML = '';
                
                // Previous button
                paginationHTML += `
                    <li class="page-item ${overviewCurrentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link overview-prev" href="#" tabindex="-1" aria-disabled="${overviewCurrentPage === 1}">
                            <i class="bi bi-chevron-left"></i> Previous
                        </a>
                    </li>
                `;
                
                // Page numbers
                for (let i = 1; i <= overviewTotalPages; i++) {
                    paginationHTML += `
                        <li class="page-item ${i === overviewCurrentPage ? 'active' : ''}">
                            <a class="page-link overview-page" href="#" data-page="${i}">${i}</a>
                        </li>
                    `;
                }
                
                // Next button
                paginationHTML += `
                    <li class="page-item ${overviewCurrentPage === overviewTotalPages ? 'disabled' : ''}">
                        <a class="page-link overview-next" href="#">
                            Next <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                `;
                
                paginationContainer.innerHTML = paginationHTML;
                attachOverviewPaginationListeners();
            }
            
            function attachOverviewEventListeners() {
                document.querySelectorAll('.view-record').forEach(button => {
                    button.addEventListener('click', function() {
                        const recordId = this.getAttribute('data-id');
                        showNotification(`Viewing overview record #${recordId}`, 'info');
                    });
                });
                
                document.querySelectorAll('.edit-record').forEach(button => {
                    button.addEventListener('click', function() {
                        const recordId = this.getAttribute('data-id');
                        showNotification(`Editing overview record #${recordId}`, 'info');
                    });
                });
                
                document.querySelectorAll('.row-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        updateBulkActionButtons();
                    });
                });
            }
            
            function attachOverviewPaginationListeners() {
                document.querySelectorAll('.overview-prev').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (overviewCurrentPage > 1) {
                            overviewCurrentPage--;
                            updateOverviewTable();
                            showNotification(`Loading page ${overviewCurrentPage}...`, 'info');
                        }
                    });
                });
                
                document.querySelectorAll('.overview-next').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (overviewCurrentPage < overviewTotalPages) {
                            overviewCurrentPage++;
                            updateOverviewTable();
                            showNotification(`Loading page ${overviewCurrentPage}...`, 'info');
                        }
                    });
                });
                
                document.querySelectorAll('.overview-page').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = parseInt(this.getAttribute('data-page'));
                        if (page !== overviewCurrentPage) {
                            overviewCurrentPage = page;
                            updateOverviewTable();
                            showNotification(`Loading page ${overviewCurrentPage}...`, 'info');
                        }
                    });
                });
            }
            
            // ===== ADMIN ATTENDANCE TAB PAGINATION =====
            let adminCurrentPage = 1;
            const adminTotalPages = 3;
            const adminEntriesPerPage = 3;
            
            const adminSampleData = [
                { id: 1, name: 'John Admin', department: 'IT Department', status: 'Present', statusClass: 'bg-success', clockIn: '09:00 AM', clockOut: '-', hours: '3.5 hrs' },
                { id: 2, name: 'Sarah Admin', department: 'Human Resources', status: 'Present', statusClass: 'bg-success', clockIn: '08:45 AM', clockOut: '-', hours: '3.8 hrs' },
                { id: 3, name: 'Mike Admin', department: 'Finance', status: 'Absent', statusClass: 'bg-danger', clockIn: '-', clockOut: '-', hours: '0 hrs' },
                { id: 4, name: 'Emma Admin', department: 'Operations', status: 'Present', statusClass: 'bg-success', clockIn: '09:10 AM', clockOut: '-', hours: '3.4 hrs' },
                { id: 5, name: 'Robert Admin', department: 'IT Department', status: 'Late', statusClass: 'bg-warning', clockIn: '10:15 AM', clockOut: '-', hours: '2.2 hrs' },
                { id: 6, name: 'Lisa Admin', department: 'Human Resources', status: 'Present', statusClass: 'bg-success', clockIn: '08:30 AM', clockOut: '-', hours: '4.0 hrs' },
                { id: 7, name: 'David Admin', department: 'Finance', status: 'Present', statusClass: 'bg-success', clockIn: '09:05 AM', clockOut: '-', hours: '3.6 hrs' },
                { id: 8, name: 'Jennifer Admin', department: 'Operations', status: 'Half Day', statusClass: 'bg-info', clockIn: '09:00 AM', clockOut: '01:00 PM', hours: '4.0 hrs' },
                { id: 9, name: 'Christopher Admin', department: 'IT Department', status: 'Present', statusClass: 'bg-success', clockIn: '09:05 AM', clockOut: '-', hours: '3.6 hrs' }
            ];
            
            function updateAdminTable() {
                const tableBody = document.querySelector('#adminAttendanceTable tbody');
                if (!tableBody) return;
                
                const startIndex = (adminCurrentPage - 1) * adminEntriesPerPage;
                const endIndex = startIndex + adminEntriesPerPage;
                const pageEntries = adminSampleData.slice(startIndex, endIndex);
                
                tableBody.innerHTML = '';
                
                pageEntries.forEach(entry => {
                    const row = `
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(entry.name)}&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                    <span>${entry.name}</span>
                                </div>
                            </td>
                            <td>${entry.department}</td>
                            <td><span class="badge ${entry.statusClass}">${entry.status}</span></td>
                            <td>${entry.clockIn}</td>
                            <td>${entry.clockOut}</td>
                            <td>${entry.hours}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary view-admin-record" data-id="${entry.id}" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning edit-admin-record" data-id="${entry.id}" title="Edit Record">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });
                
                updateAdminPagination();
                attachAdminEventListeners();
            }
            
            function updateAdminPagination() {
                const paginationContainer = document.querySelector('#admin-attendance .pagination');
                if (!paginationContainer) return;
                
                let paginationHTML = '';
                
                // Previous button
                paginationHTML += `
                    <li class="page-item ${adminCurrentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link admin-prev" href="#" tabindex="-1" aria-disabled="${adminCurrentPage === 1}">
                            <i class="bi bi-chevron-left"></i> Previous
                        </a>
                    </li>
                `;
                
                // Page numbers
                for (let i = 1; i <= adminTotalPages; i++) {
                    paginationHTML += `
                        <li class="page-item ${i === adminCurrentPage ? 'active' : ''}">
                            <a class="page-link admin-page" href="#" data-page="${i}">${i}</a>
                        </li>
                    `;
                }
                
                // Next button
                paginationHTML += `
                    <li class="page-item ${adminCurrentPage === adminTotalPages ? 'disabled' : ''}">
                        <a class="page-link admin-next" href="#">
                            Next <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                `;
                
                paginationContainer.innerHTML = paginationHTML;
                attachAdminPaginationListeners();
            }
            
            function attachAdminEventListeners() {
                document.querySelectorAll('.view-admin-record').forEach(button => {
                    button.addEventListener('click', function() {
                        const recordId = this.getAttribute('data-id');
                        showNotification(`Viewing admin record #${recordId}`, 'info');
                        showAdminRecordModal(recordId);
                    });
                });
                
                document.querySelectorAll('.edit-admin-record').forEach(button => {
                    button.addEventListener('click', function() {
                        const recordId = this.getAttribute('data-id');
                        showNotification(`Editing admin record #${recordId}`, 'info');
                        showAdminEditModal(recordId);
                    });
                });
            }
            
            function attachAdminPaginationListeners() {
                document.querySelectorAll('.admin-prev').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (adminCurrentPage > 1) {
                            adminCurrentPage--;
                            updateAdminTable();
                            showNotification(`Loading admin page ${adminCurrentPage}...`, 'info');
                        }
                    });
                });
                
                document.querySelectorAll('.admin-next').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (adminCurrentPage < adminTotalPages) {
                            adminCurrentPage++;
                            updateAdminTable();
                            showNotification(`Loading admin page ${adminCurrentPage}...`, 'info');
                        }
                    });
                });
                
                document.querySelectorAll('.admin-page').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = parseInt(this.getAttribute('data-page'));
                        if (page !== adminCurrentPage) {
                            adminCurrentPage = page;
                            updateAdminTable();
                            showNotification(`Loading admin page ${adminCurrentPage}...`, 'info');
                        }
                    });
                });
            }
            
            // ===== EMPLOYEE ATTENDANCE TAB PAGINATION =====
            let employeeCurrentPage = 1;
            const employeeTotalPages = 3;
            const employeeEntriesPerPage = 3;
            
            const employeeSampleData = [
                { id: 1, name: 'John Employee', department: 'IT Department', status: 'Present', statusClass: 'bg-success', clockIn: '09:00 AM', clockOut: '-', hours: '3.5 hrs' },
                { id: 2, name: 'Sarah Employee', department: 'Marketing', status: 'Present', statusClass: 'bg-success', clockIn: '08:45 AM', clockOut: '-', hours: '3.8 hrs' },
                { id: 3, name: 'Mike Employee', department: 'Finance', status: 'Absent', statusClass: 'bg-danger', clockIn: '-', clockOut: '-', hours: '0 hrs' },
                { id: 4, name: 'Emma Employee', department: 'Operations', status: 'Present', statusClass: 'bg-success', clockIn: '09:10 AM', clockOut: '-', hours: '3.4 hrs' },
                { id: 5, name: 'Robert Employee', department: 'IT Department', status: 'Late', statusClass: 'bg-warning', clockIn: '10:15 AM', clockOut: '-', hours: '2.2 hrs' },
                { id: 6, name: 'Lisa Employee', department: 'Marketing', status: 'Present', statusClass: 'bg-success', clockIn: '08:30 AM', clockOut: '-', hours: '4.0 hrs' },
                { id: 7, name: 'David Employee', department: 'Finance', status: 'Present', statusClass: 'bg-success', clockIn: '09:05 AM', clockOut: '-', hours: '3.6 hrs' },
                { id: 8, name: 'Jennifer Employee', department: 'Operations', status: 'Half Day', statusClass: 'bg-info', clockIn: '09:00 AM', clockOut: '01:00 PM', hours: '4.0 hrs' },
                { id: 9, name: 'Christopher Employee', department: 'IT Department', status: 'Present', statusClass: 'bg-success', clockIn: '09:05 AM', clockOut: '-', hours: '3.6 hrs' }
            ];
            
            function updateEmployeeTable() {
                const tableBody = document.querySelector('#employeeAttendanceTable tbody');
                if (!tableBody) return;
                
                const startIndex = (employeeCurrentPage - 1) * employeeEntriesPerPage;
                const endIndex = startIndex + employeeEntriesPerPage;
                const pageEntries = employeeSampleData.slice(startIndex, endIndex);
                
                tableBody.innerHTML = '';
                
                pageEntries.forEach(entry => {
                    const row = `
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(entry.name)}&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                    <span>${entry.name}</span>
                                </div>
                            </td>
                            <td>${entry.department}</td>
                            <td><span class="badge ${entry.statusClass}">${entry.status}</span></td>
                            <td>${entry.clockIn}</td>
                            <td>${entry.clockOut}</td>
                            <td>${entry.hours}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary view-employee-record" data-id="${entry.id}">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning edit-employee-record" data-id="${entry.id}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });
                
                updateEmployeePagination();
                attachEmployeeEventListeners();
            }
            
            function updateEmployeePagination() {
                const paginationContainer = document.querySelector('#employee-attendance .pagination');
                if (!paginationContainer) return;
                
                let paginationHTML = '';
                
                // Previous button
                paginationHTML += `
                    <li class="page-item ${employeeCurrentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link employee-prev" href="#" tabindex="-1" aria-disabled="${employeeCurrentPage === 1}">
                            <i class="bi bi-chevron-left"></i> Previous
                        </a>
                    </li>
                `;
                
                // Page numbers
                for (let i = 1; i <= employeeTotalPages; i++) {
                    paginationHTML += `
                        <li class="page-item ${i === employeeCurrentPage ? 'active' : ''}">
                            <a class="page-link employee-page" href="#" data-page="${i}">${i}</a>
                        </li>
                    `;
                }
                
                // Next button
                paginationHTML += `
                    <li class="page-item ${employeeCurrentPage === employeeTotalPages ? 'disabled' : ''}">
                        <a class="page-link employee-next" href="#">
                            Next <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                `;
                
                paginationContainer.innerHTML = paginationHTML;
                attachEmployeePaginationListeners();
            }
            
            function attachEmployeeEventListeners() {
                document.querySelectorAll('.view-employee-record').forEach(button => {
                    button.addEventListener('click', function() {
                        const recordId = this.getAttribute('data-id');
                        showNotification(`Viewing employee record #${recordId}`, 'info');
                    });
                });
                
                document.querySelectorAll('.edit-employee-record').forEach(button => {
                    button.addEventListener('click', function() {
                        const recordId = this.getAttribute('data-id');
                        showNotification(`Editing employee record #${recordId}`, 'info');
                    });
                });
            }
            
            function attachEmployeePaginationListeners() {
                document.querySelectorAll('.employee-prev').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (employeeCurrentPage > 1) {
                            employeeCurrentPage--;
                            updateEmployeeTable();
                            showNotification(`Loading employee page ${employeeCurrentPage}...`, 'info');
                        }
                    });
                });
                
                document.querySelectorAll('.employee-next').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (employeeCurrentPage < employeeTotalPages) {
                            employeeCurrentPage++;
                            updateEmployeeTable();
                            showNotification(`Loading employee page ${employeeCurrentPage}...`, 'info');
                        }
                    });
                });
                
                document.querySelectorAll('.employee-page').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = parseInt(this.getAttribute('data-page'));
                        if (page !== employeeCurrentPage) {
                            employeeCurrentPage = page;
                            updateEmployeeTable();
                            showNotification(`Loading employee page ${employeeCurrentPage}...`, 'info');
                        }
                    });
                });
            }
            
            // ===== MANAGER ATTENDANCE TAB PAGINATION =====
            let managerCurrentPage = 1;
            const managerTotalPages = 3;
            const managerEntriesPerPage = 3;
            
            const managerSampleData = [
                { id: 1, name: 'John Manager', department: 'IT Department', status: 'Present', statusClass: 'bg-success', clockIn: '09:00 AM', clockOut: '-', hours: '3.5 hrs' },
                { id: 2, name: 'Sarah Manager', department: 'Human Resources', status: 'Present', statusClass: 'bg-success', clockIn: '08:45 AM', clockOut: '-', hours: '3.8 hrs' },
                { id: 3, name: 'Mike Manager', department: 'Finance', status: 'Absent', statusClass: 'bg-danger', clockIn: '-', clockOut: '-', hours: '0 hrs' },
                { id: 4, name: 'Emma Manager', department: 'Operations', status: 'Present', statusClass: 'bg-success', clockIn: '09:10 AM', clockOut: '-', hours: '3.4 hrs' },
                { id: 5, name: 'Robert Manager', department: 'IT Department', status: 'Late', statusClass: 'bg-warning', clockIn: '10:15 AM', clockOut: '-', hours: '2.2 hrs' },
                { id: 6, name: 'Lisa Manager', department: 'Human Resources', status: 'Present', statusClass: 'bg-success', clockIn: '08:30 AM', clockOut: '-', hours: '4.0 hrs' },
                { id: 7, name: 'David Manager', department: 'Finance', status: 'Present', statusClass: 'bg-success', clockIn: '09:05 AM', clockOut: '-', hours: '3.6 hrs' },
                { id: 8, name: 'Jennifer Manager', department: 'Operations', status: 'Half Day', statusClass: 'bg-info', clockIn: '09:00 AM', clockOut: '01:00 PM', hours: '4.0 hrs' },
                { id: 9, name: 'Christopher Manager', department: 'IT Department', status: 'Present', statusClass: 'bg-success', clockIn: '09:05 AM', clockOut: '-', hours: '3.6 hrs' }
            ];
            
            function updateManagerTable() {
                const tableBody = document.querySelector('#managerAttendanceTable tbody');
                if (!tableBody) return;
                
                const startIndex = (managerCurrentPage - 1) * managerEntriesPerPage;
                const endIndex = startIndex + managerEntriesPerPage;
                const pageEntries = managerSampleData.slice(startIndex, endIndex);
                
                tableBody.innerHTML = '';
                
                pageEntries.forEach(entry => {
                    const row = `
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(entry.name)}&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                    <span>${entry.name}</span>
                                </div>
                            </td>
                            <td>${entry.department}</td>
                            <td><span class="badge ${entry.statusClass}">${entry.status}</span></td>
                            <td>${entry.clockIn}</td>
                            <td>${entry.clockOut}</td>
                            <td>${entry.hours}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary view-manager-record" data-id="${entry.id}">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning edit-manager-record" data-id="${entry.id}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });
                
                updateManagerPagination();
                attachManagerEventListeners();
            }
            
            function updateManagerPagination() {
                const paginationContainer = document.querySelector('#manager-attendance .pagination');
                if (!paginationContainer) return;
                
                let paginationHTML = '';
                
                // Previous button
                paginationHTML += `
                    <li class="page-item ${managerCurrentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link manager-prev" href="#" tabindex="-1" aria-disabled="${managerCurrentPage === 1}">
                            <i class="bi bi-chevron-left"></i> Previous
                        </a>
                    </li>
                `;
                
                // Page numbers
                for (let i = 1; i <= managerTotalPages; i++) {
                    paginationHTML += `
                        <li class="page-item ${i === managerCurrentPage ? 'active' : ''}">
                            <a class="page-link manager-page" href="#" data-page="${i}">${i}</a>
                        </li>
                    `;
                }
                
                // Next button
                paginationHTML += `
                    <li class="page-item ${managerCurrentPage === managerTotalPages ? 'disabled' : ''}">
                        <a class="page-link manager-next" href="#">
                            Next <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                `;
                
                paginationContainer.innerHTML = paginationHTML;
                attachManagerPaginationListeners();
            }
            
            function attachManagerEventListeners() {
                document.querySelectorAll('.view-manager-record').forEach(button => {
                    button.addEventListener('click', function() {
                        const recordId = this.getAttribute('data-id');
                        showNotification(`Viewing manager record #${recordId}`, 'info');
                    });
                });
                
                document.querySelectorAll('.edit-manager-record').forEach(button => {
                    button.addEventListener('click', function() {
                        const recordId = this.getAttribute('data-id');
                        showNotification(`Editing manager record #${recordId}`, 'info');
                    });
                });
            }
            
            function attachManagerPaginationListeners() {
                document.querySelectorAll('.manager-prev').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (managerCurrentPage > 1) {
                            managerCurrentPage--;
                            updateManagerTable();
                            showNotification(`Loading manager page ${managerCurrentPage}...`, 'info');
                        }
                    });
                });
                
                document.querySelectorAll('.manager-next').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (managerCurrentPage < managerTotalPages) {
                            managerCurrentPage++;
                            updateManagerTable();
                            showNotification(`Loading manager page ${managerCurrentPage}...`, 'info');
                        }
                    });
                });
                
                document.querySelectorAll('.manager-page').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = parseInt(this.getAttribute('data-page'));
                        if (page !== managerCurrentPage) {
                            managerCurrentPage = page;
                            updateManagerTable();
                            showNotification(`Loading manager page ${managerCurrentPage}...`, 'info');
                        }
                    });
                });
            }
            
            // ===== RECORDS TAB PAGINATION =====
            let recordsCurrentPage = 1;
            const recordsTotalPages = 4;
            const recordsEntriesPerPage = 5;
            
            const recordsSampleData = [
                { id: 1, name: 'John Smith', date: 'Jan 15, 2024', status: 'Present', statusClass: 'bg-success', clockIn: '09:00 AM', clockOut: '05:00 PM', hours: '8.0 hrs', enteredBy: 'System' },
                { id: 2, name: 'Sarah Lee', date: 'Jan 15, 2024', status: 'Present', statusClass: 'bg-success', clockIn: '08:45 AM', clockOut: '05:30 PM', hours: '8.75 hrs', enteredBy: 'System' },
                { id: 3, name: 'Mike Davis', date: 'Jan 15, 2024', status: 'Absent', statusClass: 'bg-danger', clockIn: '-', clockOut: '-', hours: '0 hrs', enteredBy: 'System' },
                { id: 4, name: 'Emma Wilson', date: 'Jan 14, 2024', status: 'Present', statusClass: 'bg-success', clockIn: '09:10 AM', clockOut: '05:15 PM', hours: '8.08 hrs', enteredBy: 'Manual Entry' },
                { id: 5, name: 'Robert Brown', date: 'Jan 14, 2024', status: 'Late', statusClass: 'bg-warning', clockIn: '10:15 AM', clockOut: '06:00 PM', hours: '7.75 hrs', enteredBy: 'System' },
                { id: 6, name: 'Lisa Garcia', date: 'Jan 14, 2024', status: 'Present', statusClass: 'bg-success', clockIn: '08:30 AM', clockOut: '05:45 PM', hours: '9.25 hrs', enteredBy: 'System' },
                { id: 7, name: 'David Miller', date: 'Jan 13, 2024', status: 'Present', statusClass: 'bg-success', clockIn: '09:05 AM', clockOut: '05:20 PM', hours: '8.25 hrs', enteredBy: 'System' },
                { id: 8, name: 'Jennifer Lee', date: 'Jan 13, 2024', status: 'Half Day', statusClass: 'bg-info', clockIn: '09:00 AM', clockOut: '01:00 PM', hours: '4.0 hrs', enteredBy: 'Manual Entry' },
                { id: 9, name: 'Christopher Anderson', date: 'Jan 13, 2024', status: 'Present', statusClass: 'bg-success', clockIn: '09:05 AM', clockOut: '05:35 PM', hours: '8.5 hrs', enteredBy: 'System' },
                { id: 10, name: 'Amanda Thomas', date: 'Jan 12, 2024', status: 'Present', statusClass: 'bg-success', clockIn: '08:50 AM', clockOut: '05:25 PM', hours: '8.58 hrs', enteredBy: 'System' },
                { id: 11, name: 'James Wilson', date: 'Jan 12, 2024', status: 'Late', statusClass: 'bg-warning', clockIn: '10:30 AM', clockOut: '06:30 PM', hours: '8.0 hrs', enteredBy: 'System' },
                { id: 12, name: 'Maria Rodriguez', date: 'Jan 12, 2024', status: 'Present', statusClass: 'bg-success', clockIn: '08:55 AM', clockOut: '05:40 PM', hours: '8.75 hrs', enteredBy: 'System' },
                { id: 13, name: 'Kevin Taylor', date: 'Jan 11, 2024', status: 'Present', statusClass: 'bg-success', clockIn: '09:15 AM', clockOut: '05:30 PM', hours: '8.25 hrs', enteredBy: 'System' },
                { id: 14, name: 'Nicole Martinez', date: 'Jan 11, 2024', status: 'Absent', statusClass: 'bg-danger', clockIn: '-', clockOut: '-', hours: '0 hrs', enteredBy: 'System' },
                { id: 15, name: 'Daniel Jackson', date: 'Jan 11, 2024', status: 'Present', statusClass: 'bg-success', clockIn: '09:20 AM', clockOut: '05:45 PM', hours: '8.42 hrs', enteredBy: 'Manual Entry' },
                { id: 16, name: 'Rachel White', date: 'Jan 10, 2024', status: 'Present', statusClass: 'bg-success', clockIn: '08:40 AM', clockOut: '05:15 PM', hours: '8.58 hrs', enteredBy: 'System' },
                { id: 17, name: 'Steven Harris', date: 'Jan 10, 2024', status: 'Present', statusClass: 'bg-success', clockIn: '09:00 AM', clockOut: '05:30 PM', hours: '8.5 hrs', enteredBy: 'System' },
                { id: 18, name: 'Michelle Clark', date: 'Jan 10, 2024', status: 'Late', statusClass: 'bg-warning', clockIn: '10:45 AM', clockOut: '06:45 PM', hours: '8.0 hrs', enteredBy: 'System' },
                { id: 19, name: 'Brian Lewis', date: 'Jan 09, 2024', status: 'Present', statusClass: 'bg-success', clockIn: '08:35 AM', clockOut: '05:50 PM', hours: '9.25 hrs', enteredBy: 'System' },
                { id: 20, name: 'Laura Walker', date: 'Jan 09, 2024', status: 'Present', statusClass: 'bg-success', clockIn: '09:10 AM', clockOut: '05:25 PM', hours: '8.25 hrs', enteredBy: 'Manual Entry' }
            ];
            
            function updateRecordsTable() {
                const tableBody = document.querySelector('#records table tbody');
                if (!tableBody) return;
                
                const startIndex = (recordsCurrentPage - 1) * recordsEntriesPerPage;
                const endIndex = startIndex + recordsEntriesPerPage;
                const pageEntries = recordsSampleData.slice(startIndex, endIndex);
                
                tableBody.innerHTML = '';
                
                pageEntries.forEach(entry => {
                    const row = `
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(entry.name)}&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                    <span>${entry.name}</span>
                                </div>
                            </td>
                            <td>${entry.date}</td>
                            <td><span class="badge ${entry.statusClass}">${entry.status}</span></td>
                            <td>${entry.clockIn}</td>
                            <td>${entry.clockOut}</td>
                            <td>${entry.hours}</td>
                            <td>${entry.enteredBy}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary view-records-record" data-id="${entry.id}">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning edit-records-record" data-id="${entry.id}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-records-record" data-id="${entry.id}" data-name="${entry.name}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });
                
                updateRecordsPagination();
                attachRecordsEventListeners();
            }
            
            function updateRecordsPagination() {
                const paginationContainer = document.querySelector('#records .pagination');
                if (!paginationContainer) return;
                
                let paginationHTML = '';
                
                // Previous button
                paginationHTML += `
                    <li class="page-item ${recordsCurrentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link records-prev" href="#" tabindex="-1" aria-disabled="${recordsCurrentPage === 1}">
                            <i class="bi bi-chevron-left"></i> Previous
                        </a>
                    </li>
                `;
                
                // Page numbers
                for (let i = 1; i <= recordsTotalPages; i++) {
                    paginationHTML += `
                        <li class="page-item ${i === recordsCurrentPage ? 'active' : ''}">
                            <a class="page-link records-page" href="#" data-page="${i}">${i}</a>
                        </li>
                    `;
                }
                
                // Next button
                paginationHTML += `
                    <li class="page-item ${recordsCurrentPage === recordsTotalPages ? 'disabled' : ''}">
                        <a class="page-link records-next" href="#">
                            Next <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                `;
                
                paginationContainer.innerHTML = paginationHTML;
                attachRecordsPaginationListeners();
            }
            
            function attachRecordsEventListeners() {
                document.querySelectorAll('.view-records-record').forEach(button => {
                    button.addEventListener('click', function() {
                        const recordId = this.getAttribute('data-id');
                        showNotification(`Viewing detailed record #${recordId}`, 'info');
                    });
                });
                
                document.querySelectorAll('.edit-records-record').forEach(button => {
                    button.addEventListener('click', function() {
                        const recordId = this.getAttribute('data-id');
                        showNotification(`Editing detailed record #${recordId}`, 'info');
                    });
                });
                
                document.querySelectorAll('.delete-records-record').forEach(button => {
                    button.addEventListener('click', function() {
                        const recordId = this.getAttribute('data-id');
                        const recordName = this.getAttribute('data-name');
                        if (confirm(`Are you sure you want to delete the attendance record for ${recordName}?`)) {
                            showNotification(`Record #${recordId} for ${recordName} deleted successfully!`, 'success');
                            // Remove the entry from recordsSampleData array
                            const index = recordsSampleData.findIndex(entry => entry.id == recordId);
                            if (index > -1) {
                                recordsSampleData.splice(index, 1);
                                // Adjust current page if necessary
                                const maxPage = Math.ceil(recordsSampleData.length / recordsEntriesPerPage);
                                if (recordsCurrentPage > maxPage && maxPage > 0) {
                                    recordsCurrentPage = maxPage;
                                }
                                updateRecordsTable();
                            }
                        }
                    });
                });
            }
            
            function attachRecordsPaginationListeners() {
                document.querySelectorAll('.records-prev').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (recordsCurrentPage > 1) {
                            recordsCurrentPage--;
                            updateRecordsTable();
                            showNotification(`Loading records page ${recordsCurrentPage}...`, 'info');
                        }
                    });
                });
                
                document.querySelectorAll('.records-next').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        if (recordsCurrentPage < recordsTotalPages) {
                            recordsCurrentPage++;
                            updateRecordsTable();
                            showNotification(`Loading records page ${recordsCurrentPage}...`, 'info');
                        }
                    });
                });
                
                document.querySelectorAll('.records-page').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = parseInt(this.getAttribute('data-page'));
                        if (page !== recordsCurrentPage) {
                            recordsCurrentPage = page;
                            updateRecordsTable();
                            showNotification(`Loading records page ${recordsCurrentPage}...`, 'info');
                        }
                    });
                });
            }
            
            // Initialize all tables when tabs are switched
            document.querySelectorAll('#attendanceTabs button').forEach(tabButton => {
                tabButton.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-bs-target');
                    
                    // Initialize the appropriate table based on the active tab
                    setTimeout(() => {
                        switch(targetTab) {
                            case '#overview':
                                updateOverviewTable();
                                break;
                            case '#admin-attendance':
                                updateAdminTable();
                                break;
                            case '#employee-attendance':
                                updateEmployeeTable();
                                break;
                            case '#manager-attendance':
                                updateManagerTable();
                                break;
                            case '#records':
                                updateRecordsTable();
                                break;
                        }
                    }, 100);
                });
            });
            
            // Initialize the default active tab (Overview)
            setTimeout(() => {
                updateOverviewTable();
            }, 500);
            
            // Status change effect on clock times
            const statusSelect = document.getElementById('attendanceStatus');
            const clockInInput = document.getElementById('clockInTime');
            const clockOutInput = document.getElementById('clockOutTime');
            
            if (statusSelect) {
                statusSelect.addEventListener('change', function() {
                    const status = this.value;
                    if (status === 'absent' || status === 'on_leave') {
                        clockInInput.value = '';
                        clockOutInput.value = '';
                        clockInInput.disabled = true;
                        clockOutInput.disabled = true;
                    } else {
                        clockInInput.disabled = false;
                        clockOutInput.disabled = false;
                        if (!clockInInput.value) {
                            clockInInput.value = '09:00';
                        }
                        if (!clockOutInput.value && status === 'present') {
                            clockOutInput.value = '17:00';
                        }
                    }
                });
            }
        });

        // Export and Print functionality
        document.getElementById('exportTableBtn').addEventListener('click', function() {
            exportTableToCSV('attendanceTable', 'attendance_records');
        });

        document.getElementById('printTableBtn').addEventListener('click', function() {
            printAttendanceTable('attendanceTable', 'Attendance Records');
        });

        // Add functionality for the buttons in lines 399-462
        // Apply Filters button
        document.getElementById('applyFiltersBtn').addEventListener('click', function() {
            const dateFilter = document.getElementById('dateFilter').value;
            const departmentFilter = document.getElementById('departmentFilter').value;
            const departmentText = document.getElementById('departmentFilter').options[document.getElementById('departmentFilter').selectedIndex].text;
            const statusFilter = document.getElementById('statusFilter').value;
            const statusText = document.getElementById('statusFilter').options[document.getElementById('statusFilter').selectedIndex].text;
            
            // In a real application, this would filter the table data
            let message = 'Filters applied:';
            if (dateFilter) message += ` Date=${dateFilter},`;
            if (departmentFilter) message += ` Department=${departmentText},`;
            if (statusFilter) message += ` Status=${statusText},`;
            
            // Remove trailing comma and add "All" for empty filters
            message = message.replace(/,$/, '');
            if (!dateFilter && !departmentFilter && !statusFilter) {
                message += ' No filters applied';
            }
            
            showNotification(message, 'info');
            
            // Here you would typically make an AJAX request to filter the data
            // Example:
            // fetch(`/attendance/filter?date=${dateFilter}&department=${departmentFilter}&status=${statusFilter}`)
            //     .then(response => response.json())
            //     .then(data => {
            //         updateAttendanceTable(data);
            //     });
        });

        // Export Report button
        document.getElementById('exportReportBtn').addEventListener('click', function() {
            // Export the current view with applied filters
            exportTableToCSV('attendanceTable', 'attendance_report');
        });

        // Print Report button
        document.getElementById('printReportBtn').addEventListener('click', function() {
            printAttendanceTable('attendanceTable', 'Attendance Report');
        });

        // Add functionality for the attendance records section (lines 465-794)
        // Select All checkbox functionality
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.row-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                
                // Enable/disable bulk action buttons based on selection
                updateBulkActionButtons();
            });
        }

        // Individual row checkbox functionality
        document.querySelectorAll('.row-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateBulkActionButtons();
                
                // If all checkboxes are selected, also select the "select all" checkbox
                const allCheckboxes = document.querySelectorAll('.row-checkbox');
                const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);
                if (selectAllCheckbox) {
                    selectAllCheckbox.checked = allChecked;
                }
            });
        });

        // View record functionality
        document.querySelectorAll('.view-record').forEach(button => {
            button.addEventListener('click', function() {
                const recordId = this.getAttribute('data-id');
                showNotification(`Viewing record #${recordId}`, 'info');
                // In a real application, this would open a modal with record details
                // Example: openRecordModal(recordId);
            });
        });

        // Edit record functionality
        document.querySelectorAll('.edit-record').forEach(button => {
            button.addEventListener('click', function() {
                const recordId = this.getAttribute('data-id');
                showNotification(`Editing record #${recordId}`, 'info');
                // In a real application, this would open an edit form or modal
                // Example: openEditModal(recordId);
            });
        });

        // Bulk Delete button functionality
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        if (bulkDeleteBtn) {
            bulkDeleteBtn.addEventListener('click', function() {
                const selectedIds = getSelectedRowIds();
                if (selectedIds.length === 0) {
                    showNotification('Please select at least one record to delete', 'warning');
                    return;
                }
                
                if (confirm(`Are you sure you want to delete ${selectedIds.length} record(s)?`)) {
                    // In a real application, this would make an AJAX request to delete records
                    showNotification(`${selectedIds.length} record(s) deleted successfully`, 'success');
                    // Example:
                    // fetch('/attendance/bulk-delete', {
                    //     method: 'POST',
                    //     headers: {
                    //         'Content-Type': 'application/json',
                    //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    //     },
                    //     body: JSON.stringify({ ids: selectedIds })
                    // })
                    // .then(response => response.json())
                    // .then(data => {
                    //     if (data.success) {
                    //         // Remove deleted rows from table
                    //         selectedIds.forEach(id => {
                    //             const row = document.querySelector(`.row-checkbox[data-id="${id}"]`).closest('tr');
                    //             if (row) row.remove();
                    //         });
                    //         showNotification(data.message, 'success');
                    //     } else {
                    //         showNotification('Error deleting records: ' + data.message, 'error');
                    //     }
                    // });
                    
                    // For demo purposes, just reset selection
                    resetSelection();
                }
            });
        }

        // Bulk Edit button functionality
        const bulkEditBtn = document.getElementById('bulkEditBtn');
        if (bulkEditBtn) {
            bulkEditBtn.addEventListener('click', function() {
                const selectedIds = getSelectedRowIds();
                if (selectedIds.length === 0) {
                    showNotification('Please select at least one record to edit', 'warning');
                    return;
                }
                
                showNotification(`Bulk editing ${selectedIds.length} record(s)`, 'info');
                // In a real application, this would open a bulk edit form
                // Example: openBulkEditModal(selectedIds);
            });
        }

        // Pagination functionality
        document.querySelectorAll('.page-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const pageText = this.textContent.trim();
                if (pageText !== 'Previous' && pageText !== 'Next') {
                    showNotification(`Loading page ${pageText}...`, 'info');
                } else {
                    showNotification(`Loading ${pageText.toLowerCase()} page...`, 'info');
                }
                // In a real application, this would load the specific page
                // Example: loadAttendancePage(pageText);
            });
        });

        // Helper function to get selected row IDs
        function getSelectedRowIds() {
            const selectedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
            return Array.from(selectedCheckboxes).map(checkbox => checkbox.getAttribute('data-id'));
        }

        // Helper function to update bulk action buttons state
        function updateBulkActionButtons() {
            const selectedCount = getSelectedRowIds().length;
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const bulkEditBtn = document.getElementById('bulkEditBtn');
            
            if (bulkDeleteBtn) {
                bulkDeleteBtn.disabled = selectedCount === 0;
            }
            
            if (bulkEditBtn) {
                bulkEditBtn.disabled = selectedCount === 0;
            }
        }

        // Helper function to reset selection
        function resetSelection() {
            // Uncheck all checkboxes
            document.querySelectorAll('.row-checkbox, #selectAllCheckbox').forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Update bulk action buttons
            updateBulkActionButtons();
        }

        // Admin attendance export/print
        const exportAdminBtn = document.getElementById('exportAdminTableBtn');
        const printAdminBtn = document.getElementById('printAdminTableBtn');
        
        if (exportAdminBtn) {
            exportAdminBtn.addEventListener('click', function() {
                exportTableToCSV('adminAttendanceTable', 'admin_attendance_records');
            });
        }
        
        if (printAdminBtn) {
            printAdminBtn.addEventListener('click', function() {
                printAttendanceTable('adminAttendanceTable', 'Admin Attendance Records');
            });
        }

        // Admin Filters functionality
        const applyAdminFiltersBtn = document.getElementById('applyAdminFiltersBtn');
        if (applyAdminFiltersBtn) {
            applyAdminFiltersBtn.addEventListener('click', function() {
                const dateFilter = document.getElementById('adminDateFilter').value;
                const departmentFilter = document.getElementById('adminDepartmentFilter').value;
                const departmentText = document.getElementById('adminDepartmentFilter').options[document.getElementById('adminDepartmentFilter').selectedIndex].text;
                const statusFilter = document.getElementById('adminStatusFilter').value;
                const statusText = document.getElementById('adminStatusFilter').options[document.getElementById('adminStatusFilter').selectedIndex].text;
                
                // Build filter message
                let message = 'Admin filters applied:';
                if (dateFilter) message += ` Date=${dateFilter},`;
                if (departmentFilter) message += ` Department=${departmentText},`;
                if (statusFilter) message += ` Status=${statusText},`;
                
                // Remove trailing comma
                message = message.replace(/,$/, '');
                if (!dateFilter && !departmentFilter && !statusFilter) {
                    message += ' No filters applied';
                }
                
                showNotification(message, 'info');
                
                // In a real application, this would make an AJAX request to filter admin attendance data
                // Example:
                // fetch(`/admin/attendance/filter?date=${dateFilter}&department=${departmentFilter}&status=${statusFilter}`)
                //     .then(response => response.json())
                //     .then(data => {
                //         updateAdminAttendanceTable(data);
                //     });
            });
        }

        // Admin record view functionality
        document.querySelectorAll('.view-admin-record').forEach(button => {
            button.addEventListener('click', function() {
                const recordId = this.getAttribute('data-id');
                showNotification(`Viewing admin record #${recordId}`, 'info');
                
                // In a real application, this would open a modal with detailed admin attendance information
                // Example modal content could include:
                // - Admin details (name, department, role)
                // - Full attendance history
                // - Performance metrics
                // - Recent activities
                
                // For now, show a placeholder modal or alert
                showAdminRecordModal(recordId);
            });
        });

        // Admin record edit functionality
        document.querySelectorAll('.edit-admin-record').forEach(button => {
            button.addEventListener('click', function() {
                const recordId = this.getAttribute('data-id');
                showNotification(`Editing admin record #${recordId}`, 'info');
                
                // In a real application, this would open an edit form for admin attendance
                // Example: openAdminEditModal(recordId);
                
                // For now, show a placeholder
                showAdminEditModal(recordId);
            });
        });

        // Function to show admin record details modal
        function showAdminRecordModal(recordId) {
            // Create a simple modal for demonstration
            const modalHtml = `
                <div class="modal fade" id="adminRecordModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Admin Record Details #${recordId}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Admin Information</h6>
                                        <p><strong>Name:</strong> John Admin</p>
                                        <p><strong>Department:</strong> IT Department</p>
                                        <p><strong>Role:</strong> System Administrator</p>
                                        <p><strong>Employee ID:</strong> ADM${recordId.toString().padStart(3, '0')}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Attendance Details</h6>
                                        <p><strong>Date:</strong> ${new Date().toLocaleDateString()}</p>
                                        <p><strong>Status:</strong> <span class="badge bg-success">Present</span></p>
                                        <p><strong>Clock In:</strong> 09:00 AM</p>
                                        <p><strong>Clock Out:</strong> 05:30 PM</p>
                                        <p><strong>Total Hours:</strong> 8.5 hrs</p>
                                    </div>
                                </div>
                                <hr>
                                <h6>Recent Activity</h6>
                                <ul class="list-unstyled">
                                    <li><i class="bi bi-clock text-success"></i> Clocked in at 09:00 AM</li>
                                    <li><i class="bi bi-pause text-warning"></i> Break: 12:00 PM - 01:00 PM</li>
                                    <li><i class="bi bi-clock text-info"></i> Currently active</li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Edit Record</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove existing modal if any
            const existingModal = document.getElementById('adminRecordModal');
            if (existingModal) {
                existingModal.remove();
            }
            
            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('adminRecordModal'));
            modal.show();
        }

        // Function to show admin edit modal
        function showAdminEditModal(recordId) {
            // Create a simple edit modal for demonstration
            const modalHtml = `
                <div class="modal fade" id="adminEditModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-dark">
                                <h5 class="modal-title">Edit Admin Record #${recordId}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="adminEditForm">
                                    <div class="mb-3">
                                        <label for="adminStatus" class="form-label">Status</label>
                                        <select class="form-select" id="adminStatus">
                                            <option value="present" selected>Present</option>
                                            <option value="absent">Absent</option>
                                            <option value="late">Late</option>
                                            <option value="on_leave">On Leave</option>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="adminClockIn" class="form-label">Clock In</label>
                                                <input type="time" class="form-control" id="adminClockIn" value="09:00">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="adminClockOut" class="form-label">Clock Out</label>
                                                <input type="time" class="form-control" id="adminClockOut" value="17:30">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="adminNotes" class="form-label">Notes</label>
                                        <textarea class="form-control" id="adminNotes" rows="3" placeholder="Add any notes..."></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-warning" onclick="saveAdminRecord(${recordId})">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove existing modal if any
            const existingModal = document.getElementById('adminEditModal');
            if (existingModal) {
                existingModal.remove();
            }
            
            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('adminEditModal'));
            modal.show();
        }

        // Function to save admin record changes
        function saveAdminRecord(recordId) {
            const status = document.getElementById('adminStatus').value;
            const clockIn = document.getElementById('adminClockIn').value;
            const clockOut = document.getElementById('adminClockOut').value;
            const notes = document.getElementById('adminNotes').value;
            
            // In a real application, this would make an AJAX request to save the changes
            // Example:
            // fetch(`/admin/attendance/${recordId}`, {
            //     method: 'PUT',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            //     },
            //     body: JSON.stringify({
            //         status: status,
            //         check_in: clockIn,
            //         check_out: clockOut,
            //         notes: notes
            //     })
            // })
            // .then(response => response.json())
            // .then(data => {
            //     if (data.success) {
            //         showNotification('Admin record updated successfully!', 'success');
            //         // Refresh the table or update the specific row
            //     } else {
            //         showNotification('Error updating record: ' + data.message, 'error');
            //     }
            // });
            
            // For demonstration, just show success message
            showNotification(`Admin record #${recordId} updated successfully!`, 'success');
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('adminEditModal'));
            modal.hide();
        }

        // Employee attendance export/print
        const exportEmployeeBtn = document.getElementById('exportEmployeeTableBtn');
        const printEmployeeBtn = document.getElementById('printEmployeeTableBtn');
        
        if (exportEmployeeBtn) {
            exportEmployeeBtn.addEventListener('click', function() {
                exportTableToCSV('employeeAttendanceTable', 'employee_attendance_records');
            });
        }
        
        if (printEmployeeBtn) {
            printEmployeeBtn.addEventListener('click', function() {
                printAttendanceTable('employeeAttendanceTable', 'Employee Attendance Records');
            });
        }

        // Manager attendance export/print
        const exportManagerBtn = document.getElementById('exportManagerTableBtn');
        const printManagerBtn = document.getElementById('printManagerTableBtn');
        
        if (exportManagerBtn) {
            exportManagerBtn.addEventListener('click', function() {
                exportTableToCSV('managerAttendanceTable', 'manager_attendance_records');
            });
        }
        
        if (printManagerBtn) {
            printManagerBtn.addEventListener('click', function() {
                printAttendanceTable('managerAttendanceTable', 'Manager Attendance Records');
            });
        }

        // Export table to CSV
        function exportTableToCSV(tableId = 'attendanceTable', filename = 'attendance_records') {
            const table = document.getElementById(tableId);
            if (!table) {
                showNotification('Table not found!', 'error');
                return;
            }
            const rows = table.querySelectorAll('tr');
            let csvContent = '';
            
            // Get current date for filename
            const currentDate = new Date().toISOString().split('T')[0];
            
            // Process each row
            rows.forEach((row, index) => {
                const cells = row.querySelectorAll('th, td');
                const rowData = [];
                
                cells.forEach((cell, cellIndex) => {
                    // Skip checkbox column (first column) and actions column (last column)
                    if (cellIndex === 0 || cellIndex === cells.length - 1) {
                        return;
                    }
                    
                    // Clean cell content
                    let cellText = cell.textContent.trim();
                    
                    // Handle special cases
                    if (cell.querySelector('img')) {
                        // For employee name cells with images, get just the text
                        const nameSpan = cell.querySelector('span');
                        cellText = nameSpan ? nameSpan.textContent.trim() : cellText;
                    }
                    
                    if (cell.querySelector('.badge')) {
                        // For status badges, get the badge text
                        const badge = cell.querySelector('.badge');
                        cellText = badge ? badge.textContent.trim() : cellText;
                    }
                    
                    // Escape quotes and wrap in quotes if contains comma
                    if (cellText.includes(',') || cellText.includes('"') || cellText.includes('\n')) {
                        cellText = '"' + cellText.replace(/"/g, '""') + '"';
                    }
                    
                    rowData.push(cellText);
                });
                
                if (rowData.length > 0) {
                    csvContent += rowData.join(',') + '\n';
                }
            });
            
            // Create and download CSV file
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            
            link.setAttribute('href', url);
            link.setAttribute('download', `${filename}_${currentDate}.csv`);
            link.style.visibility = 'hidden';
            
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            // Show success message
            showNotification(`${filename.replace(/_/g, ' ')} exported successfully!`, 'success');
        }

        // Print attendance table
        function printAttendanceTable(tableId = 'attendanceTable', tableTitle = 'Attendance Records') {
            const table = document.getElementById(tableId);
            if (!table) {
                showNotification('Table not found!', 'error');
                return;
            }
            
            const currentDateElement = document.getElementById('currentDateDisplay');
            const currentDate = currentDateElement ? currentDateElement.textContent : new Date().toLocaleDateString();
            
            // Create a new window for printing
            const printWindow = window.open('', '_blank');
            
            // Build the print content
            const printContent = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>${tableTitle} - ${currentDate}</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                            color: #333;
                        }
                        .header {
                            text-align: center;
                            margin-bottom: 30px;
                            border-bottom: 2px solid #007bff;
                            padding-bottom: 20px;
                        }
                        .header h1 {
                            color: #007bff;
                            margin: 0;
                            font-size: 24px;
                        }
                        .header p {
                            margin: 5px 0;
                            color: #666;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-top: 20px;
                        }
                        th, td {
                            border: 1px solid #ddd;
                            padding: 8px;
                            text-align: left;
                        }
                        th {
                            background-color: #007bff;
                            color: white;
                            font-weight: bold;
                        }
                        tr:nth-child(even) {
                            background-color: #f9f9f9;
                        }
                        .status-present {
                            color: #28a745;
                            font-weight: bold;
                        }
                        .status-absent {
                            color: #dc3545;
                            font-weight: bold;
                        }
                        .status-late {
                            color: #ffc107;
                            font-weight: bold;
                        }
                        .footer {
                            margin-top: 30px;
                            text-align: center;
                            font-size: 12px;
                            color: #666;
                        }
                        @media print {
                            body { margin: 0; }
                            .no-print { display: none; }
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>HR Management System</h1>
                        <p>${tableTitle} - ${currentDate}</p>
                        <p>Generated on: ${new Date().toLocaleString()}</p>
                    </div>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>Clock In</th>
                                <th>Clock Out</th>
                                <th>Hours Worked</th>
                            </tr>
                        </thead>
                        <tbody>
            `;
            
            // Process table rows
            const rows = table.querySelectorAll('tbody tr');
            let tableRows = '';
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length > 1) {
                    const employee = cells[1].querySelector('span') ? cells[1].querySelector('span').textContent.trim() : cells[1].textContent.trim();
                    const department = cells[2].textContent.trim();
                    const status = cells[3].querySelector('.badge') ? cells[3].querySelector('.badge').textContent.trim() : cells[3].textContent.trim();
                    const clockIn = cells[4].textContent.trim();
                    const clockOut = cells[5].textContent.trim();
                    const hoursWorked = cells[6].textContent.trim();
                    
                    const statusClass = status.toLowerCase().includes('present') ? 'status-present' : 
                                       status.toLowerCase().includes('absent') ? 'status-absent' : 
                                       status.toLowerCase().includes('late') ? 'status-late' : '';
                    
                    tableRows += `
                        <tr>
                            <td>${employee}</td>
                            <td>${department}</td>
                            <td class="${statusClass}">${status}</td>
                            <td>${clockIn}</td>
                            <td>${clockOut}</td>
                            <td>${hoursWorked}</td>
                        </tr>
                    `;
                }
            });
            
            printContent += tableRows + '</tbody></table></body></html>';
            
            // Write the content to the print window and print it
            printWindow.document.open();
            printWindow.document.write(printContent);
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
            
            // Show success message
            showNotification(`${tableTitle} printed successfully!`, 'success');
        }

        // Helper function to show notifications
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} alert-dismissible fade show`;
            notification.role = 'alert';
            notification.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            document.body.appendChild(notification);
            
            // Automatically close the notification after 5 seconds
            setTimeout(function() {
                notification.remove();
            }, 5000);
        }

            });
            
            const printFooter = `
                        </tbody>
                    </table>
                    
                    <div class="footer">
                        <p>This report was generated automatically by the HR Management System</p>
                        <p>© ${new Date().getFullYear()} iK soft - All rights reserved</p>
                    </div>
                </body>
                </html>
            `;
            
            // Write content to print window
            printWindow.document.write(printContent + tableRows + printFooter);
            printWindow.document.close();
            
            // Wait for content to load then print
            printWindow.onload = function() {
                printWindow.focus();
                printWindow.print();
                
                // Close print window after printing (optional)
                setTimeout(() => {
                    printWindow.close();
                }, 1000);
            };
            
            // Show success message
            showNotification('Print dialog opened successfully!', 'info');
        }

        // Utility function to show notifications
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            // Add to page
            document.body.appendChild(notification);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 3000);
        }
    </script>
</body>
</html>