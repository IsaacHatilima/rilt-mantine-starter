<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Validation\Rule;

class ExistingEmailRule
{
    public static function rules($userId): array
    {
        return [
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($userId),
            ],
        ];
    }
}
