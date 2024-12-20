@extends('layouts.user')

@section('page-title')
    Task Report
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Task Report</li>
    </ol>
@endsection

@section('content')
    <div class="container">
        <h1>Task Report</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($tasks->isEmpty())
            <p>You have no tasks in progress.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Project</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->project->name ?? 'No Project' }}</td>
                            <td>{{ $task->deadline }}</td>
                            <td>{{ ucfirst($task->status) }}</td>
                            <td>
                                @if ($task->status == 'in_progress')
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#doneModal-{{ $task->id }}">Mark as Done</button>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="doneModal-{{ $task->id }}" tabindex="-1"
                            aria-labelledby="doneModalLabel-{{ $task->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="doneModalLabel-{{ $task->id }}">Task Completed</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('user.tasks.submitTask', $task->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div>
                                                <label for="submission_file">Upload ZIP/RAR file:</label>
                                                <input type="file" name="submission_file" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Done</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
