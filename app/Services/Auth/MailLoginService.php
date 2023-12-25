<?php

namespace App\Services\Auth;

use App\DTOs\BuyersDTO;
use App\DTOs\UserDTO;
use App\Exceptions\Api\Auth\AuthException;
use App\Models\Buyer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MailLoginService
{
    /**
     * @throws AuthException
     */

    public function login(BuyersDTO $buyersDTO):Buyer
    {
        $buyer = Buyer::query()->where('email', $buyersDTO->email)->first();
        if (! $buyer || ! Hash::check($buyersDTO->code, $buyer->code)) {
            throw new AuthException('The provided credentials are incorrect.');
        }
//        $user->updateFcmToken($userDTO->fcm_token);

        return $buyer;

    }

    public function logout(int $buyerId): void
    {
        /** @var Buyer $buyer */
        $buyer = Buyer::query()->findOrFail($buyerId);

        if (!$buyer) {
            throw new NotFoundHttpException('Object not found');
        }

//        $buyer->fcm_token = null;
        $buyer->save();
        $buyer->tokens()->delete();
    }

}
