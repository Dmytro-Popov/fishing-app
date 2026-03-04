<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatchController;
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
    Route::resource('catches', CatchController::class);
    Route::get('/stats', [CatchController::class, 'stats'])->name('stats');
});

Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'de'])) {
        session(['locale' => $locale]);
        session()->save();
    }

    return redirect()->back();
})->name('language.switch');

require __DIR__ . '/auth.php';
