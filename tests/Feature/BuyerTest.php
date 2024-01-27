<?php

use App\Models\Buyer;
use Tests\TestCase;

class BuyerTest extends TestCase
{
    public function test_buyer_register()
    {
        $buyerData = [
            'email'=>'dronchik449@gmail.com',
            'password'=>bcrypt('123456'),
        ];
        $response = $this->post('/api/register/buyer', $buyerData);
        $response->assertStatus(201);
        Buyer::query()->where('email','=','dronchik449@gmail.com')->delete();
    }
}
