@extends('layouts.manager')

@section('title', 'Team Attendance - Manager Dashboard')
@section('page-title', 'Team Attendance')
@section('page-icon', 'bi bi-person-badge')
@section('page-description', 'Monitor and track team attendance')

@section('content')
<div class="container-fluid">
    <!-- Team Overview -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                <strong>Team Overview:</strong> 
                You are managing {{ $totalTeamMembers ?? 0 }} team members. 
                Today's attendance rate: {{ $totalTeamMembers > 0 ? round((($presentCount ?? 0) / $totalTeamMembers) * 100, 1) : 0 }}%
            </div>
        </div>
    </div>

    <!-- Attendance Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Present Today</h6>
                            <h3>{{ $presentCount ?? 0 }}</h3>
                        </div>
                        <i class="bi bi-person-check fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Absent Today</h6>
                            <h3>{{ $absentCount ?? 0 }}</h3>
                        </div>
                        <i class="bi bi-person-x fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Late Arrivals</h6>
                            <h3>{{ $lateCount ?? 0 }}</h3>
                        </div>
                        <i class="bi bi-clock fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">On Leave</h6>
                            <h3>{{ $onLeaveCount ?? 0 }}</h3>
                        </div>
                        <i class="bi bi-calendar-event fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5><i class="bi bi-table"></i> 
                                @if($selectedDate == date('Y-m-d'))
                                    Today's Attendance
                                @else
                                    Attendance for {{ \Carbon\Carbon::parse($selectedDate)->format('M d, Y') }}
                                @endif
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end gap-2">
                                <input type="date" class="form-control form-control-sm" style="width: auto;" 
                                       value="{{ $selectedDate ?? date('Y-m-d') }}" onchange="filterByDate(this.value)">
                                <button class="btn btn-sm btn-outline-primary" onclick="exportAttendance()">
                                    <i class="bi bi-download"></i> Export
                                </button>
                                <button class="btn btn-sm btn-primary" onclick="refreshAttendance()">
                                    <i class="bi bi-arrow-clockwise"></i> Refresh
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Employee</th>
                                    <th>Status</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Hours Worked</th>
                                    <th>Location</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendanceData ?? [] as $attendance)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2">
                                                {{ substr($attendance['employee'], 0, 2) }}
                                            </div>
                                            <div>
                                                <strong>{{ $attendance['employee'] }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $attendance['email'] ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @switch($attendance['status'])
                                            @case('Present')
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle"></i> Present
                                                </span>
                                                @break
                                            @case('Absent')
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-x-circle"></i> Absent
                                                </span>
                                                @break
                                            @case('Late')
                                                <span class="badge bg-warning">
                                                    <i class="bi bi-clock"></i> Late
                                                </span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">Unknown</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        @if($attendance['clock_in'] !== '-')
                                            <span class="text-success">
                                                <i class="bi bi-clock"></i> {{ $attendance['clock_in'] }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($attendance['clock_out'] !== '-')
                                            <span class="text-danger">
                                                <i class="bi bi-clock"></i> {{ $attendance['clock_out'] }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            @php
                                                $hours = floatval($attendance['hours']);
                                                $percentage = min(($hours / 8) * 100, 100);
                                                $color = $percentage >= 100 ? 'success' : ($percentage >= 75 ? 'warning' : 'danger');
                                            @endphp
                                            <div class="progress-bar bg-{{ $color }}" role="progressbar" style="width: {{ $percentage }}%">
                                                {{ $attendance['hours'] }}h
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($attendance['location'] !== '-')
                                            <span class="badge bg-light text-dark">
                                                <i class="bi bi-geo-alt"></i> {{ $attendance['location'] }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if($attendance['attendance_id'])
                                                <button class="btn btn-sm btn-outline-primary" title="View Details" onclick="viewAttendanceDetails({{ $attendance['attendance_id'] }})">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning" title="Edit Attendance" onclick="editAttendance({{ $attendance['attendance_id'] }})">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-outline-success" title="Mark Present" onclick="markPresent({{ $attendance['employee_id'] }})">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            @endif
                                            <button class="btn btn-sm btn-outline-info" title="Send Message" onclick="sendMessage({{ $attendance['employee_id'] }}, '{{ $attendance['employee'] }}')">
                                                <i class="bi bi-chat"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="bi bi-calendar-x fs-1 text-muted"></i>
                                        <p class="text-muted mt-2">No attendance data available for today</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Attendance Chart -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-bar-chart"></i> Weekly Attendance Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        @forelse($weeklyData ?? [] as $day)
                        <div class="col">
                            <div class="weekly-stat">
                                <div class="day-label">{{ $day['day'] }}</div>
                                <div class="attendance-bar" style="height: {{ $day['percentage'] }}%" title="{{ $day['present'] }}/{{ $day['total'] }} present"></div>
                                <div class="attendance-count">{{ $day['present'] }}/{{ $day['total'] }}</div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-4">
                            <i class="bi bi-calendar-x fs-1 text-muted"></i>
                            <p class="text-muted mt-2">No weekly data available</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

.weekly-stat {
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 150px;
}

.day-label {
    font-weight: bold;
    margin-bottom: 10px;
    color: #6c757d;
}

.attendance-bar {
    width: 30px;
    background: linear-gradient(to top, #28a745, #20c997);
    border-radius: 15px;
    margin-bottom: 10px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.attendance-bar:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.attendance-count {
    font-size: 12px;
    font-weight: bold;
    color: #495057;
}

.progress {
    background-color: #e9ecef;
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

.table-hover tbody tr:hover {
    background-color: rgba(0,123,255,0.05);
}
</style>
@endsection

@section('scripts')
<script>
function refreshAttendance() {
    location.reload();
}

function filterByDate(date) {
    const url = new URL(window.location);
    url.searchParams.set('date', date);
    window.location.href = url.toString();
}

function exportAttendance() {
    // Create CSV content
    const attendanceData = @json($attendanceData ?? []);
    let csvContent = "Employee,Status,Check In,Check Out,Hours Worked,Location\n";
    
    attendanceData.forEach(row => {
        csvContent += `"${row.employee}","${row.status}","${row.clock_in}","${row.clock_out}","${row.hours}","${row.location}"\n`;
    });
    
    // Download CSV
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `team-attendance-${new Date().toISOString().split('T')[0]}.csv`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
}

function viewAttendanceDetails(attendanceId) {
    // Show modal with attendance details
    alert(`View attendance details for ID: ${attendanceId}`);
    // TODO: Implement modal with detailed attendance information
}

function editAttendance(attendanceId) {
    // Show edit modal
    alert(`Edit attendance for ID: ${attendanceId}`);
    // TODO: Implement edit attendance modal
}

function markPresent(employeeId) {
    if (confirm('Mark this employee as present for today?')) {
        // TODO: Implement AJAX call to mark employee present
        fetch(`/manager/attendance/mark-present/${employeeId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error marking employee present');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error marking employee present');
        });
    }
}

function sendMessage(employeeId, employeeName) {
    const message = prompt(`Send a message to ${employeeName}:`);
    if (message && message.trim()) {
        // TODO: Implement AJAX call to send message
        fetch('/manager/send-message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                employee_id: employeeId,
                message: message.trim()
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Message sent successfully!');
            } else {
                alert('Error sending message');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error sending message');
        });
    }
}

// Auto-refresh every 5 minutes
setInterval(refreshAttendance, 300000);
</script>
@endsection
@endsection