<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warnings - HR Management</title>
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
        .sidebar .dropdown-menu {
            background: #2e59d9;
            border: none;
            border-radius: 0.375rem;
            padding: 0.5rem 0;
            margin: 0.2rem 0.5rem;
        }
        .sidebar .dropdown-item {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.5rem 1.5rem;
            transition: all 0.3s;
        }
        .sidebar .dropdown-item:hover, .sidebar .dropdown-item.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar .dropdown-toggle::after {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .sidebar .nav-link i {
            margin-right: 0.5rem;
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
                        
                        <!-- Attendance Dropdown -->
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
                        
                        <!-- Loans Dropdown -->
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
                        
                        <!-- Leaves Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-calendar"></i>
                                Leaves
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('hrm.leaves.employee.index') }}">Employee Leaves</a></li>
                                <li><a class="dropdown-item" href="{{ route('hrm.leaves.admin.index') }}">Admin Leaves</a></li>
                            </ul>
                        </li>
                        
                        <li class="nav-item"><a class="nav-link" href="{{ route('hrm.holidays.index') }}"><i class="bi bi-calendar-heart"></i> Holidays</a></li>
                        
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
                        
                        <li class="nav-item"><a class="nav-link active" href="{{ route('hrm.warnings.index') }}"><i class="bi bi-exclamation-triangle"></i> Warnings</a></li>
                        
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
                    <h1 class="h2">Warnings</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWarningModal">
                            <i class="bi bi-plus-circle"></i> Add Warning
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
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Warnings</div>
                                        <div class="h3 mb-0 font-weight-bold text-gray-800">24</div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat-icon bg-primary text-white">
                                            <i class="bi bi-exclamation-triangle"></i>
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
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Warnings</div>
                                        <div class="h3 mb-0 font-weight-bold text-gray-800">7</div>
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
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Unresolved</div>
                                        <div class="h3 mb-0 font-weight-bold text-gray-800">3</div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat-icon bg-danger text-white">
                                            <i class="bi bi-exclamation-octagon"></i>
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
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Resolved</div>
                                        <div class="h3 mb-0 font-weight-bold text-gray-800">14</div>
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
                </div>

                <!-- Search and Filter -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Warning Management</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-3 mb-2">
                                <input type="text" class="form-control search-bar" placeholder="Search by employee...">
                            </div>
                            <div class="col-md-3 mb-2">
                                <select class="form-select search-bar">
                                    <option selected>All Departments</option>
                                    <option>Human Resources</option>
                                    <option>Finance</option>
                                    <option>IT</option>
                                    <option>Marketing</option>
                                    <option>Operations</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <select class="form-select search-bar">
                                    <option selected>All Status</option>
                                    <option>Pending</option>
                                    <option>Resolved</option>
                                    <option>Escalated</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <input type="date" class="form-control search-bar">
                            </div>
                        </div>

                        <!-- Warnings Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Department</th>
                                        <th>Warning Type</th>
                                        <th>Date Issued</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>John Smith</td>
                                        <td>IT</td>
                                        <td>Attendance</td>
                                        <td>2025-09-20</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewWarningModal">
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
                                        <td>Sarah Johnson</td>
                                        <td>Finance</td>
                                        <td>Performance</td>
                                        <td>2025-09-18</td>
                                        <td><span class="badge bg-success">Resolved</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewWarningModal">
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
                                        <td>Michael Brown</td>
                                        <td>Operations</td>
                                        <td>Policy Violation</td>
                                        <td>2025-09-15</td>
                                        <td><span class="badge bg-danger">Escalated</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewWarningModal">
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
                                        <td>Emily Davis</td>
                                        <td>Marketing</td>
                                        <td>Attendance</td>
                                        <td>2025-09-12</td>
                                        <td><span class="badge bg-success">Resolved</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewWarningModal">
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
                                        <td>Robert Wilson</td>
                                        <td>IT</td>
                                        <td>Performance</td>
                                        <td>2025-09-10</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewWarningModal">
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

    <!-- Add Warning Modal -->
    <div class="modal fade" id="addWarningModal" tabindex="-1" aria-labelledby="addWarningModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addWarningModalLabel">Add New Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="employeeSelect" class="form-label">Employee</label>
                            <select class="form-select" id="employeeSelect" required>
                                <option selected disabled>Select Employee</option>
                                <option>John Smith - IT</option>
                                <option>Sarah Johnson - Finance</option>
                                <option>Michael Brown - Operations</option>
                                <option>Emily Davis - Marketing</option>
                                <option>Robert Wilson - IT</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="warningType" class="form-label">Warning Type</label>
                            <select class="form-select" id="warningType" required>
                                <option selected disabled>Select Warning Type</option>
                                <option>Attendance</option>
                                <option>Performance</option>
                                <option>Policy Violation</option>
                                <option>Conduct</option>
                                <option>Other</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="warningDate" class="form-label">Date Issued</label>
                            <input type="date" class="form-control" id="warningDate" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="warningDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="warningDescription" rows="4" placeholder="Enter warning details..." required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="warningSeverity" class="form-label">Severity Level</label>
                            <select class="form-select" id="warningSeverity" required>
                                <option selected disabled>Select Severity</option>
                                <option>Low</option>
                                <option>Medium</option>
                                <option>High</option>
                                <option>Critical</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="warningAction" class="form-label">Recommended Action</label>
                            <textarea class="form-control" id="warningAction" rows="2" placeholder="Enter recommended action..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Save Warning</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Warning Modal -->
    <div class="modal fade" id="viewWarningModal" tabindex="-1" aria-labelledby="viewWarningModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewWarningModalLabel">Warning Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Employee:</label>
                            <p>John Smith</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Department:</label>
                            <p>IT</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Warning Type:</label>
                            <p>Attendance</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Date Issued:</label>
                            <p>2025-09-20</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status:</label>
                            <p><span class="badge bg-warning">Pending</span></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Severity:</label>
                            <p>Medium</p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Description:</label>
                            <p>Employee has been late to work 5 times in the past month, which violates company attendance policy.</p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Recommended Action:</label>
                            <p>Issue formal written warning and schedule meeting to discuss attendance expectations.</p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Resolution Notes:</label>
                            <textarea class="form-control" rows="3" placeholder="Add resolution notes..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Mark as Resolved</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set today's date as default in date inputs
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('warningDate').value = today;
        });
    </script>
</body>
</html>