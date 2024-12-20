<!-- admin/reporting/report.blade.php -->
@extends('layouts.admin')

@section('page-title')
    Submission Reports
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Submission Reports</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-between mb-4">
            <div class="col-auto">
                <h2>Reporting Task</h2>
            </div>

        </div>
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Task Title</th>
                                <th>Project</th>
                                <th>Submitted By</th>
                                <th>Submission Date</th>
                                <th>File</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($submissions as $submission)
                                <tr>
                                    <td>{{ $submission->task->title }}</td>
                                    <td>{{ $submission->task->project->name ?? 'No Project' }}</td>
                                    <td>{{ $submission->user->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($submission->submission_date)->format('d M Y H:i') }}</td>
                                    <td>
                                        @if ($submission->file_path)
                                            <a href="{{ route('admin.submissions.download', $submission->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="bi bi-download"></i> Download
                                            </a>
                                        @else
                                            <span class="text-muted">No file</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $submission->status === 'pending' ? 'warning' : ($submission->status === 'approved' ? 'success' : 'danger') }}">
                                            {{ ucfirst($submission->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($submission->status === 'pending')
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#approveModal-{{ $submission->id }}">
                                                Approve
                                            </button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#rejectModal-{{ $submission->id }}">
                                                Reject
                                            </button>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Approve Modal -->
                                <div class="modal fade" id="approveModal-{{ $submission->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Approve Submission</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.submissions.approve', $submission->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <p>Are you sure you want to approve this submission?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-success">Approve</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Reject Modal -->
                                <div class="modal fade" id="rejectModal-{{ $submission->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Reject Submission</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.submissions.reject', $submission->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="notes">Rejection Notes</label>
                                                        <textarea class="form-control" name="notes" rows="3" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Reject</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No submissions found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
