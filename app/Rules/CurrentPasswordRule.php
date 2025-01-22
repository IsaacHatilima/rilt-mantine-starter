<?php

namespace App\Rules;

class CurrentPasswordRule
{
    public static function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
        ];
    }

    public static function messages(): array
    {
        return [
            'current_password.required' => 'Current Password is required.',
            'current_password.current_password' => 'Current password is incorrect.',
        ];
    }
}
