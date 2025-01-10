<?php

use App\Models\User;

test('user can see security page', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('security.edit'));

    $response->assertOk();
});

test('user can verify password', function () {
    $user = User::factory()->create([
        'password' => Hash::make('Password1#'),
    ]);

    $response = $this
        ->actingAs($user)
        ->post('/user/two-factor-authentication', [
            'password' => 'Password1#',
        ]);

    $response->assertStatus(302);
});

test('user can activate two-factor auth', function () {
    $user = User::factory()->create([
        'password' => Hash::make('Password1#'),
    ]);

    $response = $this
        ->actingAs($user)
        ->post('/user/two-factor-authentication');

    $response->assertStatus(302);
});
