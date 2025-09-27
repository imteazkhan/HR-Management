<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payroll Management - HR Management</title>
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
            transition: all 0.3s ease;
            border-radius: 8px;
        }
        .btn:hover {
            /* transform: translateY(-2px); */
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .btn:active {
            transform: translateY(0);
        }
        .table-row-hover:hover {
            background-color: #f8f9fa;
            /* transform: scale(1.01); */
            transition: all 0.2s ease;
        }
        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .avatar-circle.bg-success { background: linear-gradient(135deg, #43e97b, #38f9d7); }
        .avatar-circle.bg-primary { background: linear-gradient(135deg, #4facfe, #00f2fe); }
        .avatar-circle.bg-warning { background: linear-gradient(135deg, #f093fb, #f5576c); }
        .avatar-circle.bg-info { background: linear-gradient(135deg, #667eea, #764ba2); }
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
            <h2><i class="bi bi-cash-stack text-primary"></i> Payroll Management</h2>
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

        <!-- Payroll Summary Cards -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card stat-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Payroll</h6>
                            <h2>${{ number_format(array_sum(array_column($payrollData, 'net_salary')), 0) }}</h2>
                        </div>
                        <i class="bi bi-cash-stack fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-2 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Employees</h6>
                            <h2>{{ count($payrollData) }}</h2>
                        </div>
                        <i class="bi bi-people-fill fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-3 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Bonuses</h6>
                            <h2>${{ number_format(array_sum(array_column($payrollData, 'bonuses')), 0) }}</h2>
                        </div>
                        <i class="bi bi-star-fill fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-4 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Deductions</h6>
                            <h2>${{ number_format(array_sum(array_column($payrollData, 'deductions')), 0) }}</h2>
                        </div>
                        <i class="bi bi-calculator fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payroll Table -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0"><i class="bi bi-cash-stack"></i> Employee Payroll - {{ date('F Y') }}</h5>
                    </div>
                    <div class="col-auto">
                        <select class="form-select form-select-sm" id="monthFilter">
                            <option value="{{ date('F Y') }}">{{ date('F Y') }}</option>
                            <option value="{{ date('F Y', strtotime('-1 month')) }}">{{ date('F Y', strtotime('-1 month')) }}</option>
                            <option value="{{ date('F Y', strtotime('-2 months')) }}">{{ date('F Y', strtotime('-2 months')) }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Employee</th>
                                <th>Position</th>
                                <th>Base Salary</th>
                                <th>Bonuses</th>
                                <th>Deductions</th>
                                <th>Net Salary</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payrollData as $index => $payroll)
                            <tr class="table-row-hover fade-in-up">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3 bg-success">
                                            {{ substr($payroll['employee'], 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $payroll['employee'] }}</h6>
                                            <small class="text-muted">EMP{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $payroll['position'] }}</td>
                                <td>${{ number_format($payroll['base_salary'], 0) }}</td>
                                <td>
                                    <span class="badge bg-success">${{ number_format($payroll['bonuses'], 0) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-warning">${{ number_format($payroll['deductions'], 0) }}</span>
                                </td>
                                <td>
                                    <strong>${{ number_format($payroll['net_salary'], 0) }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-success">Processed</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewPayrollModal{{ $index }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-success" onclick="downloadPayroll({{ $index }})">
                                            <i class="bi bi-download"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editPayrollModal{{ $index }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- View Payroll Modal -->
                            <div class="modal fade" id="viewPayrollModal{{ $index }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Payroll Details - {{ $payroll['employee'] }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Employee:</strong> {{ $payroll['employee'] }}</p>
                                            <p><strong>Position:</strong> {{ $payroll['position'] }}</p>
                                            <p><strong>Base Salary:</strong> ${{ number_format($payroll['base_salary'], 0) }}</p>
                                            <p><strong>Bonuses:</strong> ${{ number_format($payroll['bonuses'], 0) }}</p>
                                            <p><strong>Deductions:</strong> ${{ number_format($payroll['deductions'], 0) }}</p>
                                            <p><strong>Net Salary:</strong> ${{ number_format($payroll['net_salary'], 0) }}</p>
                                            <p><strong>Status:</strong> Processed</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Payroll Modal -->
                            <div class="modal fade" id="editPayrollModal{{ $index }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Edit Payroll - {{ $payroll['employee'] }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('superadmin.payroll.update', $index) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="baseSalary{{ $index }}" class="form-label">Base Salary</label>
                                                    <input type="number" class="form-control" id="baseSalary{{ $index }}" name="base_salary" value="{{ $payroll['base_salary'] }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="bonuses{{ $index }}" class="form-label">Bonuses</label>
                                                    <input type="number" class="form-control" id="bonuses{{ $index }}" name="bonuses" value="{{ $payroll['bonuses'] }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="deductions{{ $index }}" class="form-label">Deductions</label>
                                                    <input type="number" class="form-control" id="deductions{{ $index }}" name="deductions" value="{{ $payroll['deductions'] }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update Payroll</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="2">TOTAL</th>
                                <th>${{ number_format(array_sum(array_column($payrollData, 'base_salary')), 0) }}</th>
                                <th>${{ number_format(array_sum(array_column($payrollData, 'bonuses')), 0) }}</th>
                                <th>${{ number_format(array_sum(array_column($payrollData, 'deductions')), 0) }}</th>
                                <th>${{ number_format(array_sum(array_column($payrollData, 'net_salary')), 0) }}</th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Payroll Analytics -->
        <div class="row g-3 g-md-4 mt-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Payroll Breakdown</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="payrollChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Monthly Trends</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="trendChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Process Payroll Modal -->
        <div class="modal fade" id="processPayrollModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Process Payroll</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('superadmin.payroll.process') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <p>Process payroll for <strong>{{ date('F Y') }}</strong>?</p>
                            <div class="mb-3">
                                <label for="payrollMonth" class="form-label">Select Month</label>
                                <select class="form-select" id="payrollMonth" name="month" required>
                                    <option value="{{ date('F Y') }}">{{ date('F Y') }}</option>
                                    <option value="{{ date('F Y', strtotime('-1 month')) }}">{{ date('F Y', strtotime('-1 month')) }}</option>
                                    <option value="{{ date('F Y', strtotime('-2 months')) }}">{{ date('F Y', strtotime('-2 months')) }}</option>
                                </select>
                            </div>
                            <p class="text-muted">This will calculate and distribute salaries for all employees.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Process Payroll</button>
                        </div>
                    </form>
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
            
            // Month Filter (Placeholder for client-side filtering)
            const monthFilter = document.getElementById('monthFilter');
            if (monthFilter) {
                monthFilter.addEventListener('change', function() {
                    // Implement client-side filtering or AJAX call to refresh table data
                    console.log('Filter by month:', this.value);
                });
            }
            
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

            // Download Payroll Function (Placeholder)
            window.downloadPayroll = function(index) {
                console.log('Downloading payroll for index:', index);
                // Implement download logic (e.g., generate PDF or CSV)
            };

            // Chart.js for Payroll Breakdown
            const payrollChart = document.getElementById('payrollChart');
            if (payrollChart) {
                new Chart(payrollChart, {
                    type: 'pie',
                    data: {
                        labels: ['Base Salary', 'Bonuses', 'Deductions'],
                        datasets: [{
                            data: [
                                {{ array_sum(array_column($payrollData, 'base_salary')) }},
                                {{ array_sum(array_column($payrollData, 'bonuses')) }},
                                {{ array_sum(array_column($payrollData, 'deductions')) }}
                            ],
                            backgroundColor: ['#4facfe', '#43e97b', '#f5576c'],
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

            // Chart.js for Monthly Trends
            const trendChart = document.getElementById('trendChart');
            if (trendChart) {
                new Chart(trendChart, {
                    type: 'line',
                    data: {
                        labels: ['{{ date('F Y', strtotime('-2 months')) }}', '{{ date('F Y', strtotime('-1 month')) }}', '{{ date('F Y') }}'],
                        datasets: [{
                            label: 'Total Payroll',
                            data: [
                                {{ array_sum(array_column($payrollData, 'net_salary')) * 0.95 }},
                                {{ array_sum(array_column($payrollData, 'net_salary')) * 0.98 }},
                                {{ array_sum(array_column($payrollData, 'net_salary')) }}
                            ],
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
        });
    </script>
</body>
</html>