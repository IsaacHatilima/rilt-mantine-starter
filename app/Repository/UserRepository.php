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

    public function updateEmail(User $user, string $email): void
    {
        $normalized = strtolower($email);

        if ($user->email !== $normalized) {
            $user->email = $normalized;
            $user->email_verified_at = null;
            $user->save();
        }
    }
}
