<?php

namespace App\Actions\Auth;

use App\Actions\Profile\ProfileManagerAction;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;

readonly class RegisterAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(private ProfileManagerAction $profileManagerAction)
    {
        //
    }

    public function register($request)
    {
        $user = User::create([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $this->profileManagerAction->create_profile($request, $user);

        $user->notify(new VerifyEmailNotification($user));

        return $user;
    }
}
