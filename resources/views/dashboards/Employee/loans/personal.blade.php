<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personal Loans - HR Management</title>
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
        .loan-progress {
            height: 10px;
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
            <span class="fw-bold">Employee</span>
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
                <a class="nav-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}" href="{{ route('employee.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            
            <!-- Employee Management Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person"></i> Employee Management
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('employee.profile') }}">My Profile</a></li>
                </ul>
            </li>
            
            <!-- Attendance Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-calendar-check"></i> Attendance
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('employee.attendance') }}">My Attendance</a></li>
                </ul>
            </li>
            
            <!-- Loans Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-cash"></i> Loans
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('admin.loans.office') }}">Office Loans</a></li>
                    <li><a class="dropdown-item active" href="#">Personal Loans</a></li>
                </ul>
            </li>
            
            <!-- Leaves Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-calendar-x"></i> Leaves
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('employee.leaves.index') }}">My Leaves</a></li>
                </ul>
            </li>
            
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('employee.payslips') ? 'active' : '' }}" href="{{ route('employee.payslips') }}"><i class="bi bi-cash-stack"></i> Payslips</a></li>
            
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
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 d-none d-lg-flex">
            <h2><i class="bi bi-cash text-primary"></i> Personal Loans</h2>
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
            <p class="text-muted mb-0">Employee Dashboard</p>
        </div>

        <!-- Loan Stats -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card stat-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Loans</h6>
                            <h2>3</h2>
                        </div>
                        <i class="bi bi-cash-stack fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-2 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Active Loans</h6>
                            <h2>1</h2>
                        </div>
                        <i class="bi bi-graph-up fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-3 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Repaid</h6>
                            <h2>$12,500</h2>
                        </div>
                        <i class="bi bi-currency-dollar fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-4 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Pending Approval</h6>
                            <h2>1</h2>
                        </div>
                        <i class="bi bi-hourglass-split fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Apply for Loan Card -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="bi bi-plus-circle"></i> Apply for Personal Loan</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="loanAmount" class="form-label">Loan Amount ($)</label>
                                    <input type="number" class="form-control" id="loanAmount" placeholder="e.g., 10000" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="loanPurpose" class="form-label">Purpose</label>
                                    <select class="form-select" id="loanPurpose" required>
                                        <option value="">Select Purpose</option>
                                        <option value="education">Education</option>
                                        <option value="medical">Medical Expenses</option>
                                        <option value="home">Home Improvement</option>
                                        <option value="vehicle">Vehicle Purchase</option>
                                        <option value="personal">Personal Use</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="repaymentMonths" class="form-label">Repayment Period (Months)</label>
                                    <input type="number" class="form-control" id="repaymentMonths" placeholder="e.g., 12" min="1" max="60" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="monthlyIncome" class="form-label">Monthly Income ($)</label>
                                    <input type="number" class="form-control" id="monthlyIncome" placeholder="e.g., 5000" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="loanDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="loanDescription" rows="3" placeholder="Provide details about your loan request..."></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Submit Loan Application
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loan History -->
        <div class="row g-3 g-md-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="bi bi-clock-history"></i> Loan History</h5>
                    </div>
                    <div class="card-body">
                        <!-- Loans Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Loan ID</th>
                                        <th>Amount</th>
                                        <th>Purpose</th>
                                        <th>Applied Date</th>
                                        <th>Repayment Period</th>
                                        <th>Status</th>
                                        <th>Progress</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>LN-00125</td>
                                        <td>$15,000</td>
                                        <td>Home Improvement</td>
                                        <td>2023-05-15</td>
                                        <td>36 months</td>
                                        <td><span class="status-badge badge-approved">Approved</span></td>
                                        <td>
                                            <div class="progress loan-progress mb-1">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
                                            </div>
                                            <small>15/36 paid</small>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>LN-00089</td>
                                        <td>$8,000</td>
                                        <td>Education</td>
                                        <td>2022-01-10</td>
                                        <td>24 months</td>
                                        <td><span class="status-badge badge-approved">Completed</span></td>
                                        <td>
                                            <div class="progress loan-progress mb-1">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                                            </div>
                                            <small>24/24 paid</small>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>LN-00156</td>
                                        <td>$5,000</td>
                                        <td>Medical Expenses</td>
                                        <td>2024-03-01</td>
                                        <td>12 months</td>
                                        <td><span class="status-badge badge-pending">Pending</span></td>
                                        <td>
                                            <div class="progress loan-progress mb-1">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 0%"></div>
                                            </div>
                                            <small>0/12 paid</small>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Loans pagination">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
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