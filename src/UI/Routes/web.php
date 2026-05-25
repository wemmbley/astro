<?php

use Illuminate\Support\Facades\Route;
use UI\App\Controllers\AuthWebController;
use UI\App\Controllers\FeedController;
use UI\App\Controllers\HomeController;
use UI\App\Controllers\MatrixController;
use UI\App\Controllers\MessagesController;
use UI\App\Controllers\NatalController;
use UI\App\Controllers\ProfileController;
use UI\App\Controllers\RepositoryController;

# +-----------------------------------------------------------------------------------------------
# |
# | UNVERIFIED GUESTS PUBLIC PAGES.
# |
# +-----------------------------------------------------------------------------------------------
# |
# |
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/matrix', [MatrixController::class, 'index'])->name('matrix');
Route::get('/feed', [FeedController::class, 'index'])->name('feed');

Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthWebController::class, 'auth']);
    Route::get('/register', [AuthWebController::class, 'reg']);
});

Route::get('/login', function () {
    return redirect()->route('home');
})->name('login');

Route::prefix('natal')->name('natal.')->group(function () {
    Route::get('/', [NatalController::class, 'index'])->name('index');
    Route::get('/{lat}/{lon}/{date}/{time}', [NatalController::class, 'single'])->name('single');
});

# +-----------------------------------------------------------------------------------------------
# |
# | VERIFIED USERS AUTH PAGES.
# |
# +-----------------------------------------------------------------------------------------------
# |
# |
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/{id}', [ProfileController::class, 'index'])->name('index');
    });
    Route::get('/messages', [MessagesController::class, 'index'])->name('messages');

    Route::middleware(['admin'])->group(function () {
        Route::prefix('repository')->name('repository.')->group(function () {
            Route::get('/edit/{key}', [RepositoryController::class, 'edit'])->name('edit');
        });
    });
});
