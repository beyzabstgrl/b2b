<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'E-posta zorunludur.',
            'email.email'       => 'Geçerli bir e-posta giriniz.',
            'password.required' => 'Şifre zorunludur.',
            'password.min'      => 'Şifre en az 6 karakter olmalıdır.',
        ];
    }
}
