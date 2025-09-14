<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Manager Settings - HR Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { 
            background: #f8f9fa; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header-section {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
        .btn {
            border-radius: 8px;
        }
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
</head>
<body>
    <div class="header-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <h2><i class="bi bi-gear-fill"></i> Manage Manager Settings</h2>
                    <p class="mb-0">Configure manager preferences and system settings</p>
                </div>
                <div class="col-auto">
                    <a href="{{ route('superadmin.dashboard') }}" class="btn btn-light">
                        <i class="bi bi-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Manager Settings Configuration</h4>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Manager</th>
                                        <th>Email Notifications</th>
                                        <th>Push Notifications</th>
                                        <th>Weekly Reports</th>
                                        <th>Auto Approve Leaves</th>
                                        <th>Team Size Limit</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($settings as $setting)
                                    <tr>
                                        <td>{{ $setting->user->name }}</td>
                                        <td>
                                            <span class="badge {{ $setting->email_notifications ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $setting->email_notifications ? 'Enabled' : 'Disabled' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $setting->push_notifications ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $setting->push_notifications ? 'Enabled' : 'Disabled' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $setting->weekly_reports ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $setting->weekly_reports ? 'Enabled' : 'Disabled' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $setting->auto_approve_leaves ? 'bg-warning' : 'bg-info' }}">
                                                {{ $setting->auto_approve_leaves ? 'Auto' : 'Manual' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $setting->team_size_limit }} members</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-warning" onclick="editSettings({{ $setting->id }}, {{ $setting->email_notifications ? 'true' : 'false' }}, {{ $setting->push_notifications ? 'true' : 'false' }}, {{ $setting->weekly_reports ? 'true' : 'false' }}, {{ $setting->auto_approve_leaves ? 'true' : 'false' }}, {{ $setting->team_size_limit }})">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No manager settings found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        {{ $settings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Settings Modal -->
    <div class="modal fade" id="editSettingsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Manager Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="editSettingsForm">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-3">Notification Settings</h6>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="edit_email_notifications" name="email_notifications" value="1">
                                        <label class="form-check-label" for="edit_email_notifications">
                                            Email Notifications
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="edit_push_notifications" name="push_notifications" value="1">
                                        <label class="form-check-label" for="edit_push_notifications">
                                            Push Notifications
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3">System Settings</h6>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="edit_weekly_reports" name="weekly_reports" value="1">
                                        <label class="form-check-label" for="edit_weekly_reports">
                                            Weekly Reports
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="edit_auto_approve_leaves" name="auto_approve_leaves" value="1">
                                        <label class="form-check-label" for="edit_auto_approve_leaves">
                                            Auto Approve Leaves
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_team_size_limit" class="form-label">Team Size Limit</label>
                                    <input type="number" class="form-control" id="edit_team_size_limit" name="team_size_limit" min="1" max="100" required>
                                    <div class="form-text">Maximum number of team members this manager can have</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Update Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function editSettings(id, emailNotifications, pushNotifications, weeklyReports, autoApproveLeaves, teamSizeLimit) {
        document.getElementById('edit_email_notifications').checked = emailNotifications;
        document.getElementById('edit_push_notifications').checked = pushNotifications;
        document.getElementById('edit_weekly_reports').checked = weeklyReports;
        document.getElementById('edit_auto_approve_leaves').checked = autoApproveLeaves;
        document.getElementById('edit_team_size_limit').value = teamSizeLimit;
        
        document.getElementById('editSettingsForm').action = `{{ route('superadmin.manager-data.manager-settings.update', '') }}/${id}`;
        new bootstrap.Modal(document.getElementById('editSettingsModal')).show();
    }
    </script>
</body>
</html>