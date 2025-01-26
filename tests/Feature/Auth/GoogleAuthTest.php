<?php

use App\Actions\Auth\RegisterAction;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

it('handles Google callback and creates a new user', function () {
    $googleUser = new \Laravel\Socialite\Two\User;
    $googleUser->map([
        'email' => 'user@example.com',
        'user' => [
            'given_name' => 'John',
            'family_name' => 'Doe',
        ],
    ]);

    Socialite::shouldReceive('driver')
        ->with('google')
        ->once()
        ->andReturn(Mockery::mock('Laravel\Socialite\Two\GoogleProvider')
            ->shouldReceive('stateless')
            ->once()
            ->andReturnSelf()
            ->getMock()
            ->shouldReceive('user')
            ->once()
            ->andReturn($googleUser)
            ->getMock()
        );

    $registerActionMock = Mockery::mock(RegisterAction::class);
    $registerActionMock->shouldReceive('googleRegister')
        ->once()
        ->with(Mockery::on(function ($data) {
            return $data->email === 'user@example.com' &&
                $data->first_name === 'John' &&
                $data->last_name === 'Doe';
        }))
        ->andReturn(new User([
            'id' => 1,
            'email' => 'user@example.com',
        ]));

    $this->app->instance(RegisterAction::class, $registerActionMock);

    $response = $this->get('/google/callback');

    $response->assertRedirect(route('dashboard'));
});
