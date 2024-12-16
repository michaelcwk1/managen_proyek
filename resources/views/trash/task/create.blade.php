@extends('layouts.admin')

@section('page-title')
   Create Task
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
            <h4 class="mb-0">Tambah Task Baru</h4>
        </div>
        <div class="card-body">
            <form action="{ " method="POST">
                @csrf
                <div class="mb-3">
                    <label for="project_id" class="form-label">Pilih Proyek</label>
                    <select class="form-select" id="project_id" name="project_id" required>
                        {{-- <option value="" disabled selected>Pilih Proyek</option>
                        @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach --}}
                    </select>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Task</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul task" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi Task</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Deskripsi task" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="due_date" class="form-label">Tanggal Tenggat</label>
                    <input type="date" class="form-control" id="due_date" name="due_date" required>
                </div>
                <div class="mb-3">
                    <label for="priority" class="form-label">Prioritas</label>
                    <select class="form-select" id="priority" name="priority" required>
                        <option value="low">Rendah</option>
                        <option value="medium">Sedang</option>
                        <option value="high">Tinggi</option>
                    </select>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Simpan Task</button>
                    <a href="#" class="btn btn-secondary">Cetak</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection