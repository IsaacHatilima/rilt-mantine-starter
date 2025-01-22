<?php

use App\Models\User;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'test@example.com',
        'password' => 'Password1#',
        'password_confirmation' => 'Password1#',
    ]);

    $response->assertSessionHasNoErrors();

    $this->assertAuthenticated();

    $response->assertRedirect(route('dashboard', absolute: false));

    // Assert that the user was created in the database
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);

    // Check if the user's profile was created correctly
    $user = User::where('email', 'test@example.com')->first();
    $this->assertEquals('John', $user->profile->first_name);
    $this->assertEquals('Doe', $user->profile->last_name);

});

test('user registration fails', function () {
    $response = $this->post('/register', [
        'first_name' => '',
        'last_name' => '',
        'email' => 'invalid-email',
        'password' => 'short',
        'password_confirmation' => 'not-matching',
    ]);

    $response->assertSessionHasErrors(['first_name', 'last_name', 'email', 'password']);

    $this->assertGuest();

    $this->assertDatabaseMissing('users', [
        'email' => 'invalid-email',
    ]);

});
