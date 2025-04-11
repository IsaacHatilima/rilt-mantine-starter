<?php

namespace App\Http\Requests\Auth;

use App\Rules\CurrentPasswordRule;
use App\Rules\NewPasswordRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $user = auth()->user();

        $rules = NewPasswordRule::rules();

        if (! is_null($user->password)) {
            $rules = array_merge($rules, CurrentPasswordRule::rules());
        }

        return $rules;
    }

    public function messages(): array
    {
        $user = auth()->user();

        $messages = NewPasswordRule::messages();

        if (! is_null($user->password)) {
            $messages = array_merge($messages, CurrentPasswordRule::messages());
        }

        return $messages;
    }
}
