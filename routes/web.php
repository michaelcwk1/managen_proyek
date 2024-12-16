<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\TaskController;

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
});

// User routes
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    // User Dashboard
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    
    // Task Routes
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks/{task}/take', [TaskController::class, 'takeTask'])->name('tasks.take');
    Route::get('/tasks/report', [TaskController::class, 'report'])->name('tasks.report');
    
   
    
});
