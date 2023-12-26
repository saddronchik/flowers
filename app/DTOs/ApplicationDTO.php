<?php

namespace App\DTOs;

use Illuminate\Http\Exceptions\HttpResponseException;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class ApplicationDTO extends ValidatedDTO
{
    public mixed $user_id;
    public mixed $city;
    public mixed $address;
    public mixed $budget;
    public mixed $phone_whatsapp;
    public mixed $comments;
    public mixed $status;

    protected function rules(): array
    {
       return [
           'user_id' => ['nullable', 'string'],
           'city' => ['nullable','string'],
           'address' => ['nullable', 'string'],
           'budget' => ['nullable', 'string'],
           'phone_whatsapp' => ['nullable', 'string'],
           'comments' => ['nullable', 'string'],
           'status' => ['nullable', 'string'],
           'buyer_id' => ['nullable', 'string'],
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
