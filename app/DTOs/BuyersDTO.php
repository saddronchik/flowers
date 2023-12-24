<?php

namespace App\DTOs;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class BuyersDTO extends ValidatedDTO
{

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }

    protected function rules(): array
    {
        return [
            'email' => ['nullable', 'string'],
            'code' => ['nullable','string'],
            'status' => ['nullable', 'string'],
            ];
    }
}
