<?php

namespace App\Actions\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class SetPasswordAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function check_token($email): bool
    {
        return DB::table('password_reset_tokens')
            ->where('email', $email)
            ->exists();
    }

    public function set_password($request)
    {
        return Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );
    }

    public function change_password($request): void
    {
        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);
    }
}
