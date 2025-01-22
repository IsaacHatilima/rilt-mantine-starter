<?php

namespace App\Rules;

class NewPasswordRule
{
    public static function rules(): array
    {
        return [
            'password' => [
                'required',
                'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@?]).*$/',
                'min:8',
                'required_with:password_confirmation',
                'same:password_confirmation',
            ],

            'password_confirmation' => [
                'required',
                'same:password',
            ],
        ];
    }

    public static function messages(): array
    {
        return [
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.same' => 'Password does not match.',
            'password.regex' => 'Password must contain at least one number and one uppercase and lowercase letter.',
            'password.required_with' => 'Both Password and Password Confirm are required.',

            'password_confirmation.required' => 'Confirm Password is required.',
            'password_confirmation.same' => 'Confirm Password does not match.',
        ];
    }
}
