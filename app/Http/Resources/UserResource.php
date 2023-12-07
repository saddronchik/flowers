<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        /** @var User $this */
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'store_name' => $this->store_name,
            'phone' => $this->phone,
            'login' => $this->login,
            'email' => $this->email,
            'fcm_token' => $this->fcm_token,
            'city' => $this->city,
            'crated_at' => $this->crated_at,
            'updated_at' => $this->updated_at,
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
