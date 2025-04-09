<?php

namespace App\Actions\Auth;

use App\Repository\ProfileRepository;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

class GoogleRegisterAction
{
    /**
     * Creating user accounts using Google with the Laravel Socialite
     */
    private ProfileRepository $profileRepository;

    private UserRepository $userRepository;

    public function __construct(ProfileRepository $profileRepository, UserRepository $userRepository)
    {
        $this->profileRepository = $profileRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws Throwable
     */
    public function execute($request)
    {
        return DB::transaction(function () use ($request) {
            $user = $this->userRepository->create([
                'email' => strtolower($request->email),
                'email_verified_at' => now(),
            ]);

            $this->profileRepository->create([
                'user_id' => $user->id,
                'first_name' => ucwords($request->first_name),
                'last_name' => ucwords($request->last_name),
            ]);

            return $user;
        });
    }
}
