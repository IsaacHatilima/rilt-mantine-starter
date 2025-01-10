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

    public static function messages(): array
    {
        return [
            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email.',
            'email.max' => 'Email is too long.',
            'email.string' => 'Email must be a string.',
            'email.unique' => 'Email already exists.',
            'email.lowercase' => 'Invalid email.',
        ];
    }
}
