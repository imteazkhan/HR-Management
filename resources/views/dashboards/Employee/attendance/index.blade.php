<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Attendance - HR Management</title>
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
                <a class="nav-link" href="{{ route('employee.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            
            <!-- Attendance Management -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-calendar-check"></i>
                    Attendance
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item active" href="{{ route('employee.attendance') }}">My Attendance</a></li>
                    <li><a class="dropdown-item" href="{{ route('employee.clock') }}">Clock In/Out</a></li>
                </ul>
            </li>
            
            <!-- Leave Management -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-calendar-x"></i>
                    Leave Management
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('hrm.leaves.employee.index') }}">My Leave Requests</a></li>
                    <li><a class="dropdown-item" href="{{ route('employee.leave-request') }}">Request Leave</a></li>
                </ul>
            </li>
            
            <!-- Payroll Management -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('employee.payslips') }}">
                    <i class="bi bi-currency-dollar"></i> My Payslips
                </a>
            </li>
            
            <!-- Performance Management -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-graph-up"></i> Performance
                </a>
            </li>
            
            <!-- Time Management -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-clock"></i> Time Sheet
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 d-none d-lg-flex">
            <h2><i class="bi bi-calendar-check text-primary"></i> My Attendance</h2>
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

        <!-- Attendance Stats -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card stat-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">This Month</h6>
                            <h2>18</h2>
                        </div>
                        <i class="bi bi-calendar-check fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-2 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Late Arrivals</h6>
                            <h2>2</h2>
                        </div>
                        <i class="bi bi-clock-history fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-3 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Early Leaves</h6>
                            <h2>1</h2>
                        </div>
                        <i class="bi bi-door-open fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-4 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Attendance Rate</h6>
                            <h2>92%</h2>
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
                            <div class="col-md-4">
                                <label for="dateFilter" class="form-label">Date Range</label>
                                <input type="date" class="form-control" id="dateFilter" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="statusFilter" class="form-label">Status</label>
                                <select class="form-select" id="statusFilter">
                                    <option value="">All Statuses</option>
                                    <option value="present">Present</option>
                                    <option value="absent">Absent</option>
                                    <option value="late">Late</option>
                                    <option value="leave">On Leave</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <a href="{{ route('employee.clock') }}" class="btn btn-primary w-100">
                                    <i class="bi bi-clock"></i> Clock In/Out
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Records Table -->
        <div class="row g-3 g-md-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><i class="bi bi-table"></i> Attendance Records</h5>
                            <span class="badge bg-light text-dark">Showing 10 of 186 records</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Day</th>
                                        <th>Status</th>
                                        <th>Clock In</th>
                                        <th>Clock Out</th>
                                        <th>Hours Worked</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Jan 15, 2024</td>
                                        <td>Monday</td>
                                        <td><span class="badge bg-success">Present</span></td>
                                        <td>09:00 AM</td>
                                        <td>05:00 PM</td>
                                        <td>8.0 hrs</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Jan 14, 2024</td>
                                        <td>Sunday</td>
                                        <td><span class="badge bg-secondary">Weekend</span></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Jan 13, 2024</td>
                                        <td>Saturday</td>
                                        <td><span class="badge bg-secondary">Weekend</span></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Jan 12, 2024</td>
                                        <td>Friday</td>
                                        <td><span class="badge bg-success">Present</span></td>
                                        <td>09:15 AM</td>
                                        <td>05:30 PM</td>
                                        <td>8.25 hrs</td>
                                        <td>Late arrival</td>
                                    </tr>
                                    <tr>
                                        <td>Jan 11, 2024</td>
                                        <td>Thursday</td>
                                        <td><span class="badge bg-success">Present</span></td>
                                        <td>08:45 AM</td>
                                        <td>04:45 PM</td>
                                        <td>8.0 hrs</td>
                                        <td>Early leave</td>
                                    </tr>
                                    <tr>
                                        <td>Jan 10, 2024</td>
                                        <td>Wednesday</td>
                                        <td><span class="badge bg-success">Present</span></td>
                                        <td>09:00 AM</td>
                                        <td>05:00 PM</td>
                                        <td>8.0 hrs</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Jan 9, 2024</td>
                                        <td>Tuesday</td>
                                        <td><span class="badge bg-danger">Absent</span></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>Personal leave</td>
                                    </tr>
                                    <tr>
                                        <td>Jan 8, 2024</td>
                                        <td>Monday</td>
                                        <td><span class="badge bg-success">Present</span></td>
                                        <td>09:00 AM</td>
                                        <td>05:00 PM</td>
                                        <td>8.0 hrs</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Jan 7, 2024</td>
                                        <td>Sunday</td>
                                        <td><span class="badge bg-secondary">Weekend</span></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Jan 6, 2024</td>
                                        <td>Saturday</td>
                                        <td><span class="badge bg-secondary">Weekend</span></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
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