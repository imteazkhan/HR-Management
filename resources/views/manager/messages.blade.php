@extends('layouts.manager')

@section('title', 'Team Messages - Manager Dashboard')
@section('page-title', 'Team Messages')
@section('page-icon', 'bi bi-chat-dots')
@section('page-description', 'Send and manage team communications')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Send Message Card -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5><i class="bi bi-send"></i> Send Team Message</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('manager.message') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="priority" class="form-label">Priority</label>
                            <select class="form-select" id="priority" name="priority" required>
                                <option value="low">Low</option>
                                <option value="normal" selected>Normal</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Recipients</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="all" id="all_team" name="recipients[]" checked>
                                <label class="form-check-label" for="all_team">
                                    All Team Members
                                </label>
                            </div>
                            <small class="text-muted">Message will be sent to all your team members</small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-send"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Messages List -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-inbox"></i> Recent Messages</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>From/To</th>
                                    <th>Date</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($messages ?? [] as $message)
                                <tr class="{{ !$message['read'] && $message['type'] == 'received' ? 'table-warning' : '' }}">
                                    <td>
                                        <strong>{{ $message['subject'] }}</strong>
                                        @if(!$message['read'] && $message['type'] == 'received')
                                            <span class="badge bg-primary ms-2">New</span>
                                        @endif
                                        @if($message['type'] == 'sent')
                                            <span class="badge bg-info ms-2">Sent</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $message['from'] }}
                                        @if($message['type'] == 'sent' && isset($message['recipients_count']))
                                            <small class="text-muted d-block">To {{ $message['recipients_count'] }} members</small>
                                        @endif
                                    </td>
                                    <td>{{ $message['date'] }}</td>
                                    <td>
                                        <span class="badge 
                                            @switch($message['priority'])
                                                @case('high') bg-danger @break
                                                @case('normal') bg-primary @break
                                                @case('low') bg-secondary @break
                                            @endswitch
                                        ">
                                            {{ ucfirst($message['priority']) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($message['type'] == 'received')
                                            <span class="badge {{ $message['read'] ? 'bg-success' : 'bg-warning' }}">
                                                {{ $message['read'] ? 'Read' : 'Unread' }}
                                            </span>
                                        @else
                                            <span class="badge bg-success">Sent</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary" title="View Message">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            @if($message['type'] == 'received' && !$message['read'])
                                                <form method="POST" action="{{ route('manager.messages.mark-read') }}" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="message_id" value="{{ $message['id'] }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Mark as Read">
                                                        <i class="bi bi-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if($message['type'] == 'sent')
                                                <form method="POST" action="{{ route('manager.messages.delete', $message['id']) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Message" 
                                                            onclick="return confirm('Are you sure you want to delete this message?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="bi bi-inbox fs-1 text-muted"></i>
                                        <p class="text-muted mt-2">No messages found</p>
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
</div>
@endsection