<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Team Members - HR Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { 
            background: #f8f9fa; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header-section {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
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
    </style>
</head>
<body>
    <div class="header-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <h2><i class="bi bi-people"></i> Manage Team Members</h2>
                    <p class="mb-0">Assign employees to managers and manage team structure</p>
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
                    <h4>Team Assignments</h4>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createTeamMemberModal">
                        <i class="bi bi-plus-circle"></i> Assign Team Member
                    </button>
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
                                        <th>ID</th>
                                        <th>Manager</th>
                                        <th>Employee</th>
                                        <th>Position</th>
                                        <th>Join Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($teamMembers as $member)
                                    <tr>
                                        <td>{{ $member->id }}</td>
                                        <td>{{ $member->manager->name }}</td>
                                        <td>{{ $member->employee->name }}</td>
                                        <td>{{ $member->position ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($member->join_date)->format('M d, Y') }}</td>
                                        <td>
                                            @php
                                                $statusClass = match($member->status) {
                                                    'active' => 'bg-success',
                                                    'inactive' => 'bg-secondary',
                                                    'on_leave' => 'bg-warning',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $member->status)) }}</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewTeamMember('{{ $member->employee->name }}', '{{ $member->manager->name }}', '{{ $member->position }}', '{{ $member->notes }}')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <form method="POST" action="{{ route('superadmin.manager-data.team-members.delete', $member) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No team assignments found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        {{ $teamMembers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Team Member Modal -->
    <div class="modal fade" id="createTeamMemberModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign Team Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('superadmin.manager-data.team-members.create') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="manager_id" class="form-label">Manager</label>
                                    <select class="form-select" id="manager_id" name="manager_id" required>
                                        <option value="">Select Manager</option>
                                        @foreach($managers as $manager)
                                            <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="employee_id" class="form-label">Employee</label>
                                    <select class="form-select" id="employee_id" name="employee_id" required>
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="position" class="form-label">Position</label>
                                    <input type="text" class="form-control" id="position" name="position" placeholder="e.g., Senior Developer">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="join_date" class="form-label">Join Date</label>
                                    <input type="date" class="form-control" id="join_date" name="join_date" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="on_leave">On Leave</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Additional notes about this assignment..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Assign Team Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Team Member Modal -->
    <div class="modal fade" id="viewTeamMemberModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTeamMemberTitle">Team Member Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="viewTeamMemberContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function viewTeamMember(employee, manager, position, notes) {
        document.getElementById('viewTeamMemberTitle').textContent = employee + ' - Team Assignment';
        const content = `
            <div class="row">
                <div class="col-md-6"><strong>Employee:</strong> ${employee}</div>
                <div class="col-md-6"><strong>Manager:</strong> ${manager}</div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6"><strong>Position:</strong> ${position || 'N/A'}</div>
            </div>
            ${notes ? `<div class="row mt-2"><div class="col-12"><strong>Notes:</strong><br>${notes}</div></div>` : ''}
        `;
        document.getElementById('viewTeamMemberContent').innerHTML = content;
        new bootstrap.Modal(document.getElementById('viewTeamMemberModal')).show();
    }
    </script>
</body>
</html>