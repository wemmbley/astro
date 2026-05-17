<?php

use Illuminate\Support\Facades\Route;
use UI\App\Controllers\AuthWebController;
use UI\App\Controllers\FeedController;
use UI\App\Controllers\HomeController;
use UI\App\Controllers\MatrixController;
use UI\App\Controllers\NatalController;
use UI\App\Controllers\ProfileController;
use UI\App\Controllers\RepositoryController;

// Публичные / одиночные страницы
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/matrix', [MatrixController::class, 'index'])->name('matrix');
Route::get('/feed', [FeedController::class, 'index'])->name('feed');

// Auth группой
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthWebController::class, 'auth'])->name('login');
    Route::get('/register', [AuthWebController::class, 'reg'])->name('register');
});

// Natal
Route::prefix('natal')->name('natal.')->group(function () {
    Route::get('/', [NatalController::class, 'index'])->name('index');
    Route::get('/{lat}/{lon}/{date}/{time}', [NatalController::class, 'single'])->name('single');
});

// Profile
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
});

// Repository
Route::prefix('repository')->name('repository.')->group(function () {
    Route::get('/edit/{key}', [RepositoryController::class, 'edit'])->name('edit');
});
