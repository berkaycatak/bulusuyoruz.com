<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Custom Routes
Route::get('/create', function () {
    return view('events.create');
})->middleware(['auth'])->name('events.create');

Route::get('/participate', function () {
    return view('events.participate');
})->name('events.participate');

Route::get('/result', function () {
    return view('events.result');
})->name('events.result');

require __DIR__.'/auth.php';
