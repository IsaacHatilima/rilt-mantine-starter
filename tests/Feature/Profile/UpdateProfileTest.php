<?php

use App\Models\User;

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch(route('profile.update'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'test@example.com',
            'date_of_birth' => '1992-12-01',
            'gender' => 'male',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    $this->assertSame('John', $user->profile->first_name);
    $this->assertSame('Doe', $user->profile->last_name);
    $this->assertSame('male', $user->profile->gender);
    $this->assertTrue($user->profile->date_of_birth->isSameDay('1992-12-01'));
    $this->assertSame('test@example.com', $user->email);
    $this->assertNull($user->email_verified_at);
});

test('missing profile information', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch(route('profile.update'), [
            'first_name' => '',
            'last_name' => 'Doe',
            'email' => 'test@example.com',
            // optional fields
            'date_of_birth' => '1992-12-01',
            'gender' => 'male',
        ]);

    $response
        ->assertSessionHasErrors(['first_name'])
        ->assertRedirect();

    $user->refresh();

    $this->assertNotSame('Doe', $user->profile->last_name);
    $this->assertNotSame('test@example.com', $user->email);
});
