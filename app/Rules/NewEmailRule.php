<?php

namespace App\Rules;

class NewEmailRule
{
    public static function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email',
            ],
        ];
    }
}
