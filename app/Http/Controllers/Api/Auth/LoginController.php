<?php

namespace App\Http\Controllers\Api\Auth;

use App\DTOs\UserDTO;
use App\Exceptions\Api\Auth\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Auth\LoginService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use WendellAdriel\ValidatedDTO\Exceptions\CastTargetException;
use WendellAdriel\ValidatedDTO\Exceptions\MissingCastTypeException;

class LoginController extends Controller
{
    public function __construct(private LoginService $loginService)
    {
    }

    /**
     * @throws AuthException
     * @throws CastTargetException
     * @throws MissingCastTypeException
     */
    public function login(LoginRequest $request): JsonResponse
    {

        $userDTO = UserDTO::fromArray($request->validated());

        $user = $this->loginService->login($userDTO);
        $token = $user->createAuthToken($userDTO->login);

        return response()->json([
            'status' => true,
            'token' => $token,
            'user' => new UserResource($user)
        ])->setStatusCode(200);
    }

    public function logout(LogoutRequest $request): Response
    {
        $this->loginService->logout(auth('sanctum')->id());

        return response()->noContent();
    }

    public function deleteUser(Request $request): JsonResponse
    {
        try {
            $user = User::query()->findOrFail($request->user_id)->forceDelete();
        } catch (\Exception $e) {
            throw new AuthException($e->getMessage());
        }

        return response()->json(['status' => true])
            ->setStatusCode(Response::HTTP_OK);
    }
}
