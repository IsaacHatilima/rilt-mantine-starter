<?php

namespace App\Http\Requests\Auth;

use App\Rules\NewEmailRule;
use App\Rules\NewPasswordRule;
use App\Rules\StringRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            StringRule::rules('first_name', true),
            StringRule::rules('last_name', true),
            NewEmailRule::rules(),
            NewPasswordRule::rules(),
        );
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'first_name.max' => 'First name is too long.',
            'first_name.string' => 'First name must be a string.',

            'last_name.required' => 'Last name is required.',
            'last_name.max' => 'First name is too long.',
            'last_name.string' => 'Last name must be a string.',

            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email.',
            'email.max' => 'Email is too long.',
            'email.string' => 'Email must be a string.',
            'email.unique' => 'Email already exists.',
            'email.lowercase' => 'Invalid email.',

            'password.required' => 'Password is required.',
            'password.min' => 'Password is too short.',
            'password.regex' => 'Password must contain at least one number and one uppercase and lowercase letter and a special character.',
            'password.required_with' => 'Password Confirm is required.',
            'password.same' => 'Password does not match.',

            'password_confirmation.required' => 'Confirm Password is required.',
            'password_confirmation.same' => 'Confirm Password does not match.',
        ];
    }
}
