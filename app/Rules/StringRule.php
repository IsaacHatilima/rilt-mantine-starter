<?php

namespace App\Rules;

class StringRule
{
    public static function rules(string $name, bool $required): array
    {
        return [
            $name => [
                $required ? 'required' : 'nullable',
                'string',
                'max:50',
            ],
        ];
    }

    public static function messages(string $name, bool $required): array
    {
        return [
            $name.'.required' => $required ?: ucwords($name).' is required.',
            $name.'.max' => ucwords($name).' is too long.',
            $name.'.string' => ucwords($name).' must be a string.',
        ];
    }
}
