<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;

class DeleteAccountAction
{
    /**
     * Create a new class instance.
     */
    public function delete($request): void
    {
        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
