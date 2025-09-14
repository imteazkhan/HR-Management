@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5><i class="bi bi-clipboard-data"></i> Team Reports</h5>
                        <div class="btn-group" role="group">
                            <a href="{{ route('manager.reports', ['type' => 'attendance']) }}" 
                               class="btn btn-sm {{ $reportType === 'attendance' ? 'btn-primary' : 'btn-outline-primary' }}">
                                Attendance
                            </a>
                            <a href="{{ route('manager.reports', ['type' => 'productivity']) }}" 
                               class="btn btn-sm {{ $reportType === 'productivity' ? 'btn-primary' : 'btn-outline-primary' }}">
                                Productivity
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($reportData) && !empty($reportData))
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6>{{ $reportData['title'] }}</h6>
                                <p class="text-muted">Period: {{ $reportData['period'] }}</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <button class="btn btn-success btn-sm">
                                    <i class="bi bi-download"></i> Export PDF
                                </button>
                                <button class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                                </button>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        @if($reportType === 'attendance')
                                            <th>Present Days</th>
                                            <th>Absent Days</th>
                                            <th>Late Days</th>
                                        @elseif($reportType === 'productivity')
                                            <th>Tasks Completed</th>
                                            <th>Avg Completion Time</th>
                                            <th>Efficiency</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reportData['data'] as $row)
                                    <tr>
                                        <td>{{ $row['employee'] }}</td>
                                        @if($reportType === 'attendance')
                                            <td><span class="badge bg-success">{{ $row['present_days'] }}</span></td>
                                            <td><span class="badge bg-danger">{{ $row['absent_days'] }}</span></td>
                                            <td><span class="badge bg-warning">{{ $row['late_days'] }}</span></td>
                                        @elseif($reportType === 'productivity')
                                            <td>{{ $row['tasks_completed'] }}</td>
                                            <td>{{ $row['avg_completion_time'] }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2">{{ $row['efficiency'] }}</span>
                                                    <div class="progress" style="width: 100px; height: 8px;">
                                                        <div class="progress-bar" role="progressbar" 
                                                             style="width: {{ str_replace('%', '', $row['efficiency']) }}%"
                                                             aria-valuenow="{{ str_replace('%', '', $row['efficiency']) }}" 
                                                             aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-clipboard-x fs-1 text-muted"></i>
                            <p class="text-muted">No report data available</p>
                            <p class="text-muted">Select a report type to generate data</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection