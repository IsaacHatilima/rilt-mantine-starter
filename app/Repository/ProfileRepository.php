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
}
