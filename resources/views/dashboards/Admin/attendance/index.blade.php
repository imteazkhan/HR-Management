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
                                                <tr>
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
                                                </tr>
                                               
                                                <tr>
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
                                                </tr>
                                                <tr>
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
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Bulk Actions -->
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <button class="btn btn-sm btn-outline-danger" id="bulkDeleteBtn" disabled>
                                            <i class="bi bi-trash"></i> Delete Selected
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary ms-2" id="bulkEditBtn" disabled>
                                            <i class="bi bi-pencil"></i> Edit Selected
                                        </button>
                                    </div>
                                    
                                    <!-- Pagination -->
                                    @if(isset($attendanceRecords))
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $attendanceRecords->links() }}
                                        </div>
                                    @else
                                        <nav aria-label="Attendance records pagination">
                                            <ul class="pagination mb-0">
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
                                    @endif
                                </div>
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
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                    <button class="btn btn-sm btn-outline-warning">Edit</button>
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
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                    <button class="btn btn-sm btn-outline-warning">Edit</button>
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
                                                    <button class="btn btn-sm btn-outline-primary">View</button>
                                                    <button class="btn btn-sm btn-outline-warning">Edit</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
                                                <tr>
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
                                                </tr>
                                                <tr>
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
                                                </tr>
                                                <tr>
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
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Pagination -->
                                @if(isset($attendanceRecords))
                                    <div class="d-flex justify-content-center mt-4">
                                        {{ $attendanceRecords->links() }}
                                    </div>
                                @else
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
                                @endif
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
            
            // View entry functionality
            document.querySelectorAll('.view-entry').forEach(button => {
                button.addEventListener('click', function() {
                    const entryId = this.getAttribute('data-id');
                    alert('Viewing entry #' + entryId);
                    // In a real app, this would open a modal with entry details
                });
            });
            
            // Edit entry functionality
            document.querySelectorAll('.edit-entry').forEach(button => {
                button.addEventListener('click', function() {
                    const entryId = this.getAttribute('data-id');
                    alert('Editing entry #' + entryId);
                    // In a real app, this would populate the form with entry data
                });
            });
            
            // Delete entry functionality
            document.querySelectorAll('.delete-entry').forEach(button => {
                button.addEventListener('click', function() {
                    const entryId = this.getAttribute('data-id');
                    if (confirm('Are you sure you want to delete this attendance entry?')) {
                        // In a real app, this would make an AJAX call to delete the entry
                        fetch('{{ route("hrm.attendance.delete-entry", ["id" => ":id"]) }}'.replace(':id', entryId), {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Entry #' + entryId + ' deleted successfully!');
                                // Refresh recent entries
                                refreshRecentEntries();
                            } else {
                                alert('Error deleting entry: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error deleting entry. Please try again.');
                        });
                    }
                });
            });
            
            // Pagination functionality
            const prevPageBtn = document.getElementById('prevPageBtn');
            const nextPageBtn = document.getElementById('nextPageBtn');
            
            if (prevPageBtn) {
                prevPageBtn.addEventListener('click', function() {
                    alert('Loading previous page...');
                    // In a real app, this would load the previous page of entries
                });
            }
            
            if (nextPageBtn) {
                nextPageBtn.addEventListener('click', function() {
                    alert('Loading next page...');
                    // In a real app, this would load the next page of entries
                });
            }
            
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