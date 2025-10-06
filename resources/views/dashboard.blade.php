<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HR Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { background: #f8f9fa; }
        .sidebar { background: #2c3e50; min-height: 100vh; position: fixed; top: 0; left: 0; width: 250px; z-index: 1000; }
        .sidebar .nav-link { color: #ecf0f1; padding: 12px 20px; transition: all 0.3s; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: #34495e; color: #fff; }
        .sidebar .nav-link i { width: 20px; margin-right: 10px; }
        .main-content { margin-left: 250px; padding: 20px; }
        .card { border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); transition: transform 0.2s; }
        .card:hover { transform: translateY(-2px); }
        .stat-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .stat-card-2 { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
        .stat-card-3 { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
        .stat-card-4 { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; }
        .navbar-brand { font-weight: 700; font-size: 1.5rem; color: #fff !important; }
        .recent-activity { max-height: 400px; overflow-y: auto; }
        .activity-item { padding: 10px 0; border-bottom: 1px solid #eee; }
        .activity-item:last-child { border-bottom: none; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="p-3">
            <a class="navbar-brand" href="{{route ('home')}}">
                <i class="bi bi-briefcase"></i> iK soft
            </a>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link active" href="#"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-people"></i> Employees</a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-person-badge"></i> Departments</a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-calendar-event"></i> Attendance</a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-cash-stack"></i> Payroll</a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-award"></i> Performance</a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-journal-text"></i> Leave Requests</a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-graph-up"></i> Reports</a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-bell"></i> Notifications</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-briefcase-fill text-primary"></i> HR Dashboard</h2>
            <div class="d-flex align-items-center">
                <span class="me-3">Welcome, {{ Auth::user()->name }}!</span>
                <span class="me-3 d-none d-xl-inline">{{ now()->format('l, F j, Y') }}</span>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
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
                <div class="card stat-card p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Employees</h6>
                            <h2>{{ $stats['employees'] ?? 0 }}</h2>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card-2 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Departments</h6>
                            <h2>{{ $stats['departments'] ?? 0 }}</h2>
                        </div>
                        <i class="bi bi-building fs-1 opacity-50"> </i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card-3 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Active Attendance</h6>
                            <h2>{{ $stats['attendance_today'] ?? 0 }}</h2>
                        </div>
                        <i class="bi bi-calendar-check fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card-4 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Payroll Processed</h6>
                            <h2>${{ $stats['payroll_today'] ?? 0 }}</h2>
                        </div>
                        <i class="bi bi-cash fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- HR Responsibilities -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="bi bi-clipboard-check"></i> HR Responsibilities</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 border rounded">
                                    <i class="bi bi-person-plus fs-2 text-success me-3"></i>
                                    <div>
                                        <h6 class="mb-1">Recruitment & Onboarding</h6>
                                        <p class="text-muted mb-0">Approve or reject new employee applications</p>
                                        <button class="btn btn-sm btn-outline-success mt-2">Manage</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 border rounded">
                                    <i class="bi bi-person-lines-fill fs-2 text-info me-3"></i>
                                    <div>
                                        <h6 class="mb-1">Employee Management</h6>
                                        <p class="text-muted mb-0">View, edit, and manage employee records</p>
                                        <button class="btn btn-sm btn-outline-info mt-2">Manage</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 border rounded">
                                    <i class="bi bi-cash-coin fs-2 text-warning me-3"></i>
                                    <div>
                                        <h6 class="mb-1">Payroll & Salary</h6>
                                        <p class="text-muted mb-0">Process and manage employee salaries</p>
                                        <button class="btn btn-sm btn-outline-warning mt-2">View</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 border rounded">
                                    <i class="bi bi-megaphone fs-2 text-danger me-3"></i>
                                    <div>
                                        <h6 class="mb-1">Announcements</h6>
                                        <p class="text-muted mb-0">Send company-wide announcements</p>
                                        <button class="btn btn-sm btn-outline-danger mt-2">Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row g-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h5><i class="bi bi-clock-history"></i> Recent Activity</h5></div>
                    <div class="card-body recent-activity">
                        <div class="activity-item"><i class="bi bi-person-plus text-success me-3"></i> New employee added: <strong>Jane Doe</strong> <small class="text-muted d-block">2 hours ago</small></div>
                        <div class="activity-item"><i class="bi bi-calendar-event text-info me-3"></i> Leave request submitted by <strong>John Smith</strong> <small class="text-muted d-block">4 hours ago</small></div>
                        <div class="activity-item"><i class="bi bi-award text-warning me-3"></i> Performance review completed for <strong>Sarah Lee</strong> <small class="text-muted d-block">6 hours ago</small></div>
                        <div class="activity-item"><i class="bi bi-cash-stack text-primary me-3"></i> Payroll processed: <strong>BDT 4,500</strong> for Finance Dept. <small class="text-muted d-block">8 hours ago</small></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"><h5><i class="bi bi-graph-up"></i> Quick Stats</h5></div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3"><span>Pending Applications</span><span class="badge bg-warning">7</span></div>
                        <div class="d-flex justify-content-between mb-3"><span>Active Employees</span><span class="badge bg-success">120</span></div>
                        <div class="d-flex justify-content-between mb-3"><span>Leave Requests</span><span class="badge bg-danger">3</span></div>
                        <div class="d-flex justify-content-between"><span>Payroll Today</span><span class="text-success fw-bold">BDT 15,200</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
