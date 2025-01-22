<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('password can be updated', function () {
    $user = User::factory()->create(['password' => Hash::make('Password1#')]);

    $response = $this
        ->actingAs($user)
        ->from(route('security.edit'))
        ->put(route('password.update'), [
            'current_password' => 'Password1#',
            'password' => 'Password12#',
            'password_confirmation' => 'Password12#',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('security.edit'));

    $this->assertTrue(Hash::check('Password12#', $user->refresh()->password));
});

test('correct password must be provided to update password', function () {
    $user = User::factory()->create(
        ['password' => Hash::make('Password1#')]
    );

    $response = $this
        ->actingAs($user)
        ->from(route('security.edit'))
        ->put(route('password.update'), [
            'current_password' => 'Password1s#',
            'password' => 'Password12#',
            'password_confirmation' => 'Password12#',
        ]);

    $response
        ->assertSessionHasErrors('current_password')
        ->assertRedirect(route('security.edit'));
});
