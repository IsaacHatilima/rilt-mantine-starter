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
    public function execute(object $requestData)
    {
        return DB::transaction(function () use ($requestData) {
            $user = $this->userRepository->create([
                'email' => strtolower($requestData->email),
                'email_verified_at' => now(),
            ]);

            $this->profileRepository->create([
                'user_id' => $user->id,
                'first_name' => ucwords($requestData->first_name),
                'last_name' => ucwords($requestData->last_name),
            ]);

            return $user;
        });
    }
}
