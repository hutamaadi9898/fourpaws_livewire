<?php

use App\Livewire\CreateMemorial;
use App\Livewire\Landing;
use App\Livewire\ShowMemorial;
use Illuminate\Support\Facades\Route;

// Landing and marketing pages
Route::get('/', Landing::class)->name('landing');
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/terms', 'terms')->name('terms');

// Authentication routes (Breeze)
require __DIR__.'/auth.php';

// Dashboard (requires authentication)
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Memorial routes (create requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/memorials/create', CreateMemorial::class)->name('memorials.create');
    Route::get('/memorials/{memorial}/edit', App\Livewire\EditMemorial::class)->name('memorials.edit');
    Route::get('/tributes/moderate', App\Livewire\TributeModeration::class)->name('tributes.moderate');
});

// Public memorial viewing
Route::get('/memorials/{memorial:slug}', ShowMemorial::class)->name('memorials.show');

// Fallback for memorial slugs at root level
Route::get('/{memorial:slug}', ShowMemorial::class)
    ->where('memorial', '^(?!memorials|admin|filament|login|register|api|privacy|terms|dashboard|profile|logout).+$');
