<?php

namespace App\Http\Requests\Auth;

use App\Traits\JsonFailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class LogoutRequest extends FormRequest
{
    use JsonFailedValidation;

    public function authorize(): bool
    {
        return auth('sanctum')->check();
    }

    public function rules(): array
    {
        return [];
    }
}
