<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employees Dashboard</title>
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
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
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
            transform: translateY(-8px) scale(1.02); 
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
            transition: all 0.3s ease;
        }
        .activity-item:hover {
            background-color: #f8f9fa;
            padding-left: 10px;
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
            transition: all 0.3s ease;
            border-radius: 8px;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .btn:active {
            transform: translateY(0);
        }
        
        /* Quick Action Cards */
        .border.rounded {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef !important;
        }
        .border.rounded:hover {
            border-color: #007bff !important;
            box-shadow: 0 4px 15px rgba(0,123,255,0.15);
            transform: translateY(-2px);
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
        
        /* Badge Animations */
        .badge {
            transition: all 0.3s ease;
        }
        .badge:hover {
            transform: scale(1.1);
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
                justify-content: space-between;
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
            .d-none.d-lg-block {
                display: none !important;
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
            .d-none.d-md-inline {
                display: none !important;
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
        
        /* Loading State */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .spin {
            animation: spin 1s linear infinite;
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
            <span class="fw-bold">Employee Panel</span>
        </div>
        <div class="ms-auto">
            <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('employee.profile') }}"><i class="bi bi-person"></i> Profile</a></li>
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
            <a class="navbar-brand" href="{{route ('home')}}">
                <i class="bi bi-briefcase"></i> iK soft
            </a>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}" href="{{ route('employee.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.employees') ? 'active' : '' }}" href="{{ route('superadmin.employees') }}"><i class="bi bi-people"></i> Employees</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.departments') ? 'active' : '' }}" href="{{ route('superadmin.departments') }}"><i class="bi bi-person-badge"></i> Departments</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('employee.attendance') ? 'active' : '' }}" href="{{ route('employee.attendance') }}"><i class="bi bi-calendar-event"></i> Attendance</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('employee.payslips') ? 'active' : '' }}" href="{{ route('employee.payslips') }}"><i class="bi bi-cash-stack"></i> Payroll</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('employee.profile') ? 'active' : '' }}" href="{{ route('employee.profile') }}"><i class="bi bi-award"></i> Performance</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('employee.leave-request') ? 'active' : '' }}" href="{{ route('employee.leave-request') }}"><i class="bi bi-journal-text"></i> Leave Requests</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.analytics') ? 'active' : '' }}" href="{{ route('superadmin.analytics') }}"><i class="bi bi-graph-up"></i> Reports</a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-bell"></i> Notifications</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h2 class="mb-2 mb-md-0"><i class="bi bi-briefcase-fill text-primary"></i> Employee Dashboard</h2>
            <div class="d-flex align-items-center flex-wrap">
                <span class="me-3 d-none d-lg-inline">Welcome, {{ Auth::user()->name }}!</span>
                <span class="me-3 d-none d-xl-inline">{{ now()->format('l, F j, Y') }}</span>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        <span class="d-none d-sm-inline ms-1">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('employee.profile') }}"><i class="bi bi-person"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout.confirm') }}"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card stat-card p-4 fade-in-up">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Employees</h6>
                            <h2>{{ $stats['employees'] }}</h2>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card-2 p-4 fade-in-up">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Departments</h6>
                            <h2>{{ $stats['departments'] }}</h2>
                        </div>
                        <i class="bi bi-building fs-1 opacity-50"> </i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card-3 p-4 fade-in-up">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Active Attendance</h6>
                            <h2>{{ $stats['attendance_today'] ?? 15 }}</h2>
                        </div>
                        <i class="bi bi-calendar-check fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card-4 p-4 fade-in-up">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Payroll Processed</h6>
                            <h2>${{ $stats['payroll_today'] ?? '3,200' }}</h2>
                        </div>
                        <i class="bi bi-cash fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employee Quick Actions -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="bi bi-lightning-charge"></i> Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center p-3 border rounded h-100">
                                    <i class="bi bi-clock-history fs-2 text-success me-3 d-none d-lg-block"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Clock In/Out</h6>
                                        <p class="text-muted mb-2 small">Track your attendance</p>
                                        <form action="{{ route('employee.clock') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="action" value="in">
                                            <button type="submit" class="btn btn-sm btn-success w-100">Clock In</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center p-3 border rounded h-100">
                                    <i class="bi bi-calendar-plus fs-2 text-info me-3 d-none d-lg-block"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Request Leave</h6>
                                        <p class="text-muted mb-2 small">Submit leave application</p>
                                        <a href="{{ route('employee.leave-request') }}" class="btn btn-sm btn-info w-100">Apply</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center p-3 border rounded h-100">
                                    <i class="bi bi-file-earmark-text fs-2 text-warning me-3 d-none d-lg-block"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">View Payslip</h6>
                                        <p class="text-muted mb-2 small">Download salary details</p>
                                        <a href="{{ route('employee.payslips') }}" class="btn btn-sm btn-warning w-100">View</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center p-3 border rounded h-100">
                                    <i class="bi bi-person-badge fs-2 text-danger me-3 d-none d-lg-block"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Update Profile</h6>
                                        <p class="text-muted mb-2 small">Edit personal information</p>
                                        <a href="{{ route('employee.profile') }}" class="btn btn-sm btn-outline-danger w-100">Update</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row g-3 g-md-4">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header"><h5><i class="bi bi-clock-history"></i> My Recent Activity</h5></div>
                    <div class="card-body recent-activity">
                        <div class="activity-item"><i class="bi bi-check-circle text-success me-3"></i> Completed task: <strong>Monthly Report</strong> <small class="text-muted d-block">2 hours ago</small></div>
                        <div class="activity-item"><i class="bi bi-calendar-event text-info me-3"></i> Submitted leave request for <strong>Dec 25-26</strong> <small class="text-muted d-block">4 hours ago</small></div>
                        <div class="activity-item"><i class="bi bi-clock text-warning me-3"></i> Clocked in at <strong>9:00 AM</strong> <small class="text-muted d-block">Today</small></div>
                        <div class="activity-item"><i class="bi bi-file-earmark-text text-primary me-3"></i> Downloaded payslip for <strong>November 2024</strong> <small class="text-muted d-block">Yesterday</small></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header"><h5><i class="bi bi-graph-up"></i> My Stats</h5></div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3"><span>Pending Tasks</span><span class="badge bg-warning">3</span></div>
                        <div class="d-flex justify-content-between mb-3"><span>Completed This Week</span><span class="badge bg-success">12</span></div>
                        <div class="d-flex justify-content-between mb-3"><span>Leave Balance</span><span class="badge bg-info">12 days</span></div>
                        <div class="d-flex justify-content-between"><span>This Month Salary</span><span class="text-success fw-bold">BDT 3,200</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Mobile sidebar toggle
    document.addEventListener('DOMContentLoaded', function() {
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
        
        // Add fade-in animation to cards
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('fade-in-up');
        });
        
        // Add pulse animation to important metrics
        const statCards = document.querySelectorAll('.stat-card, .stat-card-2, .stat-card-3, .stat-card-4');
        statCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.classList.add('pulse-animation');
            });
            card.addEventListener('mouseleave', function() {
                this.classList.remove('pulse-animation');
            });
        });
    });
</script>
</body>
</html>
