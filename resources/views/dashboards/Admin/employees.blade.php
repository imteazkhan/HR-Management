<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employee Management - Super Admin</title>
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
        
        /* Button Animations */
        .btn {
            /* transition: all 0.3s ease; */
            border-radius: 8px;
        }
        .btn:hover {
            /* transform: translateY(-2px); */
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .btn:active {
            transform: translateY(0);
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
        
        /* Employee specific styles */
        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .table-row-hover:hover {
            background-color: rgba(52, 152, 219, 0.1);
            /* transform: scale(1.01); */
            transition: all 0.2s ease;
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
            .col-lg-3 {
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
        
        /* Modal styles */
        .modal-content {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .modal-header {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        
        /* Alert styles */
        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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
            <h2><i class="bi bi-people-fill text-primary"></i> Employee Management</h2>
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
            <p class="text-muted mb-0">Employee Management</p>
        </div>

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

        @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Please fix the following issues:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Key Metrics -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card stat-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Employees</h6>
                            <h2>{{ $employees->total() }}</h2>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-2 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Managers</h6>
                            <h2>{{ $employees->where('role', 'manager')->count() }}</h2>
                        </div>
                        <i class="bi bi-person-check fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-3 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Staff</h6>
                            <h2>{{ $employees->where('role', 'employee')->count() }}</h2>
                        </div>
                        <i class="bi bi-person-workspace fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-4 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">New This Month</h6>
                            <h2>{{ $employees->where('created_at', '>=', now()->startOfMonth())->count() }}</h2>
                        </div>
                        <i class="bi bi-clock-history fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employee Actions -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="bi bi-person-plus"></i> Employee Management</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex">
                                <input type="text" class="form-control me-2" placeholder="Search employees..." id="searchEmployees" style="max-width: 300px;">
                                <button class="btn btn-outline-secondary me-2">
                                    <i class="bi bi-filter"></i> Filter
                                </button>
                            </div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                                <i class="bi bi-person-plus"></i> Add Employee
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employees Table -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Department</th>
                                <th>Joined</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                            <tr class="table-row-hover">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3">{{ substr($employee->name, 0, 1) }}</div>
                                        <div>
                                            <h6 class="mb-0">{{ $employee->name }}</h6>
                                            <small class="text-muted">ID: #{{ $employee->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $employee->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $employee->role === 'manager' ? 'primary' : 'secondary' }}">
                                        {{ ucfirst($employee->role) }}
                                    </span>
                                </td>
                                <td>
                                    @if($employee->department)
                                        <span class="text-muted">{{ $employee->department->name }}</span>
                                    @else
                                        <span class="text-muted">No Department</span>
                                    @endif
                                </td>
                                <td>{{ $employee->created_at->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge bg-success">Active</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewEmployee({{ $employee->id }}, '{{ $employee->name }}', '{{ $employee->email }}', '{{ $employee->role }}', '{{ $employee->created_at->format('M d, Y') }}', '{{ $employee->department ? $employee->department->name : 'No Department' }}', {{ $employee->department_id ?? 'null' }})" title="View">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="editEmployee({{ $employee->id }}, '{{ $employee->name }}', '{{ $employee->email }}', '{{ $employee->role }}', {{ $employee->department_id ?? 'null' }})" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteEmployee({{ $employee->id }}, '{{ $employee->name }}')" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $employees->links() }}
            </div>
        </div>
    </div>

    <!-- Add Employee Modal -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEmployeeModalLabel">Add New Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('superadmin.employees.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="employeeName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="employeeName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="employeeEmail" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="employeeEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="employeePassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="employeePassword" name="password" required minlength="8">
                        </div>
                        <div class="mb-3">
                            <label for="employeeRole" class="form-label">Role</label>
                            <select class="form-select" id="employeeRole" name="role" required>
                                <option value="">Select Role</option>
                                <option value="employee">Employee</option>
                                <option value="manager">Manager</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="employeeDepartment" class="form-label">Department</label>
                            <select class="form-select" id="employeeDepartment" name="department_id">
                                <option value="">Select Department</option>
                                @foreach($departments ?? [] as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Employee Modal -->
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEmployeeModalLabel">Edit Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editEmployeeForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="editEmployeeId" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editEmployeeName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="editEmployeeName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmployeeEmail" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="editEmployeeEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEmployeeRole" class="form-label">Role</label>
                            <select class="form-select" id="editEmployeeRole" name="role" required>
                                <option value="employee">Employee</option>
                                <option value="manager">Manager</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editEmployeeDepartment" class="form-label">Department</label>
                            <select class="form-select" id="editEmployeeDepartment" name="department_id">
                                <option value="">Select Department</option>
                                @foreach($departments ?? [] as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editEmployeePassword" class="form-label">New Password (leave blank to keep current)</label>
                            <input type="password" class="form-control" id="editEmployeePassword" name="password" minlength="8">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" onclick="console.log('Form submission URL:', document.getElementById('editEmployeeForm').action)">Update Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Employee Modal -->
    <div class="modal fade" id="viewEmployeeModal" tabindex="-1" aria-labelledby="viewEmployeeModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewEmployeeModalLabel">Employee Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="avatar-circle mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2em;" id="viewEmployeeAvatar">A</div>
                        </div>
                        <div class="col-md-8">
                            <h4 id="viewEmployeeName">-</h4>
                            <p class="text-muted mb-1"><i class="bi bi-envelope me-2"></i><span id="viewEmployeeEmail">-</span></p>
                            <p class="text-muted mb-1"><i class="bi bi-person-badge me-2"></i><span id="viewEmployeeRole">-</span></p>
                            <p class="text-muted mb-1"><i class="bi bi-building me-2"></i><span id="viewEmployeeDepartment">-</span></p>
                            <p class="text-muted mb-1"><i class="bi bi-calendar me-2"></i>Joined: <span id="viewEmployeeJoined">-</span></p>
                            <span class="badge bg-success">Active</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="editFromView()">Edit Employee</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Employee Modal -->
    <div class="modal fade" id="deleteEmployeeModal" tabindex="-1" aria-labelledby="deleteEmployeeModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteEmployeeModalLabel">Delete Employee</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the employee <strong id="deleteEmployeeName"></strong>?</p>
                    <p class="text-muted">This action cannot be undone. All employee data will be permanently removed.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteEmployeeForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Employee</button>
                    </form>
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
        
        // View Employee Function
        window.viewEmployee = function(id, name, email, role, joined, departmentName, departmentId) {
            document.getElementById('viewEmployeeName').textContent = name;
            document.getElementById('viewEmployeeEmail').textContent = email;
            document.getElementById('viewEmployeeRole').textContent = role.charAt(0).toUpperCase() + role.slice(1);
            document.getElementById('viewEmployeeDepartment').textContent = departmentName || 'No Department';
            document.getElementById('viewEmployeeJoined').textContent = joined;
            document.getElementById('viewEmployeeAvatar').textContent = name.charAt(0).toUpperCase();
            
            // Store ID and department ID for edit function
            document.getElementById('viewEmployeeModal').setAttribute('data-employee-id', id);
            document.getElementById('viewEmployeeModal').setAttribute('data-department-id', departmentId);
            
            var viewModal = new bootstrap.Modal(document.getElementById('viewEmployeeModal'));
            viewModal.show();
        }

        // Edit Employee Function
        window.editEmployee = function(id, name, email, role, departmentId) {
            console.log('Edit Employee called with ID:', id);
            document.getElementById('editEmployeeName').value = name;
            document.getElementById('editEmployeeEmail').value = email;
            document.getElementById('editEmployeeRole').value = role;
            
            // Set department selection
            const departmentSelect = document.getElementById('editEmployeeDepartment');
            if (departmentSelect && departmentId) {
                departmentSelect.value = departmentId;
            } else if (departmentSelect) {
                departmentSelect.value = '';
            }
            
            // Update form action with correct Laravel route
            const actionUrl = '{{ url("superadmin/employees") }}/' + id;
            console.log('Setting form action to:', actionUrl);
            document.getElementById('editEmployeeForm').action = actionUrl;
            
            var editModal = new bootstrap.Modal(document.getElementById('editEmployeeModal'));
            editModal.show();
        }

        // Edit from View Modal
        window.editFromView = function() {
            const viewModal = bootstrap.Modal.getInstance(document.getElementById('viewEmployeeModal'));
            const employeeId = document.getElementById('viewEmployeeModal').getAttribute('data-employee-id');
            const departmentId = document.getElementById('viewEmployeeModal').getAttribute('data-department-id');
            const name = document.getElementById('viewEmployeeName').textContent;
            const email = document.getElementById('viewEmployeeEmail').textContent;
            const role = document.getElementById('viewEmployeeRole').textContent.toLowerCase();
            
            viewModal.hide();
            
            setTimeout(() => {
                editEmployee(employeeId, name, email, role, departmentId === 'null' ? null : departmentId);
            }, 300);
        }

        // Delete Employee Function
        window.deleteEmployee = function(id, name) {
            console.log('Delete Employee called with ID:', id);
            document.getElementById('deleteEmployeeName').textContent = name;
            const actionUrl = '{{ url("superadmin/employees") }}/' + id;
            console.log('Setting delete form action to:', actionUrl);
            document.getElementById('deleteEmployeeForm').action = actionUrl;
            
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteEmployeeModal'));
            deleteModal.show();
        }

        // Search Functionality
        document.getElementById('searchEmployees').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('tbody tr');
            
            tableRows.forEach(row => {
                const name = row.querySelector('h6').textContent.toLowerCase();
                const email = row.cells[1].textContent.toLowerCase();
                const role = row.cells[2].textContent.toLowerCase();
                
                if (name.includes(searchTerm) || email.includes(searchTerm) || role.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Success/Error Messages Auto-hide
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
    });
</script>
</body>
</html>