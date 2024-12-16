@extends('layouts.admin')

@section('page-title')
   Create New Task
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Projects</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.tasks.index') }}">Tasks</a></li>
        <li class="breadcrumb-item active">Create Task</li>
    </ol>
@endsection

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Create New Task</h1>

    <!-- Form untuk membuat task -->
    <form action="{{ route('admin.tasks.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <!-- Task Title -->
                <div class="form-group mt-3">
                    <label for="title">Task Title</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                        value="{{ old('title') }}" placeholder="Enter task title" required>
                    @error('title')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Project Dropdown -->
                <div class="form-group mb-3">
                    <label for="project_id">Select Project</label>
                    <select name="project_id" id="project_id" class="form-control @error('project_id') is-invalid @enderror" required>
                        <option value="">Select Project</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Assigned To -->
                <div class="form-group mb-3">
                    <label for="assigned_to">Assign to User</label>
                    <select name="assigned_to" id="assigned_to" class="form-control @error('assigned_to') is-invalid @enderror" required>
                        <option value="">Select User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_to')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Deadline -->
                <div class="form-group mb-3">
                    <label for="deadline">Deadline</label>
                    <input type="date" name="deadline" id="deadline" 
                        class="form-control @error('deadline') is-invalid @enderror" 
                        value="{{ old('deadline') }}" required>
                    @error('deadline')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Create Task</button>
                    <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
