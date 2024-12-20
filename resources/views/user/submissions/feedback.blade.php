@extends('layouts.user')

@section('page-title')
    Task Feedback
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Task Feedback</li>
    </ol>
@endsection

@section('content')
    <div class="container">
        <h1>Task Feedback</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-header">
                Rejection Feedback
            </div>
            <div class="card-body">
                <p><strong>Rejection Notes:</strong></p>
                <p>{{ $submission->notes }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Submit Revision
            </div>
            <div class="card-body">
                <form action="{{ route('user.submissions.revise', ['submission' => $submission->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">Upload Revised Task (ZIP or RAR)</label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file"
                            name="file" required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Revision</button>
                </form>
            </div>
        </div>
    </div>
@endsection
