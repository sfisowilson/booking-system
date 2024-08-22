<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Role-specific routes
Route::view('professional-dashboard', 'pages.professional.dashboard')
    ->middleware(['auth', 'role:professional'])
    ->name('professional.dashboard');


Route::view('client-dashboard', 'pages.client.dashboard')
    ->middleware(['auth', 'role:client'])
    ->name('client.dashboard');

require __DIR__.'/auth.php';
