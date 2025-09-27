<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Designations - HR Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --danger-color: #e74a3b;
            --warning-color: #f6c23e;
            --light-color: #f8f9fc;
            --dark-color: #3a3b45;
        }
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .sidebar {
            background: linear-gradient(180deg, var(--primary-color) 0%, #2e59d9 100%);
            color: white;
            min-height: 100vh;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            margin: 0.2rem 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar .nav-link i {
            margin-right: 0.5rem;
        }
        
        .dropdown-menu {
            background-color: #2e59d9;
            border: none;
        }
        
        .dropdown-item {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.25rem;
            border-top-left-radius: calc(0.5rem - 1px) !important;
            border-top-right-radius: calc(0.5rem - 1px) !important;
        }
        
        .stat-card {
            border-left: 0.25rem solid;
        }
        
        .stat-card-primary {
            border-left-color: var(--primary-color);
        }
        
        .stat-card-success {
            border-left-color: var(--success-color);
        }
        
        .stat-card-warning {
            border-left-color: var(--warning-color);
        }
        
        .stat-card-danger {
            border-left-color: var(--danger-color);
        }
        
        .stat-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .table th {
            font-weight: 600;
            border-top: none;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }
        
        .btn-warning {
            background-color: var(--warning-color);
            border-color: var(--warning-color);
        }
        
        .btn-warning:hover {
            background-color: #f4b619;
            border-color: #f4b619;
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }
        
        .btn-danger:hover {
            background-color: #e02d1d;
            border-color: #e02d1d;
        }
        
        .badge-warning {
            background-color: var(--warning-color);
            color: #000;
        }
        
        .badge-danger {
            background-color: var(--danger-color);
        }
        
        .badge-success {
            background-color: var(--success-color);
        }
        
        .modal-content {
            border-radius: 0.5rem;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .search-bar {
            background-color: #f8f9fc;
            border: 1px solid #e3e6f0;
            border-radius: 0.35rem;
        }
        
        .search-bar:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
            
            .stat-card .h5 {
                font-size: 1rem;
            }
            
            .stat-card .h3 {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2"></i>
                                Dashboard
                            </a>
                        </li>
                        
                        <!-- Employee Management Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person"></i>
                                Employee Management
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('employee.profile') }}">Employee Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('hrm.designations.index') }}">Designations</a></li>
                            </ul>
                        </li>
                        
                        <!-- Attendance Management Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-calendar-check"></i>
                                Attendance
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('hrm.attendance.admin.index') }}">Admin Attendance</a></li>
                                <li><a class="dropdown-item" href="{{ route('hrm.attendance.employee.index') }}">Employee Attendance</a></li>
                                <li><a class="dropdown-item" href="{{ route('hrm.attendance.biometric.index') }}">Biometric Attendance</a></li>
                            </ul>
                        </li>
                        
                        <!-- Loan Management Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-cash-stack"></i>
                                Loans
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('hrm.loans.office.index') }}">Office Loan</a></li>
                                <li><a class="dropdown-item" href="{{ route('hrm.loans.personal.index') }}">Personal Loan</a></li>
                            </ul>
                        </li>
                        
                        <!-- Leave Management Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-calendar-x"></i>
                                Leaves
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('hrm.leaves.employee.index') }}">Employee Leaves</a></li>
                                <li><a class="dropdown-item" href="{{ route('hrm.leaves.admin.index') }}">Admin Leaves</a></li>
                            </ul>
                        </li>
                        
                        <!-- Holiday Management -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('hrm.holidays.index') }}">
                                <i class="bi bi-calendar-heart"></i>
                                Holidays
                            </a>
                        </li>
                        
                        <!-- Time Management Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-clock"></i>
                                Time Management
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('hrm.timesheets.index') }}">Time Sheet</a></li>
                                <li><a class="dropdown-item" href="{{ route('hrm.schedules.index') }}">Schedule</a></li>
                                <li><a class="dropdown-item" href="{{ route('hrm.overtime.index') }}">Overtime</a></li>
                            </ul>
                        </li>
                        
                        <!-- Warning Management -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('hrm.warnings.index') }}">
                                <i class="bi bi-exclamation-triangle"></i>
                                Warnings
                            </a>
                        </li>
                        
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
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Designations</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDesignationModal">
                            <i class="bi bi-plus-circle"></i> Add Designation
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card stat-card-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Designations</div>
                                        <div class="h3 mb-0 font-weight-bold text-gray-800">24</div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat-icon bg-primary text-white">
                                            <i class="bi bi-briefcase"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card stat-card-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active</div>
                                        <div class="h3 mb-0 font-weight-bold text-gray-800">21</div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat-icon bg-success text-white">
                                            <i class="bi bi-check-circle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card stat-card-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending</div>
                                        <div class="h3 mb-0 font-weight-bold text-gray-800">2</div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat-icon bg-warning text-white">
                                            <i class="bi bi-clock"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card stat-card-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Inactive</div>
                                        <div class="h3 mb-0 font-weight-bold text-gray-800">1</div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat-icon bg-danger text-white">
                                            <i class="bi bi-x-circle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Designation Management</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4 mb-2">
                                <input type="text" class="form-control search-bar" placeholder="Search by designation...">
                            </div>
                            <div class="col-md-4 mb-2">
                                <select class="form-select search-bar">
                                    <option selected>All Departments</option>
                                    <option>Human Resources</option>
                                    <option>Finance</option>
                                    <option>IT</option>
                                    <option>Marketing</option>
                                    <option>Operations</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <select class="form-select search-bar">
                                    <option selected>All Status</option>
                                    <option>Active</option>
                                    <option>Inactive</option>
                                    <option>Pending</option>
                                </select>
                            </div>
                        </div>

                        <!-- Designations Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Designation</th>
                                        <th>Department</th>
                                        <th>Employees</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Software Engineer</td>
                                        <td>IT</td>
                                        <td>12</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>2023-01-15</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewDesignationModal">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>HR Manager</td>
                                        <td>Human Resources</td>
                                        <td>3</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>2022-11-20</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewDesignationModal">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Financial Analyst</td>
                                        <td>Finance</td>
                                        <td>5</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                        <td>2024-03-10</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewDesignationModal">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Marketing Specialist</td>
                                        <td>Marketing</td>
                                        <td>8</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>2023-05-22</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewDesignationModal">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Operations Manager</td>
                                        <td>Operations</td>
                                        <td>4</td>
                                        <td><span class="badge bg-danger">Inactive</span></td>
                                        <td>2022-08-14</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewDesignationModal">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Designation Modal -->
    <div class="modal fade" id="addDesignationModal" tabindex="-1" aria-labelledby="addDesignationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDesignationModalLabel">Add New Designation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="designationName" class="form-label">Designation Name</label>
                            <input type="text" class="form-control" id="designationName" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <select class="form-select" id="department" required>
                                <option selected disabled>Select Department</option>
                                <option>Human Resources</option>
                                <option>Finance</option>
                                <option>IT</option>
                                <option>Marketing</option>
                                <option>Operations</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" rows="3" placeholder="Enter designation description..."></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" required>
                                <option selected disabled>Select Status</option>
                                <option>Active</option>
                                <option>Inactive</option>
                                <option>Pending</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Save Designation</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Designation Modal -->
    <div class="modal fade" id="viewDesignationModal" tabindex="-1" aria-labelledby="viewDesignationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDesignationModalLabel">Designation Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Designation:</label>
                            <p>Software Engineer</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Department:</label>
                            <p>IT</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status:</label>
                            <p><span class="badge bg-success">Active</span></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Employees:</label>
                            <p>12</p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Description:</label>
                            <p>Responsible for developing, testing, and maintaining software applications.</p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Created Date:</label>
                            <p>2023-01-15</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>