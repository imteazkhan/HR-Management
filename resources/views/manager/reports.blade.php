@extends('layouts.manager')

@section('title', 'Team Reports - Manager Dashboard')
@section('page-title', 'Team Reports')
@section('page-icon', 'bi bi-clipboard-data')
@section('page-description', 'Generate and view team reports')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-clipboard-data"></i> Team Reports</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <form method="GET" action="{{ route('manager.reports') }}" class="row g-3">
                                <div class="col-md-4">
                                    <label for="type" class="form-label">Report Type</label>
                                    <select name="type" id="type" class="form-select">
                                        <option value="attendance" {{ request('type') == 'attendance' ? 'selected' : '' }}>Attendance Report</option>
                                        <option value="productivity" {{ request('type') == 'productivity' ? 'selected' : '' }}>Productivity Report</option>
                                        <option value="leave" {{ request('type') == 'leave' ? 'selected' : '' }}>Leave Report</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="period" class="form-label">Period</label>
                                    <select name="period" id="period" class="form-select">
                                        <option value="current_week" {{ request('period') == 'current_week' ? 'selected' : '' }}>Current Week</option>
                                        <option value="current_month" {{ request('period') == 'current_month' ? 'selected' : '' }}>Current Month</option>
                                        <option value="last_month" {{ request('period') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                                        <option value="last_3_months" {{ request('period') == 'last_3_months' ? 'selected' : '' }}>Last 3 Months</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-grid">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="bi bi-bar-chart"></i> Generate Report
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            @if(isset($reportData))
                                <div class="d-grid">
                                    <button class="btn btn-success" onclick="exportReport()">
                                        <i class="bi bi-download"></i> Export to CSV
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if(isset($reportData))
                    <div class="report-section">
                        <h6>{{ $reportData['title'] }}</h6>
                        <p class="text-muted">Period: {{ $reportData['period'] }}</p>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        @if($reportType == 'attendance')
                                            <th>Employee</th>
                                            <th>Present Days</th>
                                            <th>Absent Days</th>
                                            <th>Late Days</th>
                                        @elseif($reportType == 'productivity')
                                            <th>Employee</th>
                                            <th>Tasks Completed</th>
                                            <th>Avg Completion Time</th>
                                            <th>Efficiency</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reportData['data'] as $row)
                                    <tr>
                                        @if($reportType == 'attendance')
                                            <td>{{ $row['employee'] }}</td>
                                            <td><span class="badge bg-success">{{ $row['present_days'] }}</span></td>
                                            <td><span class="badge bg-danger">{{ $row['absent_days'] }}</span></td>
                                            <td><span class="badge bg-warning">{{ $row['late_days'] }}</span></td>
                                        @elseif($reportType == 'productivity')
                                            <td>{{ $row['employee'] }}</td>
                                            <td>{{ $row['tasks_completed'] }}</td>
                                            <td>{{ $row['avg_completion_time'] }}</td>
                                            <td>{{ $row['efficiency'] }}</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="bi bi-clipboard-data fs-1 text-muted"></i>
                        <p class="text-muted mt-3">Select a report type and click "Generate Report" to view data</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection