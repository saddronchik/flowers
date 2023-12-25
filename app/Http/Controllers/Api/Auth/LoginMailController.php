<?php

namespace App\Http\Controllers\Api\Auth;

use App\DTOs\BuyersDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginMailRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Resources\BuyersResource;
use App\Services\Auth\MailLoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LoginMailController extends Controller
{
    public function __construct(private MailLoginService $mailLoginService)
    {
    }
    public function login(LoginMailRequest $request): JsonResponse
    {
        $buyerDTO = BuyersDTO::fromArray($request->validated());
        $buyer = $this->mailLoginService->login($buyerDTO);

        $token = $buyer->createAuthToken($buyerDTO->email);

        return response()->json([
            'status' => true,
            'token' => $token,
            'user' => new BuyersResource($buyer)
        ])->setStatusCode(200);
    }

    public function logout(LogoutRequest $request): Response
    {
        $this->mailLoginService->logout(auth('sanctum')->id());

        return response()->noContent();
    }
}
