<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Leave Count - HR Management</title>
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
            <li class="nav-item">
                <a class="nav-link" href="{{ route('superadmin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            
            <!-- Attendance Management -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('superadmin.attendance.index') }}">
                    <i class="bi bi-calendar-check"></i> Attendance
                </a>
            </li>
            
            <!-- Leave Count -->
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('superadmin.attendance.leave-count') }}">
                    <i class="bi bi-calendar-x"></i> Leave Count
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 d-none d-lg-flex">
            <h2><i class="bi bi-calendar-x text-primary"></i> Leave Count Management</h2>
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

        <!-- Leave Count Stats -->
        <div class="row g-3 g-md-4 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card stat-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Employees</h6>
                            <h2>{{ $leaveData->count() }}</h2>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-2 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Annual Leaves</h6>
                            <h2>{{ $leaveData->sum('annual_leaves') }}</h2>
                        </div>
                        <i class="bi bi-calendar-check fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-3 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Sick Leaves</h6>
                            <h2>{{ $leaveData->sum('sick_leaves') }}</h2>
                        </div>
                        <i class="bi bi-heart fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card stat-card-4 p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Used Leaves</h6>
                            <h2>{{ $leaveData->sum('used_annual_leaves') + $leaveData->sum('used_sick_leaves') }}</h2>
                        </div>
                        <i class="bi bi-graph-up fs-1 opacity-50 d-none d-md-block"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leave Count Records -->
        <div class="row g-3 g-md-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5><i class="bi bi-table"></i> Employee Leave Balances</h5>
                            <div>
                                <button class="btn btn-sm btn-light me-2">
                                    <i class="bi bi-download"></i> Export
                                </button>
                                <button class="btn btn-sm btn-light">
                                    <i class="bi bi-printer"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filters -->
                        <form method="GET" action="{{ route('superadmin.attendance.leave-count') }}">
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label for="employeeFilter" class="form-label">Employee</label>
                                    <input type="text" class="form-control" id="employeeFilter" name="employee_name" placeholder="Search employee..." value="{{ request('employee_name') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="departmentFilter" class="form-label">Department</label>
                                    <select class="form-select" id="departmentFilter" name="department_id">
                                        <option value="">All Departments</option>
                                        <option value="1" {{ request('department_id') == '1' ? 'selected' : '' }}>IT Department</option>
                                        <option value="2" {{ request('department_id') == '2' ? 'selected' : '' }}>Human Resources</option>
                                        <option value="3" {{ request('department_id') == '3' ? 'selected' : '' }}>Marketing</option>
                                        <option value="4" {{ request('department_id') == '4' ? 'selected' : '' }}>Finance</option>
                                        <option value="5" {{ request('department_id') == '5' ? 'selected' : '' }}>Operations</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="leaveTypeFilter" class="form-label">Leave Type</label>
                                    <select class="form-select" id="leaveTypeFilter" name="leave_type">
                                        <option value="">All Leave Types</option>
                                        <option value="annual" {{ request('leave_type') == 'annual' ? 'selected' : '' }}>Annual Leave</option>
                                        <option value="sick" {{ request('leave_type') == 'sick' ? 'selected' : '' }}>Sick Leave</option>
                                        <option value="maternity" {{ request('leave_type') == 'maternity' ? 'selected' : '' }}>Maternity Leave</option>
                                        <option value="paternity" {{ request('leave_type') == 'paternity' ? 'selected' : '' }}>Paternity Leave</option>
                                        <option value="emergency" {{ request('leave_type') == 'emergency' ? 'selected' : '' }}>Emergency Leave</option>
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button class="btn btn-primary w-100" type="submit">
                                        <i class="bi bi-search"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Annual</th>
                                        <th>Sick</th>
                                        <th>Maternity</th>
                                        <th>Paternity</th>
                                        <th>Emergency</th>
                                        <th>Compensatory</th>
                                        <th>Used Annual</th>
                                        <th>Used Sick</th>
                                        <th>Remaining</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leaveData as $employee)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($employee['name']) }}&background=0D8ABC&color=fff" class="rounded-circle me-2" width="30" height="30">
                                                    <span>{{ $employee['name'] }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $employee['annual_leaves'] }}</td>
                                            <td>{{ $employee['sick_leaves'] }}</td>
                                            <td>{{ $employee['maternity_leaves'] }}</td>
                                            <td>{{ $employee['paternity_leaves'] }}</td>
                                            <td>{{ $employee['emergency_leaves'] }}</td>
                                            <td>{{ $employee['compensatory_leaves'] }}</td>
                                            <td>{{ $employee['used_annual_leaves'] }}</td>
                                            <td>{{ $employee['used_sick_leaves'] }}</td>
                                            <td>{{ $employee['remaining_annual_leaves'] + $employee['remaining_sick_leaves'] }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary edit-leave" 
                                                        data-id="{{ $employee['id'] }}"
                                                        data-name="{{ $employee['name'] }}"
                                                        data-annual="{{ $employee['annual_leaves'] }}"
                                                        data-sick="{{ $employee['sick_leaves'] }}"
                                                        data-maternity="{{ $employee['maternity_leaves'] }}"
                                                        data-paternity="{{ $employee['paternity_leaves'] }}"
                                                        data-emergency="{{ $employee['emergency_leaves'] }}"
                                                        data-compensatory="{{ $employee['compensatory_leaves'] }}"
                                                        data-used-annual="{{ $employee['used_annual_leaves'] }}"
                                                        data-used-sick="{{ $employee['used_sick_leaves'] }}"
                                                        data-used-maternity="{{ $employee['used_maternity_leaves'] }}"
                                                        data-used-paternity="{{ $employee['used_paternity_leaves'] }}"
                                                        data-used-emergency="{{ $employee['used_emergency_leaves'] }}"
                                                        data-used-compensatory="{{ $employee['used_compensatory_leaves'] }}">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <nav aria-label="Leave records pagination">
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
            </div>
        </div>
    </div>

    <!-- Edit Leave Modal -->
    <div class="modal fade" id="editLeaveModal" tabindex="-1" aria-labelledby="editLeaveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('superadmin.attendance.update-leave-balance') }}">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editLeaveModalLabel">Edit Leave Balance</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="user_id" name="user_id">
                        <div class="row mb-3">
                            <div class="col-12">
                                <h5 id="employeeName"></h5>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="annual_leaves" class="form-label">Annual Leaves</label>
                                <input type="number" class="form-control" id="annual_leaves" name="annual_leaves" min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sick_leaves" class="form-label">Sick Leaves</label>
                                <input type="number" class="form-control" id="sick_leaves" name="sick_leaves" min="0" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="maternity_leaves" class="form-label">Maternity Leaves</label>
                                <input type="number" class="form-control" id="maternity_leaves" name="maternity_leaves" min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="paternity_leaves" class="form-label">Paternity Leaves</label>
                                <input type="number" class="form-control" id="paternity_leaves" name="paternity_leaves" min="0" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="emergency_leaves" class="form-label">Emergency Leaves</label>
                                <input type="number" class="form-control" id="emergency_leaves" name="emergency_leaves" min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="compensatory_leaves" class="form-label">Compensatory Leaves</label>
                                <input type="number" class="form-control" id="compensatory_leaves" name="compensatory_leaves" min="0" required>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="used_annual_leaves" class="form-label">Used Annual Leaves</label>
                                <input type="number" class="form-control" id="used_annual_leaves" name="used_annual_leaves" min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="used_sick_leaves" class="form-label">Used Sick Leaves</label>
                                <input type="number" class="form-control" id="used_sick_leaves" name="used_sick_leaves" min="0" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="used_maternity_leaves" class="form-label">Used Maternity Leaves</label>
                                <input type="number" class="form-control" id="used_maternity_leaves" name="used_maternity_leaves" min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="used_paternity_leaves" class="form-label">Used Paternity Leaves</label>
                                <input type="number" class="form-control" id="used_paternity_leaves" name="used_paternity_leaves" min="0" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="used_emergency_leaves" class="form-label">Used Emergency Leaves</label>
                                <input type="number" class="form-control" id="used_emergency_leaves" name="used_emergency_leaves" min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="used_compensatory_leaves" class="form-label">Used Compensatory Leaves</label>
                                <input type="number" class="form-control" id="used_compensatory_leaves" name="used_compensatory_leaves" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
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
            
            // Edit leave balance functionality
            document.querySelectorAll('.edit-leave').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    const employeeName = this.getAttribute('data-name');
                    const annualLeaves = this.getAttribute('data-annual');
                    const sickLeaves = this.getAttribute('data-sick');
                    const maternityLeaves = this.getAttribute('data-maternity');
                    const paternityLeaves = this.getAttribute('data-paternity');
                    const emergencyLeaves = this.getAttribute('data-emergency');
                    const compensatoryLeaves = this.getAttribute('data-compensatory');
                    const usedAnnualLeaves = this.getAttribute('data-used-annual');
                    const usedSickLeaves = this.getAttribute('data-used-sick');
                    const usedMaternityLeaves = this.getAttribute('data-used-maternity');
                    const usedPaternityLeaves = this.getAttribute('data-used-paternity');
                    const usedEmergencyLeaves = this.getAttribute('data-used-emergency');
                    const usedCompensatoryLeaves = this.getAttribute('data-used-compensatory');
                    
                    // Set modal values
                    document.getElementById('user_id').value = userId;
                    document.getElementById('employeeName').textContent = employeeName;
                    document.getElementById('annual_leaves').value = annualLeaves;
                    document.getElementById('sick_leaves').value = sickLeaves;
                    document.getElementById('maternity_leaves').value = maternityLeaves;
                    document.getElementById('paternity_leaves').value = paternityLeaves;
                    document.getElementById('emergency_leaves').value = emergencyLeaves;
                    document.getElementById('compensatory_leaves').value = compensatoryLeaves;
                    document.getElementById('used_annual_leaves').value = usedAnnualLeaves;
                    document.getElementById('used_sick_leaves').value = usedSickLeaves;
                    document.getElementById('used_maternity_leaves').value = usedMaternityLeaves;
                    document.getElementById('used_paternity_leaves').value = usedPaternityLeaves;
                    document.getElementById('used_emergency_leaves').value = usedEmergencyLeaves;
                    document.getElementById('used_compensatory_leaves').value = usedCompensatoryLeaves;
                    
                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('editLeaveModal'));
                    modal.show();
                });
            });
        });
    </script>
</body>
</html>