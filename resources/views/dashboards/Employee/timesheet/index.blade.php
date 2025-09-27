<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Time Sheet - HR Management</title>
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
        .badge-submitted {
            background: #0d6efd;
            color: white;
        }
        .time-entry-card {
            border-left: 4px solid #667eea;
        }
        .calendar-day {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #667eea;
            color: white;
            font-weight: bold;
        }
        .week-navigation {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
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
                    <li><a class="dropdown-item" href="{{ route('employee.loans.personal') }}">Personal Loans</a></li>
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
                    <li><a class="dropdown-item active" href="#">Time Sheet</a></li>
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
            <h2><i class="bi bi-clock-history text-primary"></i> My Time Sheet</h2>
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

        <!-- Time Sheet Stats -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card stat-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">This Week</h6>
                            <h2>32h</h2>
                        </div>
                        <i class="bi bi-clock fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-2 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">This Month</h6>
                            <h2>128h</h2>
                        </div>
                        <i class="bi bi-calendar fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-3 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Pending Approval</h6>
                            <h2>8h</h2>
                        </div>
                        <i class="bi bi-hourglass-split fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-4 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Approved</h6>
                            <h2>120h</h2>
                        </div>
                        <i class="bi bi-check-circle fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Week Navigation -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12">
                <div class="card week-navigation">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-light">
                                <i class="bi bi-chevron-left"></i> Previous Week
                            </button>
                            <h4 class="mb-0">Week of Dec 15 - Dec 21, 2024</h4>
                            <button class="btn btn-light">
                                Next Week <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Time Entry Card -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="bi bi-plus-circle"></i> Add Time Entry</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="project" class="form-label">Project</label>
                                    <select class="form-select" id="project" required>
                                        <option value="">Select Project</option>
                                        <option value="1">Website Redesign</option>
                                        <option value="2">Mobile App Development</option>
                                        <option value="3">Database Migration</option>
                                        <option value="4">API Integration</option>
                                        <option value="5">Security Audit</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="task" class="form-label">Task</label>
                                    <select class="form-select" id="task" required>
                                        <option value="">Select Task</option>
                                        <option value="1">Frontend Development</option>
                                        <option value="2">Backend Development</option>
                                        <option value="3">Testing</option>
                                        <option value="4">Documentation</option>
                                        <option value="5">Code Review</option>
                                        <option value="6">Meeting</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="hours" class="form-label">Hours</label>
                                    <input type="number" class="form-control" id="hours" placeholder="e.g., 8" min="0.5" step="0.5" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="minutes" class="form-label">Minutes</label>
                                    <select class="form-select" id="minutes">
                                        <option value="0">0 minutes</option>
                                        <option value="15">15 minutes</option>
                                        <option value="30">30 minutes</option>
                                        <option value="45">45 minutes</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" rows="3" placeholder="Describe the work done..."></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Add Time Entry
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Time Sheet Entries -->
        <div class="row g-3 g-md-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><i class="bi bi-clock-history"></i> Time Sheet Entries</h5>
                            <div class="d-flex">
                                <select class="form-select form-select-sm me-2" style="width: auto;">
                                    <option>This Week</option>
                                    <option>Last Week</option>
                                    <option>This Month</option>
                                    <option>Last Month</option>
                                </select>
                                <button class="btn btn-sm btn-light">
                                    <i class="bi bi-send"></i> Submit for Approval
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Time Sheet Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Project</th>
                                        <th>Task</th>
                                        <th>Description</th>
                                        <th>Hours</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="calendar-day me-3">15</div>
                                                <div>
                                                    <div class="fw-bold">Dec 15, 2024</div>
                                                    <div class="text-muted small">Monday</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Website Redesign</td>
                                        <td>Frontend Development</td>
                                        <td>Implemented new user interface for dashboard</td>
                                        <td>8.0</td>
                                        <td><span class="status-badge badge-approved">Approved</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View Details</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="calendar-day me-3 bg-warning">16</div>
                                                <div>
                                                    <div class="fw-bold">Dec 16, 2024</div>
                                                    <div class="text-muted small">Tuesday</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Mobile App Development</td>
                                        <td>Backend Development</td>
                                        <td>Created REST API endpoints for user management</td>
                                        <td>7.5</td>
                                        <td><span class="status-badge badge-approved">Approved</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View Details</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="calendar-day me-3 bg-info">17</div>
                                                <div>
                                                    <div class="fw-bold">Dec 17, 2024</div>
                                                    <div class="text-muted small">Wednesday</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Database Migration</td>
                                        <td>Testing</td>
                                        <td>Performed unit tests on database migration scripts</td>
                                        <td>6.0</td>
                                        <td><span class="status-badge badge-submitted">Submitted</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View Details</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="calendar-day me-3 bg-primary">18</div>
                                                <div>
                                                    <div class="fw-bold">Dec 18, 2024</div>
                                                    <div class="text-muted small">Thursday</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>API Integration</td>
                                        <td>Code Review</td>
                                        <td>Reviewed code for payment gateway integration</td>
                                        <td>8.0</td>
                                        <td><span class="status-badge badge-approved">Approved</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View Details</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="calendar-day me-3 bg-success">19</div>
                                                <div>
                                                    <div class="fw-bold">Dec 19, 2024</div>
                                                    <div class="text-muted small">Friday</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Security Audit</td>
                                        <td>Documentation</td>
                                        <td>Documented security vulnerabilities findings</td>
                                        <td>7.0</td>
                                        <td><span class="status-badge badge-pending">Pending</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View Details</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Weekly Summary -->
                        <div class="row mt-4">
                            <div class="col-md-8">
                                <h5>Weekly Summary</h5>
                                <div class="progress mb-2" style="height: 20px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 64%">Approved (32h)</div>
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 12%">Submitted (6h)</div>
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 14%">Pending (7h)</div>
                                    <div class="progress-bar bg-secondary" role="progressbar" style="width: 10%">Remaining (5h)</div>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <h5>Total Hours: 45.0</h5>
                                <p class="text-muted">Standard Work Week: 40h</p>
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