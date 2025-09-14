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
                <h1 class="h2">System Settings</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-sm btn-success" onclick="saveSettings()">
                        <i class="bi bi-check-circle"></i> Save Settings
                    </button>
                </div>
            </div>

            <form action="{{ route('superadmin.settings.update') }}" method="POST" id="settingsForm">
                @csrf
                @method('PATCH')
                
                <!-- General Settings -->
                <div class="row mb-4">
                    <div class="col-lg-6 mb-4">
                        <div class="card settings-card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-gear-fill me-2"></i>General Settings
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="siteName" class="form-label">Site Name</label>
                                    <input type="text" class="form-control" id="siteName" name="site_name" value="{{ $settings['site_name'] }}">
                                </div>
                                <div class="mb-3">
                                    <label for="companyName" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="companyName" name="company_name" value="{{ $settings['company_name'] }}">
                                </div>
                                <div class="mb-3">
                                    <label for="timezone" class="form-label">Timezone</label>
                                    <select class="form-select" id="timezone" name="timezone">
                                        <option value="UTC" {{ $settings['timezone'] === 'UTC' ? 'selected' : '' }}>UTC</option>
                                        <option value="America/New_York" {{ $settings['timezone'] === 'America/New_York' ? 'selected' : '' }}>Eastern Time</option>
                                        <option value="America/Chicago" {{ $settings['timezone'] === 'America/Chicago' ? 'selected' : '' }}>Central Time</option>
                                        <option value="America/Denver" {{ $settings['timezone'] === 'America/Denver' ? 'selected' : '' }}>Mountain Time</option>
                                        <option value="America/Los_Angeles" {{ $settings['timezone'] === 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="currency" class="form-label">Default Currency</label>
                                    <select class="form-select" id="currency" name="currency">
                                        <option value="USD" {{ $settings['currency'] === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                        <option value="EUR" {{ $settings['currency'] === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                        <option value="GBP" {{ $settings['currency'] === 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                        <option value="CAD" {{ $settings['currency'] === 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 mb-4">
                        <div class="card settings-card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-clock-fill me-2"></i>Working Hours
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="workingHoursStart" class="form-label">Start Time</label>
                                    <input type="time" class="form-control" id="workingHoursStart" name="working_hours_start" value="{{ $settings['working_hours_start'] }}">
                                </div>
                                <div class="mb-3">
                                    <label for="workingHoursEnd" class="form-label">End Time</label>
                                    <input type="time" class="form-control" id="workingHoursEnd" name="working_hours_end" value="{{ $settings['working_hours_end'] }}">
                                </div>
                                <div class="mb-3">
                                    <label for="annualLeaveDays" class="form-label">Annual Leave Days</label>
                                    <input type="number" class="form-control" id="annualLeaveDays" name="annual_leave_days" value="{{ $settings['annual_leave_days'] }}" min="0" max="365">
                                </div>
                                <div class="working-hours-preview">
                                    <div class="alert alert-info">
                                        <small>
                                            <i class="bi bi-info-circle me-1"></i>
                                            Standard working day: {{ $settings['working_hours_start'] }} - {{ $settings['working_hours_end'] }}
                                            ({{ round((strtotime($settings['working_hours_end']) - strtotime($settings['working_hours_start'])) / 3600) }} hours)
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email Settings -->
                <div class="row mb-4">
                    <div class="col-lg-6 mb-4">
                        <div class="card settings-card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-envelope-fill me-2"></i>Email Configuration
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="smtpHost" class="form-label">SMTP Host</label>
                                    <input type="text" class="form-control" id="smtpHost" name="smtp_host" placeholder="smtp.gmail.com">
                                </div>
                                <div class="mb-3">
                                    <label for="smtpPort" class="form-label">SMTP Port</label>
                                    <input type="number" class="form-control" id="smtpPort" name="smtp_port" value="587">
                                </div>
                                <div class="mb-3">
                                    <label for="smtpUsername" class="form-label">SMTP Username</label>
                                    <input type="email" class="form-control" id="smtpUsername" name="smtp_username">
                                </div>
                                <div class="mb-3">
                                    <label for="smtpPassword" class="form-label">SMTP Password</label>
                                    <input type="password" class="form-control" id="smtpPassword" name="smtp_password">
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="testEmailConnection()">
                                    <i class="bi bi-send"></i> Test Connection
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 mb-4">
                        <div class="card settings-card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-bell-fill me-2"></i>Notification Settings
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="notification-setting">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h6 class="mb-1">Email Notifications</h6>
                                            <small class="text-muted">Send email alerts for important events</small>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" checked>
                                        </div>
                                    </div>
                                </div>
                                <div class="notification-setting">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h6 class="mb-1">Leave Request Alerts</h6>
                                            <small class="text-muted">Notify managers of new leave requests</small>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" checked>
                                        </div>
                                    </div>
                                </div>
                                <div class="notification-setting">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h6 class="mb-1">System Maintenance</h6>
                                            <small class="text-muted">Alert users about scheduled maintenance</small>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </div>
                                </div>
                                <div class="notification-setting">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">Payroll Reminders</h6>
                                            <small class="text-muted">Monthly payroll processing reminders</small>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" checked>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Preferences -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card settings-card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-sliders me-2"></i>System Preferences
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 mb-3">
                                        <label for="dateFormat" class="form-label">Date Format</label>
                                        <select class="form-select" id="dateFormat" name="date_format">
                                            <option value="Y-m-d" {{ $settings['date_format'] === 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                            <option value="m/d/Y" {{ $settings['date_format'] === 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                                            <option value="d/m/Y" {{ $settings['date_format'] === 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                                            <option value="M d, Y" {{ $settings['date_format'] === 'M d, Y' ? 'selected' : '' }}>Mon DD, YYYY</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label for="recordsPerPage" class="form-label">Records Per Page</label>
                                        <select class="form-select" id="recordsPerPage" name="records_per_page">
                                            <option value="10">10</option>
                                            <option value="15" selected>15</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label for="sessionTimeout" class="form-label">Session Timeout (minutes)</label>
                                        <select class="form-select" id="sessionTimeout" name="session_timeout">
                                            <option value="15">15</option>
                                            <option value="30" selected>30</option>
                                            <option value="60">60</option>
                                            <option value="120">120</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Maintenance -->
                <div class="row">
                    <div class="col-12">
                        <div class="card settings-card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-tools me-2"></i>System Maintenance
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 text-center mb-3">
                                        <div class="maintenance-action">
                                            <div class="maintenance-icon bg-primary">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </div>
                                            <h6 class="mt-2">Clear Cache</h6>
                                            <p class="text-muted small">Clear application cache to improve performance</p>
                                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="clearCache()">
                                                Clear Now
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 text-center mb-3">
                                        <div class="maintenance-action">
                                            <div class="maintenance-icon bg-success">
                                                <i class="bi bi-database"></i>
                                            </div>
                                            <h6 class="mt-2">Optimize Database</h6>
                                            <p class="text-muted small">Optimize database tables for better performance</p>
                                            <button type="button" class="btn btn-outline-success btn-sm" onclick="optimizeDatabase()">
                                                Optimize
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 text-center mb-3">
                                        <div class="maintenance-action">
                                            <div class="maintenance-icon bg-warning">
                                                <i class="bi bi-download"></i>
                                            </div>
                                            <h6 class="mt-2">System Backup</h6>
                                            <p class="text-muted small">Create a full system backup</p>
                                            <button type="button" class="btn btn-outline-warning btn-sm" onclick="createBackup()">
                                                Backup Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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

.settings-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.settings-card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

.notification-setting {
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.notification-setting:last-child {
    border-bottom: none;
}

.maintenance-action {
    padding: 20px;
    border: 1px solid #eee;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.maintenance-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.maintenance-icon {
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

<script>
function saveSettings() {
    document.getElementById('settingsForm').submit();
}

function testEmailConnection() {
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i> Testing...';
    btn.disabled = true;
    
    setTimeout(() => {
        btn.innerHTML = '<i class="bi bi-check-circle"></i> Connection Successful';
        btn.classList.remove('btn-outline-primary');
        btn.classList.add('btn-outline-success');
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-outline-success');
            btn.classList.add('btn-outline-primary');
            btn.disabled = false;
        }, 3000);
    }, 2000);
}

function clearCache() {
    performMaintenanceAction('Clear Cache', 'Cache cleared successfully!');
}

function optimizeDatabase() {
    performMaintenanceAction('Optimize Database', 'Database optimized successfully!');
}

function createBackup() {
    performMaintenanceAction('Create Backup', 'Backup created successfully!');
}

function performMaintenanceAction(action, successMessage) {
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i> Working...';
    btn.disabled = true;
    
    setTimeout(() => {
        btn.innerHTML = '<i class="bi bi-check-circle"></i> Done';
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