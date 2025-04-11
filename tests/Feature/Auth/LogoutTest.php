<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('users can logout', function () {

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
            ->where('auth.user', auth()->user())
        );

    $this
        ->followingRedirects()
        ->post(route('logout'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Auth/Login')
        );

    $this->assertGuest();
});
