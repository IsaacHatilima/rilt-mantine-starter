<?php

namespace App\Repository;

use App\Models\User;

class UserRepository
{
    public function __construct() {}

    public function create(array $data): User
    {
        return User::create($data);
    }
}
