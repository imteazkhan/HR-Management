<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Overtime Requests - HR Management</title>
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
        .sidebar .dropdown-item.active {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: #fff;
        }
        .sidebar .dropdown-toggle::after {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
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
        .badge-rejected {
            background: #dc3545;
            color: white;
        }
        .overtime-progress {
            height: 10px;
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
                    <i class="bi bi-person"></i>
                    Employee Management
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('employee.profile') }}">My Profile</a></li>
                </ul>
            </li>
            
            <!-- Attendance Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-calendar-check"></i>
                    Attendance
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('employee.attendance') }}">My Attendance</a></li>
                </ul>
            </li>
            
            <!-- Leaves Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-calendar-x"></i>
                    Leaves
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('employee.leave-request') }}">Leave Requests</a></li>
                </ul>
            </li>
            
            <!-- Loans Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-cash"></i>
                    Loans
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('employee.loans.personal') }}">Personal Loans</a></li>
                </ul>
            </li>
            
            <!-- Time Management Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-clock"></i>
                    Time Management
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('employee.timesheet') }}">Time Sheet</a></li>
                    <li><a class="dropdown-item" href="{{ route('employee.schedule') }}">My Schedule</a></li>
                    <li><a class="dropdown-item active" href="#">Overtime</a></li>
                </ul>
            </li>
            
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('employee.payslips') ? 'active' : '' }}" href="{{ route('employee.payslips') }}"><i class="bi bi-cash-stack"></i> Payslips</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 d-none d-lg-flex">
            <h2><i class="bi bi-clock text-primary"></i> Overtime Requests</h2>
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

        <!-- Overtime Stats -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card stat-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Requests</h6>
                            <h2>12</h2>
                        </div>
                        <i class="bi bi-clock fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-2 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Approved Hours</h6>
                            <h2>48h</h2>
                        </div>
                        <i class="bi bi-check-circle fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-3 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Pending Approval</h6>
                            <h2>3</h2>
                        </div>
                        <i class="bi bi-hourglass-split fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-4 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">This Month</h6>
                            <h2>16h</h2>
                        </div>
                        <i class="bi bi-calendar fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Request Overtime Card -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="bi bi-plus-circle"></i> Request Overtime</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="overtimeDate" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="overtimeDate" required>
                                </div>
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
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="startTime" class="form-label">Start Time</label>
                                    <input type="time" class="form-control" id="startTime" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="endTime" class="form-label">End Time</label>
                                    <input type="time" class="form-control" id="endTime" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="totalHours" class="form-label">Total Hours</label>
                                    <input type="number" class="form-control" id="totalHours" placeholder="e.g., 2.5" min="0.5" step="0.5" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="overtimeRate" class="form-label">Overtime Rate</label>
                                    <select class="form-select" id="overtimeRate" required>
                                        <option value="1.5">1.5x (Weekday)</option>
                                        <option value="2">2x (Weekend)</option>
                                        <option value="2.5">2.5x (Holiday)</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason for Overtime</label>
                                <textarea class="form-control" id="reason" rows="3" placeholder="Explain why overtime is needed..." required></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="attachment" class="form-label">Attachment (Optional)</label>
                                <input type="file" class="form-control" id="attachment">
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Submit Overtime Request
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overtime History -->
        <div class="row g-3 g-md-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><i class="bi bi-clock-history"></i> Overtime History</h5>
                            <div class="d-flex">
                                <select class="form-select form-select-sm me-2" style="width: auto;">
                                    <option>This Month</option>
                                    <option>Last Month</option>
                                    <option>Last 3 Months</option>
                                    <option>This Year</option>
                                </select>
                                <select class="form-select form-select-sm" style="width: auto;">
                                    <option>All Status</option>
                                    <option>Approved</option>
                                    <option>Pending</option>
                                    <option>Rejected</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Overtime Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Project</th>
                                        <th>Hours</th>
                                        <th>Rate</th>
                                        <th>Reason</th>
                                        <th>Submitted On</th>
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
                                        <td>2.5</td>
                                        <td>1.5x</td>
                                        <td>Urgent client deliverable</td>
                                        <td>Dec 14, 2024</td>
                                        <td><span class="status-badge badge-approved">Approved</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="calendar-day me-3 bg-warning">10</div>
                                                <div>
                                                    <div class="fw-bold">Dec 10, 2024</div>
                                                    <div class="text-muted small">Wednesday</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Mobile App Development</td>
                                        <td>3.0</td>
                                        <td>1.5x</td>
                                        <td>Fixing critical bug</td>
                                        <td>Dec 9, 2024</td>
                                        <td><span class="status-badge badge-approved">Approved</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="calendar-day me-3 bg-info">05</div>
                                                <div>
                                                    <div class="fw-bold">Dec 05, 2024</div>
                                                    <div class="text-muted small">Friday</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Database Migration</td>
                                        <td>4.0</td>
                                        <td>1.5x</td>
                                        <td>Completing migration tasks</td>
                                        <td>Dec 4, 2024</td>
                                        <td><span class="status-badge badge-pending">Pending</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="calendar-day me-3 bg-primary">28</div>
                                                <div>
                                                    <div class="fw-bold">Nov 28, 2024</div>
                                                    <div class="text-muted small">Thursday</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>API Integration</td>
                                        <td>2.0</td>
                                        <td>1.5x</td>
                                        <td>Integration testing</td>
                                        <td>Nov 27, 2024</td>
                                        <td><span class="status-badge badge-approved">Approved</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="calendar-day me-3 bg-success">20</div>
                                                <div>
                                                    <div class="fw-bold">Nov 20, 2024</div>
                                                    <div class="text-muted small">Wednesday</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Security Audit</td>
                                        <td>3.5</td>
                                        <td>1.5x</td>
                                        <td>Completing security assessment</td>
                                        <td>Nov 19, 2024</td>
                                        <td><span class="status-badge badge-rejected">Rejected</span></td>
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
                        <nav aria-label="Overtime pagination">
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
            
            // Calculate total hours based on start and end time
            const startTime = document.getElementById('startTime');
            const endTime = document.getElementById('endTime');
            const totalHours = document.getElementById('totalHours');
            
            if (startTime && endTime && totalHours) {
                function calculateHours() {
                    if (startTime.value && endTime.value) {
                        const start = new Date(`1970-01-01T${startTime.value}`);
                        const end = new Date(`1970-01-01T${endTime.value}`);
                        
                        // Handle case where end time is next day (overnight)
                        let diff = (end - start) / (1000 * 60 * 60);
                        if (diff < 0) diff += 24; // Add 24 hours for overnight
                        
                        totalHours.value = diff.toFixed(1);
                    }
                }
                
                startTime.addEventListener('change', calculateHours);
                endTime.addEventListener('change', calculateHours);
            }
        });
    </script>
</body>
</html>