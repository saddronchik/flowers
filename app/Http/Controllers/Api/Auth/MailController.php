<?php

namespace App\Http\Controllers\Api\Auth;

use App\DTOs\BuyersDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\MailRequest;
use App\Http\Resources\BuyersResource;
use App\Mail\CodeBuyers;
use App\Models\Buyers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class MailController extends Controller
{
    public function register(MailRequest $request)
    {
        $data = [
            'email'=>$request->email,
            'code'=>Str::random(10)
        ];

        $buyersDTO = BuyersDTO::fromArray($data);
        $buyer = Buyers::registerBuyers($buyersDTO);

        return response()->json([
            'status' => true,
            'token' => $this->createBuyerToken($buyer, $buyersDTO->email),
            'buyer' => new BuyersResource($buyer)
        ])->setStatusCode(201);

    }

    public function sendCode(MailRequest $request)
    {
        $data = [
            'email'=>$request->email,
            'code'=>Str::random(10)
        ];

        Mail::to($request->email)->send(new CodeBuyers($data));

        return response()->json(['status' => true, 'application'=>$data]);
    }
    private function createBuyerToken(Buyers $buyer, string $salt): string
    {
        return $buyer->createToken($salt)->plainTextToken;
    }
}
