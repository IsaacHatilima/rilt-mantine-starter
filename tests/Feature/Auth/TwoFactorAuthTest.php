<?php

use App\Models\User;
use PragmaRX\Google2FA\Google2FA;

test('user can see security page', function () {
    $user = User::factory()->create(['password' => Hash::make('Password1#')]);

    $response = $this
        ->actingAs($user)
        ->get(route('security.edit'));

    $response->assertOk();
});

test('user can confirm password', function () {
    $user = User::factory()->create(['password' => Hash::make('Password1#')]);

    $response = $this->actingAs($user)->post('/user/confirm-password', [
        'password' => 'Password1#',
    ]);

    $response->assertStatus(302);
});

test('user password confirmation fails', function () {
    $user = User::factory()->create(['password' => Hash::make('Password1#')]);

    $response = $this->actingAs($user)->post('/user/confirm-password', [
        'password' => 'Password12#',
    ]);

    $response->assertStatus(302);
    $this->assertEquals(session('errors')->get('password')[0], 'The provided password was incorrect.');
});

test('user can enable 2FA', function () {
    $user = User::factory()->create([
        'password' => Hash::make('Password1#'),
    ]);

    $this->actingAs($user)->post('/user/confirm-password', [
        'password' => 'Password1#',
    ]);

    $response = $this->actingAs($user)->post('/user/two-factor-authentication');

    $user->refresh();

    $response->assertStatus(302);
    $this->assertNotNull($user->two_factor_secret);
    $this->assertNotNull($user->two_factor_recovery_codes);
    $this->assertNull($user->two_factor_confirmed_at);
});

test('user can confirm 2FA', function () {
    $user = User::factory()->create([
        'password' => Hash::make('Password1#'),
    ]);

    $this->actingAs($user)->post('/user/confirm-password', [
        'password' => 'Password1#',
    ]);

    $this->actingAs($user)->post('/user/two-factor-authentication');

    $decryptedSecret = Crypt::decrypt($user->two_factor_secret);

    $google2fa = new Google2FA;
    $otp = $google2fa->getCurrentOtp($decryptedSecret);

    $response = $this->actingAs($user)->post('/user/confirmed-two-factor-authentication', [
        'code' => $otp,
    ]);

    $user->refresh();

    $response->assertStatus(302);
    $this->assertEquals(session('status'), 'two-factor-authentication-confirmed');
    $this->assertNotNull($user->two_factor_confirmed_at);
});

test('user cannot confirm 2FA', function () {
    $user = User::factory()->create([
        'password' => Hash::make('Password1#'),
    ]);

    $this->actingAs($user)->post('/user/confirm-password', [
        'password' => 'Password1#',
    ]);

    $this->actingAs($user)->post('/user/two-factor-authentication');

    $response = $this->actingAs($user)->post('/user/confirmed-two-factor-authentication', [
        'code' => '124578',
    ]);

    $user->refresh();

    $response->assertStatus(302);
    $this->assertNull(session('status'));
    $this->assertNull($user->two_factor_confirmed_at);
});
