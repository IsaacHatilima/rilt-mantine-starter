<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('user can enable 2FA', function () {
    $user = User::factory()->create([
        'password' => Hash::make('Password1#'),
    ]);

    $this->get(route('login'));

    $this
        ->followingRedirects()
        ->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'Password1#',
        ])
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Dashboard')
        );

    $this->get(route('security.edit'))
        ->assertInertia(fn (Assert $page) => $page
            ->component('Profile/Security')
            ->where('errors', [])
        );

    $this
        ->followingRedirects()
        ->put(route('enable.fortify'), [
            'current_password' => 'Password1#',
        ])
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Profile/Security')
            ->whereNot('auth.user.two_factor_secret', null)
            ->whereNot('auth.user.two_factor_recovery_codes', null)
            ->where('auth.user.two_factor_confirmed_at', null)
        );
});

test('user cannot enable 2FA with wrong password', function () {
    $user = User::factory()->create([
        'password' => Hash::make('Password1#'),
    ]);

    $this->get(route('login'));

    $this
        ->followingRedirects()
        ->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'Password1#',
        ])
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Dashboard')
        );

    $this->get(route('security.edit'))
        ->assertInertia(fn (Assert $page) => $page
            ->component('Profile/Security')
            ->where('errors', [])
        );

    $this
        ->followingRedirects()
        ->put(route('enable.fortify'), [
            'current_password' => 'Password12h#',
        ])
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Profile/Security')
            ->has('errors')
            ->where('errors.current_password', 'Current password is incorrect.')
        );
});
