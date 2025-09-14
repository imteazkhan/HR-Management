@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-graph-up"></i> Team Performance</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Score</th>
                                    <th>Completed Tasks</th>
                                    <th>On-Time Rate</th>
                                    <th>Rating</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($performanceData as $performance)
                                <tr>
                                    <td>{{ $performance['employee'] }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">{{ $performance['score'] }}%</span>
                                            <div class="progress" style="width: 100px; height: 8px;">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: {{ $performance['score'] }}%"
                                                     aria-valuenow="{{ $performance['score'] }}" 
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $performance['completed_tasks'] }}</td>
                                    <td>{{ $performance['on_time_rate'] }}%</td>
                                    <td>
                                        @php
                                            $badgeClass = match($performance['rating']) {
                                                'Outstanding' => 'bg-success',
                                                'Excellent' => 'bg-primary',
                                                'Good' => 'bg-info',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $performance['rating'] }}</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary">View Details</button>
                                        <button class="btn btn-sm btn-outline-secondary">Review</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No performance data found</td>
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
@endsection