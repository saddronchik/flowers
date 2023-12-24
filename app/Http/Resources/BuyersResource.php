<?php

namespace App\Http\Resources;

use App\Models\Buyers;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuyersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        /** @var Buyers $this */
        return [
            'id' => $this->id,
            'email' => $this->email,
            'code' => $this->code,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Email уже занят',
        ];
    }
}
