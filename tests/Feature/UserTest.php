<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\RequestFactories\App\Http\Requests\SignupRequest;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_user_register()
    {
        $userData = [
            'full_name'=>'Андрей Двойкин',
            'store_name'=>'Мечта',
            'phone'=>'+7949356071',
            'login'=>'sad_name2',
            'password'=>bcrypt('123456'),
            'fcm_token'=>'1',
            'city'=>'Алматы',
        ];
        $response = $this->post('/api/register', $userData);
        $response->assertStatus(201);
        User::query()->where('login','=','sad_name2')->delete();
    }
    public function test_user_change_pass()
    {
        $user = User::factory()->create([
            'login' => 's888',
            'password' => bcrypt('123456'),
            'fcm_token' => '1',
        ]);
        $newPass =[
            'login'=>'s888',
            'password_old'=>'123456',
            'password'=>'123456789',
            'password_confirmation'=>'123456789',
        ];
        $response = $this->post('/api/password/reset', $newPass);
        $response->assertStatus(200);

        User::query()->where('login','=','s888')->delete();
    }

    public function test_user_register_and_login()
    {
        $user = User::factory()->create([
            'login' => 'sad_name48',
            'password' => bcrypt('123456'),
            'fcm_token' => '1',
        ]);

        $response = $this->post('/api/login', [
            'login' => 'sad_name48',
            'password' => '123456',
            'fcm_token' => '1',
        ]);

        $auth = Auth::attempt(['login' => 'sad_name48', 'password' => '123456','fcm_token' => '1',]);
        $response->assertStatus(200);

        User::query()->where('login','=','sad_name48')->delete();
    }

    public function findUser():User
    {
        return User::query()
            ->where('login', 'sad_name48')
            ->first();
    }

}
