<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function resetPassword(ForgotPasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::query()
            ->where('login', $request->validated('login'))
            ->firstOrFail();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (Hash::check($request->validated('password_old'), $user->password)) {
            $user->changePassword(
                $request->validated('password')
            );
            return response()->json(['message' => 'Password reset successful'], 200);
        } else {
            return response()->json(['message' => 'The current password is not correct'], 422);
        }

    }
}
