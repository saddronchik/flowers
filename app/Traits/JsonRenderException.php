<?php

namespace App\Traits;

trait JsonRenderException
{
    public function render($request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['status' => false, 'message' => $this->getMessage()])
            ->setStatusCode(500);
    }
}
