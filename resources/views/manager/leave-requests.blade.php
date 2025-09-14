@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-calendar-event"></i> Leave Requests</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Submitted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leaveRequests as $request)
                                <tr>
                                    <td>{{ $request['employee'] }}</td>
                                    <td>{{ $request['type'] }}</td>
                                    <td>{{ $request['start_date'] }}</td>
                                    <td>{{ $request['end_date'] }}</td>
                                    <td>{{ $request['reason'] }}</td>
                                    <td>
                                        <span class="badge bg-warning">{{ $request['status'] }}</span>
                                    </td>
                                    <td>{{ $request['submitted_at'] }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('manager.leave-requests.handle') }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="request_id" value="{{ $request['id'] }}">
                                            <button type="submit" name="action" value="approve" class="btn btn-sm btn-success">
                                                <i class="bi bi-check"></i> Approve
                                            </button>
                                            <button type="submit" name="action" value="reject" class="btn btn-sm btn-danger">
                                                <i class="bi bi-x"></i> Reject
                                            </button>
                                        </form>
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
@endsection