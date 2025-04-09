<?php

namespace App\Actions\Profile;

use App\Repository\ProfileRepository;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdateProfileAction
{
    /**
     * Execute the profile update in a database transaction.
     */
    private UserRepository $userRepository;

    private ProfileRepository $profileRepository;

    public function __construct(UserRepository $userRepository, ProfileRepository $profileRepository)
    {
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
    }

    /**
     * @throws Throwable
     */
    public function execute($request): void
    {
        $user = auth()->user();
        $profile = $user->profile;

        DB::transaction(function () use ($user, $profile, $request) {
            $this->userRepository->updateEmail($user, $request->email);

            $this->profileRepository->update($profile, [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
            ]);
        });
    }
}
