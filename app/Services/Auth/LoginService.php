<?php

namespace App\Services\Auth;

use App\DTOs\UserDTO;
use App\Exceptions\Api\Auth\AuthException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LoginService
{

    /**
     * @throws AuthException
     */

    public function login(UserDTO $userDTO): User
    {
        $user = User::query()->where('login', $userDTO->login)->first();
        if (! $user || ! Hash::check($userDTO->password, $user->password)) {
            throw new AuthException('The provided credentials are incorrect.');
        }

        $user->updateFcmToken($userDTO->fcm_token);

        return $user;

    }

    public function logout(int $userId): void
    {
        /** @var User $user */
        $user = User::query()->findOrFail($userId);

        if (!$user) {
            throw new NotFoundHttpException('Object not found');
        }

        $user->fcm_token = null;
        $user->save();
        $user->tokens()->delete();
    }

}
