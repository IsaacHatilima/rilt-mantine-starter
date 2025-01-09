<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
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
        return [
            'email' => ['required', 'email', 'exists:users,email', 'lowercase'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.exists' => 'Provided E-Mail does not exist.',
            'email.required' => 'E-Mail is required.',
            'email.email' => 'Invalid E-Mail address.',
            'email.lowercase' => 'E-Mail address must be lowercase.',
        ];
    }
}
