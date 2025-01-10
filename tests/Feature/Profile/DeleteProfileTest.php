<?php

use App\Models\User;

test('user can delete their account', function () {
    $user = User::factory()->create([
        'password' => Hash::make('Password1#'),
    ]);

    $response = $this
        ->actingAs($user)
        ->delete(route('profile.destroy'), [
            'current_password' => 'Password1#',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
    $this->assertDatabaseMissing('profiles', ['user_id' => $user->id]);
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'current_password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrors('current_password')
        ->assertRedirect('/profile');

    $this->assertNotNull($user->fresh());
});
