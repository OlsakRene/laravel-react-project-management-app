<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware(['auth', 'verified'])->group(function() {    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('project', ProjectController::class);

    // Admin-only routes for project creation, editing, and deletion
    Route::middleware('is_admin:admin')->group(function () {
        Route::get('/project/create', [ProjectController::class, 'create'])->name('project.create');
        Route::post('project', [ProjectController::class, 'store'])->name('project.store');
        Route::get('project/{project}/edit', [ProjectController::class, 'edit'])->name('project.edit');
        Route::put('project/{project}', [ProjectController::class, 'update'])->name('project.update');
        Route::delete('project/{project}', [ProjectController::class, 'destroy'])->name('project.destroy');
    });

    Route::get('/task/my-tasks', [TaskController::class, 'myTasks'])->name('task.myTasks');
    Route::resource('task', TaskController::class);
    Route::resource('user', UserController::class)->middleware('is_admin:admin');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
