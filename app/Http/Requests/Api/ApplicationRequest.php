<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
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
            'user_id' => ['nullable', 'string'],
            'city' => ['required','string'],
            'address' => ['nullable', 'string'],
            'budget' => ['required', 'string'],
            'phone_whatsapp' => ['required', 'string'],
            'comments' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
            'buyer_id' => ['nullable', 'string'],
        ];
    }
}
