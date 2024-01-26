<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_index_application()
    {
        $user = User::factory()->create([
            'login' => 'lll',
            'password' => bcrypt('123456'),
            'fcm_token' => '1',
        ]);

        $token = $user->createToken('test-token')->plainTextToken;
        $this->actingAs($user, 'api');

        $response = $this->postJson('/api/login', [
            'login' => $user->login,
            'password' => '123456',
            'fcm_token' => '1',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->get('/api/index/application');

        $response->assertStatus(200);
    }

}
