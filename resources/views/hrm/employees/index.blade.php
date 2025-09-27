@extends('layouts.app')

@section('title', 'Employees')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Employees</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('hrm.dashboard') }}">HRM</a></li>
                        <li class="breadcrumb-item active">Employees</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">Employee List</h4>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('hrm.employees.create') }}" class="btn btn-primary">
                                <i class="ri-user-add-line me-1"></i> Add Employee
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Joining Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($employees as $employee)
                                    <tr>
                                        <td>
                                            <span class="fw-medium">
                                                {{ $employee->employeeProfile->employee_id ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    @if($employee->employeeProfile && $employee->employeeProfile->profile_picture)
                                                        <img src="{{ Storage::url($employee->employeeProfile->profile_picture) }}" 
                                                             alt="{{ $employee->name }}" class="img-fluid rounded-circle">
                                                    @else
                                                        <div class="avatar-title rounded-circle bg-primary text-white">
                                                            {{ substr($employee->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $employee->name }}</h6>
                                                    <small class="text-muted">{{ $employee->employeeProfile->phone ?? 'No phone' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $employee->email }}</td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $employee->department->name ?? 'No Department' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ $employee->designation->title ?? 'No Designation' }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $employee->employeeProfile->joining_date ? $employee->employeeProfile->joining_date->format('M d, Y') : 'N/A' }}
                                        </td>
                                        <td>
                                            @php
                                                $status = $employee->employeeProfile->status ?? 'active';
                                                $badgeClass = match($status) {
                                                    'active' => 'bg-success',
                                                    'inactive' => 'bg-warning',
                                                    'terminated' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                                        data-bs-toggle="dropdown">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('hrm.employees.show', $employee) }}">
                                                            <i class="ri-eye-line me-2"></i>View
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('hrm.employees.edit', $employee) }}">
                                                            <i class="ri-edit-line me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('hrm.employees.destroy', $employee) }}" 
                                                              method="POST" class="d-inline"
                                                              onsubmit="return confirm('Are you sure you want to delete this employee?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="ri-delete-bin-line me-2"></i>Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="ri-user-line font-size-48 mb-3 d-block"></i>
                                                <h5>No employees found</h5>
                                                <p>Start by adding your first employee to the system.</p>
                                                <a href="{{ route('hrm.employees.create') }}" class="btn btn-primary">
                                                    <i class="ri-user-add-line me-1"></i> Add Employee
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($employees->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $employees->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection