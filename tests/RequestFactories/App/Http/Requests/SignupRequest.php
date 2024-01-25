<?php

namespace Tests\RequestFactories\App\Http\Requests;

use Worksome\RequestFactories\RequestFactory;

class SignupRequest extends RequestFactory
{
    public function definition(): array
    {
        return [
            'full_name'=>'Андрей Двойкин',
            'store_name'=>'Мечта',
            'phone'=>'+7949356071',
            'login'=>'sad_name',
            'password'=>bcrypt('123456'),
            'fcm_token'=>'1',
            'city'=>'Алматы',
        ];
    }
}
