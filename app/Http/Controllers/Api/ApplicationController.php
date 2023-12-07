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
    public function index()
    {
        $application = Application::all()->where('status','!=',Application::STATUS_DELETE);
        return response()->json([
            'status' => true,
            'application' => $application
        ]);
    }
    public function create(ApplicationRequest $request)
    {
        $applicationDTO = ApplicationDTO::fromArray($request->validated());

        $application = (new Application)->createApplication($applicationDTO);

        return response()->json([
            'status' => true,
            'application_status'=>Application::STATUS_ACTIVE,
            'application' => new ApplicationRecource($application)
        ])->setStatusCode(201);
    }

    public function status_delete(Request $request)
    {
        $application = Application::query()->where('id','=', $request->id)->firstOrFail();

        $application->update(['status' => Application::STATUS_DELETE]);

        return response()->json(['status' => true, 'message' => 'Status application delete'])
            ->setStatusCode(200);
    }
    public function status_by_store(Request $request)
    {
        $application = Application::query()->where('id','=', $request->id)->firstOrFail();

        $application->update(['status' => Application::STATUS_BY_STORE]);

        return response()->json(['status' => true, 'message' => 'Status application by in store'])
            ->setStatusCode(200);
    }

    public function status_by_other_store(Request $request)
    {
        $application = Application::query()->where('id','=', $request->id)->firstOrFail();

        $application->update(['status' => Application::STATUS_BY_OTHER_STORE ]);

        return response()->json(['status' => true, 'message' => 'Status application by other store'])
            ->setStatusCode(200);
    }
}
