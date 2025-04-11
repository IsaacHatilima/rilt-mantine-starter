<?php

namespace App\Actions\Auth;

use App\Jobs\SendPasswordResetLink;
use Illuminate\Http\Request;

class ForgotPasswordAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function execute(Request $request): void
    {
        SendPasswordResetLink::dispatch($request->email);
    }
}
