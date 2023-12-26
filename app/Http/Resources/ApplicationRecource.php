<?php

namespace App\Http\Resources;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationRecource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Application $this */
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'city' => $this->city,
            'address' => $this->address,
            'budget' => $this->budget,
            'phone_whatsapp' => $this->phone_whatsapp,
            'comments' => $this->comments,
            'status' => $this->status,
            'buyer_id' => $this->buyer_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
