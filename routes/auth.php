<?php

use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\SecurityController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register'); // Done

    Route::post('register', [RegisteredUserController::class, 'store']); // Done

    Route::get('login', [LoginController::class, 'create'])
        ->name('login');

    Route::get('/two-factor-challenge', function () {
        return Inertia::render('Auth/TwoFactorChallenge');
    })->name('two-factor.login');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request'); // Done

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email'); // Done

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset'); // Done

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store'); // Done
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify'); // Done

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send'); // Done

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [SecurityController::class, 'update'])->name('password.update');

    Route::post('logout', [LogoutController::class, 'destroy'])
        ->name('logout'); // Done
});
