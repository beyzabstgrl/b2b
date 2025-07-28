<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'nullable|in:admin,customer'
        ];
    }


    public function messages(): array
    {
        return [
            'name.required'     => 'İsim alanı zorunludur.',
            'email.required'    => 'E-posta adresi zorunludur.',
            'email.email'       => 'Geçerli bir e-posta adresi giriniz.',
            'email.unique'      => 'Bu e-posta zaten kayıtlı.',
            'password.required' => 'Şifre zorunludur.',
            'password.min'      => 'Şifre en az 6 karakter olmalıdır.',
            'password.confirmed'=> 'Şifreler uyuşmuyor.',
            'role.in'           => 'Rol yalnızca "admin" veya "customer" olabilir.'
        ];
    }
}
