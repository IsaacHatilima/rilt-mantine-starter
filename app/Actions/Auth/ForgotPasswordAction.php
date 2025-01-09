<?php

namespace App\Actions\Auth;

use App\Jobs\SendPasswordResetLink;

class ForgotPasswordAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function execute($request): void
    {
        SendPasswordResetLink::dispatch($request->email);
    }
}
