<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Departments Management - HR Management</title>
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
        .btn {
            transition: all 0.3s ease;
            border-radius: 8px;
        }
        .btn:hover {
            /* transform: translateY(-2px); */
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .btn:active {
            transform: translateY(0);
        }
        .progress {
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
        }
        .progress-bar {
            transition: width 1s ease-in-out;
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
            <h2><i class="bi bi-building text-primary"></i> Departments Management</h2>
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

        <!-- Department Stats -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card stat-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Departments</h6>
                            <h2>{{ count($departments) }}</h2>
                        </div>
                        <i class="bi bi-building fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-2 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Employees</h6>
                            <h2>{{ $departments->sum('employees_count') }}</h2>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-3 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Active Managers</h6>
                            <h2>{{ count($departments) }}</h2>
                        </div>
                        <i class="bi bi-person-badge fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-4 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Avg. Team Size</h6>
                            <h2>{{ $departments->count() > 0 ? number_format($departments->sum('employees_count') / $departments->count(), 1) : '0.0' }}</h2>
                        </div>
                        <i class="bi bi-graph-up fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Departments Grid -->
        <div class="row g-3 g-md-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><i class="bi bi-building"></i> Departments</h5>
                            <button type="button" class="btn btn-sm btn-outline-light" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
                                <i class="bi bi-building-add"></i> Add Department
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach($departments as $department)
                            <div class="col-md-6">
                                <div class="card fade-in-up">
                                    <div class="card-header bg-primary text-white">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0"><i class="bi bi-building me-2"></i>{{ $department->name }}</h5>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-light" type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#" onclick="editDepartment({{ $department->id }}, '{{ $department->name }}', '{{ $department->description }}', {{ $department->manager_id ?? 'null' }}, '{{ $department->location }}', '{{ $department->budget }}', {{ $department->max_employees }})"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="{{ route('superadmin.departments.show', $department) }}"><i class="bi bi-eye me-2"></i>View Details</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteDepartment({{ $department->id }}, '{{ $department->name }}')"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="text-muted">Department Manager</h6>
                                                <p class="fw-bold">{{ $department->manager ? $department->manager->name : 'Not Assigned' }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="text-muted">Team Size</h6>
                                                <p class="fw-bold">{{ $department->employees_count ?? 0 }} employees</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="text-muted">Created</h6>
                                                <p class="text-muted">{{ $department->created_at->format('M d, Y') }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="text-muted">Status</h6>
                                                <span class="badge {{ $department->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $department->is_active ? 'Active' : 'Inactive' }}</span>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $department->max_employees > 0 ? (($department->employees_count ?? 0) / $department->max_employees) * 100 : 0 }}%"></div>
                                            </div>
                                            <small class="text-muted">Team capacity utilization ({{ $department->employees_count ?? 0 }}/{{ $department->max_employees }})</small>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-light">
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-sm btn-outline-primary"><i class="bi bi-people me-1"></i>View Team</button>
                                            <button class="btn btn-sm btn-outline-success"><i class="bi bi-graph-up me-1"></i>Reports</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Department Modal -->
    <div class="modal fade" id="addDepartmentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add New Department</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('superadmin.departments.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="departmentName" class="form-label">Department Name</label>
                            <input type="text" class="form-control" id="departmentName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="departmentManager" class="form-label">Department Manager</label>
                            <select class="form-select" id="departmentManager" name="manager_id">
                                <option value="">Select Manager</option>
                                @foreach($managers as $manager)
                                    <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="departmentDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="departmentDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="departmentLocation" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="departmentLocation" name="location" placeholder="e.g., Building A, Floor 2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="departmentBudget" class="form-label">Budget</label>
                                    <input type="text" class="form-control" id="departmentBudget" name="budget" placeholder="e.g., $500,000">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="maxEmployees" class="form-label">Maximum Employees</label>
                            <input type="number" class="form-control" id="maxEmployees" name="max_employees" value="50" min="1" max="500">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Department</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Department Modal -->
    <div class="modal fade" id="editDepartmentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit Department</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editDepartmentForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="editDepartmentId" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editDepartmentName" class="form-label">Department Name</label>
                            <input type="text" class="form-control" id="editDepartmentName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDepartmentManager" class="form-label">Department Manager</label>
                            <select class="form-select" id="editDepartmentManager" name="manager_id">
                                <option value="">Select Manager</option>
                                @foreach($managers as $manager)
                                    <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editDepartmentDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editDepartmentDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editDepartmentLocation" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="editDepartmentLocation" name="location">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editDepartmentBudget" class="form-label">Budget</label>
                                    <input type="text" class="form-control" id="editDepartmentBudget" name="budget">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editMaxEmployees" class="form-label">Maximum Employees</label>
                                    <input type="number" class="form-control" id="editMaxEmployees" name="max_employees" min="1" max="500">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editIsActive" class="form-label">Status</label>
                                    <select class="form-select" id="editIsActive" name="is_active">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Department</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Department Modal -->
    <div class="modal fade" id="deleteDepartmentModal" tabindex="-1" aria-labelledby="deleteDepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteDepartmentModalLabel">Delete Department</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the department <strong id="deleteDepartmentName"></strong>?</p>
                    <p class="text-muted">This action cannot be undone. All employees in this department will need to be reassigned.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteDepartmentForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Department</button>
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
        });

        // Edit Department Function
        function editDepartment(id, name, description, managerId, location, budget, maxEmployees) {
            document.getElementById('editDepartmentName').value = name;
            document.getElementById('editDepartmentDescription').value = description || '';
            document.getElementById('editDepartmentManager').value = managerId || '';
            document.getElementById('editDepartmentLocation').value = location || '';
            document.getElementById('editDepartmentBudget').value = budget || '';
            document.getElementById('editMaxEmployees').value = maxEmployees || '';
            document.getElementById('editDepartmentForm').action = '/superadmin/departments/' + id;
            var editModal = new bootstrap.Modal(document.getElementById('editDepartmentModal'));
            editModal.show();
        }

        // Delete Department Function
        function deleteDepartment(id, name) {
            document.getElementById('deleteDepartmentName').textContent = name;
            document.getElementById('deleteDepartmentForm').action = '/superadmin/departments/' + id;
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteDepartmentModal'));
            deleteModal.show();
        }
    </script>
</body>
</html>