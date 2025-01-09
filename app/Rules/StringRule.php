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
}
