<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Halaman login
Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

// Proses login
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/profile', function () {
    return redirect()->route('dashboard');
})->name('profile.edit');

