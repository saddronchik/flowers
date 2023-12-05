<?php

namespace App\Http\Requests\Auth;

use App\Rules\PhoneNumber;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string','min:4', 'max:50'],
            'store_name' => ['nullable', 'string'],
            'phone' => ['required', 'string'],
            'login' => ['required', 'string'],
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
            'fcm_token' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],

        ];
    }

    public function messages(): array
    {
        return [
            'login.unique' => 'Такой логин уже занят',
            'email.unique' => 'Email уже занят',
        ];
    }
}
