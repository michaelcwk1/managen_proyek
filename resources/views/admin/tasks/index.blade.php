@extends('layouts.admin')

@section('page-title')
    Task List
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Projects</a></li>
        <li class="breadcrumb-item active">Tasks</li>
    </ol>
@endsection

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Task List</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary mb-3">Create New Task</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Project</th>
                    <th>Assigned User</th>
                    <th>Status</th>
                    <th>Deadline</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->project->name }}</td>
                        <td>
                            @if ($task->assigned_to)
                                {{ $task->assignedTo->role ?? 'Unassigned' }}
                            @else
                                Unassigned
                            @endif
                        </td>
                        <td>{{ ucfirst($task->status) }}</td>
                        <td>{{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') : 'N/A' }}</td>
                        <td>
                            <a href="{{ route('admin.tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $tasks->links() }}
    </div>
@endsection
