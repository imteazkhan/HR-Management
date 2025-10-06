<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Super Admin Dashboard - HR Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Ensure Bootstrap takes priority over any conflicting styles -->
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
        .recent-activity { 
            max-height: 400px; 
            overflow-y: auto;
        }
        .activity-item { 
            padding: 15px 0; 
            border-bottom: 1px solid #eee;
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
            transition: all 0.2s ease;
            border-radius: 8px;
        }
        .btn:hover {
            transform: translateY(-1px);
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
        
        /* Avatar circle for modals */
        .avatar-circle {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        /* Spinner animation */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
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
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.employees') ? 'active' : '' }}" href="{{ route('superadmin.employees') }}"><i class="bi bi-people"></i> Employees</a></li>

            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.designations') ? 'active' : '' }}" href="{{ route('superadmin.designations') }}"><i class="bi bi-award"></i> Designations</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.departments') ? 'active' : '' }}" href="{{ route('superadmin.departments') }}"><i class="bi bi-building"></i> Departments</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.user-roles') ? 'active' : '' }}" href="{{ route('superadmin.user-roles') }}"><i class="bi bi-person-badge"></i> User Roles</a></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.payroll') ? 'active' : '' }}" href="{{ route('superadmin.payroll') }}"><i class="bi bi-cash-stack"></i> Payroll Management</a></li>

            <li class="nav-item"><a class="nav-link {{ request()->routeIs('superadmin.attendance.index') ? 'active' : '' }}" href="{{ route('superadmin.attendance.index') }}"><i class="bi bi-calendar-check"></i> Attendance</a></li>

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
            <h2><i class="bi bi-award text-primary"></i> Designations Management</h2>
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

        <!-- Designation Stats -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card stat-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Designations</h6>
                            <h2>{{ $designations->count() ?? 0 }}</h2>
                        </div>
                        <i class="bi bi-award fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-2 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Active Positions</h6>
                            <h2>{{ $designations->where('is_active', true)->count() ?? 0 }}</h2>
                        </div>
                        <i class="bi bi-check-circle fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-3 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Employees Assigned</h6>
                            <h2>{{ $designations->sum('employees_count') ?? 0 }}</h2>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-4 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Avg. Salary Range</h6>
                            <h2>{{ $designations->avg('max_salary') ? number_format($designations->avg('max_salary'), 0) : '0' }}</h2>
                        </div>
                        <i class="bi bi-cash-stack fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Designations Grid -->
        <div class="row g-3 g-md-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><i class="bi bi-award"></i> Job Designations</h5>
                            <button type="button" class="btn btn-sm btn-outline-light" data-bs-toggle="modal" data-bs-target="#addDesignationModal">
                                <i class="bi bi-plus-circle"></i> Add Designation
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @forelse($designations ?? [] as $designation)
                            <div class="col-md-6 col-lg-4">
                                <div class="card fade-in-up h-100">
                                    <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0"><i class="bi bi-award me-2"></i>{{ $designation->title ?? 'N/A' }}</h6>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-light" type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#" onclick="editDesignation({{ $designation->id }}, '{{ $designation->title }}', '{{ addslashes($designation->description ?? '') }}', '{{ $designation->department_id ?? '' }}', '{{ $designation->min_salary ?? '' }}', '{{ $designation->max_salary ?? '' }}', '{{ is_array($designation->requirements) ? addslashes(implode(', ', $designation->requirements)) : addslashes($designation->requirements ?? '') }}', {{ $designation->is_active ? 'true' : 'false' }})"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="viewDesignation({{ $designation->id }})"><i class="bi bi-eye me-2"></i>View Details</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteDesignation({{ $designation->id }}, '{{ $designation->title }}')"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <h6 class="text-muted">Department</h6>
                                            <p class="fw-bold">{{ $designation->department->name ?? 'Not Assigned' }}</p>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <h6 class="text-muted">Employees</h6>
                                                <p class="fw-bold">{{ $designation->employees_count ?? 0 }}</p>
                                            </div>
                                            <div class="col-6">
                                                <h6 class="text-muted">Status</h6>
                                                <span class="badge {{ ($designation->is_active ?? true) ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ ($designation->is_active ?? true) ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="text-muted">Salary Range</h6>
                                            <p class="fw-bold">
                                                BDT {{ number_format($designation->min_salary ?? 0) }} - {{ number_format($designation->max_salary ?? 0) }}
                                            </p>
                                        </div>
                                        @if($designation->description)
                                        <div class="mb-3">
                                            <h6 class="text-muted">Description</h6>
                                            <p class="text-sm">{{ Str::limit($designation->description, 100) }}</p>
                                        </div>
                                        @endif
                                        @if($designation->requirements)
                                        <div class="mb-3">
                                            <h6 class="text-muted">Requirements</h6>
                                            <p class="text-sm">{{ is_array($designation->requirements) ? implode(', ', $designation->requirements) : $designation->requirements }}</p>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="card-footer bg-light">
                                        <div class="d-flex justify-content-between">
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewEmployees({{ $designation->id }})">
                                                <i class="bi bi-people me-1"></i>View Employees
                                            </button>
                                            <button class="btn btn-sm btn-outline-success" onclick="viewReports({{ $designation->id }})">
                                                <i class="bi bi-graph-up me-1"></i>Reports
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="bi bi-award fs-1 text-muted"></i>
                                    <h4 class="text-muted mt-3">No Designations Found</h4>
                                    <p class="text-muted">Start by adding your first job designation.</p>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDesignationModal">
                                        <i class="bi bi-plus-circle"></i> Add First Designation
                                    </button>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Designation Modal -->
    <div class="modal fade" id="addDesignationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add New Designation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('superadmin.designations.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="designationTitle" class="form-label">Designation Title</label>
                                    <input type="text" class="form-control" id="designationTitle" name="title" required placeholder="e.g., Senior Software Engineer">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="designationDepartment" class="form-label">Department</label>
                                    <select class="form-select" id="designationDepartment" name="department_id">
                                        <option value="">Select Department</option>
                                        @foreach($departments ?? [] as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="designationDescription" class="form-label">Job Description</label>
                            <textarea class="form-control" id="designationDescription" name="description" rows="3" placeholder="Brief description of the role and responsibilities"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="minSalary" class="form-label">Minimum Salary (BDT)</label>
                                    <input type="number" class="form-control" id="minSalary" name="min_salary" placeholder="30000" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="maxSalary" class="form-label">Maximum Salary (BDT)</label>
                                    <input type="number" class="form-control" id="maxSalary" name="max_salary" placeholder="80000" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="designationRequirements" class="form-label">Requirements & Qualifications</label>
                            <textarea class="form-control" id="designationRequirements" name="requirements" rows="3" placeholder="Education, experience, skills required for this position"></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="isActive" name="is_active" value="1" checked>
                                <label class="form-check-label" for="isActive">
                                    Active Position (Available for hiring)
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Designation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>    <
!-- Edit Designation Modal -->
    <div class="modal fade" id="editDesignationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit Designation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editDesignationForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="editDesignationId" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editDesignationTitle" class="form-label">Designation Title</label>
                                    <input type="text" class="form-control" id="editDesignationTitle" name="title" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editDesignationDepartment" class="form-label">Department</label>
                                    <select class="form-select" id="editDesignationDepartment" name="department_id">
                                        <option value="">Select Department</option>
                                        @foreach($departments ?? [] as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editDesignationDescription" class="form-label">Job Description</label>
                            <textarea class="form-control" id="editDesignationDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editMinSalary" class="form-label">Minimum Salary (BDT)</label>
                                    <input type="number" class="form-control" id="editMinSalary" name="min_salary" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editMaxSalary" class="form-label">Maximum Salary (BDT)</label>
                                    <input type="number" class="form-control" id="editMaxSalary" name="max_salary" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editDesignationRequirements" class="form-label">Requirements & Qualifications</label>
                            <textarea class="form-control" id="editDesignationRequirements" name="requirements" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="editIsActive" name="is_active" value="1">
                                <label class="form-check-label" for="editIsActive">
                                    Active Position (Available for hiring)
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Designation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Designation Modal -->
    <div class="modal fade" id="deleteDesignationModal" tabindex="-1" aria-labelledby="deleteDesignationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteDesignationModalLabel">Delete Designation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the designation <strong id="deleteDesignationName"></strong>?</p>
                    <p class="text-muted">This action cannot be undone. All employees with this designation will need to be reassigned.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteDesignationForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Designation</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Designation Details Modal -->
    <div class="modal fade" id="viewDesignationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Designation Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="designationDetailsContent">
                    <!-- Content will be loaded dynamically -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

            // Form validation
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const minSalary = form.querySelector('input[name="min_salary"]');
                    const maxSalary = form.querySelector('input[name="max_salary"]');
                    
                    if (minSalary && maxSalary && minSalary.value && maxSalary.value) {
                        if (parseInt(minSalary.value) >= parseInt(maxSalary.value)) {
                            e.preventDefault();
                            alert('Maximum salary must be greater than minimum salary.');
                            return false;
                        }
                    }
                });
            });
        });

        // Edit Designation Function
        function editDesignation(id, title, description, departmentId, minSalary, maxSalary, requirements, isActive) {
            document.getElementById('editDesignationTitle').value = title || '';
            document.getElementById('editDesignationDescription').value = description || '';
            document.getElementById('editDesignationDepartment').value = departmentId || '';
            document.getElementById('editMinSalary').value = minSalary || '';
            document.getElementById('editMaxSalary').value = maxSalary || '';
            document.getElementById('editDesignationRequirements').value = requirements || '';
            document.getElementById('editIsActive').checked = isActive;
            document.getElementById('editDesignationForm').action = '/superadmin/designations/' + id;
            var editModal = new bootstrap.Modal(document.getElementById('editDesignationModal'));
            editModal.show();
        }

        // Delete Designation Function
        function deleteDesignation(id, title) {
            document.getElementById('deleteDesignationName').textContent = title;
            document.getElementById('deleteDesignationForm').action = '/superadmin/designations/' + id;
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteDesignationModal'));
            deleteModal.show();
        }

        // View Designation Details Function
        function viewDesignation(id) {
            // You can implement AJAX call here to fetch detailed information
            const content = document.getElementById('designationDetailsContent');
            content.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            
            // Simulate loading (replace with actual AJAX call)
            setTimeout(() => {
                content.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Designation ID</h6>
                            <p class="fw-bold">#${id}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Created Date</h6>
                            <p class="fw-bold">${new Date().toLocaleDateString()}</p>
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Detailed view functionality can be implemented with AJAX calls to fetch complete designation information.
                    </div>
                `;
            }, 1000);
            
            var viewModal = new bootstrap.Modal(document.getElementById('viewDesignationModal'));
            viewModal.show();
        }

        // View Employees Function
        function viewEmployees(designationId) {
            // Show loading state
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-spinner-border spinner-border-sm me-1"></i>Loading...';
            button.disabled = true;
            
            // Fetch employees for this designation
            fetch(`/superadmin/designations/${designationId}/employees`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showEmployeesModal(data.employees, data.designation);
                    } else {
                        // Fallback to employees page with filter
                        window.location.href = `{{ route('superadmin.employees') }}?designation_id=${designationId}`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Fallback to employees page
                    window.location.href = `{{ route('superadmin.employees') }}?designation_id=${designationId}`;
                })
                .finally(() => {
                    // Restore button state
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
        }

        // View Reports Function
        function viewReports(designationId) {
            // Show loading state
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-spinner-border spinner-border-sm me-1"></i>Loading...';
            button.disabled = true;
            
            // Fetch reports for this designation
            fetch(`/superadmin/designations/${designationId}/reports`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showReportsModal(data.reports, data.designation);
                    } else {
                        // Fallback to analytics page
                        window.location.href = `{{ route('superadmin.analytics') }}?designation_id=${designationId}`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Fallback to analytics page
                    window.location.href = `{{ route('superadmin.analytics') }}?designation_id=${designationId}`;
                })
                .finally(() => {
                    // Restore button state
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
        }

        // Show Employees Modal
        function showEmployeesModal(employees, designation) {
            const modalHtml = `
                <div class="modal fade" id="employeesModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">
                                    <i class="bi bi-people me-2"></i>Employees in ${designation.title}
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                ${employees.length > 0 ? `
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Department</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                ${employees.map(employee => `
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-circle me-2" style="width: 30px; height: 30px; font-size: 12px;">
                                                                    ${employee.name.charAt(0)}
                                                                </div>
                                                                ${employee.name}
                                                            </div>
                                                        </td>
                                                        <td>${employee.email}</td>
                                                        <td>${employee.department || 'Not Assigned'}</td>
                                                        <td><span class="badge bg-success">Active</span></td>
                                                        <td>
                                                            <a href="/superadmin/employees/${employee.id}/edit" class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                `).join('')}
                                            </tbody>
                                        </table>
                                    </div>
                                ` : `
                                    <div class="text-center py-4">
                                        <i class="bi bi-people fs-1 text-muted"></i>
                                        <h5 class="text-muted mt-3">No Employees Found</h5>
                                        <p class="text-muted">No employees are currently assigned to this designation.</p>
                                        <a href="{{ route('superadmin.employees') }}" class="btn btn-primary">
                                            <i class="bi bi-person-plus"></i> Add Employee
                                        </a>
                                    </div>
                                `}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a href="{{ route('superadmin.employees') }}?designation_id=${designation.id}" class="btn btn-primary">
                                    <i class="bi bi-eye"></i> View All Employees
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove existing modal if any
            const existingModal = document.getElementById('employeesModal');
            if (existingModal) {
                existingModal.remove();
            }
            
            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('employeesModal'));
            modal.show();
            
            // Clean up modal after hiding
            document.getElementById('employeesModal').addEventListener('hidden.bs.modal', function() {
                this.remove();
            });
        }

        // Show Reports Modal
        function showReportsModal(reports, designation) {
            const modalHtml = `
                <div class="modal fade" id="reportsModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title">
                                    <i class="bi bi-graph-up me-2"></i>Reports for ${designation.title}
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3 mb-4">
                                    <div class="col-md-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <h3 class="text-primary">${reports.total_employees || 0}</h3>
                                                <small class="text-muted">Total Employees</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <h3 class="text-success">${reports.avg_salary || 0}</h3>
                                                <small class="text-muted">Avg. Salary</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <h3 class="text-info">${reports.attendance_rate || 0}%</h3>
                                                <small class="text-muted">Attendance Rate</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <h3 class="text-warning">${reports.performance_score || 0}</h3>
                                                <small class="text-muted">Performance</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Department:</strong> ${designation.department || 'Not Assigned'}<br>
                                    <strong>Salary Range:</strong> BDT ${designation.min_salary || 0} - ${designation.max_salary || 0}<br>
                                    <strong>Status:</strong> ${designation.is_active ? 'Active' : 'Inactive'}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a href="{{ route('superadmin.analytics') }}?designation_id=${designation.id}" class="btn btn-success">
                                    <i class="bi bi-graph-up"></i> View Detailed Analytics
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove existing modal if any
            const existingModal = document.getElementById('reportsModal');
            if (existingModal) {
                existingModal.remove();
            }
            
            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('reportsModal'));
            modal.show();
            
            // Clean up modal after hiding
            document.getElementById('reportsModal').addEventListener('hidden.bs.modal', function() {
                this.remove();
            });
        }

        // Search and Filter Functions
        function filterDesignations() {
            const searchInput = document.getElementById('searchDesignations');
            const departmentFilter = document.getElementById('departmentFilter');
            const statusFilter = document.getElementById('statusFilter');
            
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const designationCards = document.querySelectorAll('.col-md-6.col-lg-4');
                    
                    designationCards.forEach(card => {
                        const title = card.querySelector('h6').textContent.toLowerCase();
                        const description = card.querySelector('.text-sm')?.textContent.toLowerCase() || '';
                        
                        if (title.includes(searchTerm) || description.includes(searchTerm)) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            }
        }

        // Initialize filters when page loads
        document.addEventListener('DOMContentLoaded', filterDesignations);
    </script>
</body>
</html>