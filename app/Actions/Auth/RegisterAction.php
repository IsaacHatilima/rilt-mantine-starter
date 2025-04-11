<?php

namespace App\Actions\Auth;

use App\Jobs\SendVerificationEmailJob;
use App\Repository\ProfileRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class RegisterAction
{
    /**
     * Creating user accounts by filling out the register form
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
    public function execute(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $user = $this->userRepository->create([
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password),
            ]);

            $this->profileRepository->create([
                'user_id' => $user->id,
                'first_name' => ucwords($request->first_name),
                'last_name' => ucwords($request->last_name),
            ]);

            SendVerificationEmailJob::dispatch($user);

            return $user;
        });
    }
}
