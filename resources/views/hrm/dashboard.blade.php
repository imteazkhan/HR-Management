@extends('layouts.app')

@section('title', 'HRM Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">HRM Dashboard</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">HRM</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Total Employees</h5>
                            <h3 class="my-2 py-1">{{ $totalEmployees }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2">{{ $activeEmployees }} Active</span>
                            </p>
                        </div>
                        <div class="align-self-center">
                            <div class="avatar-sm rounded-circle bg-primary-subtle">
                                <span class="avatar-title rounded-circle text-primary">
                                    <i class="ri-team-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Today's Attendance</h5>
                            <h3 class="my-2 py-1">{{ $presentToday }}/{{ $totalEmployees }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-info me-2">{{ number_format(($presentToday/$totalEmployees)*100, 1) }}% Present</span>
                            </p>
                        </div>
                        <div class="align-self-center">
                            <div class="avatar-sm rounded-circle bg-success-subtle">
                                <span class="avatar-title rounded-circle text-success">
                                    <i class="ri-calendar-check-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Pending Leaves</h5>
                            <h3 class="my-2 py-1">{{ $pendingLeaves }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-warning me-2">{{ $onLeaveToday }} On Leave Today</span>
                            </p>
                        </div>
                        <div class="align-self-center">
                            <div class="avatar-sm rounded-circle bg-warning-subtle">
                                <span class="avatar-title rounded-circle text-warning">
                                    <i class="ri-calendar-event-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Pending Loans</h5>
                            <h3 class="my-2 py-1">{{ $pendingPersonalLoans + $pendingOfficeLoans }}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-danger me-2">{{ $pendingPersonalLoans }} Personal, {{ $pendingOfficeLoans }} Office</span>
                            </p>
                        </div>
                        <div class="align-self-center">
                            <div class="avatar-sm rounded-circle bg-danger-subtle">
                                <span class="avatar-title rounded-circle text-danger">
                                    <i class="ri-money-dollar-circle-line font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Quick Actions -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('hrm.employees.create') }}" class="btn btn-primary">
                            <i class="ri-user-add-line me-1"></i> Add New Employee
                        </a>
                        <a href="{{ route('hrm.attendance.index') }}" class="btn btn-success">
                            <i class="ri-calendar-check-line me-1"></i> Mark Attendance
                        </a>
                        <a href="{{ route('hrm.leaves.index') }}" class="btn btn-warning">
                            <i class="ri-calendar-event-line me-1"></i> Manage Leaves
                        </a>
                        <a href="{{ route('hrm.holidays.create') }}" class="btn btn-info">
                            <i class="ri-calendar-line me-1"></i> Add Holiday
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Holidays -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Upcoming Holidays</h4>
                </div>
                <div class="card-body">
                    @if($upcomingHolidays->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($upcomingHolidays as $holiday)
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $holiday->name }}</h6>
                                            <small class="text-muted">{{ $holiday->date->format('M d, Y') }}</small>
                                        </div>
                                        <span class="badge bg-{{ $holiday->type === 'national' ? 'danger' : ($holiday->type === 'religious' ? 'warning' : 'info') }}">
                                            {{ ucfirst($holiday->type) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center">No upcoming holidays</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Recent Activities</h4>
                </div>
                <div class="card-body">
                    @if($recentActivities->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentActivities as $activity)
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-1">
                                            <p class="mb-1 small">{{ $activity['message'] }}</p>
                                            <small class="text-muted">{{ $activity['date']->diffForHumans() }}</small>
                                        </div>
                                        <span class="badge bg-{{ $activity['status'] === 'approved' ? 'success' : ($activity['status'] === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($activity['status']) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center">No recent activities</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- HRM Navigation -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">HRM Modules</h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('hrm.employees.index') }}" class="text-decoration-none">
                                <div class="card border h-100">
                                    <div class="card-body text-center">
                                        <i class="ri-team-line font-size-48 text-primary mb-3"></i>
                                        <h5>Employees</h5>
                                        <p class="text-muted small">Manage employee profiles and information</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('hrm.attendance.index') }}" class="text-decoration-none">
                                <div class="card border h-100">
                                    <div class="card-body text-center">
                                        <i class="ri-calendar-check-line font-size-48 text-success mb-3"></i>
                                        <h5>Attendance</h5>
                                        <p class="text-muted small">Track employee attendance and working hours</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('hrm.leaves.index') }}" class="text-decoration-none">
                                <div class="card border h-100">
                                    <div class="card-body text-center">
                                        <i class="ri-calendar-event-line font-size-48 text-warning mb-3"></i>
                                        <h5>Leaves</h5>
                                        <p class="text-muted small">Manage leave requests and balances</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('hrm.loans.index') }}" class="text-decoration-none">
                                <div class="card border h-100">
                                    <div class="card-body text-center">
                                        <i class="ri-money-dollar-circle-line font-size-48 text-info mb-3"></i>
                                        <h5>Loans</h5>
                                        <p class="text-muted small">Handle personal and office loans</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('hrm.timesheets.index') }}" class="text-decoration-none">
                                <div class="card border h-100">
                                    <div class="card-body text-center">
                                        <i class="ri-time-line font-size-48 text-secondary mb-3"></i>
                                        <h5>Time Sheets</h5>
                                        <p class="text-muted small">Track project time and tasks</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('hrm.schedules.index') }}" class="text-decoration-none">
                                <div class="card border h-100">
                                    <div class="card-body text-center">
                                        <i class="ri-calendar-2-line font-size-48 text-primary mb-3"></i>
                                        <h5>Schedules</h5>
                                        <p class="text-muted small">Manage work schedules and shifts</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('hrm.overtime.index') }}" class="text-decoration-none">
                                <div class="card border h-100">
                                    <div class="card-body text-center">
                                        <i class="ri-timer-line font-size-48 text-danger mb-3"></i>
                                        <h5>Overtime</h5>
                                        <p class="text-muted small">Track and approve overtime work</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('hrm.warnings.index') }}" class="text-decoration-none">
                                <div class="card border h-100">
                                    <div class="card-body text-center">
                                        <i class="ri-alert-line font-size-48 text-warning mb-3"></i>
                                        <h5>Warnings</h5>
                                        <p class="text-muted small">Issue and track employee warnings</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection