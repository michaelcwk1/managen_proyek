@extends('layouts.admin')

@section('page-title')
    Complete Tasks
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Complete Tasks</li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>List of Completed Tasks</h4>
        </div>
        <div class="card-body">
            @if ($completeTasks->isEmpty())
                <p>No completed tasks found.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Task Name</th>
                            <th>Submitted By</th>
                            <th>Submission Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($completeTasks as $task)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $task->task->name ?? 'N/A' }}</td>
                                <td>{{ $task->user->name ?? 'N/A' }}</td>
                                <td>{{ $task->submission_date }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
