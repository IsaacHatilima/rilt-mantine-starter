<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class RegisteredUserController extends Controller
{
    public function __construct(private readonly RegisterAction $registerAction) {}

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(RegisterRequest $request)
    {
        try {
            $user = $this->registerAction->execute($request);
        } catch (Throwable $e) {
            report($e);

            return redirect()->route('login')->withErrors([
                'error' => 'We couldn’t register your account. Please try again later.',
            ]);
        }

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));

    }

    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register', [
            'socialAuth' => [
                'google' => config('auth.socialAuth.google'),
                'github' => config('auth.socialAuth.github'),
                'facebook' => config('auth.socialAuth.facebook'),
            ],
        ]);
    }
}
