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
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        @media print {
            /* Hide elements that shouldn't be printed */
            .sidebar, .mobile-header, .sidebar-overlay, .btn, select, .nav, .dropdown, .modal, .chart-container {
                display: none !important;
            }
            
            /* Show print-only elements */
            .print-title, .print-summary {
                display: block !important;
            }
            
            /* Adjust layout for printing */
            .main-content {
                margin-left: 0 !important;
                padding: 0 !important;
            }
            
            /* Ensure the card takes full width */
            .card {
                box-shadow: none;
                border: none;
            }
            
            /* Improve table appearance for printing */
            .table {
                font-size: 12px;
            }
            
            .table th, .table td {
                padding: 8px;
                vertical-align: top;
                border-top: 1px solid #dee2e6;
            }
            
            /* Ensure badges are visible in print */
            .badge {
                color: #000 !important;
                background-color: #fff !important;
                border: 1px solid #000;
            }
            
            /* Print the page title */
            .print-title {
                text-align: center;
                margin-bottom: 20px;
                font-size: 24px;
                font-weight: bold;
            }
            
            /* Print summary information */
            .print-summary {
                margin-bottom: 20px;
                font-size: 14px;
            }
            
            /* Ensure footer is visible */
            tfoot {
                display: table-footer-group;
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

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Payroll Summary Cards -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card stat-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Payroll</h6>
                            <h2>BDT {{ number_format(array_sum(array_column($payrollData, 'net_salary')), 0) }}</h2>
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
                            <h2>BDT {{ number_format(array_sum(array_column($payrollData, 'bonuses')), 0) }}</h2>
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
                            <h2>BDT {{ number_format(array_sum(array_column($payrollData, 'deductions')), 0) }}</h2>
                        </div>
                        <i class="bi bi-calculator fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payroll Table -->
        <div class="card">
            <!-- Print Title (only visible when printing) -->
            <div class="print-title d-none">
                Employee Payroll Report - {{ date('F Y') }}
            </div>
            
            <!-- Print Summary (only visible when printing) -->
            <div class="print-summary d-none">
                <p><strong>Report Generated:</strong> {{ date('F j, Y') }}</p>
                <p><strong>Total Employees:</strong> {{ count($payrollData) }}</p>
                <p><strong>Total Payroll:</strong> BDT {{ number_format(array_sum(array_column($payrollData, 'net_salary')), 0) }}</p>
            </div>
            
            <div class="card-header bg-primary text-white">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0"><i class="bi bi-cash-stack"></i> Employee Payroll - {{ date('F Y') }}</h5>
                    </div>
                    <div class="col-auto">
                        <select class="form-select form-select-sm" id="monthFilter">
                            <option value="{{ date('F Y') }}" {{ request('month') == date('F Y') ? 'selected' : '' }}>{{ date('F Y') }}</option>
                            <option value="{{ date('F Y', strtotime('-1 month')) }}" {{ request('month') == date('F Y', strtotime('-1 month')) ? 'selected' : '' }}>{{ date('F Y', strtotime('-1 month')) }}</option>
                            <option value="{{ date('F Y', strtotime('-2 months')) }}" {{ request('month') == date('F Y', strtotime('-2 months')) ? 'selected' : '' }}>{{ date('F Y', strtotime('-2 months')) }}</option>
                            <option value="{{ date('F Y', strtotime('-3 months')) }}" {{ request('month') == date('F Y', strtotime('-3 months')) ? 'selected' : '' }}>{{ date('F Y', strtotime('-3 months')) }}</option>
                            <option value="{{ date('F Y', strtotime('-4 months')) }}" {{ request('month') == date('F Y', strtotime('-4 months')) ? 'selected' : '' }}>{{ date('F Y', strtotime('-4 months')) }}</option>
                            <option value="{{ date('F Y', strtotime('-5 months')) }}" {{ request('month') == date('F Y', strtotime('-5 months')) ? 'selected' : '' }}>{{ date('F Y', strtotime('-5 months')) }}</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-sm btn-info" onclick="window.location.reload()">
                            <i class="bi bi-arrow-clockwise"></i> Refresh
                        </button>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#processPayrollModal">
                            <i class="bi bi-plus-circle"></i> Process Payroll
                        </button>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-sm btn-light" id="printPayrollBtn">
                            <i class="bi bi-printer"></i> Print
                        </button>
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
                                <th>Attendance</th>
                                <th>Leave</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payrollData as $index => $payroll)
                            <tr class="table-row-hover fade-in-up">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3 bg-success">
                                            {{ substr($payroll['employee'], 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $payroll['employee'] }}</h6>
                                            <small class="text-muted">EMP{{ str_pad($payroll['user_id'], 3, '0', STR_PAD_LEFT) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $payroll['position'] }}</td>
                                <td>BDT {{ number_format($payroll['base_salary'], 0) }}</td>
                                <td>
                                    <span class="badge bg-success">BDT {{ number_format($payroll['bonuses'], 0) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-warning">BDT {{ number_format($payroll['deductions'], 0) }}</span>
                                </td>
                                <td>
                                    <strong>BDT {{ number_format($payroll['net_salary'], 0) }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $payroll['attendance_rate'] ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $payroll['leave_balance'] ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">Processed</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="showViewPayrollModal({{ json_encode($payroll) }})">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-success" onclick="downloadPayroll({{ $index }})">
                                            <i class="bi bi-download"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="showEditPayrollModal({{ json_encode($payroll) }})">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        <p>No payroll records found for this month.</p>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#processPayrollModal">
                                            <i class="bi bi-plus-circle"></i> Process Payroll
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="2">TOTAL</th>
                                <th>BDT {{ number_format(array_sum(array_column($payrollData, 'base_salary')), 0) }}</th>
                                <th>BDT {{ number_format(array_sum(array_column($payrollData, 'bonuses')), 0) }}</th>
                                <th>BDT {{ number_format(array_sum(array_column($payrollData, 'deductions')), 0) }}</th>
                                <th>BDT {{ number_format(array_sum(array_column($payrollData, 'net_salary')), 0) }}</th>
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
                            <div class="mb-3">
                                <label for="payrollMonth" class="form-label">Select Month</label>
                                <input type="month" class="form-control" id="payrollMonth" name="month" value="{{ date('Y-m') }}" required>
                                <div class="form-text">Select the month for which you want to process payroll.</div>
                            </div>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i>
                                <strong>Note:</strong> This will calculate and distribute salaries for all employees based on their attendance, performance, and leave records for the selected month.
                            </div>
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i>
                                <strong>Warning:</strong> If payroll already exists for this month, it will be skipped to avoid duplicates.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Process Payroll</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- View Payroll Modal -->
        <div class="modal fade" id="viewPayrollModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Payroll Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Employee:</strong> <span id="viewEmployeeName"></span></p>
                        <p><strong>Position:</strong> <span id="viewPosition"></span></p>
                        <p><strong>Base Salary:</strong> BDT <span id="viewBaseSalary"></span></p>
                        <p><strong>Bonuses:</strong> BDT <span id="viewBonuses"></span></p>
                        <p><strong>Deductions:</strong> BDT <span id="viewDeductions"></span></p>
                        <p><strong>Net Salary:</strong> BDT <span id="viewNetSalary"></span></p>
                        <p><strong>Status:</strong> <span id="viewStatus"></span></p>
                        <p><strong>Attendance Rate:</strong> <span id="viewAttendanceRate">N/A</span></p>
                        <p><strong>Leave Balance:</strong> <span id="viewLeaveBalance">N/A</span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Payroll Modal -->
        <div class="modal fade" id="editPayrollModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Edit Payroll</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="editPayrollForm" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editEmployeeName" class="form-label">Employee</label>
                                <input type="text" class="form-control" id="editEmployeeName" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="editBaseSalary" class="form-label">Base Salary</label>
                                <input type="number" class="form-control" id="editBaseSalary" name="base_salary" required>
                            </div>
                            <div class="mb-3">
                                <label for="editBonuses" class="form-label">Bonuses</label>
                                <input type="number" class="form-control" id="editBonuses" name="bonuses" required>
                            </div>
                            <div class="mb-3">
                                <label for="editDeductions" class="form-label">Deductions</label>
                                <input type="number" class="form-control" id="editDeductions" name="deductions" required>
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
            
            // Month Filter functionality
            const monthFilter = document.getElementById('monthFilter');
            if (monthFilter) {
                monthFilter.addEventListener('change', function() {
                    // Reload page with month parameter
                    const selectedMonth = this.value;
                    const url = new URL(window.location);
                    url.searchParams.set('month', selectedMonth);
                    window.location.href = url.toString();
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

            // Download Payroll Function
            window.downloadPayroll = function(index) {
                // Create a simple payroll report
                const payroll = @json($payrollData);
                const payrollData = payroll[index];
                
                if (!payrollData) {
                    alert('Payroll data not found!');
                    return;
                }
                
                // Create CSV content
                let csvContent = "Employee,Position,Base Salary,Bonuses,Deductions,Net Salary,Attendance Rate,Leave Balance,Month,Status\n";
                csvContent += `"${payrollData.employee}","${payrollData.position}","${payrollData.base_salary}","${payrollData.bonuses}","${payrollData.deductions}","${payrollData.net_salary}","${payrollData.attendance_rate}","${payrollData.leave_balance}","{{ request('month', date('F Y')) }}","Processed"\n`;
                
                // Create blob and download
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.setAttribute('href', url);
                link.setAttribute('download', `payroll_${payrollData.employee.replace(/\s+/g, '_')}_{{ request('month', date('F_Y')) }}.csv`);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                // Show success message
                showNotification('Payroll downloaded successfully!', 'success');
            };
            
            // Print Payroll Function
            window.printPayroll = function() {
                window.print();
            };
            
            // Add event listener for print button
            document.getElementById('printPayrollBtn').addEventListener('click', printPayroll);
            
            // Show View Payroll Modal
            window.showViewPayrollModal = function(payroll) {
                document.getElementById('viewEmployeeName').textContent = payroll.employee;
                document.getElementById('viewPosition').textContent = payroll.position;
                document.getElementById('viewBaseSalary').textContent = parseFloat(payroll.base_salary).toLocaleString();
                document.getElementById('viewBonuses').textContent = parseFloat(payroll.bonuses).toLocaleString();
                document.getElementById('viewDeductions').textContent = parseFloat(payroll.deductions).toLocaleString();
                document.getElementById('viewNetSalary').textContent = parseFloat(payroll.net_salary).toLocaleString();
                document.getElementById('viewStatus').textContent = 'Processed';
                document.getElementById('viewAttendanceRate').textContent = payroll.attendance_rate || 'N/A';
                document.getElementById('viewLeaveBalance').textContent = payroll.leave_balance || 'N/A';
                
                const viewModal = new bootstrap.Modal(document.getElementById('viewPayrollModal'));
                viewModal.show();
            };
            
            // Show Edit Payroll Modal
            window.showEditPayrollModal = function(payroll) {
                // Set form action
                const form = document.getElementById('editPayrollForm');
                form.action = '{{ route("superadmin.payroll.update", ":id") }}'.replace(':id', payroll.id);
                
                // Populate form fields
                document.getElementById('editEmployeeName').value = payroll.employee;
                document.getElementById('editBaseSalary').value = payroll.base_salary;
                document.getElementById('editBonuses').value = payroll.bonuses;
                document.getElementById('editDeductions').value = payroll.deductions;
                
                // Calculate and show net salary
                updateNetSalary();
                
                const editModal = new bootstrap.Modal(document.getElementById('editPayrollModal'));
                editModal.show();
            };
            
            // Update net salary calculation in edit form
            function updateNetSalary() {
                const baseSalary = parseFloat(document.getElementById('editBaseSalary').value) || 0;
                const bonuses = parseFloat(document.getElementById('editBonuses').value) || 0;
                const deductions = parseFloat(document.getElementById('editDeductions').value) || 0;
                const netSalary = baseSalary + bonuses - deductions;
                
                // Show calculated net salary
                let netSalaryDisplay = document.getElementById('netSalaryDisplay');
                if (!netSalaryDisplay) {
                    netSalaryDisplay = document.createElement('div');
                    netSalaryDisplay.id = 'netSalaryDisplay';
                    netSalaryDisplay.className = 'alert alert-info mt-2';
                    document.getElementById('editDeductions').parentNode.appendChild(netSalaryDisplay);
                }
                netSalaryDisplay.innerHTML = `<strong>Net Salary: BDT ${netSalary.toLocaleString()}</strong>`;
            }
            
            // Add event listeners for real-time calculation
            document.addEventListener('DOMContentLoaded', function() {
                ['editBaseSalary', 'editBonuses', 'editDeductions'].forEach(id => {
                    const element = document.getElementById(id);
                    if (element) {
                        element.addEventListener('input', updateNetSalary);
                    }
                });
            });
            
            // Notification system
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
                notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                notification.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                
                document.body.appendChild(notification);
                
                // Auto remove after 3 seconds
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 3000);
            }

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