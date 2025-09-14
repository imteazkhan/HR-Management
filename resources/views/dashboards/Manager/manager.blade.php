<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manager Dashboard - HR Management</title>
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
            transform: translateX(5px);
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
        
        /* Table Row Hover Effects */
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.01);
            transition: all 0.2s ease;
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
        
        /* Quick Action Cards */
        .quick-action-card {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            cursor: pointer;
        }
        .quick-action-card:hover {
            border-color: #007bff;
            box-shadow: 0 4px 15px rgba(0,123,255,0.15);
            transform: translateY(-2px);
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
            <span class="fw-bold">Manager Dashboard</span>
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
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}" href="{{ route('manager.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('manager.team') ? 'active' : '' }}" href="{{ route('manager.team') }}"><i class="bi bi-people"></i> My Team</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('manager.attendance') ? 'active' : '' }}" href="{{ route('manager.attendance') }}"><i class="bi bi-person-badge"></i> Team Attendance</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('manager.leave-requests') ? 'active' : '' }}" href="{{ route('manager.leave-requests') }}"><i class="bi bi-calendar-event"></i> Leave Approvals</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('manager.performance') ? 'active' : '' }}" href="{{ route('manager.performance') }}"><i class="bi bi-graph-up"></i> Team Performance</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('manager.reports') ? 'active' : '' }}" href="{{ route('manager.reports') }}"><i class="bi bi-clipboard-data"></i> Reports</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('manager.messages') ? 'active' : '' }}" href="{{ route('manager.messages') }}"><i class="bi bi-chat-dots"></i> Team Messages</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('manager.notifications') ? 'active' : '' }}" href="{{ route('manager.notifications') }}"><i class="bi bi-bell"></i> Notifications</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('manager.settings') ? 'active' : '' }}" href="{{ route('manager.settings') }}"><i class="bi bi-gear"></i> Settings</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 d-none d-lg-flex">
            <h2><i class="bi bi-people-fill text-primary"></i> Manager Dashboard</h2>
            <div class="d-flex align-items-center">
                <span class="me-3 d-none d-md-inline">Welcome, {{ Auth::user()->name }}!</span>
                 <span class="me-3 d-none d-md-inline">|| {{ now ()-> format ('i,F j,Y') }}</span>
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
            <p class="text-muted mb-0">Manage your team effectively</p>
        </div>

        <!-- Key Metrics -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card stat-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Team Members</h6>
                            <h2>{{ $stats['employees'] ?? 15 }}</h2>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-2 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Present Today</h6>
                            <h2>{{ $stats['attendance_today'] ?? 12 }}</h2>
                        </div>
                        <i class="bi bi-calendar-check fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-3 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Pending Approvals</h6>
                            <h2>{{ $stats['departments'] ?? 5 }}</h2>
                        </div>
                        <i class="bi bi-clock-history fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-4 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Team Performance</h6>
                            <h2>87%</h2>
                        </div>
                        <i class="bi bi-graph-up fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Manager Tools -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="bi bi-tools"></i> Management Tools</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center p-3 border rounded h-100">
                                    <i class="bi bi-people-fill fs-2 text-success me-3 d-none d-lg-block"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Team Management</h6>
                                        <p class="text-muted mb-2 small">View and manage team members</p>
                                        <button class="btn btn-sm btn-success w-100">Manage Team</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center p-3 border rounded h-100">
                                    <i class="bi bi-check-circle fs-2 text-info me-3 d-none d-lg-block"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Approve Leaves</h6>
                                        <p class="text-muted mb-2 small">Review leave requests</p>
                                        <button class="btn btn-sm btn-info w-100">Review (5)</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center p-3 border rounded h-100">
                                    <i class="bi bi-graph-up-arrow fs-2 text-warning me-3 d-none d-lg-block"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Performance Review</h6>
                                        <p class="text-muted mb-2 small">Evaluate team performance</p>
                                        <button class="btn btn-sm btn-warning w-100">Review</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center p-3 border rounded h-100">
                                    <i class="bi bi-clipboard-data fs-2 text-danger me-3 d-none d-lg-block"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Generate Reports</h6>
                                        <p class="text-muted mb-2 small">Team productivity reports</p>
                                        <button class="btn btn-sm btn-outline-danger w-100">Generate</button>
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
                    <div class="card-header"><h5><i class="bi bi-clock-history"></i> Team Activity</h5></div>
                    <div class="card-body recent-activity">
                        <div class="activity-item"><i class="bi bi-person-check text-success me-3"></i> <strong>John Smith</strong> clocked in <small class="text-muted d-block">2 hours ago</small></div>
                        <div class="activity-item"><i class="bi bi-calendar-event text-info me-3"></i> <strong>Sarah Lee</strong> submitted leave request <small class="text-muted d-block">4 hours ago</small></div>
                        <div class="activity-item"><i class="bi bi-check-circle text-warning me-3"></i> <strong>Mike Davis</strong> completed project milestone <small class="text-muted d-block">6 hours ago</small></div>
                        <div class="activity-item"><i class="bi bi-award text-primary me-3"></i> Team performance review scheduled for <strong>Finance Team</strong> <small class="text-muted d-block">Yesterday</small></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header"><h5><i class="bi bi-graph-up"></i> Team Overview</h5></div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3"><span>Present Today</span><span class="badge bg-success">12/15</span></div>
                        <div class="d-flex justify-content-between mb-3"><span>Pending Approvals</span><span class="badge bg-warning">5</span></div>
                        <div class="d-flex justify-content-between mb-3"><span>Completed Tasks</span><span class="badge bg-info">28</span></div>
                        <div class="d-flex justify-content-between"><span>Team Performance</span><span class="text-success fw-bold">87%</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Mobile sidebar toggle
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    });
    
    // Close sidebar when overlay is clicked
    document.getElementById('sidebarOverlay').addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    });
</script>
</body>
</html>
