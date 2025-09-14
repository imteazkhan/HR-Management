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
                <h1 class="h2">Database Management</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export Database</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" onclick="createBackup()">
                        <i class="bi bi-download"></i> Create Backup
                    </button>
                </div>
            </div>

            <!-- Database Status Overview -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect border-primary">
                        <div class="card-body text-center">
                            <div class="database-icon bg-primary">
                                <i class="bi bi-database-fill"></i>
                            </div>
                            <h4 class="card-title mt-3">{{ $databaseStats['total_tables'] }}</h4>
                            <p class="card-text text-muted">Total Tables</p>
                            <small class="text-success">All tables healthy</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect border-success">
                        <div class="card-body text-center">
                            <div class="database-icon bg-success">
                                <i class="bi bi-files"></i>
                            </div>
                            <h4 class="card-title mt-3">{{ $databaseStats['total_records'] }}</h4>
                            <p class="card-text text-muted">Total Records</p>
                            <small class="text-info">Active data</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect border-info">
                        <div class="card-body text-center">
                            <div class="database-icon bg-info">
                                <i class="bi bi-hdd-stack"></i>
                            </div>
                            <h4 class="card-title mt-3">{{ $databaseStats['database_size'] }}</h4>
                            <p class="card-text text-muted">Database Size</p>
                            <small class="text-warning">68% capacity</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect border-warning">
                        <div class="card-body text-center">
                            <div class="database-icon bg-warning">
                                <i class="bi bi-wifi"></i>
                            </div>
                            <h4 class="card-title mt-3">{{ $databaseStats['connection_status'] }}</h4>
                            <p class="card-text text-muted">Connection Status</p>
                            <small class="text-success">Healthy connection</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Database Tables Overview -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Database Tables</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Table Name</th>
                                            <th>Records</th>
                                            <th>Size</th>
                                            <th>Last Updated</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-table me-2 text-primary"></i>
                                                    <strong>users</strong>
                                                </div>
                                            </td>
                                            <td>{{ $databaseStats['total_records'] - 100 }}</td>
                                            <td>245 KB</td>
                                            <td>{{ now()->subMinutes(15)->format('M d, H:i') }}</td>
                                            <td><span class="badge bg-success">Healthy</span></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-table me-2 text-primary"></i>
                                                    <strong>leave_requests</strong>
                                                </div>
                                            </td>
                                            <td>45</td>
                                            <td>89 KB</td>
                                            <td>{{ now()->subHours(2)->format('M d, H:i') }}</td>
                                            <td><span class="badge bg-success">Healthy</span></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-table me-2 text-primary"></i>
                                                    <strong>attendance</strong>
                                                </div>
                                            </td>
                                            <td>320</td>
                                            <td>156 KB</td>
                                            <td>{{ now()->subHours(1)->format('M d, H:i') }}</td>
                                            <td><span class="badge bg-success">Healthy</span></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-table me-2 text-primary"></i>
                                                    <strong>departments</strong>
                                                </div>
                                            </td>
                                            <td>8</td>
                                            <td>12 KB</td>
                                            <td>{{ now()->subDays(3)->format('M d, H:i') }}</td>
                                            <td><span class="badge bg-success">Healthy</span></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup Management -->
            <div class="row mb-4">
                <div class="col-lg-8 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Recent Backups</h5>
                        </div>
                        <div class="card-body">
                            <div class="backup-item">
                                <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="backup-icon me-3">
                                            <i class="bi bi-archive-fill text-success"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Full Database Backup</h6>
                                            <small class="text-muted">{{ $databaseStats['last_backup'] }}</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-success me-2">{{ $databaseStats['backup_size'] }}</span>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-download"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="backup-item">
                                <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="backup-icon me-3">
                                            <i class="bi bi-archive-fill text-info"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Scheduled Backup</h6>
                                            <small class="text-muted">{{ now()->subDays(7)->format('M d, Y H:i:s') }}</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-info me-2">1.6 MB</span>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-download"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="backup-item">
                                <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="backup-icon me-3">
                                            <i class="bi bi-archive-fill text-warning"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Manual Backup</h6>
                                            <small class="text-muted">{{ now()->subDays(14)->format('M d, Y H:i:s') }}</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-warning me-2">1.4 MB</span>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-download"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Database Tools</h5>
                        </div>
                        <div class="card-body">
                            <div class="database-tool mb-3">
                                <div class="text-center">
                                    <div class="tool-icon bg-primary mb-2">
                                        <i class="bi bi-speedometer2"></i>
                                    </div>
                                    <h6>Optimize Database</h6>
                                    <p class="text-muted small">Optimize all tables for better performance</p>
                                    <button class="btn btn-outline-primary btn-sm" onclick="optimizeDatabase()">
                                        Optimize Now
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <div class="database-tool mb-3">
                                <div class="text-center">
                                    <div class="tool-icon bg-success mb-2">
                                        <i class="bi bi-check-circle"></i>
                                    </div>
                                    <h6>Repair Tables</h6>
                                    <p class="text-muted small">Check and repair database tables</p>
                                    <button class="btn btn-outline-success btn-sm" onclick="repairTables()">
                                        Check & Repair
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <div class="database-tool">
                                <div class="text-center">
                                    <div class="tool-icon bg-warning mb-2">
                                        <i class="bi bi-trash"></i>
                                    </div>
                                    <h6>Clean Up</h6>
                                    <p class="text-muted small">Remove old logs and temporary data</p>
                                    <button class="btn btn-outline-warning btn-sm" onclick="cleanupDatabase()">
                                        Clean Up
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Database Configuration -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Database Configuration</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label class="form-label">Database Engine</label>
                                    <p class="fw-bold">MySQL 8.0</p>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label class="form-label">Character Set</label>
                                    <p class="fw-bold">utf8mb4_unicode_ci</p>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label class="form-label">Max Connections</label>
                                    <p class="fw-bold">151</p>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <label class="form-label">Query Cache</label>
                                    <p class="fw-bold text-success">Enabled</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="form-label">Performance Metrics</label>
                                    <div class="mt-2">
                                        <div class="d-flex justify-content-between">
                                            <small>Query Time</small>
                                            <small>0.23ms avg</small>
                                        </div>
                                        <div class="progress mb-2">
                                            <div class="progress-bar bg-success" style="width: 25%"></div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <small>Connection Pool</small>
                                            <small>45/151 used</small>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-primary" style="width: 30%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label">Storage Information</label>
                                    <div class="mt-2">
                                        <div class="d-flex justify-content-between">
                                            <small>Used Space</small>
                                            <small>{{ $databaseStats['database_size'] }}</small>
                                        </div>
                                        <div class="progress mb-2">
                                            <div class="progress-bar bg-info" style="width: 68%"></div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <small>Index Size</small>
                                            <small>0.8 MB</small>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" style="width: 35%"></div>
                                        </div>
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

.database-icon {
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

.backup-icon {
    font-size: 1.5rem;
}

.tool-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
    font-size: 1.2rem;
}

.database-tool {
    padding: 15px;
    border: 1px solid #eee;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.database-tool:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.backup-item .border:hover {
    border-color: #007bff !important;
    box-shadow: 0 2px 8px rgba(0,123,255,0.15);
    transition: all 0.3s ease;
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.progress {
    height: 6px;
    border-radius: 3px;
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
function createBackup() {
    performDatabaseAction('Create Backup', 'Backup created successfully!');
}

function optimizeDatabase() {
    performDatabaseAction('Optimize Database', 'Database optimized successfully!');
}

function repairTables() {
    performDatabaseAction('Repair Tables', 'All tables checked and repaired!');
}

function cleanupDatabase() {
    performDatabaseAction('Database Cleanup', 'Database cleanup completed!');
}

function performDatabaseAction(action, successMessage) {
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i> Working...';
    btn.disabled = true;
    
    setTimeout(() => {
        btn.innerHTML = '<i class="bi bi-check-circle"></i> Complete';
        btn.classList.add('btn-success');
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.disabled = false;
        }, 2000);
    }, 3000);
}
</script>
@endsection