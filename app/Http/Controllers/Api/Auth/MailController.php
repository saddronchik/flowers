<?php

namespace App\Http\Controllers\Api\Auth;

use App\DTOs\BuyersDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\MailRequest;
use App\Http\Resources\BuyersResource;
use App\Mail\CodeBuyers;
use App\Models\Buyer;
use App\Services\Auth\MailLoginService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class MailController extends Controller
{
    public function register(MailRequest $request)
    {
        $email = $request->email;
        $existingUser = Buyer::where('email', $email)->first();

        if ($existingUser) {
            $data = [
                'email'=>$request->email,
                'code'=>$existingUser->code
            ];
            Mail::to($request->email)->send(new CodeBuyers($data));
            return response()->json(['status' => true,'code' => $existingUser->code])->setStatusCode(201);
        }

        $data = [
            'email'=>$request->email,
            'code'=>Str::random(10)
        ];

        $buyersDTO = BuyersDTO::fromArray($data);
        $buyer = Buyer::registerBuyers($buyersDTO);

        Mail::to($request->email)->send(new CodeBuyers($data));
        return response()->json([
            'status' => true,
            'buyer_data'=>$data,
            'token' => $this->createBuyerToken($buyer, $buyersDTO->email),
            'buyer' => new BuyersResource($buyer),
        ])->setStatusCode(201);
    }

    private function createBuyerToken(Buyer $buyer, string $salt): string
    {
        return $buyer->createToken($salt)->plainTextToken;
    }
}
