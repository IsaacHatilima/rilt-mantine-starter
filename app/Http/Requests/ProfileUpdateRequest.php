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
                'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            ]
        );
    }
}
