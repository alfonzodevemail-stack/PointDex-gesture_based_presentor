<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');

/*
|--------------------------------------------------------------------------
| Authenticated & Protected Routes (Exam Part 2 Requirement)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Presenter Dashboard
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    // PointDex Presentation CRUD Module (Resource Routes)
    Route::resource('presentations', PresentationController::class);

    // Presenter Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';