<?php

use App\Livewire\Categories;
use App\Livewire\Companies;
use App\Livewire\CompanyDetails;
use App\Livewire\JobPositionDetails;
use App\Livewire\JobPositions;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', JobPositions::class)->name('positions.index');
Route::get('/positions/{position}', JobPositionDetails::class)->name('positions.show');
Route::get('/categories', Categories::class)->name('categories.index');
Route::get('/companies', Companies::class)->name('companies.index');
Route::get('/companies/{company:slug}', CompanyDetails::class)->name('companies.show');

// Member routes
Route::middleware(['auth', 'verified', 'role:member'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');
});

require __DIR__ . '/auth.php';
