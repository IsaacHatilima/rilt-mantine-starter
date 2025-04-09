<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('user can delete their account', function () {
    $user = User::factory()->create(['email' => 'user@mail.com', 'password' => Hash::make('Password1#')]);

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

    $this->get(route('profile.edit'))
        ->assertInertia(fn (Assert $page) => $page
            ->component('Profile/Edit')
            ->where('errors', [])
        );

    $this
        ->followingRedirects()
        ->delete(route('profile.destroy'), [
            'current_password' => 'Password1#',
        ])
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Welcome')
        );

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create(['email' => 'user@mail.com', 'password' => Hash::make('Password1#')]);

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

    $this->get(route('profile.edit'))
        ->assertInertia(fn (Assert $page) => $page
            ->component('Profile/Edit')
            ->where('errors', [])
        );

    $this
        ->followingRedirects()
        ->delete(route('profile.destroy'), [
            'current_password' => 'Password1234#',
        ])
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Profile/Edit')
            ->has('errors')
            ->where('errors.current_password', 'Current password is incorrect.')
        );

    $this->assertDatabaseHas('users', ['id' => $user->id]);
});
