<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use PragmaRX\Google2FA\Google2FA;

test('2FA users can authenticate with valid code', function () {
    // Create User
    $user = User::factory()->create([
        'password' => Hash::make('Password1#'),
    ]);

    // Enable 2FA
    $enable2FA = app(EnableTwoFactorAuthentication::class);
    $enable2FA($user);

    // Confirm 2FA (manually for test)
    $user->forceFill([
        'two_factor_confirmed_at' => now(),
    ])->save();

    // Initial login
    $this->get(route('login'));

    $this
        ->followingRedirects()
        ->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'Password1#',
        ])
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Auth/TwoFactorChallenge')
        );

    $decryptedSecret = Crypt::decrypt($user->two_factor_secret);
    $google2fa = new Google2FA;
    $otp = $google2fa->getCurrentOtp($decryptedSecret);

    // 2FA Challenge
    $this
        ->followingRedirects()
        ->post('/two-factor-challenge', [
            'code' => $otp,
        ])
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Dashboard')
        );
});

test('2FA users cannot authenticate with invalid code', function () {
    // Create User
    $user = User::factory()->create([
        'password' => Hash::make('Password1#'),
    ]);

    // Enable 2FA
    $enable2FA = app(EnableTwoFactorAuthentication::class);
    $enable2FA($user);

    // Confirm 2FA (manually for test)
    $user->forceFill([
        'two_factor_confirmed_at' => now(),
    ])->save();

    // Initial login
    $this->get(route('login.store'));

    $this
        ->followingRedirects()
        ->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'Password1#',
        ])
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Auth/TwoFactorChallenge')
        );

    // 2FA Challenge with invalid code
    $this
        ->followingRedirects()
        ->post('/two-factor-challenge', [
            'code' => '0011',
        ])
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Auth/TwoFactorChallenge')
        );
});
