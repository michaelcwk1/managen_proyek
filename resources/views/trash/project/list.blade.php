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
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Daftar Proyek</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            {{-- @if($projects->isEmpty())
                <p class="text-center">Belum ada proyek yang ditambahkan.</p>
            @else --}}
                <table class="table table-bordered table-striped">
                    <thead  >
                        <tr>
                            <th>No</th>
                            <th>Nama Proyek</th>
                            <th>Klien</th>
                            <th>Total Task</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach($projects as $project)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->client_name }}</td>
                            <td>
                                <span class="badge {{ $project->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </td>
                            <td>{{ $project->start_date }}</td>
                            <td>{{ $project->end_date }}</td>
                            <td>{{ $project->creator->name ?? 'Admin' }}</td>
                        </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            {{-- @endif --}}
        </div>
    </div>
</div>
@endsection