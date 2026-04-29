<?php

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\MatrixController;
use App\Http\Controllers\Web\NatalController;
use App\Http\Controllers\Web\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/matrix', [MatrixController::class, 'index'])->name('matrix');
Route::get('/natal', [NatalController::class, 'index'])->name('natal');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

Route::get('/natal/{lat}/{lon}/{date}/{time}', [NatalController::class, 'single'])->name('natal.single');
