@extends('layouts.user')

@section('page-title')
    Submitted Tasks
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Submitted Tasks</li>
    </ol>
@endsection
@section('content')
<div class="container">
    <h1>My Submissions</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Project</th>
                    <th>Status</th>
                    <th>Submission Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submissions as $submission)
                    <tr>
                        <td>{{ $submission->task->title }}</td>
                        <td>{{ $submission->task->project->name }}</td>
                        <td>{{ ucfirst($submission->status) }}</td>
                        <td>{{ $submission->submission_date }}</td>
                        <td>
                            @if($submission->status === 'rejected')
                                <a href="{{ route('user.submissions.feedback', $submission->id) }}" 
                                   class="btn btn-info btn-sm">
                                    View Feedback
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection