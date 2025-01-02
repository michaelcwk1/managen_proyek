@extends('layouts.user')

@section('page-title')
    Dashboard
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
@endsection
@section('content')
    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Total Tasks Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card total-tasks-card">
                            <div class="card-body">
                                <h5 class="card-title">Total Tasks </h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-list-check"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $tasks->count() }}</h6> <!-- Display the total number of tasks -->
                                        <span
                                            class="text-success small pt-1 fw-bold">{{ $tasks->where('status', 'completed')->count() }}%</span>
                                        <span class="text-muted small pt-2 ps-1">completed</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- End Total Tasks Card -->

                    <!-- In-Progress Tasks Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card in-progress-tasks-card">
                            <div class="card-body">
                                <h5 class="card-title">In-Progress Tasks </h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $tasks->where('status', 'in_progress')->count() }}</h6>
                                        <!-- Display in-progress tasks -->

                                        <span class="text-warning small pt-1 fw-bold">8%</span> <span
                                            class="text-muted small pt-2 ps-1">increase</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End In-Progress Tasks Card -->

                    <!-- Completed Tasks Card -->
                    <div class="col-xxl-4 col-xl-12">

                        <div class="card info-card completed-tasks-card">
                            <div class="card-body">
                                <h5 class="card-title">Completed Tasks </h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-check-circle"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $tasks->where('status', 'completed')->count() }}</h6>
                                        <!-- Display completed tasks -->

                                        <span class="text-success small pt-1 fw-bold">5%</span> <span
                                            class="text-muted small pt-2 ps-1">increase</span>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Completed Tasks Card -->
                </div>
                <!-- Recent Tasks Card -->
                <div class="col-12">
                    <div class="card recent-tasks overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Recent Tasks </h5>
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Task Name</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Assigned To</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $task)
                                        <tr>
                                            <th scope="row"><a href="#">#{{ $task->id }}</a></th>
                                            <td>{{ $task->title }}</td>
                                            <td><span
                                                    class="badge bg-{{ $task->status == 'completed' ? 'success' : ($task->status == 'in_progress' ? 'warning' : 'danger') }}">{{ ucfirst($task->status) }}</span>
                                            </td>
                                            <td>{{ $task->user->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

                <!-- End Recent Tasks Card -->

            </div><!-- End Left side columns -->


            <!-- Right side columns -->
            <div class="col-lg-4">

                <!-- Recent Activity -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Recent Activity</h5>
                        <div class="activity" style="max-height: 250x; overflow-y: auto;">
                            <!-- Show the most recent activities first -->
                            @foreach ($tasks->reverse()->take(5) as $task)
                                <div class="activity-item d-flex">
                                    <div class="activite-label">Today</div>
                                    <i
                                        class="bi bi-circle-fill activity-badge text-{{ $task->status == 'completed' ? 'success' : ($task->status == 'in-progress' ? 'warning' : 'danger') }} align-self-start"></i>
                                    <div class="activity-content">
                                        Task {{ $task->title }} status changed to <span
                                            class="fw-bold text-dark">{{ ucfirst($task->status) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- End Recent Activity -->



                <!-- Recent Submission -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Recent Submissions</h5>

                        <div class="activity" style="max-height: 300px; overflow-y: auto;">
                            @foreach ($submissions->reverse()->take(5) as $submission)
                                <div class="activity-item d-flex">
                                    <div class="activite-label">Today</div>
                                    <i
                                        class="bi bi-file-earmark-check activity-badge text-{{ $submission->status == 'approved' ? 'success' : ($submission->status == 'pending' ? 'warning' : 'danger') }} align-self-start"></i>
                                    <div class="activity-content">
                                        Submission for Task: <strong>{{ $submission->task->title }}</strong>
                                        <br>
                                        Status: <span class="fw-bold text-dark">{{ ucfirst($submission->status) }}</span>
                                        <br>
                                        File: <a href="{{ asset($submission->file_path) }}" target="_blank">Download</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- End Recent Submission -->




            </div><!-- End Right side columns -->

        </div>
    </section>
@endsection

