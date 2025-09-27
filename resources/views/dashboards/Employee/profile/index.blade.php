<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Profile - HR Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { 
            background: #f8f9fa; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar { 
            background: linear-gradient(180deg, #4e73df 0%, #2e59d9 100%);
            color: white;
            min-height: 100vh; 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 250px; 
            z-index: 1000;
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
            width: 20px; 
            margin-right: 10px;
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
        .main-content { 
            margin-left: 250px; 
            padding: 20px;
            transition: all 0.3s ease;
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
        .profile-header { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
        }
        .profile-img { 
            width: 150px; 
            height: 150px; 
            border: 5px solid rgba(255,255,255,0.3); 
        }
        .stat-card { 
            background: white; 
            border-left: 4px solid #667eea; 
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
            padding: 10px 0; 
            border-bottom: 1px solid #eee; 
        }
        .activity-item:last-child { 
            border-bottom: none; 
        }
        @media (max-width: 768px) {
            .sidebar { 
                transform: translateX(-100%); 
                transition: transform 0.3s; 
                min-height: auto;
            }
            .sidebar.show { 
                transform: translateX(0); 
            }
            .main-content { 
                margin-left: 0; 
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="p-3">
            <a class="navbar-brand" href="{{route ('home')}}">
                <i class="bi bi-briefcase"></i> iK soft
            </a>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('employee.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            
            <!-- Employee Management Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person"></i>
                    Employee Management
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item active" href="{{ route('employee.profile') }}">My Profile</a></li>
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
                    <li><a class="dropdown-item" href="{{ route('hrm.attendance.employee.index') }}">My Attendance</a></li>
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
                    <li><a class="dropdown-item" href="{{ route('hrm.loans.personal.index') }}">Personal Loans</a></li>
                </ul>
            </li>
            
            <!-- Leave Management Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-calendar-x"></i>
                    Leaves
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('hrm.leaves.employee.index') }}">Leave Requests</a></li>
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
                    <li><a class="dropdown-item" href="{{ route('hrm.schedules.index') }}">My Schedule</a></li>
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
            
            <!-- Payslips -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('employee.payslips') }}">
                    <i class="bi bi-cash-stack"></i>
                    Payslips
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
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-person-badge-fill text-primary"></i> Employee Profile</h2>
            <div class="d-flex align-items-center">
                <span class="me-3">Welcome, {{ Auth::user()->name }}!</span>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout.confirm') }}"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Profile Header -->
        <div class="card profile-header mb-4">
            <div class="card-body text-center p-5">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&size=150&background=0D8ABC&color=fff" 
                     alt="Profile Image" class="profile-img rounded-circle mb-3">
                <h2 class="mb-1">{{ Auth::user()->name }}</h2>
                <p class="mb-2">{{ Auth::user()->email }}</p>
                <span class="badge bg-light text-dark">Employee</span>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="row g-4 mb-4">
            <!-- Personal Information -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="bi bi-person-lines-fill"></i> Personal Information</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Full Name</label>
                                    <p>{{ Auth::user()->name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Email Address</label>
                                    <p>{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Employee ID</label>
                                    <p>EMP-{{ str_pad(Auth::user()->id, 4, '0', STR_PAD_LEFT) }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Department</label>
                                    <p>IT Department</p>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Position</label>
                                    <p>Software Engineer</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Date of Joining</label>
                                    <p>January 15, 2022</p>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Phone Number</label>
                                    <p>+1 (555) 123-4567</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Emergency Contact</label>
                                    <p>+1 (555) 987-6543</p>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Address</label>
                                <p>123 Main Street, Cityville, State 12345</p>
                            </div>
                            
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                <i class="bi bi-pencil-square"></i> Edit Profile
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Stats and Quick Actions -->
            <div class="col-lg-4">
                <!-- Stats -->
                <div class="card stat-card mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><i class="bi bi-bar-chart-line"></i> Performance Stats</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Attendance Rate</span>
                            <span class="fw-bold">98%</span>
                        </div>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 98%"></div>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Leave Balance</span>
                            <span class="fw-bold">12 days</span>
                        </div>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 60%"></div>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Projects Completed</span>
                            <span class="fw-bold">24/25</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 96%"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5><i class="bi bi-lightning-charge"></i> Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('employee.leave-request') }}" class="btn btn-outline-primary">
                                <i class="bi bi-calendar-plus"></i> Request Leave
                            </a>
                            <a href="{{ route('employee.attendance') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-clock-history"></i> View Attendance
                            </a>
                            <a href="{{ route('employee.payslips') }}" class="btn btn-outline-success">
                                <i class="bi bi-cash"></i> View Payslips
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-clock-history"></i> Recent Activity</h5>
            </div>
            <div class="card-body recent-activity">
                <div class="activity-item">
                    <i class="bi bi-check-circle text-success me-3"></i> 
                    Profile updated successfully 
                    <small class="text-muted d-block">2 hours ago</small>
                </div>
                <div class="activity-item">
                    <i class="bi bi-calendar-event text-info me-3"></i> 
                    Submitted leave request for Dec 25-26 
                    <small class="text-muted d-block">4 hours ago</small>
                </div>
                <div class="activity-item">
                    <i class="bi bi-clock text-warning me-3"></i> 
                    Clocked in at 9:00 AM 
                    <small class="text-muted d-block">Today</small>
                </div>
                <div class="activity-item">
                    <i class="bi bi-file-earmark-text text-primary me-3"></i> 
                    Downloaded payslip for November 2024 
                    <small class="text-muted d-block">Yesterday</small>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="fullName" value="{{ Auth::user()->name }}">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone" value="+1 (555) 123-4567">
                            </div>
                            <div class="col-md-6">
                                <label for="emergencyContact" class="form-label">Emergency Contact</label>
                                <input type="text" class="form-control" id="emergencyContact" value="+1 (555) 987-6543">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" rows="3">123 Main Street, Cityville, State 12345</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="profileImage" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="profileImage">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Mobile sidebar toggle
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        
        // Check if we're on mobile
        function checkMobile() {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('show');
            } else {
                sidebar.classList.add('show');
            }
        }
        
        // Initial check
        checkMobile();
        
        // Check on resize
        window.addEventListener('resize', checkMobile);
    });
</script>
</body>
</html>