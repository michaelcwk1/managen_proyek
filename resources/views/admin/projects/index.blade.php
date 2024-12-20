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
    <div class="container">
        <div class="row justify-content-between mb-4">
            <div class="col-auto">
                <h2>Projects</h2>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i> New Project
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Client</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ $project->client_name }}</td>
                                    <td>{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d M Y') : '-' }}
                                    </td>
                                    <td>{{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d M Y') : '-' }}
                                    </td>

                                    <td>
                                        <span
                                            class="badge bg-{{ $project->status === 'active' ? 'success' : ($project->status === 'completed' ? 'primary' : 'warning') }}">
                                            {{ $project->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.projects.edit', $project) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                {{ $projects->links() }}
            </div>
        </div>
    </div>
@endsection
