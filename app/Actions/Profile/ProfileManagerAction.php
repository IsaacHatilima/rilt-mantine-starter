<?php

namespace App\Actions\Profile;

class ProfileManagerAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function update_profile($request): void
    {
        $profile = auth()->user()->profile;

        $profile->first_name = ucwords($request->first_name);
        $profile->last_name = ucwords($request->last_name);
        $profile->gender = $request->gender;
        $profile->date_of_birth = $request->date_of_birth;

        auth()->user()->email = strtolower($request->email);

        if (auth()->user()->isDirty('email')) {
            auth()->user()->email_verified_at = null;
        }

        $profile->save();
        auth()->user()->save();
    }
}
