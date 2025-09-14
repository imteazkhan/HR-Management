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
                <h1 class="h2">Payroll Management</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export Report</button>
                    </div>
                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#processPayrollModal">
                        <i class="bi bi-play-circle"></i> Process Payroll
                    </button>
                </div>
            </div>

            <!-- Payroll Summary Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect border-success">
                        <div class="card-body text-center">
                            <div class="display-6 text-success mb-2">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <h4 class="card-title">${{ number_format(array_sum(array_column($payrollData, 'net_salary')), 0) }}</h4>
                            <p class="card-text text-muted">Total Payroll</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect border-primary">
                        <div class="card-body text-center">
                            <div class="display-6 text-primary mb-2">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <h4 class="card-title">{{ count($payrollData) }}</h4>
                            <p class="card-text text-muted">Employees</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect border-warning">
                        <div class="card-body text-center">
                            <div class="display-6 text-warning mb-2">
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <h4 class="card-title">${{ number_format(array_sum(array_column($payrollData, 'bonuses')), 0) }}</h4>
                            <p class="card-text text-muted">Total Bonuses</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-hover-effect border-info">
                        <div class="card-body text-center">
                            <div class="display-6 text-info mb-2">
                                <i class="bi bi-calculator"></i>
                            </div>
                            <h4 class="card-title">${{ number_format(array_sum(array_column($payrollData, 'deductions')), 0) }}</h4>
                            <p class="card-text text-muted">Total Deductions</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payroll Table -->
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Employee Payroll - {{ date('F Y') }}</h5>
                        </div>
                        <div class="col-auto">
                            <select class="form-select form-select-sm">
                                <option>{{ date('F Y') }}</option>
                                <option>{{ date('F Y', strtotime('-1 month')) }}</option>
                                <option>{{ date('F Y', strtotime('-2 months')) }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Employee</th>
                                    <th>Position</th>
                                    <th>Base Salary</th>
                                    <th>Bonuses</th>
                                    <th>Deductions</th>
                                    <th>Net Salary</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payrollData as $index => $payroll)
                                <tr class="table-row-hover">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-3">{{ substr($payroll['employee'], 0, 1) }}</div>
                                            <div>
                                                <h6 class="mb-0">{{ $payroll['employee'] }}</h6>
                                                <small class="text-muted">EMP{{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $payroll['position'] }}</td>
                                    <td>${{ number_format($payroll['base_salary'], 0) }}</td>
                                    <td>
                                        <span class="badge bg-success">${{ number_format($payroll['bonuses'], 0) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">${{ number_format($payroll['deductions'], 0) }}</span>
                                    </td>
                                    <td>
                                        <strong>${{ number_format($payroll['net_salary'], 0) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">Processed</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-download"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="2">TOTAL</th>
                                    <th>${{ number_format(array_sum(array_column($payrollData, 'base_salary')), 0) }}</th>
                                    <th>${{ number_format(array_sum(array_column($payrollData, 'bonuses')), 0) }}</th>
                                    <th>${{ number_format(array_sum(array_column($payrollData, 'deductions')), 0) }}</th>
                                    <th>${{ number_format(array_sum(array_column($payrollData, 'net_salary')), 0) }}</th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Payroll Analytics -->
            <div class="row mt-4">
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Payroll Breakdown</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="payrollChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Monthly Trends</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="trendChart" width="400" height="200"></canvas>
                        </div>
                    </div>
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
@endsection