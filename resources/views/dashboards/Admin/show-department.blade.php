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
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('superadmin.departments') }}">Departments</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $department->name }}</li>
                        </ol>
                    </nav>
                    <h1 class="h2">{{ $department->name }}</h1>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-sm btn-outline-primary me-2" onclick="editDepartment({{ $department->id }}, '{{ $department->name }}', '{{ $department->description }}', {{ $department->manager_id ?? 'null' }}, '{{ $department->location }}', '{{ $department->budget }}', {{ $department->max_employees }})">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteDepartment({{ $department->id }}, '{{ $department->name }}')">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <!-- Department Info -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Department Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Department Name:</strong>
                                    <p class="text-muted">{{ $department->name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Department Manager:</strong>
                                    <p class="text-muted">{{ $department->manager ? $department->manager->name : 'Not Assigned' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Location:</strong>
                                    <p class="text-muted">{{ $department->location ?? 'Not Specified' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Budget:</strong>
                                    <p class="text-muted">{{ $department->budget ?? 'Not Specified' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Maximum Employees:</strong>
                                    <p class="text-muted">{{ $department->max_employees }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Current Employees:</strong>
                                    <p class="text-muted">{{ $department->employees_count ?? 0 }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Status:</strong>
                                    <span class="badge {{ $department->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $department->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Created:</strong>
                                    <p class="text-muted">{{ $department->created_at->format('M d, Y g:i A') }}</p>
                                </div>
                            </div>
                            @if($department->description)
                            <div class="row">
                                <div class="col-12">
                                    <strong>Description:</strong>
                                    <p class="text-muted">{{ $department->description }}</p>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Capacity Progress -->
                            <div class="row">
                                <div class="col-12">
                                    <strong>Team Capacity:</strong>
                                    <div class="progress mt-2" style="height: 25px;">
                                        <div class="progress-bar bg-info" role="progressbar" 
                                             style="width: {{ $department->max_employees > 0 ? (($department->employees_count ?? 0) / $department->max_employees) * 100 : 0 }}%">
                                            {{ $department->employees_count ?? 0 }}/{{ $department->max_employees }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Department Employees -->
                    @if($department->employees && $department->employees->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-people me-2"></i>Department Employees ({{ $department->employees->count() }})</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Joined</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($department->employees as $employee)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-person-circle me-2 text-muted"></i>
                                                    {{ $employee->name }}
                                                </div>
                                            </td>
                                            <td>{{ $employee->email }}</td>
                                            <td>
                                                <span class="badge bg-primary">{{ ucfirst($employee->role) }}</span>
                                            </td>
                                            <td>{{ $employee->created_at->format('M d, Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="bi bi-people display-1 text-muted"></i>
                            <h5 class="mt-3">No Employees Assigned</h5>
                            <p class="text-muted">This department doesn't have any employees assigned yet.</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Side Panel -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Quick Stats</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <div class="display-4 text-primary">{{ $department->employees_count ?? 0 }}</div>
                                <p class="text-muted">Total Employees</p>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Capacity Used:</span>
                                <span class="fw-bold">{{ $department->max_employees > 0 ? round((($department->employees_count ?? 0) / $department->max_employees) * 100, 1) : 0 }}%</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Available Slots:</span>
                                <span class="fw-bold">{{ $department->max_employees - ($department->employees_count ?? 0) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Department Status:</span>
                                <span class="badge {{ $department->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $department->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Include modals and scripts from departments.blade.php -->
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
</script>

<style>
.sidebar {
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
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

.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}
</style>

@endsection