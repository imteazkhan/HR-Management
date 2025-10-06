<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Profile - Employee Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { background: #f8f9fa; }
        .sidebar { background: #2c3e50; min-height: 100vh; position: fixed; top: 0; left: 0; width: 250px; z-index: 1000; }
        .sidebar .nav-link { color: #ecf0f1; padding: 12px 20px; transition: all 0.3s; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: #34495e; color: #fff; }
        .sidebar .nav-link i { width: 20px; margin-right: 10px; }
        .main-content { margin-left: 250px; padding: 20px; }
        .card { border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .navbar-brand { font-weight: 700; font-size: 1.5rem; color: #fff !important; }
        .avatar-circle { width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, #3498db, #2980b9); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 2.5rem; margin: 0 auto 20px; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="p-3">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-briefcase"></i> iK soft
            </a>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="{{ route('employee.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('employee.profile') }}"><i class="bi bi-person-badge"></i> My Profile</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('employee.attendance') }}"><i class="bi bi-clock-history"></i> Attendance</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('employee.payslips') }}"><i class="bi bi-cash-stack"></i> Payroll</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('employee.leave-request') }}"><i class="bi bi-journal-text"></i> Leave Requests</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-person-badge text-primary"></i> My Profile</h2>
            <a href="{{ route('employee.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <!-- Success/Error Messages -->
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

        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="avatar-circle">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h4>{{ Auth::user()->name }}</h4>
                        <p class="text-muted">{{ ucfirst(Auth::user()->role) }}</p>
                        <p class="text-muted">Employee ID: #{{ Auth::user()->id }}</p>
                        <span class="badge bg-success">Active</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="bi bi-person-lines-fill"></i> Personal Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('employee.profile.update') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name', Auth::user()->name) }}" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email', Auth::user()->email) }}" required>
                                </div>
                            </div>
                            
                            @php
                                $profile = Auth::user()->employeeProfile;
                            @endphp
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone" 
                                           value="{{ old('phone', $profile->phone ?? '') }}">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" 
                                           value="{{ old('date_of_birth', $profile && $profile->date_of_birth ? $profile->date_of_birth->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $profile->address ?? '') }}</textarea>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="emergency_contact" class="form-label">Emergency Contact</label>
                                    <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" 
                                           value="{{ old('emergency_contact', $profile->emergency_contact ?? '') }}">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="department" class="form-label">Department</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->department->name ?? 'Not Assigned' }}" readonly>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('employee.dashboard') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>