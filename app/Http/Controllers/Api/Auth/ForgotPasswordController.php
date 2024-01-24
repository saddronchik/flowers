<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;

class ForgotPasswordController extends Controller
{
    public function resetPassword(ForgotPasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::query()
            ->where('login', $request->validated('login'))
            ->firstOrFail();

        if (Hash::check($request->validated('password_old'), $user->password)) {
            $user->changePassword(
                $request->validated('password')
            );
            return response()->json(['message' => trans('messages.success_password')], 200);
        } else {
            return response()->json(['message' => trans('messages.not_correct_password')], 422);
        }

    }
}
