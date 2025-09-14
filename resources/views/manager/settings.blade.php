@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-gear"></i> Manager Settings</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('manager.settings') }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Notification Preferences</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="email_notifications" 
                                                   name="email_notifications" {{ $settings['email_notifications'] ? 'checked' : '' }}>
                                            <label class="form-check-label" for="email_notifications">
                                                Email Notifications
                                            </label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="push_notifications" 
                                                   name="push_notifications" {{ $settings['push_notifications'] ? 'checked' : '' }}>
                                            <label class="form-check-label" for="push_notifications">
                                                Push Notifications
                                            </label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="weekly_reports" 
                                                   name="weekly_reports" {{ $settings['weekly_reports'] ? 'checked' : '' }}>
                                            <label class="form-check-label" for="weekly_reports">
                                                Weekly Team Reports
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Team Management</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="auto_approve_leaves" 
                                                   name="auto_approve_leaves" {{ $settings['auto_approve_leaves'] ? 'checked' : '' }}>
                                            <label class="form-check-label" for="auto_approve_leaves">
                                                Auto-approve certain leave types
                                            </label>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="team_size_limit" class="form-label">Team Size Limit</label>
                                            <input type="number" class="form-control" id="team_size_limit" 
                                                   name="team_size_limit" value="{{ $settings['team_size_limit'] }}" min="1" max="100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Save Settings
                                </button>
                                <a href="{{ route('manager.dashboard') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Back to Dashboard
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection