<?php

namespace Tests\Feature;

use App\Models\Application;
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

        User::query()->where('login','=','lll')->delete();
    }

    public function test_create_update_application()
    {
        $user = User::factory()->create([
            'login' => '111',
            'password' => bcrypt('123456'),
            'fcm_token' => '1',
        ]);

        $applicationData = [
            'address'=>'прос.Кириленко',
            'budget'=>'10000',
            'phone_whatsapp'=>'+2332412313',
            'comments'=>'Скорее',
            'city'=>'Алматы',
        ];

        $token = $user->createToken('test-token')->plainTextToken;
        $this->actingAs($user, 'api');

        $response = $this->postJson('/api/login', [
            'login' => $user->login,
            'password' => '123456',
            'fcm_token' => '1',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post('/api/create/application',$applicationData);

        $application=Application::query()->where('id','=', $response['application']['id'])
            ->firstOrFail();

        $application->update(['status' => Application::STATUS_DELETE]);

        $response->assertStatus(201);

        User::query()->where('login','=','111')->delete();
        Application::query()->where('id','=',$response['application']['id'])->delete();
    }

}
