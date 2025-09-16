<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\TopicController;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::middleware(['web'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/feed', [FeedController::class, 'index'])
    ->middleware('auth')
    ->name('feed');

Route::get('/topics', [TopicController::class, 'edit'])
    ->middleware('auth')
    ->name('topics');

Route::put('/topics', [TopicController::class, 'update'])
    ->middleware('auth')
    ->name('topics.update');
