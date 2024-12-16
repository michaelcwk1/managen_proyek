@extends('layouts.admin')

@section('page-title')
   Project List
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
@endsection

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Create New Project</h1>
        <form action="{{ route('admin.projects.store') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="form-group mt-3">
                        <label for="name">Project Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                            value="{{ old('name') }}" placeholder="Enter project name" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="client_name">Client Name</label>
                        <input type="text" name="client_name" id="client_name" 
                            class="form-control @error('client_name') is-invalid @enderror" 
                            value="{{ old('client_name') }}" placeholder="Enter client name" required>
                        @error('client_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="4" 
                            class="form-control @error('description') is-invalid @enderror" 
                            placeholder="Enter project description" required>{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="deadline">Deadline</label>
                        <input type="date" name="deadline" id="deadline" 
                            class="form-control @error('deadline') is-invalid @enderror" 
                            value="{{ old('deadline') }}" required>
                        @error('deadline')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="on_hold" {{ old('status') == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">Create Project</button>
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection