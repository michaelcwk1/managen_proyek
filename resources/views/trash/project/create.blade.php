@extends('layouts.admin')

@section('page-title')
    Create New Projek
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
            <h4 class="mb-0">Tambah Proyek Baru</h4>
        </div>
        <div class="card-body">
            <form action=" " method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama Proyek</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama proyek" required>
                    </div>
                    <div class="col-md-6">
                        <label for="client_name" class="form-label">Nama Klien</label>
                        <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Masukkan nama klien" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Deskripsi proyek" required></textarea>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="ongoing">Sedang Berjalan</option>
                        <option value="completed">Selesai</option>
                    </select>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Tambah Proyek</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
