<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Leave Request - Employee Dashboard</title>
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
            <li class="nav-item"><a class="nav-link" href="{{ route('employee.profile') }}"><i class="bi bi-person-badge"></i> My Profile</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('employee.attendance') }}"><i class="bi bi-clock-history"></i> Attendance</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('employee.payslips') }}"><i class="bi bi-cash-stack"></i> Payroll</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('employee.leave-request') }}"><i class="bi bi-journal-text"></i> Leave Requests</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-calendar-plus text-primary"></i> Leave Request</h2>
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

        @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Please fix the following issues:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Leave Request Form -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="bi bi-calendar-plus"></i> Submit Leave Request</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('employee.leave-request.submit') }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="leave_type" class="form-label">Leave Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="leave_type" name="leave_type" required>
                                        <option value="">Select Leave Type</option>
                                        <option value="annual" {{ old('leave_type') == 'annual' ? 'selected' : '' }}>Annual Leave</option>
                                        <option value="sick" {{ old('leave_type') == 'sick' ? 'selected' : '' }}>Sick Leave</option>
                                        <option value="maternity" {{ old('leave_type') == 'maternity' ? 'selected' : '' }}>Maternity Leave</option>
                                        <option value="paternity" {{ old('leave_type') == 'paternity' ? 'selected' : '' }}>Paternity Leave</option>
                                        <option value="emergency" {{ old('leave_type') == 'emergency' ? 'selected' : '' }}>Emergency Leave</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" 
                                           value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" 
                                           value="{{ old('end_date') }}" min="{{ date('Y-m-d') }}" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="total_days" class="form-label">Total Days</label>
                                    <input type="number" class="form-control" id="total_days" name="total_days" readonly>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="reason" name="reason" rows="4" 
                                          placeholder="Please provide a detailed reason for your leave request..." required>{{ old('reason') }}</textarea>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('employee.dashboard') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> Submit Request
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5><i class="bi bi-info-circle"></i> Leave Balance</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $leaveBalance = DB::table('leave_balances')
                                ->where('user_id', Auth::id())
                                ->where('year', date('Y'))
                                ->first();
                        @endphp
                        
                        @if($leaveBalance)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span>Annual Leave:</span>
                                    <span class="fw-bold">{{ $leaveBalance->annual_leaves - $leaveBalance->used_annual_leaves }} / {{ $leaveBalance->annual_leaves }}</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span>Sick Leave:</span>
                                    <span class="fw-bold">{{ $leaveBalance->sick_leaves - $leaveBalance->used_sick_leaves }} / {{ $leaveBalance->sick_leaves }}</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span>Emergency Leave:</span>
                                    <span class="fw-bold">{{ $leaveBalance->emergency_leaves - $leaveBalance->used_emergency_leaves }} / {{ $leaveBalance->emergency_leaves }}</span>
                                </div>
                            </div>
                        @else
                            <p class="text-muted">No leave balance information available.</p>
                        @endif
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-header bg-warning text-dark">
                        <h5><i class="bi bi-exclamation-triangle"></i> Important Notes</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li><i class="bi bi-check text-success me-2"></i>Submit requests at least 3 days in advance</li>
                            <li><i class="bi bi-check text-success me-2"></i>Emergency leaves can be submitted same day</li>
                            <li><i class="bi bi-check text-success me-2"></i>Manager approval required for all requests</li>
                            <li><i class="bi bi-check text-success me-2"></i>Check your leave balance before applying</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Calculate total days when dates change
        function calculateDays() {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            
            if (startDate && endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);
                const timeDiff = end.getTime() - start.getTime();
                const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;
                
                if (dayDiff > 0) {
                    document.getElementById('total_days').value = dayDiff;
                } else {
                    document.getElementById('total_days').value = '';
                }
            }
        }
        
        document.getElementById('start_date').addEventListener('change', function() {
            // Update end date minimum
            document.getElementById('end_date').min = this.value;
            calculateDays();
        });
        
        document.getElementById('end_date').addEventListener('change', calculateDays);
    </script>
</body>
</html>