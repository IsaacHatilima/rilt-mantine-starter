<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'status' => session('status'),
            'socialAuth' => [
                'google' => config('auth.socialAuth.google'),
                'github' => config('auth.socialAuth.github'),
                'facebook' => config('auth.socialAuth.facebook'),
            ],
        ]);
    }
}
