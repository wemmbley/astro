<?php

use Illuminate\Support\Facades\Route;
use UI\App\Controllers\Auth\AuthWebController;
use UI\App\Controllers\FeedController;
use UI\App\Controllers\HomeController;
use UI\App\Controllers\MatrixController;
use UI\App\Controllers\NatalController;
use UI\App\Controllers\ProfileController;
use UI\App\Controllers\RepositoryController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/matrix', [MatrixController::class, 'index'])->name('matrix');
Route::get('/natal', [NatalController::class, 'index'])->name('natal');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/feed', [FeedController::class, 'index'])->name('feed');
Route::get('/repository/edit/{key}', [RepositoryController::class, 'edit'])->name('repo-edit');
Route::get('/natal/{lat}/{lon}/{date}/{time}', [NatalController::class, 'single'])->name('natal.single');
Route::get('/auth', [AuthWebController::class, 'auth'])->name('web-auth');
Route::get('/reg', [AuthWebController::class, 'reg'])->name('web-reg');
