<?php

namespace App\Repository;

use App\Models\Profile;

class ProfileRepository
{
    public function __construct() {}

    public function create($data)
    {
        return Profile::create($data);
    }

    public function update(Profile $profile, array $data): void
    {
        $profile->update([
            'first_name' => ucwords($data['first_name']),
            'last_name' => ucwords($data['last_name']),
            'gender' => $data['gender'],
            'date_of_birth' => $data['date_of_birth'],
        ]);
    }
}
