@extends('layouts.manager')

@section('title', 'Leave Requests - Manager Dashboard')
@section('page-title', 'Leave Requests')
@section('page-icon', 'bi bi-calendar-event')
@section('page-description', 'Review and approve team leave requests')

@section('content')
<div class="container-fluid">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Leave Request Statistics -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Pending Requests</h6>
                            <h3>{{ count($leaveRequests ?? []) }}</h3>
                        </div>
                        <i class="bi bi-clock-history fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Approved Today</h6>
                            <h3>{{ $approvedToday ?? 0 }}</h3>
                        </div>
                        <i class="bi bi-check-circle fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Rejected Today</h6>
                            <h3>{{ $rejectedToday ?? 0 }}</h3>
                        </div>
                        <i class="bi bi-x-circle fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Team Members</h6>
                            <h3>{{ $teamMembersCount ?? 0 }}</h3>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="bi bi-calendar-event"></i> Leave Requests</h5>
                    <div>
                        <button class="btn btn-sm btn-outline-primary" onclick="refreshPage()">
                            <i class="bi bi-arrow-clockwise"></i> Refresh
                        </button>
                        <button class="btn btn-sm btn-outline-success" onclick="exportLeaveRequests()">
                            <i class="bi bi-download"></i> Export
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Employee</th>
                                    <th>Type</th>
                                    <th>Duration</th>
                                    <th>Days</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Submitted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leaveRequests as $request)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2">
                                                {{ substr($request['employee'], 0, 2) }}
                                            </div>
                                            <div>
                                                <strong>{{ $request['employee'] }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $request['employee_email'] ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $request['type'] }}</span>
                                        @if($request['is_half_day'] ?? false)
                                            <br><small class="text-muted">Half Day</small>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $request['start_date'] }}</strong>
                                        <br>
                                        <small class="text-muted">to</small>
                                        <br>
                                        <strong>{{ $request['end_date'] }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $request['total_days'] ?? 0 }} day{{ ($request['total_days'] ?? 0) != 1 ? 's' : '' }}</span>
                                    </td>
                                    <td>
                                        <span title="{{ $request['reason'] }}">
                                            {{ Str::limit($request['reason'], 50) }}
                                        </span>
                                    </td>
                                    <td>
                                        @switch($request['status'])
                                            @case('Pending')
                                                <span class="badge bg-warning">{{ $request['status'] }}</span>
                                                @break
                                            @case('Approved')
                                                <span class="badge bg-success">{{ $request['status'] }}</span>
                                                @break
                                            @case('Rejected')
                                                <span class="badge bg-danger">{{ $request['status'] }}</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ $request['status'] }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $request['submitted_at'] }}</td>
                                    <td>
                                        @if($request['status'] === 'Pending')
                                            <div class="btn-group" role="group">
                                                <form method="POST" action="{{ route('manager.leave-requests.handle') }}" class="d-inline" onsubmit="return confirmAction('approve', '{{ $request['employee'] }}')">
                                                    @csrf
                                                    <input type="hidden" name="request_id" value="{{ $request['id'] }}">
                                                    <button type="submit" name="action" value="approve" class="btn btn-sm btn-success" title="Approve Request">
                                                        <i class="bi bi-check-circle"></i> Approve
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('manager.leave-requests.handle') }}" class="d-inline" onsubmit="return confirmAction('reject', '{{ $request['employee'] }}')">
                                                    @csrf
                                                    <input type="hidden" name="request_id" value="{{ $request['id'] }}">
                                                    <button type="submit" name="action" value="reject" class="btn btn-sm btn-danger" title="Reject Request">
                                                        <i class="bi bi-x-circle"></i> Reject
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-outline-info" onclick="showRequestDetails({{ $request['id'] }})" title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                        @else
                                            <span class="badge bg-secondary">{{ $request['status'] }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No leave requests found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
function confirmAction(action, employeeName) {
    const actionText = action === 'approve' ? 'approve' : 'reject';
    const message = `Are you sure you want to ${actionText} the leave request for ${employeeName}?`;
    return confirm(message);
}

function showRequestDetails(requestId) {
    // Find the request data from the table
    const requests = @json($leaveRequests ?? []);
    const request = requests.find(r => r.id == requestId);
    
    if (request) {
        let details = `Employee: ${request.employee}\n`;
        details += `Type: ${request.type}\n`;
        details += `Start Date: ${request.start_date}\n`;
        details += `End Date: ${request.end_date}\n`;
        details += `Reason: ${request.reason}\n`;
        details += `Status: ${request.status}\n`;
        details += `Submitted: ${request.submitted_at}`;
        
        alert(details);
        // TODO: Replace with a proper modal
    }
}

function refreshPage() {
    location.reload();
}

function exportLeaveRequests() {
    const requests = @json($leaveRequests ?? []);
    let csvContent = "Employee,Type,Start Date,End Date,Reason,Status,Submitted\n";
    
    requests.forEach(request => {
        csvContent += `"${request.employee}","${request.type}","${request.start_date}","${request.end_date}","${request.reason}","${request.status}","${request.submitted_at}"\n`;
    });
    
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `leave-requests-${new Date().toISOString().split('T')[0]}.csv`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endsection

@section('styles')
<style>
.avatar-circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 12px;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,123,255,0.05);
}

.btn-group .btn {
    border-radius: 0;
}

.btn-group .btn:first-child {
    border-top-left-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
}

.btn-group .btn:last-child {
    border-top-right-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
}
</style>
@endsection
@endsection