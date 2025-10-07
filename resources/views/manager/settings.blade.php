@extends('layouts.manager')

@section('title', 'Settings - Manager Dashboard')
@section('page-title', 'Settings')
@section('page-icon', 'bi bi-gear')
@section('page-description', 'Manage your preferences and settings')

@section('content')
<div class="container-fluid">
    <div class="row g-4">
        <!-- Profile Settings -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5><i class="bi bi-person-gear"></i> Profile Settings</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" value="{{ $user->name ?? '' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" value="{{ $user->email ?? '' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <input type="text" class="form-control" id="role" value="{{ ucfirst($user->role ?? '') }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Change Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter new password">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" placeholder="Confirm new password">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update Profile
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Manager Settings -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5><i class="bi bi-sliders"></i> Manager Preferences</h5>
                </div>
                <div class="card-body">
                    <form method="PATCH" action="{{ route('manager.settings.update') }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="email_notifications" name="email_notifications" 
                                       {{ ($settings['email_notifications'] ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="email_notifications">
                                    Email Notifications
                                </label>
                            </div>
                            <small class="text-muted">Receive email notifications for team activities</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="push_notifications" name="push_notifications"
                                       {{ ($settings['push_notifications'] ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="push_notifications">
                                    Push Notifications
                                </label>
                            </div>
                            <small class="text-muted">Receive browser push notifications</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="weekly_reports" name="weekly_reports"
                                       {{ ($settings['weekly_reports'] ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="weekly_reports">
                                    Weekly Reports
                                </label>
                            </div>
                            <small class="text-muted">Receive weekly team performance reports</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="auto_approve_leaves" name="auto_approve_leaves"
                                       {{ ($settings['auto_approve_leaves'] ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="auto_approve_leaves">
                                    Auto-approve Leave Requests
                                </label>
                            </div>
                            <small class="text-muted">Automatically approve certain types of leave requests</small>
                        </div>

                        <div class="mb-3">
                            <label for="team_size_limit" class="form-label">Team Size Limit</label>
                            <input type="number" class="form-control" id="team_size_limit" name="team_size_limit" 
                                   value="{{ $settings['team_size_limit'] ?? 20 }}" min="1" max="100">
                            <small class="text-muted">Maximum number of team members you can manage</small>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> Save Settings
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Settings -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5><i class="bi bi-shield-check"></i> Security & Privacy</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Two-Factor Authentication</h6>
                            <p class="text-muted">Add an extra layer of security to your account</p>
                            <button class="btn btn-outline-warning">
                                <i class="bi bi-shield-plus"></i> Enable 2FA
                            </button>
                        </div>
                        <div class="col-md-6">
                            <h6>Login Sessions</h6>
                            <p class="text-muted">Manage your active login sessions</p>
                            <button class="btn btn-outline-danger">
                                <i class="bi bi-power"></i> Logout All Devices
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
.form-switch .form-check-input {
    width: 3em;
    height: 1.5em;
}

.form-switch .form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

.card-header {
    border-bottom: 2px solid rgba(0,0,0,0.1);
}

.settings-section {
    padding: 1.5rem 0;
    border-bottom: 1px solid #dee2e6;
}

.settings-section:last-child {
    border-bottom: none;
}
</style>
@endsection
@endsection