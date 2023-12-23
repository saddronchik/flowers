<?php

namespace App\DTOs;

use Illuminate\Http\Exceptions\HttpResponseException;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class UserDTO extends ValidatedDTO
{
    public ?string $name;
    public string|null $phone;
    public ?string $password;
    public ?string $fcm_token;
    public ?string $city;
    public ?string $status;
    public mixed $store_name;
    public mixed $full_name;
    public mixed $login;


    protected function rules():array
    {
        return [
            'full_name' => ['nullable', 'string', 'min:4', 'max:50'],
            'store_name' => ['nullable', 'string'],
            'phone' => ['nullable', 'string',],
            'login' => ['nullable', 'string'],
            'password' => ['nullable'],
            'fcm_token' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
        ];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }

    protected function failedValidation(): void
    {
        throw new HttpResponseException(
            response()->json(["status" => false, "message" => $this->validator->errors()->first()],
                422));
    }
}
