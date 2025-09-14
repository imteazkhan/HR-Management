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
                <h1 class="h2">System Security</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Security Report</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-warning">
                        <i class="bi bi-shield-exclamation"></i> Run Security Scan
                    </button>
                </div>
            </div>

            <!-- Security Status Overview -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect border-danger">
                        <div class="card-body text-center">
                            <div class="security-icon bg-danger">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </div>
                            <h4 class="card-title mt-3">{{ $securityStats['failed_logins_today'] }}</h4>
                            <p class="card-text text-muted">Failed Logins Today</p>
                            <small class="text-danger">Requires attention</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect border-success">
                        <div class="card-body text-center">
                            <div class="security-icon bg-success">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <h4 class="card-title mt-3">{{ $securityStats['active_sessions'] }}</h4>
                            <p class="card-text text-muted">Active Sessions</p>
                            <small class="text-success">Normal activity</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect border-primary">
                        <div class="card-body text-center">
                            <div class="security-icon bg-primary">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h4 class="card-title mt-3">{{ $securityStats['ssl_status'] }}</h4>
                            <p class="card-text text-muted">SSL Certificate</p>
                            <small class="text-success">Valid & Secure</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect border-info">
                        <div class="card-body text-center">
                            <div class="security-icon bg-info">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <h4 class="card-title mt-3">6h ago</h4>
                            <p class="card-text text-muted">Last Security Scan</p>
                            <small class="text-info">{{ $securityStats['last_security_scan'] }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Settings -->
            <div class="row mb-4">
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Security Configuration</h5>
                        </div>
                        <div class="card-body">
                            <div class="security-setting">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">Two-Factor Authentication</h6>
                                        <small class="text-muted">Require 2FA for admin users</small>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="security-setting">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">Password Policy</h6>
                                        <small class="text-muted">Enforce strong passwords</small>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="security-setting">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">Session Timeout</h6>
                                        <small class="text-muted">Auto logout after 30 minutes</small>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked>
                                    </div>
                                </div>
                            </div>
                            <div class="security-setting">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-1">IP Whitelisting</h6>
                                        <small class="text-muted">Restrict access by IP address</small>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </div>
                            </div>
                            <div class="security-setting">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Login Notifications</h6>
                                        <small class="text-muted">Email alerts for admin logins</small>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Firewall Status</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <div class="firewall-status-icon">
                                    <i class="bi bi-shield-fill-check text-success"></i>
                                </div>
                                <h4 class="text-success">{{ $securityStats['firewall_status'] }}</h4>
                                <p class="text-muted">Web Application Firewall is protecting your system</p>
                            </div>
                            <div class="firewall-stats">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <h5 class="text-success">1,247</h5>
                                        <small class="text-muted">Requests Allowed</small>
                                    </div>
                                    <div class="col-4">
                                        <h5 class="text-danger">23</h5>
                                        <small class="text-muted">Threats Blocked</small>
                                    </div>
                                    <div class="col-4">
                                        <h5 class="text-warning">5</h5>
                                        <small class="text-muted">Suspicious Activity</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Security Events -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Recent Security Events</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Time</th>
                                            <th>Event Type</th>
                                            <th>Description</th>
                                            <th>IP Address</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ now()->subMinutes(15)->format('H:i') }}</td>
                                            <td><span class="badge bg-danger">Failed Login</span></td>
                                            <td>Multiple failed login attempts</td>
                                            <td>192.168.1.105</td>
                                            <td><span class="badge bg-warning">Monitoring</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger">Block IP</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ now()->subHours(1)->format('H:i') }}</td>
                                            <td><span class="badge bg-success">Successful Login</span></td>
                                            <td>Admin user logged in</td>
                                            <td>10.0.0.1</td>
                                            <td><span class="badge bg-success">Normal</span></td>
                                            <td>-</td>
                                        </tr>
                                        <tr>
                                            <td>{{ now()->subHours(2)->format('H:i') }}</td>
                                            <td><span class="badge bg-warning">Suspicious Activity</span></td>
                                            <td>Unusual API access pattern</td>
                                            <td>203.45.67.89</td>
                                            <td><span class="badge bg-info">Investigated</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">Details</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ now()->subHours(4)->format('H:i') }}</td>
                                            <td><span class="badge bg-primary">Security Scan</span></td>
                                            <td>Automated security scan completed</td>
                                            <td>System</td>
                                            <td><span class="badge bg-success">Passed</span></td>
                                            <td>-</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup Encryption -->
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Backup Encryption</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="encryption-icon mb-3">
                                <i class="bi bi-lock-fill text-success"></i>
                            </div>
                            <h4>{{ $securityStats['backup_encryption'] }}</h4>
                            <p class="text-muted">Your backups are encrypted with industry-standard encryption</p>
                            <button class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-gear"></i> Configure
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Security Recommendations</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    SSL certificate is valid and up to date
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Strong password policy is enforced
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                                    Consider enabling IP whitelisting
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-info-circle-fill text-info me-2"></i>
                                    Regular security scans are recommended
                                </li>
                            </ul>
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

.security-icon {
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

.firewall-status-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.encryption-icon {
    font-size: 3rem;
}

.security-setting {
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.security-setting:last-child {
    border-bottom: none;
}

.form-check-input:checked {
    background-color: #28a745;
    border-color: #28a745;
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
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
@endsection