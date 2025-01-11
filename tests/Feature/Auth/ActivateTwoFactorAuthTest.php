<?php

use App\Models\User;

test('user can see security page', function () {
    $user = User::factory()->create(['password' => Hash::make('Password1#')]);

    $response = $this
        ->actingAs($user)
        ->get(route('security.edit'));

    $response->assertOk();
});

test('confirm user password', function () {
    $user = User::factory()->create(['password' => Hash::make('Password1#')]);

    $response = $this->actingAs($user)->post('/user/confirm-password', [
        'password' => 'Password1#',
    ]);

    $response->assertStatus(302);
});

test('enable 2FA', function () {
    $user = User::factory()->create([
        'password' => Hash::make('Password1#'),
    ]);

    // Confirm User Password
    $this->actingAs($user)->post('/user/confirm-password', [
        'password' => 'Password1#',
    ]);

    // Activate 2FA
    $response = $this->actingAs($user)->post('/user/two-factor-authentication');

    $response->assertStatus(302);

    $user->refresh();

    $this->assertNotNull($user->two_factor_secret);
    $this->assertNotNull($user->two_factor_recovery_codes);
    $this->assertNull($user->two_factor_confirmed_at);
});
