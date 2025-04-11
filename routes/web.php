<?php

use App\Http\Controllers\Auth\CustomFortifyController;
use App\Http\Controllers\Auth\SecurityController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/security', [SecurityController::class, 'edit'])->name('security.edit');
    Route::put('/security', [SecurityController::class, 'copyRecoveryCodes'])->name('security.put');
    Route::put('/enable-fortify', [CustomFortifyController::class, 'enable'])->name('enable.fortify');
    Route::put('/disable-fortify', [CustomFortifyController::class, 'disable'])->name('disable.fortify');
    Route::put('/confirm-fortify-2fa', [CustomFortifyController::class, 'confirm'])->name('confirm.fortify');
});

require __DIR__.'/auth.php';
