<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Employee - Super Admin</title>
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
            margin-bottom: 20px;
            overflow: hidden;
        }
        .card:hover { 
           transform: translateY(-1px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }
        .form-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .section-title {
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        .avatar-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 2.5rem;
            margin: 0 auto 20px;
        }
        
        /* Tab styles */
        .nav-tabs .nav-link {
            font-weight: 500;
            color: #6c757d;
            border: none;
            border-bottom: 3px solid transparent;
        }
        
        .nav-tabs .nav-link.active {
            color: #3498db;
            background-color: transparent;
            border-bottom: 3px solid #3498db;
        }
        
        .nav-tabs .nav-link:hover {
            border-color: transparent;
            color: #3498db;
        }
        
        .tab-content {
            padding: 25px 0;
        }
        
        .table th {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .badge-status {
            font-size: 0.85em;
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
            .card-body {
                padding: 1rem;
            }
        }
        
        @media (max-width: 575.98px) {
            .main-content {
                padding: 10px;
            }
            .card {
                margin-bottom: 15px;
            }
            .form-section {
                padding: 15px;
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
            <li class="nav-item"><a class="nav-link" href="{{ route('superadmin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('superadmin.employees') }}"><i class="bi bi-people"></i> Employees</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('superadmin.designations') }}"><i class="bi bi-award"></i> Designations</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('superadmin.departments') }}"><i class="bi bi-building"></i> Departments</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('superadmin.user-roles') }}"><i class="bi bi-person-badge"></i> User Roles</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('superadmin.payroll') }}"><i class="bi bi-cash-stack"></i> Payroll Management</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('superadmin.attendance.index') }}"><i class="bi bi-calendar-check"></i> Attendance</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('superadmin.analytics') }}"><i class="bi bi-graph-up"></i> Analytics</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('superadmin.security') }}"><i class="bi bi-shield-check"></i> System Security</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('superadmin.settings') }}"><i class="bi bi-gear"></i> System Settings</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('superadmin.database') }}"><i class="bi bi-database"></i> Database</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 d-none d-lg-flex">
            <h2><i class="bi bi-person-badge text-primary"></i> Edit Employee</h2>
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
            <p class="text-muted mb-0">Edit Employee</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Please fix the following issues:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Employee Edit Form -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5><i class="bi bi-person-lines-fill"></i> {{ $employee->name }} - Employee Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <div class="avatar-circle">
                            {{ $employee->employeeProfile ? substr($employee->employeeProfile->first_name, 0, 1) : substr($employee->name, 0, 1) }}
                        </div>
                        <h4>{{ $employee->name }}</h4>
                        <p class="text-muted">Employee ID: #{{ $employee->id }}</p>
                        <p class="text-muted">
                            <span class="badge bg-{{ $employee->role === 'manager' ? 'primary' : 'secondary' }}">
                                {{ ucfirst($employee->role) }}
                            </span>
                        </p>
                    </div>
                    
                    <div class="col-md-9">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs" id="employeeTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">
                                    <i class="bi bi-person"></i> Profile
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab" aria-controls="attendance" aria-selected="false">
                                    <i class="bi bi-calendar-check"></i> Attendance
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="leaves-tab" data-bs-toggle="tab" data-bs-target="#leaves" type="button" role="tab" aria-controls="leaves" aria-selected="false">
                                    <i class="bi bi-calendar-x"></i> Leaves
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reports-tab" data-bs-toggle="tab" data-bs-target="#reports" type="button" role="tab" aria-controls="reports" aria-selected="false">
                                    <i class="bi bi-bar-chart"></i> Reports
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab" aria-controls="files" aria-selected="false">
                                    <i class="bi bi-folder"></i> Employee File
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="performance-tab" data-bs-toggle="tab" data-bs-target="#performance" type="button" role="tab" aria-controls="performance" aria-selected="false">
                                    <i class="bi bi-graph-up"></i> Performance
                                </button>
                            </li>
                        </ul>
                        
                        <!-- Tab Content -->
                        <div class="tab-content" id="employeeTabContent">
                            <!-- Profile Tab -->
                            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <form action="{{ route('superadmin.employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <!-- Personal Information Section -->
                                    <div class="form-section">
                                        <h5 class="section-title">Personal Information</h5>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="first_name" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" 
                                                       value="{{ old('first_name', $employee->employeeProfile->first_name ?? '') }}" required>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="last_name" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" 
                                                       value="{{ old('last_name', $employee->employeeProfile->last_name ?? '') }}" required>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="email" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" id="email" name="email" 
                                                       value="{{ old('email', $employee->email) }}" required>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="phone" class="form-label">Phone Number</label>
                                                <input type="text" class="form-control" id="phone" name="phone" 
                                                       value="{{ old('phone', $employee->employeeProfile->phone ?? '') }}">
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" 
                                                       value="{{ old('date_of_birth', $employee->employeeProfile->date_of_birth ?? '') }}">
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="gender" class="form-label">Gender</label>
                                                <select class="form-select" id="gender" name="gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="male" {{ old('gender', $employee->employeeProfile->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                                    <option value="female" {{ old('gender', $employee->employeeProfile->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                                    <option value="other" {{ old('gender', $employee->employeeProfile->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="marital_status" class="form-label">Marital Status</label>
                                                <select class="form-select" id="marital_status" name="marital_status">
                                                    <option value="">Select Status</option>
                                                    <option value="single" {{ old('marital_status', $employee->employeeProfile->marital_status ?? '') == 'single' ? 'selected' : '' }}>Single</option>
                                                    <option value="married" {{ old('marital_status', $employee->employeeProfile->marital_status ?? '') == 'married' ? 'selected' : '' }}>Married</option>
                                                    <option value="divorced" {{ old('marital_status', $employee->employeeProfile->marital_status ?? '') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                                    <option value="widowed" {{ old('marital_status', $employee->employeeProfile->marital_status ?? '') == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="nationality" class="form-label">Nationality</label>
                                                <input type="text" class="form-control" id="nationality" name="nationality" 
                                                       value="{{ old('nationality', $employee->employeeProfile->nationality ?? '') }}">
                                            </div>
                                            
                                            <div class="col-12 mb-3">
                                                <label for="address" class="form-label">Address</label>
                                                <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $employee->employeeProfile->address ?? '') }}</textarea>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="emergency_contact" class="form-label">Emergency Contact</label>
                                                <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" 
                                                       value="{{ old('emergency_contact', $employee->employeeProfile->emergency_contact ?? '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Employment Information Section -->
                                    <div class="form-section">
                                        <h5 class="section-title">Employment Information</h5>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="role" class="form-label">Role</label>
                                                <select class="form-select" id="role" name="role" required>
                                                    <option value="employee" {{ old('role', $employee->role) == 'employee' ? 'selected' : '' }}>Employee</option>
                                                    <option value="manager" {{ old('role', $employee->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="department_id" class="form-label">Department</label>
                                                <select class="form-select" id="department_id" name="department_id">
                                                    <option value="">Select Department</option>
                                                    @foreach($departments as $department)
                                                        <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="designation_id" class="form-label">Designation</label>
                                                <select class="form-select" id="designation_id" name="designation_id">
                                                    <option value="">Select Designation</option>
                                                    @foreach($designations as $designation)
                                                        <option value="{{ $designation->id }}" {{ old('designation_id', $employee->designation_id) == $designation->id ? 'selected' : '' }}>
                                                            {{ $designation->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="joining_date" class="form-label">Joining Date</label>
                                                <input type="date" class="form-control" id="joining_date" name="joining_date" 
                                                       value="{{ old('joining_date', $employee->employeeProfile->joining_date ?? '') }}">
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="employment_type" class="form-label">Employment Type</label>
                                                <select class="form-select" id="employment_type" name="employment_type">
                                                    <option value="">Select Type</option>
                                                    <option value="full_time" {{ old('employment_type', $employee->employeeProfile->employment_type ?? '') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                                                    <option value="part_time" {{ old('employment_type', $employee->employeeProfile->employment_type ?? '') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                                                    <option value="contract" {{ old('employment_type', $employee->employeeProfile->employment_type ?? '') == 'contract' ? 'selected' : '' }}>Contract</option>
                                                    <option value="intern" {{ old('employment_type', $employee->employeeProfile->employment_type ?? '') == 'intern' ? 'selected' : '' }}>Intern</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="salary" class="form-label">Salary (BDT)</label>
                                                <input type="number" class="form-control" id="salary" name="salary" step="0.01" 
                                                       value="{{ old('salary', $employee->employeeProfile->salary ?? '') }}">
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-select" id="status" name="status">
                                                    <option value="active" {{ old('status', $employee->employeeProfile->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive" {{ old('status', $employee->employeeProfile->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                    <option value="terminated" {{ old('status', $employee->employeeProfile->status ?? '') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="bank_account" class="form-label">Bank Account</label>
                                                <input type="text" class="form-control" id="bank_account" name="bank_account" 
                                                       value="{{ old('bank_account', $employee->employeeProfile->bank_account ?? '') }}">
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="tax_id" class="form-label">Tax ID</label>
                                                <input type="text" class="form-control" id="tax_id" name="tax_id" 
                                                       value="{{ old('tax_id', $employee->employeeProfile->tax_id ?? '') }}">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Password Section -->
                                    <div class="form-section">
                                        <h5 class="section-title">Password Update</h5>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                                                <input type="password" class="form-control" id="password" name="password" minlength="8">
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" minlength="8">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Form Actions -->
                                    <div class="d-flex justify-content-between mt-4">
                                        <a href="{{ route('superadmin.employees') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Back to Employees
                                        </a>
                                        <div>
                                            <button type="reset" class="btn btn-outline-secondary me-2">
                                                <i class="bi bi-arrow-counterclockwise"></i> Reset
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-save"></i> Update Employee
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Attendance Tab -->
                            <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
                                <div class="form-section">
                                    <h5 class="section-title">Attendance Records</h5>
                                    
                                    @if($employee->employeeAttendances->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Check In</th>
                                                        <th>Check Out</th>
                                                        <th>Total Hours</th>
                                                        <th>Status</th>
                                                        <th>Notes</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($employee->employeeAttendances->sortByDesc('date')->take(10) as $attendance)
                                                        <tr>
                                                            <td>{{ $attendance->date->format('M d, Y') }}</td>
                                                            <td>{{ $attendance->check_in ? $attendance->check_in->format('H:i') : '-' }}</td>
                                                            <td>{{ $attendance->check_out ? $attendance->check_out->format('H:i') : '-' }}</td>
                                                            <td>{{ $attendance->total_hours ? number_format($attendance->total_hours / 60, 2) : '-' }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $attendance->status === 'present' ? 'success' : ($attendance->status === 'absent' ? 'danger' : 'warning') }}">
                                                                    {{ ucfirst($attendance->status) }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $attendance->notes ?? '-' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="bi bi-calendar-x fs-1 text-muted"></i>
                                            <p class="mt-3">No attendance records found for this employee.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Leaves Tab -->
                            <div class="tab-pane fade" id="leaves" role="tabpanel" aria-labelledby="leaves-tab">
                                <div class="form-section">
                                    <h5 class="section-title">Leave Records</h5>
                                    
                                    @if($employee->employeeLeaves->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Leave Type</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Total Days</th>
                                                        <th>Status</th>
                                                        <th>Reason</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($employee->employeeLeaves->sortByDesc('created_at')->take(10) as $leave)
                                                        <tr>
                                                            <td>{{ ucfirst($leave->leave_type) }}</td>
                                                            <td>{{ $leave->start_date->format('M d, Y') }}</td>
                                                            <td>{{ $leave->end_date->format('M d, Y') }}</td>
                                                            <td>{{ $leave->total_days }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $leave->status === 'approved' ? 'success' : ($leave->status === 'rejected' ? 'danger' : 'warning') }}">
                                                                    {{ ucfirst($leave->status) }}
                                                                </span>
                                                            </td>
                                                            <td>{{ Str::limit($leave->reason, 30) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="bi bi-calendar-x fs-1 text-muted"></i>
                                            <p class="mt-3">No leave records found for this employee.</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="form-section">
                                    <h5 class="section-title">Leave Balance</h5>
                                    
                                    @if($employee->leaveBalances->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Leave Type</th>
                                                        <th>Allocated</th>
                                                        <th>Used</th>
                                                        <th>Remaining</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($employee->leaveBalances as $balance)
                                                        <tr>
                                                            <td>Annual Leave</td>
                                                            <td>{{ $balance->annual_leaves }}</td>
                                                            <td>{{ $balance->used_annual_leaves }}</td>
                                                            <td>{{ $balance->annual_leaves - $balance->used_annual_leaves }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sick Leave</td>
                                                            <td>{{ $balance->sick_leaves }}</td>
                                                            <td>{{ $balance->used_sick_leaves }}</td>
                                                            <td>{{ $balance->sick_leaves - $balance->used_sick_leaves }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Maternity Leave</td>
                                                            <td>{{ $balance->maternity_leaves }}</td>
                                                            <td>{{ $balance->used_maternity_leaves }}</td>
                                                            <td>{{ $balance->maternity_leaves - $balance->used_maternity_leaves }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Paternity Leave</td>
                                                            <td>{{ $balance->paternity_leaves }}</td>
                                                            <td>{{ $balance->used_paternity_leaves }}</td>
                                                            <td>{{ $balance->paternity_leaves - $balance->used_paternity_leaves }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Emergency Leave</td>
                                                            <td>{{ $balance->emergency_leaves }}</td>
                                                            <td>{{ $balance->used_emergency_leaves }}</td>
                                                            <td>{{ $balance->emergency_leaves - $balance->used_emergency_leaves }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="bi bi-calendar-x fs-1 text-muted"></i>
                                            <p class="mt-3">No leave balance records found for this employee.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Reports Tab -->
                            <div class="tab-pane fade" id="reports" role="tabpanel" aria-labelledby="reports-tab">
                                <div class="form-section">
                                    <h5 class="section-title">Payroll Reports</h5>
                                    
                                    @if($employee->payrolls->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Month</th>
                                                        <th>Base Salary</th>
                                                        <th>Bonuses</th>
                                                        <th>Deductions</th>
                                                        <th>Net Salary</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($employee->payrolls->sortByDesc('created_at')->take(10) as $payroll)
                                                        <tr>
                                                            <td>{{ $payroll->month }}</td>
                                                            <td>BDT {{ number_format($payroll->base_salary, 2) }}</td>
                                                            <td>BDT {{ number_format($payroll->bonuses, 2) }}</td>
                                                            <td>BDT {{ number_format($payroll->deductions, 2) }}</td>
                                                            <td>BDT {{ number_format($payroll->net_salary, 2) }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $payroll->status === 'processed' ? 'success' : 'warning' }}">
                                                                    {{ ucfirst($payroll->status) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="bi bi-cash-stack fs-1 text-muted"></i>
                                            <p class="mt-3">No payroll records found for this employee.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Employee File Tab -->
                            <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">
                                <div class="form-section">
                                    <h5 class="section-title">Employee Documents</h5>
                                    
                                    @if($employee->employeeProfile && $employee->employeeProfile->documents)
                                        <div class="row">
                                            @foreach(json_decode($employee->employeeProfile->documents, true) as $document)
                                                <div class="col-md-6 col-lg-4 mb-3">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h6 class="card-title">
                                                                <i class="bi bi-file-earmark-text"></i> 
                                                                {{ pathinfo($document, PATHINFO_FILENAME) }}
                                                            </h6>
                                                            <p class="card-text text-muted small">
                                                                {{ pathinfo($document, PATHINFO_EXTENSION) }} file
                                                            </p>
                                                            <a href="{{ asset('storage/' . $document) }}" class="btn btn-sm btn-primary" target="_blank">
                                                                <i class="bi bi-download"></i> Download
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="bi bi-folder fs-1 text-muted"></i>
                                            <p class="mt-3">No documents found for this employee.</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="form-section">
                                    <h5 class="section-title">Upload New Document</h5>
                                    <form action="{{ route('superadmin.employees.documents.upload', $employee) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="document" class="form-label">Select Document</label>
                                            <input type="file" class="form-control" id="document" name="document">
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-upload"></i> Upload Document
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Performance Tab -->
                            <div class="tab-pane fade" id="performance" role="tabpanel" aria-labelledby="performance-tab">
                                <div class="form-section">
                                    <h5 class="section-title">Performance Reviews</h5>
                                    
                                    @if($employee->performanceReviews->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Period</th>
                                                        <th>Reviewer</th>
                                                        <th>Score</th>
                                                        <th>Rating</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($employee->performanceReviews->sortByDesc('created_at')->take(10) as $review)
                                                        <tr>
                                                            <td>{{ $review->review_period_start->format('M Y') }} - {{ $review->review_period_end->format('M Y') }}</td>
                                                            <td>{{ $review->reviewer->name }}</td>
                                                            <td>{{ $review->score ?? 'N/A' }}%</td>
                                                            <td>
                                                                <span class="badge {{ $review->rating_badge_class }}">
                                                                    {{ ucfirst(str_replace('_', ' ', $review->rating)) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-{{ $review->status === 'completed' ? 'success' : 'warning' }}">
                                                                    {{ ucfirst($review->status) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="bi bi-graph-up fs-1 text-muted"></i>
                                            <p class="mt-3">No performance reviews found for this employee.</p>
                                        </div>
                                    @endif
                                </div>
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
            
            // Auto-hide alerts
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
        });
    </script>
</body>
</html>