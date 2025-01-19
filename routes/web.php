<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Categories;
use App\Livewire\JobPositionDetails;
use App\Livewire\JobPositions;

Route::get('/', JobPositions::class)->name('positions.index');
Route::get('/positions/{position}', JobPositionDetails::class)->name('positions.show');
Route::get('/categories', Categories::class)->name('categories.index');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
