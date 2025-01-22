<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterAction;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;

class GoogleAuthController extends Controller
{
    public function __construct(private readonly RegisterAction $registerAction) {}

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
            return redirect()->route('login')->with(['googleError' => 'Your Google account is missing names.']);
        }

        $user = User::where('email', $googleUser->user['email'])->first();

        if (! $user) {

            $data = [
                'email' => $googleUser->email,
                'first_name' => $googleUser->user['given_name'],
                'last_name' => $googleUser->user['family_name'],
            ];

            $user = $this->registerAction->googleRegister((object) $data);
        }

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
