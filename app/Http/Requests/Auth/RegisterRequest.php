<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Hypervel\Foundation\Http\FormRequest;
use Hypervel\Validation\Rule;
use Hypervel\Validation\Rules\Password;

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
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users', 'email'),
            ],
            'name' => 'required|string',
            'password' => [
                'required',
                Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(),
            ]
        ];
    }
}