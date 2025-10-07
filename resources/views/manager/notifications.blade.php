@extends('layouts.manager')

@section('title', 'Notifications - Manager Dashboard')
@section('page-title', 'Notifications')
@section('page-icon', 'bi bi-bell')
@section('page-description', 'View and manage your notifications')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="bi bi-bell"></i> Notifications</h5>
                    <div>
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-check-all"></i> Mark All Read
                        </button>
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i> Clear All
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="notification-list">
                        @forelse($notifications ?? [] as $notification)
                        <div class="notification-item {{ !$notification['read'] ? 'unread' : '' }} p-3 border-bottom">
                            <div class="d-flex align-items-start">
                                <div class="notification-icon me-3">
                                    @switch($notification['type'])
                                        @case('attendance')
                                            <i class="bi bi-person-check text-success fs-4"></i>
                                            @break
                                        @case('leave_request')
                                            <i class="bi bi-calendar-event text-info fs-4"></i>
                                            @break
                                        @case('task')
                                            <i class="bi bi-check-circle text-warning fs-4"></i>
                                            @break
                                        @default
                                            <i class="bi bi-bell text-primary fs-4"></i>
                                    @endswitch
                                </div>
                                <div class="notification-content flex-grow-1">
                                    <div class="notification-message">
                                        {{ $notification['message'] }}
                                    </div>
                                    <div class="notification-time text-muted small">
                                        <i class="bi bi-clock"></i> {{ $notification['time'] }}
                                    </div>
                                </div>
                                <div class="notification-actions">
                                    @if(!$notification['read'])
                                        <span class="badge bg-primary">New</span>
                                    @endif
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-check"></i> Mark as Read</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-trash"></i> Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="bi bi-bell-slash fs-1 text-muted"></i>
                            <p class="text-muted mt-3">No notifications found</p>
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
.notification-item {
    transition: all 0.3s ease;
}

.notification-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

.notification-item.unread {
    background-color: #fff3cd;
    border-left: 4px solid #ffc107;
}

.notification-icon {
    min-width: 50px;
    text-align: center;
}

.notification-list {
    max-height: 600px;
    overflow-y: auto;
}

.notification-list::-webkit-scrollbar {
    width: 6px;
}

.notification-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.notification-list::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.notification-list::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
@endsection
@endsection