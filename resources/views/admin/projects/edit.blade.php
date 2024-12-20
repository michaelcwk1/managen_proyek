@extends('layouts.admin')

@section('page-title')
   Edit Project
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Projects</a></li>
        <li class="breadcrumb-item active">Edit Project</li>
    </ol>
@endsection

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Project</h1>

    <!-- Form untuk mengedit project -->
    <form action="{{ route('admin.projects.update', $project->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Menandakan ini adalah update request -->
        
        <div class="card">
            <div class="card-body">
                <div class="form-group mt-3">
                    <label for="name">Project Name</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                        value="{{ old('name', $project->name) }}" placeholder="Enter project name" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="client_name">Client Name</label>
                    <input type="text" name="client_name" id="client_name" 
                        class="form-control @error('client_name') is-invalid @enderror" 
                        value="{{ old('client_name', $project->client_name) }}" placeholder="Enter client name" required>
                    @error('client_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="4" 
                        class="form-control @error('description') is-invalid @enderror" 
                        placeholder="Enter project description" required>{{ old('description', $project->description) }}</textarea>
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="start_date">Start Date</label>
                    <input type="date" name="start_date" id="start_date" 
                        class="form-control @error('start_date') is-invalid @enderror" 
                        value="{{ old('start_date', $project->start_date) }}" required>
                    @error('start_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" 
                        class="form-control @error('end_date') is-invalid @enderror" 
                        value="{{ old('end_date', $project->end_date) }}" required>
                    @error('end_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status', $project->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="on_hold" {{ old('status', $project->status) == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Update Project</button>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
