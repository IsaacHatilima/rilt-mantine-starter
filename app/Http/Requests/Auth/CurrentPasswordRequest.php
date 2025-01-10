<?php

namespace App\Http\Requests\Auth;

use App\Rules\CurrentPasswordRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CurrentPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(
            CurrentPasswordRule::rules(),
        );
    }

    public function messages(): array
    {
        return array_merge(
            CurrentPasswordRule::messages(),
        );
    }
}
