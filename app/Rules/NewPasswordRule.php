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
}
