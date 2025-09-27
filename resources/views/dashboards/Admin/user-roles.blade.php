<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Roles Management - HR Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"></noscript>
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
        .sidebar .dropdown-toggle::after {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
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
            /* transition: all 0.3s ease; */
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
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .btn:active {
            transform: translateY(0);
        }
        .table-row-hover:hover {
            background-color: #f8f9fa;
            /* transform: scale(1.01); */
            transition: all 0.2s ease;
        }
        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
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
            .col-lg-4 {
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
        
        /* Modal accessibility improvements */
        .modal.show {
            /* Ensure visible modals never have aria-hidden */
        }
        .modal.show[aria-hidden="true"] {
            /* Force remove aria-hidden on visible modals */
            aria-hidden: false !important;
        }
        
        /* Focus management for better accessibility */
        .modal .btn-close:focus {
            outline: 2px solid #0d6efd;
            outline-offset: 2px;
        }
        
        /* Ensure proper contrast for focus indicators */
        .btn:focus,
        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
            border-color: #86b7fe;
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
            <span class="fw-bold">Super Admin</span>
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
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}" href="{{ route('superadmin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.employees') ? 'active' : '' }}" href="{{ route('superadmin.employees') }}"><i class="bi bi-people"></i> All Employees</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.departments') ? 'active' : '' }}" href="{{ route('superadmin.departments') }}"><i class="bi bi-building"></i> Departments</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.user-roles') ? 'active' : '' }}" href="{{ route('superadmin.user-roles') }}"><i class="bi bi-person-badge"></i> User Roles</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.payroll') ? 'active' : '' }}" href="{{ route('superadmin.payroll') }}"><i class="bi bi-cash-stack"></i> Payroll Management</a></li>
            
            <!-- HRM Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-workspace"></i>
                    HRM
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('hrm.designations.index') }}">Designations</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.attendance.admin.index') }}">Admin Attendance</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.attendance.employee.index') }}">Employee Attendance</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.attendance.biometric.index') }}">Biometric Attendance</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.loans.office.index') }}">Office Loan</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.loans.personal.index') }}">Personal Loan</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.leaves.employee.index') }}">Employee Leaves</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.leaves.admin.index') }}">Admin Leaves</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.holidays.index') }}">Holidays</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.timesheets.index') }}">Time Sheet</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.schedules.index') }}">Schedule</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.overtime.index') }}">Overtime</a></li>
                    <li><a class="dropdown-item" href="{{ route('hrm.warnings.index') }}">Warnings</a></li>
                </ul>
            </li>
            
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.analytics') ? 'active' : '' }}" href="{{ route('superadmin.analytics') }}"><i class="bi bi-graph-up"></i> Analytics</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.security') ? 'active' : '' }}" href="{{ route('superadmin.security') }}"><i class="bi bi-shield-check"></i> System Security</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.settings') ? 'active' : '' }}" href="{{ route('superadmin.settings') }}"><i class="bi bi-gear"></i> System Settings</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.database') ? 'active' : '' }}" href="{{ route('superadmin.database') }}"><i class="bi bi-database"></i> Database</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 d-none d-lg-flex">
            <h2><i class="bi bi-person-badge text-primary"></i> User Roles Management</h2>
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
            <p class="text-muted mb-0">System Administrator</p>
        </div>

        <!-- Role Statistics -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-6 col-lg-4">
                <div class="card stat-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Super Admins</h6>
                            <h2>{{ $roleCounts['superadmin'] }}</h2>
                        </div>
                        <i class="bi bi-shield-fill-exclamation fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4">
                <div class="card stat-card-2 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Managers</h6>
                            <h2>{{ $roleCounts['manager'] }}</h2>
                        </div>
                        <i class="bi bi-person-badge-fill fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4">
                <div class="card stat-card-3 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Employees</h6>
                            <h2>{{ $roleCounts['employee'] }}</h2>
                        </div>
                        <i class="bi bi-people-fill fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0"><i class="bi bi-person-badge"></i> User Roles</h5>
                    </div>
                    <div class="col-auto">
                        <select class="form-select form-select-sm" id="roleFilter">
                            <option value="">All Roles</option>
                            <option value="superadmin">Super Admin</option>
                            <option value="manager">Manager</option>
                            <option value="employee">Employee</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Current Role</th>
                                <th>Joined</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="table-row-hover fade-in-up">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3 bg-{{ $user->role === 'superadmin' ? 'danger' : ($user->role === 'manager' ? 'primary' : 'success') }}">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                            <small class="text-muted">ID: #{{ $user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->role === 'superadmin' ? 'danger' : ($user->role === 'manager' ? 'primary' : 'success') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge bg-success">Active</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="User actions for {{ $user->name }}">
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#changeRoleModal{{ $user->id }}"
                                            aria-label="Change role for {{ $user->name }}">
                                            <i class="bi bi-arrow-repeat"></i> Change Role
                                        </button>
                                        @if($user->role !== 'superadmin')
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteUserModal{{ $user->id }}"
                                            aria-label="Delete user {{ $user->name }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <!-- Change Role Modal -->
                            <div class="modal fade" id="changeRoleModal{{ $user->id }}" tabindex="-1"
                                aria-labelledby="changeRoleModalLabel{{ $user->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="changeRoleModalLabel{{ $user->id }}">Change User Role</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('superadmin.users.role') }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <div class="modal-body">
                                            <p>Change role for <strong>{{ $user->name }}</strong></p>
                                            <div class="mb-3">
                                                <label for="role{{ $user->id }}" class="form-label">New Role</label>
                                                <select class="form-select" id="role{{ $user->id }}" name="role" required aria-describedby="roleHelp{{ $user->id }}">
                                                    <option value="employee" {{ $user->role === 'employee' ? 'selected' : '' }}>Employee</option>
                                                    <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Manager</option>
                                                    <option value="superadmin" {{ $user->role === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                                                </select>
                                                <div id="roleHelp{{ $user->id }}" class="form-text">Select the new role for this user.</div>
                                            </div>
                                        </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update Role</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete User Modal -->
                           <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" 
                                aria-labelledby="deleteUserModalLabel{{ $user->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="deleteUserModalLabel{{ $user->id }}">Delete User</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the user <strong>{{ $user->name }}</strong>?</p>
                                            <p class="text-muted">This action cannot be undone and will permanently remove all user data.</p>
                                            <div class="alert alert-warning" role="alert">
                                                <i class="bi bi-exclamation-triangle"></i> 
                                                This will delete all associated records for this user.
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('superadmin.users.delete') }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you absolutely sure you want to delete {{ $user->name }}? This cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <button type="submit" class="btn btn-danger" aria-describedby="deleteWarning{{ $user->id }}">Delete User</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
               {{ $users->links('pagination::bootstrap-5') }}

            </div>
        </div>

        <!-- Add User Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('superadmin.users.create') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="userName" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="userName" name="name" required aria-describedby="nameHelp">
                                <div id="nameHelp" class="form-text">Enter the full name of the user.</div>
                            </div>
                            <div class="mb-3">
                                <label for="userEmail" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="userEmail" name="email" required aria-describedby="emailHelp">
                                <div id="emailHelp" class="form-text">Enter a valid email address.</div>
                            </div>
                            <div class="mb-3">
                                <label for="userPassword" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="userPassword" name="password" required minlength="8" aria-describedby="passwordHelp">
                                <div id="passwordHelp" class="form-text">Password must be at least 8 characters long.</div>
                            </div>
                            <div class="mb-3">
                                <label for="userRole" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select" id="userRole" name="role" required aria-describedby="roleSelectHelp">
                                    <option value="">Select a role</option>
                                    <option value="employee">Employee</option>
                                    <option value="manager">Manager</option>
                                    <option value="superadmin">Super Admin</option>
                                </select>
                                <div id="roleSelectHelp" class="form-text">Choose the appropriate role for this user.</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
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
            
            // Initialize all Bootstrap tooltips and popovers
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
            
            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
            const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
            
            // Role Filter
            const roleFilter = document.getElementById('roleFilter');
            if (roleFilter) {
                roleFilter.addEventListener('change', function() {
                    const role = this.value;
                    const rows = document.querySelectorAll('tbody tr');
                    rows.forEach(row => {
                        const roleCell = row.querySelector('td:nth-child(3) .badge').textContent.toLowerCase();
                        row.style.display = role === '' || roleCell.includes(role) ? '' : 'none';
                    });
                });
            }
            
            // Success/Error Message Auto-hide
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                if (!alert.classList.contains('alert-permanent')) {
                    setTimeout(function() {
                        alert.style.transition = 'opacity 0.5s';
                        alert.style.opacity = '0';
                        setTimeout(function() {
                            alert.remove();
                        }, 500);
                    }, 5000);
                }
            });

            // Modal Focus Management for Better Accessibility
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.addEventListener('show.bs.modal', function () {
                    // Remove aria-hidden when modal is being shown
                    modal.removeAttribute('aria-hidden');
                });
                
                modal.addEventListener('shown.bs.modal', function () {
                    // Ensure aria-hidden is removed and focus on the first focusable element
                    modal.removeAttribute('aria-hidden');
                    const firstFocusable = modal.querySelector('input, select, textarea, button:not([data-bs-dismiss])');
                    if (firstFocusable) {
                        firstFocusable.focus();
                    }
                });
                
                modal.addEventListener('hide.bs.modal', function () {
                    // Remove aria-hidden before hiding
                    modal.removeAttribute('aria-hidden');
                });
                
                modal.addEventListener('hidden.bs.modal', function () {
                    // Only add aria-hidden after modal is completely hidden
                    setTimeout(() => {
                        modal.setAttribute('aria-hidden', 'true');
                    }, 100);
                });
            });

            // Override Bootstrap's default modal behavior
            const originalModalShow = bootstrap.Modal.prototype.show;
            bootstrap.Modal.prototype.show = function() {
                // Remove aria-hidden before calling original show
                this._element.removeAttribute('aria-hidden');
                return originalModalShow.call(this);
            };

            const originalModalHide = bootstrap.Modal.prototype.hide;
            bootstrap.Modal.prototype.hide = function() {
                // Remove aria-hidden before hiding
                this._element.removeAttribute('aria-hidden');
                return originalModalHide.call(this);
            };

            // Keyboard navigation improvements
            document.addEventListener('keydown', function(e) {
                // Enhanced ESC key handling for modals
                if (e.key === 'Escape') {
                    const openModal = document.querySelector('.modal.show');
                    if (openModal) {
                        const modalInstance = bootstrap.Modal.getInstance(openModal);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    }
                }
            });

            // MutationObserver to prevent Bootstrap from adding aria-hidden on visible modals
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'aria-hidden') {
                        const target = mutation.target;
                        if (target.classList.contains('modal') && target.style.display === 'block') {
                            // If modal is visible but aria-hidden was added, remove it
                            if (target.getAttribute('aria-hidden') === 'true') {
                                target.removeAttribute('aria-hidden');
                            }
                        }
                    }
                });
            });

            // Observe all modals for attribute changes
            modals.forEach(modal => {
                observer.observe(modal, {
                    attributes: true,
                    attributeFilter: ['aria-hidden', 'style', 'class']
                });
            });

            // Special handling for close buttons to prevent aria-hidden conflicts
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-close') || e.target.closest('.btn-close')) {
                    const modal = e.target.closest('.modal');
                    if (modal) {
                        // Ensure aria-hidden is removed before the close action
                        modal.removeAttribute('aria-hidden');
                    }
                }
            });

            // Override the default Bootstrap modal backdrop behavior
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('modal') && e.target.classList.contains('show')) {
                    const modalInstance = bootstrap.Modal.getInstance(e.target);
                    if (modalInstance) {
                        e.target.removeAttribute('aria-hidden');
                        modalInstance.hide();
                    }
                }
            });

            

        });
    </script>
</body>
</html>