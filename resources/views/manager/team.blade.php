@extends('layouts.manager')

@section('title', 'My Team - Manager Dashboard')
@section('page-title', 'My Team')
@section('page-icon', 'bi bi-people')
@section('page-description', 'View and manage your team members')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-people"></i> My Team</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Position</th>
                                    <th>Status</th>
                                    <th>Join Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teamMembers as $member)
                                <tr>
                                    <td>{{ $member['name'] }}</td>
                                    <td>{{ $member['email'] }}</td>
                                    <td>{{ $member['position'] }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ $member['status'] }}</span>
                                    </td>
                                    <td>{{ $member['join_date'] }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i> View
                                        </button>
                                        <button class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No team members found</td>
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