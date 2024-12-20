    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Auth\LoginController;
    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\User\TaskController;
    use App\Http\Controllers\User\SubmissionController;

    // Auth routes
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Admin routes
    Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Admin Dashboard
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::resource('projects', App\Http\Controllers\Admin\ProjectController::class);
        Route::resource('tasks', App\Http\Controllers\Admin\TaskController::class);
        Route::put('admin/tasks/{task}', [TaskController::class, 'update'])->name('admin.tasks.update');

        // submission
        Route::get('/reporting', [App\Http\Controllers\Admin\SubmissionController::class, 'index'])->name('reporting.report');

        // Submission actions
        Route::post('/submissions/{submission}/approve', [App\Http\Controllers\Admin\SubmissionController::class, 'approve'])->name('submissions.approve');
        Route::post('/submissions/{submission}/reject', [App\Http\Controllers\Admin\SubmissionController::class, 'reject'])->name('submissions.reject');


        // Download route - Perbaikan method dari download menjadi downloadFile
        Route::get('admin/submissions/download/{id}', [SubmissionController::class, 'download'])
        ->name('admin.submissions.download');
        Route::get('/submission/{id}/download', [SubmissionController::class, 'download'])->name('submission.download');
        Route::get('/submissions/{submission}/download', [App\Http\Controllers\Admin\SubmissionController::class, 'download'])->name('submissions.download');
    });

    // User routes
    Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
        // User Dashboard
        Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');

        // Task Routes
        Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::post('/tasks/{task}/take', [TaskController::class, 'takeTask'])->name('tasks.take');
        Route::post('/tasks/{task}/submit', [TaskController::class, 'submitTask'])->name('tasks.submitTask');
        Route::get('/tasks/report', [TaskController::class, 'report'])->name('tasks.report');

        // Submission Routes
        Route::get('submissions', [TaskController::class, 'submissionIndex'])->name('submissions.index');
        Route::post('submissions/submit-all', [TaskController::class, 'submitAll'])->name('submissions.submit-all');
        Route::post('/tasks/{id}/submit', [TaskController::class, 'submitTask'])->name('tasks.submitTask');
        Route::get('/submissions', [SubmissionController::class, 'indexSubmissions'])
            ->name('submissions.index');

        Route::get('/submissions/{submission}/feedback', [SubmissionController::class, 'showFeedback'])
            ->name('submissions.feedback');


        Route::post('/submissions/{submission}/revise', [SubmissionController::class, 'reviseSubmission'])
            ->name('submissions.revise');
    });
