@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <h5 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Super Admin Panel</span>
                </h5>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}" href="{{ route('superadmin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.employees') ? 'active' : '' }}" href="{{ route('superadmin.employees') }}"><i class="bi bi-people"></i> All Employees</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.departments') ? 'active' : '' }}" href="{{ route('superadmin.departments') }}"><i class="bi bi-building"></i> Departments</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.user-roles') ? 'active' : '' }}" href="{{ route('superadmin.user-roles') }}"><i class="bi bi-person-badge"></i> User Roles</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.payroll') ? 'active' : '' }}" href="{{ route('superadmin.payroll') }}"><i class="bi bi-cash-stack"></i> Payroll Management</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.analytics') ? 'active' : '' }}" href="{{ route('superadmin.analytics') }}"><i class="bi bi-graph-up"></i> Analytics</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.security') ? 'active' : '' }}" href="{{ route('superadmin.security') }}"><i class="bi bi-shield-check"></i> System Security</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.settings') ? 'active' : '' }}" href="{{ route('superadmin.settings') }}"><i class="bi bi-gear"></i> System Settings</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.database') ? 'active' : '' }}" href="{{ route('superadmin.database') }}"><i class="bi bi-database"></i> Database</a></li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">System Analytics</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export Data</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                </div>
            </div>

            <!-- Analytics Overview -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect analytics-card">
                        <div class="card-body text-center">
                            <div class="analytics-icon bg-primary">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <h3 class="card-title mt-3">{{ $analytics['total_users'] }}</h3>
                            <p class="card-text text-muted">Total Users</p>
                            <small class="text-success">
                                <i class="bi bi-arrow-up"></i> +{{ $analytics['new_users_this_month'] }} this month
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect analytics-card">
                        <div class="card-body text-center">
                            <div class="analytics-icon bg-success">
                                <i class="bi bi-activity"></i>
                            </div>
                            <h3 class="card-title mt-3">{{ $analytics['active_sessions'] }}</h3>
                            <p class="card-text text-muted">Active Sessions</p>
                            <small class="text-info">
                                <i class="bi bi-clock"></i> Real-time
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect analytics-card">
                        <div class="card-body text-center">
                            <div class="analytics-icon bg-warning">
                                <i class="bi bi-server"></i>
                            </div>
                            <h3 class="card-title mt-3">{{ $analytics['system_uptime'] }}</h3>
                            <p class="card-text text-muted">System Uptime</p>
                            <small class="text-success">
                                <i class="bi bi-check-circle"></i> Excellent
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect analytics-card">
                        <div class="card-body text-center">
                            <div class="analytics-icon bg-info">
                                <i class="bi bi-hdd-stack"></i>
                            </div>
                            <h3 class="card-title mt-3">{{ $analytics['storage_used'] }}</h3>
                            <p class="card-text text-muted">Storage Used</p>
                            <small class="text-warning">
                                <i class="bi bi-exclamation-triangle"></i> 68% capacity
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row mb-4">
                <div class="col-lg-8 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">User Activity Trends</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="activityChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">User Roles Distribution</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="rolesChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Performance Metrics -->
            <div class="row mb-4">
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">System Performance</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">CPU Usage</label>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" style="width: 65%"></div>
                                    </div>
                                    <small class="text-muted">65% - Normal</small>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Memory Usage</label>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" style="width: 78%"></div>
                                    </div>
                                    <small class="text-muted">78% - High</small>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Disk I/O</label>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" style="width: 45%"></div>
                                    </div>
                                    <small class="text-muted">45% - Good</small>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Network</label>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" style="width: 32%"></div>
                                    </div>
                                    <small class="text-muted">32% - Good</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Recent System Events</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Backup Completed</div>
                                        <small class="text-muted">System backup finished successfully</small>
                                    </div>
                                    <span class="badge bg-success rounded-pill">Success</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Security Scan</div>
                                        <small class="text-muted">No threats detected</small>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">Info</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">System Update</div>
                                        <small class="text-muted">Update available</small>
                                    </div>
                                    <span class="badge bg-warning rounded-pill">Warning</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Database Optimization</div>
                                        <small class="text-muted">Query performance improved</small>
                                    </div>
                                    <span class="badge bg-info rounded-pill">Optimized</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup Status -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Backup & Recovery</h5>
                            <button type="button" class="btn btn-sm btn-success" onclick="initiateBackup()">
                                <i class="bi bi-shield-check"></i> Create Backup
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <div class="display-6 text-success mb-2">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </div>
                                        <h6>Backup Status</h6>
                                        <p class="text-muted">{{ $analytics['backup_status'] }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <div class="display-6 text-primary mb-2">
                                            <i class="bi bi-clock-fill"></i>
                                        </div>
                                        <h6>Last Backup</h6>
                                        <p class="text-muted">{{ $analytics['last_backup'] }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <div class="display-6 text-info mb-2">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </div>
                                        <h6>Next Scheduled</h6>
                                        <p class="text-muted">{{ date('Y-m-d H:i:s', strtotime('+1 day')) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
.sidebar {
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
    transition: all 0.3s ease;
}

.nav-link {
    transition: all 0.3s ease;
    border-radius: 5px;
    margin: 2px 8px;
}

.nav-link:hover {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white !important;
    transform: translateX(5px);
}

.nav-link.active {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white !important;
}

.card-hover-effect {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-hover-effect:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.analytics-card {
    position: relative;
    overflow: hidden;
}

.analytics-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #007bff, #0056b3);
}

.analytics-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
    font-size: 1.5rem;
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.progress {
    height: 8px;
    border-radius: 4px;
}

.list-group-item {
    border: none;
    border-bottom: 1px solid #dee2e6;
}

@media (max-width: 768px) {
    .sidebar {
        position: fixed;
        top: 0;
        left: -250px;
        height: 100vh;
        width: 250px;
        z-index: 1000;
        transition: left 0.3s ease;
    }
    
    .sidebar.show {
        left: 0;
    }
}
</style>

<script>
function initiateBackup() {
    // Show loading state
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i> Creating...';
    btn.disabled = true;
    
    // Simulate backup process
    setTimeout(() => {
        btn.innerHTML = '<i class="bi bi-check-circle"></i> Backup Complete';
        btn.classList.remove('btn-success');
        btn.classList.add('btn-outline-success');
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-outline-success');
            btn.classList.add('btn-success');
            btn.disabled = false;
        }, 2000);
    }, 3000);
}
</script>
@endsection