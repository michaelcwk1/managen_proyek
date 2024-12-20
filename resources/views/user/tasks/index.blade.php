@extends('layouts.user')

@section('page-title')
    Task List
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Task List</li>
    </ol>
@endsection

@section('content')
    <div class="container">
        <h1>Task List</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($tasks->isEmpty())
            <p>No tasks available.</p>
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
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#taskModal-{{ $task->id }}">View</button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="taskModal-{{ $task->id }}" tabindex="-1"
                            aria-labelledby="taskModalLabel-{{ $task->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="taskModalLabel-{{ $task->id }}">Task Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Title:</strong> {{ $task->title }}</p>
                                        <p><strong>Description:</strong> {{ $task->description }}</p>
                                        <p><strong>Deadline:</strong> {{ $task->deadline }}</p>
                                        <p><strong>Status:</strong> {{ ucfirst($task->status) }}</p>

                                        <!-- Display file path if available -->
                                        @if ($task->file_path)
                                            <p><strong>Attached File:</strong> <a
                                                    href="{{ asset('storage/' . $task->file_path) }}" target="_blank">View
                                                    File</a></p>
                                        @else
                                            <p>No file attached.</p>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        @if ($task->status === 'pending')
                                            <form method="POST" action="{{ route('user.tasks.take', $task->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Take Task</button>
                                            </form>
                                        @else
                                            <button class="btn btn-secondary" disabled>Already Taken</button>
                                        @endif
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
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
