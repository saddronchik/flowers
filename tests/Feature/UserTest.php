<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Database\Factories\UserFactory;
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
            'login'=>'sad_name22',
            'password'=>bcrypt('123456'),
            'fcm_token'=>'1',
            'city'=>'Алматы',
        ];

        $response = $this->post('/api/register', $userData);

        $response->assertStatus(201);

    }

    public function test_user_register_and_login()
    {
        $user = User::factory()->create([
            'login' => 'sad_name',
            'password' => bcrypt('123456'),
            'fcm_token' => '1',
        ]);

        $response = $this->post('/api/login', [
            'login' => 'sad_name',
            'password' => '123456',
            'fcm_token' => '1',
        ]);

        $response->assertStatus(200);
//        $this->assertAuthenticatedAs($user);
    }

//    public function register_user_test(): void
//    {
//        $password = '123456';
//
//        $response = UserFactory::new()->create([
//            'full_name'=>'Андрей Двойкин',
//            'store_name'=>'Мечта',
//            'phone'=>'+7949356071',
//            'login'=>'sad_name',
//            'password'=>bcrypt($password),
//            'fcm_token'=>'1',
//            'city'=>'Алматы',
//        ]);
//
////        $request = SignupRequest::factory->create([
////            'full_name'=>$user->full_name,
////            'store_name'=>$user->store_name,
////            'phone'=>$user->phone,
////            'login'=>$user->login,
////            'fcm_token'=>$user->fcm_token,
////            'city'=>$user->city,
////            'password'=>$password
////        ]);
////
//        $response = $this->post(action([LoginController::class, 'login']), $request);
//
////        $response->assertValid()
////            ->assertRedirect('/api/index/application');
//        $response->assertStatus(200);
//
////        $this->assertAuthenticatedAs($user);
//
//    }
}
