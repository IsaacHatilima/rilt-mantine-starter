<?php

namespace App\Http\Requests;

use App\Rules\ExistingEmailRule;
use App\Rules\StringRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(
            StringRule::rules('first_name', true),
            StringRule::rules('last_name', true),
            ExistingEmailRule::rules($this->user()->id),
            [
                'date_of_birth' => ['nullable', 'date'],
                'gender' => ['nullable', Rule::in(['male', 'female', 'other']), 'string'],
            ]
        );
    }

    public function messages(): array
    {
        return array_merge(
            StringRule::messages('first_name', true),
            StringRule::messages('last_name', true),
            ExistingEmailRule::messages(),
            [
                'date_of_birth.date' => 'Date of birth must be a valid date.',
                'gender.string' => 'Gender must be a string.',
            ]
        );
    }
}
