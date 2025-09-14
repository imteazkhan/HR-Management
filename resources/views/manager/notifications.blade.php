@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-bell"></i> Notifications</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse($notifications as $notification)
                        <div class="list-group-item {{ !$notification['read'] ? 'list-group-item-warning' : '' }}">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">
                                    @switch($notification['type'])
                                        @case('leave_request')
                                            <i class="bi bi-calendar-event text-info"></i>
                                            @break
                                        @case('attendance')
                                            <i class="bi bi-person-badge text-warning"></i>
                                            @break
                                        @case('task')
                                            <i class="bi bi-check-circle text-success"></i>
                                            @break
                                    @endswitch
                                    {{ $notification['message'] }}
                                </h6>
                                <small>{{ $notification['time'] }}</small>
                            </div>
                            @if(!$notification['read'])
                                <div class="mt-2">
                                    <button class="btn btn-sm btn-outline-primary">Mark as Read</button>
                                </div>
                            @endif
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="bi bi-bell-slash fs-1 text-muted"></i>
                            <p class="text-muted">No notifications found</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection