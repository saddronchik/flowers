<?php

namespace App\Http\Controllers\Api;

use App\DTOs\ApplicationDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApplicationRequest;
use App\Http\Resources\ApplicationRecource;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function create(ApplicationRequest $request)
    {
        $applicationDTO = ApplicationDTO::fromArray($request->validated());

        $application = (new \App\Models\Application)->createApplication($applicationDTO);

        return response()->json([
            'status' => true,
            'application' => new ApplicationRecource($application)
        ])->setStatusCode(201);
    }
}
