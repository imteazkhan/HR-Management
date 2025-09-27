<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Performance Reviews - HR Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body { 
            background: #f8f9fa; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header-section {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
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
                    <h2><i class="bi bi-graph-up"></i> Manage Performance Reviews</h2>
                    <p class="mb-0">Create and manage employee performance evaluations</p>
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
                    <h4>Performance Reviews</h4>
                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#createReviewModal">
                        <i class="bi bi-plus-circle"></i> Create Review
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
                                        <th>Employee</th>
                                        <th>Reviewer</th>
                                        <th>Score</th>
                                        <th>Rating</th>
                                        <th>Status</th>
                                        <th>Review Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reviews as $review)
                                    <tr>
                                        <td>{{ $review->id }}</td>
                                        <td>{{ $review->employee->name }}</td>
                                        <td>{{ $review->reviewer->name }}</td>
                                        <td>
                                            @if($review->score)
                                                <span class="badge bg-primary">{{ $review->score }}%</span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $ratingClass = match($review->rating) {
                                                    'outstanding' => 'bg-success',
                                                    'excellent' => 'bg-info',
                                                    'good' => 'bg-primary',
                                                    'satisfactory' => 'bg-warning',
                                                    'needs_improvement' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $ratingClass }}">{{ ucfirst(str_replace('_', ' ', $review->rating)) }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = match($review->status) {
                                                    'completed' => 'bg-success',
                                                    'approved' => 'bg-info',
                                                    'draft' => 'bg-warning',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }}">{{ ucfirst($review->status) }}</span>
                                        </td>
                                        <td>{{ $review->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewReview({{ $review->id }}, '{{ $review->employee->name }}', '{{ $review->rating }}', {{ $review->score ?? 0 }}, '{{ $review->comments }}')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning" onclick="editReview({{ $review->id }}, {{ $review->score ?? 0 }}, '{{ $review->rating }}', '{{ $review->comments }}', '{{ $review->status }}')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form method="POST" action="{{ route('superadmin.manager-data.performance-reviews.delete', $review) }}" class="d-inline">
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
                                        <td colspan="8" class="text-center">No performance reviews found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Review Modal -->
    <div class="modal fade" id="createReviewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Performance Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('superadmin.manager-data.performance-reviews.create') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reviewer_id" class="form-label">Reviewer</label>
                                    <select class="form-select" id="reviewer_id" name="reviewer_id" required>
                                        <option value="">Select Reviewer</option>
                                        @foreach($managers as $manager)
                                            <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="score" class="form-label">Score (0-100)</label>
                                    <input type="number" class="form-control" id="score" name="score" min="0" max="100">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="completed_tasks" class="form-label">Completed Tasks</label>
                                    <input type="number" class="form-control" id="completed_tasks" name="completed_tasks" min="0" value="0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="on_time_rate" class="form-label">On-Time Rate (%)</label>
                                    <input type="number" class="form-control" id="on_time_rate" name="on_time_rate" min="0" max="100" step="0.1" value="0">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rating" class="form-label">Rating</label>
                                    <select class="form-select" id="rating" name="rating" required>
                                        <option value="outstanding">Outstanding</option>
                                        <option value="excellent">Excellent</option>
                                        <option value="good">Good</option>
                                        <option value="satisfactory" selected>Satisfactory</option>
                                        <option value="needs_improvement">Needs Improvement</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="draft">Draft</option>
                                        <option value="completed">Completed</option>
                                        <option value="approved">Approved</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="comments" class="form-label">Comments</label>
                            <textarea class="form-control" id="comments" name="comments" rows="4" placeholder="Detailed feedback and comments..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">Create Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Review Modal -->
    <div class="modal fade" id="editReviewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Performance Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" id="editReviewForm">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="edit_score" class="form-label">Score (0-100)</label>
                                    <input type="number" class="form-control" id="edit_score" name="score" min="0" max="100">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="edit_rating" class="form-label">Rating</label>
                                    <select class="form-select" id="edit_rating" name="rating" required>
                                        <option value="outstanding">Outstanding</option>
                                        <option value="excellent">Excellent</option>
                                        <option value="good">Good</option>
                                        <option value="satisfactory">Satisfactory</option>
                                        <option value="needs_improvement">Needs Improvement</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="edit_status" class="form-label">Status</label>
                                    <select class="form-select" id="edit_status" name="status" required>
                                        <option value="draft">Draft</option>
                                        <option value="completed">Completed</option>
                                        <option value="approved">Approved</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="edit_comments" class="form-label">Comments</label>
                            <textarea class="form-control" id="edit_comments" name="comments" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Update Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Review Modal -->
    <div class="modal fade" id="viewReviewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewReviewTitle">Performance Review Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="viewReviewContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function viewReview(id, employee, rating, score, comments) {
        document.getElementById('viewReviewTitle').textContent = employee + ' - Performance Review';
        const content = `
            <div class="row">
                <div class="col-md-6"><strong>Employee:</strong> ${employee}</div>
                <div class="col-md-6"><strong>Score:</strong> ${score}%</div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6"><strong>Rating:</strong> ${rating.replace('_', ' ')}</div>
            </div>
            ${comments ? `<div class="row mt-3"><div class="col-12"><strong>Comments:</strong><br>${comments}</div></div>` : ''}
        `;
        document.getElementById('viewReviewContent').innerHTML = content;
        new bootstrap.Modal(document.getElementById('viewReviewModal')).show();
    }

    function editReview(id, score, rating, comments, status) {
        document.getElementById('edit_score').value = score;
        document.getElementById('edit_rating').value = rating;
        document.getElementById('edit_comments').value = comments;
        document.getElementById('edit_status').value = status;
        document.getElementById('editReviewForm').action = `{{ route('superadmin.manager-data.performance-reviews.update', '') }}/${id}`;
        new bootstrap.Modal(document.getElementById('editReviewModal')).show();
    }
    </script>
</body>
</html>