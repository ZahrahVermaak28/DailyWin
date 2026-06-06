<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminControllerAZU;
use App\Http\Controllers\CategoryControllerAZU;
use App\Http\Controllers\DashboardControllerAZU;
use App\Http\Controllers\TaskControllerAZU;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', DashboardControllerAZU::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(["auth", "verified"])->group(function () {
    Route::patch('tasks/{task}/status', [TaskControllerAZU::class, 'updateStatus'])->name('tasks.update-status');
    Route::resource('tasks', TaskControllerAZU::class);

    Route::middleware('role:admin')->group(function () {
        Route::get('admin', [AdminControllerAZU::class, 'index'])->name('admin.index');
        Route::resource('categories', CategoryControllerAZU::class)->except('show');
    });
});
