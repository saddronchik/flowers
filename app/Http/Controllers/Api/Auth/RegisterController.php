<?php

namespace App\Http\Controllers\Api\Auth;

use App\DTOs\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $userDto = UserDTO::fromArray($request->validated());
        $user = User::registerUser($userDto);

        return response()->json([
            'status' => true,
            'token' => $this->createUserToken($user, $userDto->store_name),
            'user' => new UserResource($user)
        ])->setStatusCode(201);
    }
    private function createUserToken(User $user, string $salt): string
    {
        return $user->createToken($salt)->plainTextToken;
    }

}
