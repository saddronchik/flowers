<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function resetPassword(ForgotPasswordRequest $request)
    {
        $user = User::query()->where('login', $request->validated('login'))->firstOrFail();

        $user->changePassword(
            $request->validated('password')
        );
        return response()->json(['status' => true, 'message' => 'Password reset successful'])
            ->setStatusCode(200);
    }
}
