@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-person-badge"></i> Team Attendance</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6>Today's Attendance - {{ now()->format('F j, Y') }}</h6>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="btn btn-primary btn-sm">
                                <i class="bi bi-download"></i> Export Report
                            </button>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Status</th>
                                    <th>Clock In</th>
                                    <th>Clock Out</th>
                                    <th>Hours Worked</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendanceData as $attendance)
                                <tr>
                                    <td>{{ $attendance['employee'] }}</td>
                                    <td>
                                        @if($attendance['status'] === 'Present')
                                            <span class="badge bg-success">{{ $attendance['status'] }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $attendance['status'] }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $attendance['clock_in'] }}</td>
                                    <td>{{ $attendance['clock_out'] }}</td>
                                    <td>{{ $attendance['hours'] }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View Details</button>
                                        @if($attendance['status'] === 'Absent')
                                            <button class="btn btn-sm btn-outline-warning">Mark Present</button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No attendance data found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h4>{{ collect($attendanceData)->where('status', 'Present')->count() }}</h4>
                                    <p class="mb-0">Present</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <h4>{{ collect($attendanceData)->where('status', 'Absent')->count() }}</h4>
                                    <p class="mb-0">Absent</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h4>{{ collect($attendanceData)->where('status', 'Late')->count() }}</h4>
                                    <p class="mb-0">Late</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h4>{{ round((collect($attendanceData)->where('status', 'Present')->count() / count($attendanceData)) * 100) }}%</h4>
                                    <p class="mb-0">Attendance Rate</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection