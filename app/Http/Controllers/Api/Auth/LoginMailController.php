<?php

namespace App\Http\Controllers\Api\Auth;

use App\DTOs\BuyersDTO;
use App\Exceptions\Api\Auth\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginMailRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Resources\BuyersResource;
use App\Models\Buyer;
use App\Services\Auth\MailLoginService;
use Illuminate\Http\Request;
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
            'buyer' => new BuyersResource($buyer)
        ])->setStatusCode(200);
    }

    public function logout(LogoutRequest $request): Response
    {
        $this->mailLoginService->logout(auth('sanctum')->id());

        return response()->noContent();
    }

    public function deleteBuyer(Request $request): JsonResponse
    {
        try {
            $buyer = Buyer::query()->findOrFail($request->buyer_id)->forceDelete();
        } catch (\Exception $e) {
            throw new AuthException($e->getMessage());
        }

        return response()->json(['status' => true])
            ->setStatusCode(Response::HTTP_OK);
    }
}
