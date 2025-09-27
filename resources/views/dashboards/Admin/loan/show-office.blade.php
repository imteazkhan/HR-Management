<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Office Loan Details - HR Management</title>
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
            <h2><i class="bi bi-cash-stack text-primary"></i> Office Loan Details</h2>
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

        <!-- Loan Details -->
        <div class="row g-3 g-md-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><i class="bi bi-info-circle"></i> Loan Information</h5>
                            <span class="badge bg-light text-dark">Loan ID: OL-2024-001</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted">Employee</h6>
                                <p><i class="bi bi-person"></i> John Smith</p>
                                
                                <h6 class="text-muted">Department</h6>
                                <p><i class="bi bi-building"></i> IT Department</p>
                                
                                <h6 class="text-muted">Loan Amount</h6>
                                <p><i class="bi bi-currency-dollar"></i> $5,000.00</p>
                                
                                <h6 class="text-muted">Interest Rate</h6>
                                <p><i class="bi bi-percent"></i> 5.5%</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Application Date</h6>
                                <p><i class="bi bi-calendar"></i> January 15, 2024</p>
                                
                                <h6 class="text-muted">Repayment Term</h6>
                                <p><i class="bi bi-clock"></i> 12 months</p>
                                
                                <h6 class="text-muted">Repayment Start Date</h6>
                                <p><i class="bi bi-calendar-check"></i> February 15, 2024</p>
                                
                                <h6 class="text-muted">Status</h6>
                                <p><span class="badge bg-success">Approved</span></p>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="text-muted">Purpose of Loan</h6>
                                <p>Office equipment upgrade for the IT department to improve system performance and security.</p>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="text-muted">Supporting Documents</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-file-earmark-pdf"></i> Equipment Quote.pdf
                                    </a>
                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-file-earmark-pdf"></i> Budget Proposal.pdf
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Repayment Schedule -->
        <div class="row g-3 g-md-4 mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><i class="bi bi-calendar-check"></i> Repayment Schedule</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Installment</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Principal</th>
                                        <th>Interest</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>February 15, 2024</td>
                                        <td>$429.50</td>
                                        <td>$403.25</td>
                                        <td>$26.25</td>
                                        <td>$4,596.75</td>
                                        <td><span class="badge bg-success">Paid</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>March 15, 2024</td>
                                        <td>$429.50</td>
                                        <td>$405.10</td>
                                        <td>$24.40</td>
                                        <td>$4,191.65</td>
                                        <td><span class="badge bg-success">Paid</span></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>April 15, 2024</td>
                                        <td>$429.50</td>
                                        <td>$406.96</td>
                                        <td>$22.54</td>
                                        <td>$3,784.69</td>
                                        <td><span class="badge bg-success">Paid</span></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>May 15, 2024</td>
                                        <td>$429.50</td>
                                        <td>$408.84</td>
                                        <td>$20.66</td>
                                        <td>$3,375.85</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>June 15, 2024</td>
                                        <td>$429.50</td>
                                        <td>$410.73</td>
                                        <td>$18.77</td>
                                        <td>$2,965.12</td>
                                        <td><span class="badge bg-secondary">Upcoming</span></td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>July 15, 2024</td>
                                        <td>$429.50</td>
                                        <td>$412.63</td>
                                        <td>$16.87</td>
                                        <td>$2,552.49</td>
                                        <td><span class="badge bg-secondary">Upcoming</span></td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>August 15, 2024</td>
                                        <td>$429.50</td>
                                        <td>$414.55</td>
                                        <td>$14.95</td>
                                        <td>$2,137.94</td>
                                        <td><span class="badge bg-secondary">Upcoming</span></td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>September 15, 2024</td>
                                        <td>$429.50</td>
                                        <td>$416.48</td>
                                        <td>$13.02</td>
                                        <td>$1,721.46</td>
                                        <td><span class="badge bg-secondary">Upcoming</span></td>
                                    </tr>
                                    <tr>
                                        <td>9</td>
                                        <td>October 15, 2024</td>
                                        <td>$429.50</td>
                                        <td>$418.42</td>
                                        <td>$11.08</td>
                                        <td>$1,303.04</td>
                                        <td><span class="badge bg-secondary">Upcoming</span></td>
                                    </tr>
                                    <tr>
                                        <td>10</td>
                                        <td>November 15, 2024</td>
                                        <td>$429.50</td>
                                        <td>$420.38</td>
                                        <td>$9.12</td>
                                        <td>$882.66</td>
                                        <td><span class="badge bg-secondary">Upcoming</span></td>
                                    </tr>
                                    <tr>
                                        <td>11</td>
                                        <td>December 15, 2024</td>
                                        <td>$429.50</td>
                                        <td>$422.35</td>
                                        <td>$7.15</td>
                                        <td>$460.31</td>
                                        <td><span class="badge bg-secondary">Upcoming</span></td>
                                    </tr>
                                    <tr>
                                        <td>12</td>
                                        <td>January 15, 2025</td>
                                        <td>$429.50</td>
                                        <td>$424.33</td>
                                        <td>$5.17</td>
                                        <td>$0.00</td>
                                        <td><span class="badge bg-secondary">Upcoming</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="row g-3 g-md-4 mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('hrm.loans.office.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Office Loans
                            </a>
                            <div>
                                <button class="btn btn-warning">
                                    <i class="bi bi-pencil"></i> Edit Loan
                                </button>
                                <button class="btn btn-danger ms-2">
                                    <i class="bi bi-trash"></i> Delete Loan
                                </button>
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
        });
    </script>
</body>
</html>