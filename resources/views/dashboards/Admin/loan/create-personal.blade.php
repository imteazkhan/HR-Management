<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Personal Loan - HR Management</title>
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
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-calendar-check"></i>
                    Attendance
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('hrm.attendance.admin.index') }}">Admin Attendance</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.attendance.employee.index') }}">Employee Attendance</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.attendance.biometric.index') }}">Biometric Attendance</a></li>
                </ul>
            </li>
            
            <!-- Loan Management Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown">
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
            <h2><i class="bi bi-cash-stack text-primary"></i> Create Personal Loan</h2>
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

        <!-- Create Loan Form -->
        <div class="row g-3 g-md-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><i class="bi bi-plus-circle"></i> New Personal Loan Application</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="employeeSelect" class="form-label">Employee</label>
                                    <select class="form-select" id="employeeSelect" required>
                                        <option value="">Select Employee</option>
                                        <option value="1">John Smith - IT Department</option>
                                        <option value="2">Sarah Lee - Marketing</option>
                                        <option value="3">Mike Davis - Finance</option>
                                        <option value="4">Emma Johnson - Human Resources</option>
                                        <option value="5">Robert Brown - Operations</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="loanAmount" class="form-label">Loan Amount ($)</label>
                                    <input type="number" class="form-control" id="loanAmount" placeholder="Enter loan amount" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="applicationDate" class="form-label">Application Date</label>
                                    <input type="date" class="form-control" id="applicationDate" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="repaymentTerm" class="form-label">Repayment Term (months)</label>
                                    <input type="number" class="form-control" id="repaymentTerm" placeholder="Enter repayment term" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="loanPurpose" class="form-label">Purpose of Loan</label>
                                    <textarea class="form-control" id="loanPurpose" rows="3" placeholder="Describe the purpose of the loan..." required></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="interestRate" class="form-label">Interest Rate (%)</label>
                                    <input type="number" class="form-control" id="interestRate" placeholder="Enter interest rate" step="0.01">
                                </div>
                                <div class="col-md-6">
                                    <label for="startDate" class="form-label">Repayment Start Date</label>
                                    <input type="date" class="form-control" id="startDate" value="{{ date('Y-m-d', strtotime('+1 month')) }}" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="supportingDocuments" class="form-label">Supporting Documents</label>
                                    <input type="file" class="form-control" id="supportingDocuments" multiple>
                                    <div class="form-text">Upload any supporting documents (pay stubs, quotes, etc.)</div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('hrm.loans.personal.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Back to Personal Loans
                                        </a>
                                        <div>
                                            <button type="reset" class="btn btn-outline-danger me-2">
                                                <i class="bi bi-x-circle"></i> Reset
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-check-circle"></i> Submit Application
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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
        });
    </script>
</body>
</html>