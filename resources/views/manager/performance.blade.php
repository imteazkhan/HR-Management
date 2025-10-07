@extends('layouts.manager')

@section('title', 'Team Performance - Manager Dashboard')
@section('page-title', 'Team Performance')
@section('page-icon', 'bi bi-graph-up')
@section('page-description', 'Monitor and evaluate team performance')

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
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $performance['score'] }}%">
                                                {{ $performance['score'] }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $performance['completed_tasks'] }}</td>
                                    <td>{{ $performance['on_time_rate'] }}%</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $performance['rating'] }}</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> Details
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No performance data available</td>
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