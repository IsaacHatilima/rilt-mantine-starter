<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\GoogleRegisterAction;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Throwable;

class GoogleAuthController extends Controller
{
    private GoogleRegisterAction $googleRegisterAction;

    public function __construct(GoogleRegisterAction $googleRegisterAction)
    {
        $this->googleRegisterAction = $googleRegisterAction;
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        /** @var GoogleProvider $driver */
        $driver = Socialite::driver('google');
        $googleUser = $driver->stateless()->user();

        if (! isset($googleUser->user['given_name']) || ! isset($googleUser->user['family_name'])) {
            return redirect()->route('login')->withErrors(['error' => 'Your Google account is missing names.']);
        }

        $user = User::where('email', $googleUser->email)->first();

        if (! $user) {

            $data = [
                'email' => $googleUser->email,
                'first_name' => $googleUser->user['given_name'],
                'last_name' => $googleUser->user['family_name'],
            ];

            try {
                $user = $this->googleRegisterAction->execute((object) $data);
            } catch (Throwable $e) {
                report($e);

                return redirect()->route('login')->withErrors([
                    'error' => 'We couldn’t register your account. Please try again later.',
                ]);
            }
        }

        Auth::login($user);

        $user->update([
            'last_login_at' => now(),
        ]);

        return redirect(route('dashboard', absolute: false));
    }
}
