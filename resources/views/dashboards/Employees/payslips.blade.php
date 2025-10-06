<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payslips - Employee Dashboard</title>
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
            <li class="nav-item"><a class="nav-link active" href="{{ route('employee.payslips') }}"><i class="bi bi-cash-stack"></i> Payroll</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('employee.leave-request') }}"><i class="bi bi-journal-text"></i> Leave Requests</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-cash-stack text-primary"></i> My Payslips</h2>
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

        <!-- Payslips Table -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5><i class="bi bi-file-earmark-text"></i> Salary History</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Base Salary</th>
                                <th>Bonuses</th>
                                <th>Deductions</th>
                                <th>Net Salary</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $payslips = [
                                    ['month' => 'December 2024', 'base' => 25000, 'bonus' => 2000, 'deduction' => 1500, 'net' => 25500, 'status' => 'Paid'],
                                    ['month' => 'November 2024', 'base' => 25000, 'bonus' => 1000, 'deduction' => 1200, 'net' => 24800, 'status' => 'Paid'],
                                    ['month' => 'October 2024', 'base' => 25000, 'bonus' => 500, 'deduction' => 1000, 'net' => 24500, 'status' => 'Paid'],
                                ];
                            @endphp
                            
                            @foreach($payslips as $payslip)
                            <tr>
                                <td>{{ $payslip['month'] }}</td>
                                <td>BDT {{ number_format($payslip['base']) }}</td>
                                <td>BDT {{ number_format($payslip['bonus']) }}</td>
                                <td>BDT {{ number_format($payslip['deduction']) }}</td>
                                <td><strong>BDT {{ number_format($payslip['net']) }}</strong></td>
                                <td><span class="badge bg-success">{{ $payslip['status'] }}</span></td>
                                <td>
                                    <form action="{{ route('employee.payslips.download') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="month" value="{{ $payslip['month'] }}">
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-download"></i> Download
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Current Month Summary -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5><i class="bi bi-calendar-month"></i> Current Month Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-muted">Base Salary</h6>
                                <h4>BDT 25,000</h4>
                            </div>
                            <div class="col-6">
                                <h6 class="text-muted">Expected Net</h6>
                                <h4 class="text-success">BDT 25,500</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5><i class="bi bi-info-circle"></i> Payment Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Payment Date:</strong> Last working day of month</p>
                        <p><strong>Payment Method:</strong> Bank Transfer</p>
                        <p><strong>Bank Account:</strong> ****1234</p>
                        <p class="mb-0"><strong>Next Payment:</strong> {{ date('M d, Y', strtotime('last day of this month')) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>