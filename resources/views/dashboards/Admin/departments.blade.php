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
                <h1 class="h2">Departments Management</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
                        <i class="bi bi-building-add"></i> Add Department
                    </button>
                </div>
            </div>

            <!-- Department Stats -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect">
                        <div class="card-body text-center">
                            <div class="display-6 text-primary mb-2">
                                <i class="bi bi-building-fill"></i>
                            </div>
                            <h4 class="card-title">{{ count($departments) }}</h4>
                            <p class="card-text text-muted">Total Departments</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect">
                        <div class="card-body text-center">
                            <div class="display-6 text-success mb-2">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <h4 class="card-title">{{ $departments->sum('employees_count') }}</h4>
                            <p class="card-text text-muted">Total Employees</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect">
                        <div class="card-body text-center">
                            <div class="display-6 text-info mb-2">
                                <i class="bi bi-person-badge-fill"></i>
                            </div>
                            <h4 class="card-title">{{ count($departments) }}</h4>
                            <p class="card-text text-muted">Active Managers</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect">
                        <div class="card-body text-center">
                            <div class="display-6 text-warning mb-2">
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <h4 class="card-title">{{ $departments->count() > 0 ? number_format($departments->sum('employees_count') / $departments->count(), 1) : '0.0' }}</h4>
                            <p class="card-text text-muted">Avg. Team Size</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Departments Grid -->
            <div class="row">
                @foreach($departments as $department)
                <div class="col-lg-6 col-md-12 mb-4">
                    <div class="card department-card">
                        <div class="card-header bg-gradient-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="bi bi-building me-2"></i>{{ $department->name }}
                                </h5>
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
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-people me-1"></i>View Team
                                </button>
                                <button class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-graph-up me-1"></i>Reports
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </div>
</div>

<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
            <div class="modal-header">
                <h5 class="modal-title">Edit Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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

.department-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.department-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
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

<script>
// Edit Department Function
function editDepartment(id, name, description, managerId, location, budget, maxEmployees) {
    document.getElementById('editDepartmentName').value = name;
    document.getElementById('editDepartmentDescription').value = description || '';
    document.getElementById('editDepartmentManager').value = managerId || '';
    document.getElementById('editDepartmentLocation').value = location || '';
    document.getElementById('editDepartmentBudget').value = budget || '';
    document.getElementById('editMaxEmployees').value = maxEmployees || '';
    
    // Update form action
    document.getElementById('editDepartmentForm').action = '/superadmin/departments/' + id;
    
    // Show modal
    var editModal = new bootstrap.Modal(document.getElementById('editDepartmentModal'));
    editModal.show();
}

// Delete Department Function
function deleteDepartment(id, name) {
    document.getElementById('deleteDepartmentName').textContent = name;
    document.getElementById('deleteDepartmentForm').action = '/superadmin/departments/' + id;
    
    // Show modal
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteDepartmentModal'));
    deleteModal.show();
}

// Success/Error Message Auto-hide
document.addEventListener('DOMContentLoaded', function() {
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
</script>

@endsection