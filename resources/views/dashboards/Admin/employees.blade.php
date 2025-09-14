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
                <h1 class="h2">All Employees</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                        <i class="bi bi-person-plus"></i> Add Employee
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Employee Stats Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect">
                        <div class="card-body text-center">
                            <div class="display-6 text-primary mb-2">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <h4 class="card-title">{{ $employees->total() }}</h4>
                            <p class="card-text text-muted">Total Employees</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect">
                        <div class="card-body text-center">
                            <div class="display-6 text-success mb-2">
                                <i class="bi bi-person-check-fill"></i>
                            </div>
                            <h4 class="card-title">{{ $employees->where('role', 'manager')->count() }}</h4>
                            <p class="card-text text-muted">Managers</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect">
                        <div class="card-body text-center">
                            <div class="display-6 text-info mb-2">
                                <i class="bi bi-person-workspace"></i>
                            </div>
                            <h4 class="card-title">{{ $employees->where('role', 'employee')->count() }}</h4>
                            <p class="card-text text-muted">Staff</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect">
                        <div class="card-body text-center">
                            <div class="display-6 text-warning mb-2">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <h4 class="card-title">{{ $employees->where('created_at', '>=', now()->startOfMonth())->count() }}</h4>
                            <p class="card-text text-muted">New This Month</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employees Table -->
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Employee List</h5>
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control" placeholder="Search employees..." id="searchEmployees">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
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
                                    <td>{{ $employee->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-success">Active</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewEmployee({{ $employee->id }}, '{{ $employee->name }}', '{{ $employee->email }}', '{{ $employee->role }}', '{{ $employee->created_at->format('M d, Y') }}')" title="View">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="editEmployee({{ $employee->id }}, '{{ $employee->name }}', '{{ $employee->email }}', '{{ $employee->role }}')" title="Edit">
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

.table-row-hover:hover {
    background-color: #f8f9fa;
    transform: scale(1.01);
    transition: all 0.2s ease;
}

.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
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

<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
<div class="modal fade" id="editEmployeeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
                    <button type="submit" class="btn btn-primary">Update Employee</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Employee Modal -->
<div class="modal fade" id="viewEmployeeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Employee Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
<div class="modal fade" id="deleteEmployeeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Delete Employee</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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

<script>
// View Employee Function
function viewEmployee(id, name, email, role, joined) {
    document.getElementById('viewEmployeeName').textContent = name;
    document.getElementById('viewEmployeeEmail').textContent = email;
    document.getElementById('viewEmployeeRole').textContent = role.charAt(0).toUpperCase() + role.slice(1);
    document.getElementById('viewEmployeeJoined').textContent = joined;
    document.getElementById('viewEmployeeAvatar').textContent = name.charAt(0).toUpperCase();
    
    // Store ID for edit function
    document.getElementById('viewEmployeeModal').setAttribute('data-employee-id', id);
    
    var viewModal = new bootstrap.Modal(document.getElementById('viewEmployeeModal'));
    viewModal.show();
}

// Edit Employee Function
function editEmployee(id, name, email, role) {
    document.getElementById('editEmployeeName').value = name;
    document.getElementById('editEmployeeEmail').value = email;
    document.getElementById('editEmployeeRole').value = role;
    
    // Update form action
    document.getElementById('editEmployeeForm').action = '/superadmin/employees/' + id;
    
    var editModal = new bootstrap.Modal(document.getElementById('editEmployeeModal'));
    editModal.show();
}

// Edit from View Modal
function editFromView() {
    const viewModal = bootstrap.Modal.getInstance(document.getElementById('viewEmployeeModal'));
    const employeeId = document.getElementById('viewEmployeeModal').getAttribute('data-employee-id');
    const name = document.getElementById('viewEmployeeName').textContent;
    const email = document.getElementById('viewEmployeeEmail').textContent;
    const role = document.getElementById('viewEmployeeRole').textContent.toLowerCase();
    
    viewModal.hide();
    
    setTimeout(() => {
        editEmployee(employeeId, name, email, role);
    }, 300);
}

// Delete Employee Function
function deleteEmployee(id, name) {
    document.getElementById('deleteEmployeeName').textContent = name;
    document.getElementById('deleteEmployeeForm').action = '/superadmin/employees/' + id;
    
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