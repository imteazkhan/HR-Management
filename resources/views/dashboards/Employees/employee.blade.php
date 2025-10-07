<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Dashboard</title>
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
            <li class="nav-item"><a class="nav-link active" href="{{ route('employee.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('employee.profile') }}"><i class="bi bi-person-badge"></i> My Profile</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('employee.attendance') }}"><i class="bi bi-clock-history"></i> Attendance</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('employee.payslips') }}"><i class="bi bi-cash-stack"></i> Payroll</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('employee.leave-request') }}"><i class="bi bi-journal-text"></i> Leave Requests</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-briefcase-fill text-primary"></i> Employee Dashboard</h2>
            <div class="d-flex align-items-center">
                <span class="me-3">Welcome, {{ Auth::user()->name }}!</span>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('employee.profile') }}"><i class="bi bi-person"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout.confirm') }}"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Key Metrics -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card stat-card p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Leave Balance</h6>
                            <h2>{{ $stats['leave_balance'] ?? 12 }} days</h2>
                        </div>
                        <i class="bi bi-calendar-check fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card-2 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">This Month Salary</h6>
                            <h2>BDT {{ $stats['salary_this_month'] ?? '3,200' }}</h2>
                        </div>
                        <i class="bi bi-cash fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card-3 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Pending Tasks</h6>
                            <h2>{{ $stats['pending_tasks'] ?? 3 }}</h2>
                        </div>
                        <i class="bi bi-list-check fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card-4 p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Worked This Week</h6>
                            <h2>{{ $stats['hours_this_week'] ?? 40 }} hrs</h2>
                        </div>
                        <i class="bi bi-clock-history fs-1 opacity-50"></i>
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
                                        @php
                                            $today = date('Y-m-d');
                                            $attendance = DB::table('employee_attendances')
                                                ->where('user_id', Auth::id())
                                                ->where('date', $today)
                                                ->first();
                                        @endphp
                                        
                                        @if(!$attendance || !$attendance->check_in)
                                            <form action="{{ route('employee.clock') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="action" value="in">
                                                <button type="submit" class="btn btn-sm btn-success w-100">
                                                    <i class="bi bi-play-circle"></i> Check In
                                                </button>
                                            </form>
                                        @elseif(!$attendance->check_out)
                                            <form action="{{ route('employee.clock') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="action" value="out">
                                                <button type="submit" class="btn btn-sm btn-danger w-100">
                                                    <i class="bi bi-stop-circle"></i> Check Out
                                                </button>
                                            </form>
                                            <small class="text-success d-block mt-1">
                                                Checked in: {{ date('g:i A', strtotime($attendance->check_in)) }}
                                            </small>
                                        @else
                                            <button class="btn btn-sm btn-secondary w-100" disabled>
                                                <i class="bi bi-check-circle"></i> Completed
                                            </button>
                                            <small class="text-muted d-block mt-1">
                                                {{ date('g:i A', strtotime($attendance->check_in)) }} - {{ date('g:i A', strtotime($attendance->check_out)) }}
                                            </small>
                                        @endif
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
                        @if(isset($recentActivities) && count($recentActivities) > 0)
                            @foreach($recentActivities as $activity)
                                <div class="activity-item">
                                    <i class="bi bi-{{ $activity['icon'] }} text-{{ $activity['color'] }} me-3"></i>
                                    {{ $activity['message'] }}
                                    <small class="text-muted d-block">{{ $activity['time'] }}</small>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-clock-history fs-1 text-muted"></i>
                                <p class="text-muted mt-2">No recent activities</p>
                            </div>
                        @endif
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
</body>
</html>