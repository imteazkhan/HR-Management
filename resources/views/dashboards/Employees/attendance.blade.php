<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance - Employee Dashboard</title>
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
            <li class="nav-item"><a class="nav-link active" href="{{ route('employee.attendance') }}"><i class="bi bi-clock-history"></i> Attendance</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('employee.payslips') }}"><i class="bi bi-cash-stack"></i> Payroll</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('employee.leave-request') }}"><i class="bi bi-journal-text"></i> Leave Requests</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-clock-history text-primary"></i> My Attendance</h2>
            <a href="{{ route('employee.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <!-- Today's Status -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        @php
                            $today = date('Y-m-d');
                            $attendance = DB::table('employee_attendances')
                                ->where('user_id', Auth::id())
                                ->where('date', $today)
                                ->first();
                        @endphp
                        
                        @if($attendance && $attendance->check_in)
                            <i class="bi bi-check-circle fs-1 text-success"></i>
                            <h5 class="mt-2">Checked In</h5>
                            <p class="text-muted">{{ date('g:i A', strtotime($attendance->check_in)) }}</p>
                        @else
                            <i class="bi bi-x-circle fs-1 text-danger"></i>
                            <h5 class="mt-2">Not Checked In</h5>
                            <p class="text-muted">Please check in</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        @if($attendance && $attendance->check_out)
                            <i class="bi bi-check-circle fs-1 text-success"></i>
                            <h5 class="mt-2">Checked Out</h5>
                            <p class="text-muted">{{ date('g:i A', strtotime($attendance->check_out)) }}</p>
                        @else
                            <i class="bi bi-clock fs-1 text-warning"></i>
                            <h5 class="mt-2">Working</h5>
                            <p class="text-muted">Remember to check out</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="bi bi-stopwatch fs-1 text-info"></i>
                        <h5 class="mt-2">Hours Today</h5>
                        @php
                            $hoursToday = 0;
                            if($attendance && $attendance->check_in) {
                                if($attendance->total_hours) {
                                    // Use total_hours from database (convert from minutes to hours)
                                    $hoursToday = round($attendance->total_hours / 60, 1);
                                } elseif($attendance->check_out) {
                                    $checkIn = strtotime($attendance->check_in);
                                    $checkOut = strtotime($attendance->check_out);
                                    $hoursToday = round(($checkOut - $checkIn) / 3600, 1);
                                } else {
                                    // If still working, calculate from check_in to now
                                    $checkIn = strtotime($attendance->check_in);
                                    $now = time();
                                    $hoursToday = round(($now - $checkIn) / 3600, 1);
                                }
                            }
                        @endphp
                        <p class="text-muted">{{ $hoursToday }} hours</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance History -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5><i class="bi bi-calendar-week"></i> Recent Attendance</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Hours Worked</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $attendanceRecords = DB::table('employee_attendances')
                                    ->where('user_id', Auth::id())
                                    ->orderBy('date', 'desc')
                                    ->limit(10)
                                    ->get();
                            @endphp
                            
                            @if($attendanceRecords->count() > 0)
                                @foreach($attendanceRecords as $record)
                                <tr>
                                    <td>{{ date('M d, Y', strtotime($record->date)) }}</td>
                                    <td>{{ $record->check_in ? date('g:i A', strtotime($record->check_in)) : '-' }}</td>
                                    <td>{{ $record->check_out ? date('g:i A', strtotime($record->check_out)) : '-' }}</td>
                                    <td>
                                        @php
                                            $recordHours = 0;
                                            if($record->total_hours) {
                                                // Use total_hours from database (convert from minutes to hours)
                                                $recordHours = round($record->total_hours / 60, 1);
                                            } elseif($record->check_in && $record->check_out) {
                                                $checkIn = strtotime($record->check_in);
                                                $checkOut = strtotime($record->check_out);
                                                $recordHours = round(($checkOut - $checkIn) / 3600, 1);
                                            }
                                        @endphp
                                        {{ $recordHours }} hrs
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $record->status === 'present' ? 'success' : 'danger' }}">
                                            {{ ucfirst($record->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="bi bi-calendar-x fs-1 text-muted"></i>
                                        <p class="text-muted mt-2">No attendance records found</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Monthly Summary -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5><i class="bi bi-calendar-month"></i> This Month Summary</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $monthlyStats = DB::table('employee_attendances')
                                ->where('user_id', Auth::id())
                                ->whereMonth('date', date('m'))
                                ->whereYear('date', date('Y'))
                                ->selectRaw('
                                    COUNT(*) as total_days,
                                    SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_days
                                ')
                                ->first();
                                
                            // Calculate total hours manually
                            $monthlyRecords = DB::table('employee_attendances')
                                ->where('user_id', Auth::id())
                                ->whereMonth('date', date('m'))
                                ->whereYear('date', date('Y'))
                                ->whereNotNull('check_in')
                                ->get();
                                
                            $totalHours = 0;
                            foreach($monthlyRecords as $record) {
                                if($record->total_hours) {
                                    // Use total_hours from database (convert from minutes to hours)
                                    $totalHours += $record->total_hours / 60;
                                } elseif($record->check_out) {
                                    $checkIn = strtotime($record->check_in);
                                    $checkOut = strtotime($record->check_out);
                                    $totalHours += ($checkOut - $checkIn) / 3600;
                                }
                            }
                            $monthlyStats->total_hours = round($totalHours, 1);
                        @endphp
                        
                        <div class="row">
                            <div class="col-4 text-center">
                                <h4>{{ $monthlyStats->present_days ?? 0 }}</h4>
                                <small class="text-muted">Present Days</small>
                            </div>
                            <div class="col-4 text-center">
                                <h4>{{ $monthlyStats->total_days - $monthlyStats->present_days ?? 0 }}</h4>
                                <small class="text-muted">Absent Days</small>
                            </div>
                            <div class="col-4 text-center">
                                <h4>{{ round($monthlyStats->total_hours ?? 0, 1) }}</h4>
                                <small class="text-muted">Total Hours</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5><i class="bi bi-graph-up"></i> Performance</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $attendanceRate = $monthlyStats->total_days > 0 ? 
                                round(($monthlyStats->present_days / $monthlyStats->total_days) * 100, 1) : 0;
                        @endphp
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Attendance Rate</span>
                                <span>{{ $attendanceRate }}%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: {{ $attendanceRate }}%"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Average Hours/Day</span>
                                <span>{{ $monthlyStats->present_days > 0 ? round($monthlyStats->total_hours / $monthlyStats->present_days, 1) : 0 }} hrs</span>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            @if($attendanceRate >= 95)
                                <span class="badge bg-success">Excellent</span>
                            @elseif($attendanceRate >= 85)
                                <span class="badge bg-primary">Good</span>
                            @elseif($attendanceRate >= 75)
                                <span class="badge bg-warning">Average</span>
                            @else
                                <span class="badge bg-danger">Needs Improvement</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>