<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Super Admin Attendance - HR Management</title>
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
            <li class="nav-item">
                <a class="nav-link" href="{{ route('superadmin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            
            <!-- Employee Management Dropdown -->
            <!-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-people"></i>
                    Employee Management
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('superadmin.employees') }}">All Employees</a></li>
                    <li><a class="dropdown-item" href="{{ route('superadmin.departments') }}">Departments</a></li>
                </ul>
            </li> -->
            
            <!-- Attendance Management -->
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('superadmin.attendance.index') }}">
                    <i class="bi bi-calendar-check"></i>
                    Attendance
                </a>
            </li>
            
            <!-- Leave Count -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('superadmin.attendance.leave-count') }}">
                    <i class="bi bi-calendar-x"></i>
                    Leave Count
                </a>
            </li>
            
            <!-- Payroll -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('superadmin.payroll') }}">
                    <i class="bi bi-cash"></i>
                    Payroll
                </a>
            </li>
            
            <!-- Other Admin Functions -->
            <!-- <li class="nav-item dropdown">
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
            </li> -->
            
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
                <button class="nav-link active" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab" aria-controls="attendance" aria-selected="true">
                    <i class="bi bi-calendar-check"></i> Attendance
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="leave-count-tab" data-bs-toggle="tab" data-bs-target="#leave-count" type="button" role="tab" aria-controls="leave-count" aria-selected="false">
                    <i class="bi bi-calendar-x"></i> Leave Count
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="payroll-tab" data-bs-toggle="tab" data-bs-target="#payroll" type="button" role="tab" aria-controls="payroll" aria-selected="false">
                    <i class="bi bi-cash"></i> Payroll
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mb-4" id="attendanceTabContent">
            <!-- Attendance Tab -->
            <div class="tab-pane fade show active" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
                <!-- Attendance Stats -->
                <div class="row g-3 g-md-4 mb-4">
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Total Employees</h6>
                                    <h2>186</h2>
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
                                    <h2>168</h2>
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
                                    <h2>18</h2>
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
                                    <h2>90.3%</h2>
                                </div>
                                <i class="bi bi-graph-up fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Manual Attendance Entry -->
                <div class="row g-3 g-md-4 mb-4">
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

                                <form method="POST" action="{{ route('superadmin.attendance.manual-entry') }}">
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
                                        <button type="submit" class="btn btn-primary">
                                            <span class="spinner-border spinner-border-sm d-none" role="status" id="attendanceSpinner"></span>
                                            <span>Save Attendance</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Records -->
                <div class="row g-3 g-md-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5><i class="bi bi-table"></i> Attendance Records</h5>
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
            
            <!-- Leave Count Tab -->
            <div class="tab-pane fade" id="leave-count" role="tabpanel" aria-labelledby="leave-count-tab">
                <!-- Leave Count Stats -->
                <div class="row g-3 g-md-4 mb-4">
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Total Employees</h6>
                                    <h2>{{ $leaveData->count() }}</h2>
                                </div>
                                <i class="bi bi-people fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card-2 p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Annual Leaves</h6>
                                    <h2>{{ $leaveData->sum('annual_leaves') }}</h2>
                                </div>
                                <i class="bi bi-calendar-check fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card-3 p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Sick Leaves</h6>
                                    <h2>{{ $leaveData->sum('sick_leaves') }}</h2>
                                </div>
                                <i class="bi bi-heart fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card-4 p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Used Leaves</h6>
                                    <h2>{{ $leaveData->sum('used_annual_leaves') + $leaveData->sum('used_sick_leaves') }}</h2>
                                </div>
                                <i class="bi bi-graph-up fs-1 opacity-50 d-none d-md-block"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Leave Count Records -->
                <div class="row g-3 g-md-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5><i class="bi bi-table"></i> Employee Leave Balances</h5>
                                    <div>
                                        <button class="btn btn-sm btn-light me-2">
                                            <i class="bi bi-download"></i> Export
                                        </button>
                                        <a href="{{ route('superadmin.attendance.leave-count') }}" class="btn btn-sm btn-light">
                                            <i class="bi bi-eye"></i> View All
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Annual</th>
                                                <th>Used Annual</th>
                                                <th>Remaining Annual</th>
                                                <th>Sick</th>
                                                <th>Used Sick</th>
                                                <th>Remaining Sick</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($leaveData as $employee)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($employee['name']) }}&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                            <span>{{ $employee['name'] }}</span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $employee['annual_leaves'] }}</td>
                                                    <td>{{ $employee['used_annual_leaves'] }}</td>
                                                    <td>{{ $employee['remaining_annual_leaves'] }}</td>
                                                    <td>{{ $employee['sick_leaves'] }}</td>
                                                    <td>{{ $employee['used_sick_leaves'] }}</td>
                                                    <td>{{ $employee['remaining_sick_leaves'] }}</td>
                                                    <td>
                                                        <a href="{{ route('superadmin.attendance.leave-count') }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Manual Attendance Entry -->
        <div class="row g-3 g-md-4 mb-4">
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

                        <form method="POST" action="{{ route('superadmin.attendance.manual-entry') }}">
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
                                <button type="submit" class="btn btn-primary">
                                    <span class="spinner-border spinner-border-sm d-none" role="status" id="attendanceSpinner"></span>
                                    <span>Save Attendance</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Records -->
        <div class="row g-3 g-md-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><i class="bi bi-table"></i> Attendance Records</h5>
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
            
            <!-- Payroll Tab -->
            <div class="tab-pane fade" id="payroll" role="tabpanel" aria-labelledby="payroll-tab">
                <div class="row g-3 g-md-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5><i class="bi bi-cash"></i> Payroll Management</h5>
                            </div>
                            <div class="card-body">
                                <p>Payroll management functionality will be implemented here.</p>
                                <a href="{{ route('superadmin.payroll') }}" class="btn btn-primary">View Payroll Details</a>
                            </div>
                        </div>
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
            
            // Enhanced delete functionality with confirmation
            document.querySelectorAll('.delete-record').forEach(button => {
                button.addEventListener('click', function() {
                    const recordId = this.getAttribute('data-id');
                    const employeeName = this.getAttribute('data-name');
                    
                    if (confirm(`Are you sure you want to delete the attendance record for ${employeeName}?`)) {
                        // Submit delete form
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/superadmin/attendance/delete-entry/${recordId}`;
                        
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        
                        const methodField = document.createElement('input');
                        methodField.type = 'hidden';
                        methodField.name = '_method';
                        methodField.value = 'DELETE';
                        
                        form.appendChild(csrfToken);
                        form.appendChild(methodField);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
            
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
    </script>
</body>
</html>