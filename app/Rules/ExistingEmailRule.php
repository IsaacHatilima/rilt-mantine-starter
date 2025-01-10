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

    public static function messages(): array
    {
        return [
            'email.required' => 'E-Mail is required.',
            'email.string' => 'E-Mail must be a string.',
            'email.lowercase' => 'E-Mail address must be lowercase.',
            'email.email' => 'Invalid E-Mail address.',
            'email.max' => 'Maximum 255 characters allowed.',
            'email.unique' => 'This E-Mail address is already in use.',
        ];
    }
}
