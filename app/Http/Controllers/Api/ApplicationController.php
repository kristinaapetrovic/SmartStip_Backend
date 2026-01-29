<?php

namespace App\Http\Controllers\Api;

use App;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use Gate;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Gate::allows('viewAny', Application::class))
            return ApplicationResource::collection(Application::all());
        else
            return response()->json(['message' => 'Forbidden'], 403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicationRequest $request)
    {
        $data = $request->validated();

        $application = Application::create($data);

        return response()->json([
            'message' => 'Prijava uspešno kreirana',
            'model' => new ApplicationResource($application)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        if(Gate::allows('view', $application))
            return new ApplicationResource($application);
        else
            return response()->json(['message' => 'Forbidden'], 403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        $data = $request->validated();

        $application->update($data);

        return response()->json([
            'message' => 'Prijava uspešno ažurirana',
            'model' => new ApplicationResource($application)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        if(Gate::allows('delete', $application)){
            $application->delete();
            return response()->json([
                'message' => 'Prijava uspešno obrisana.',
            ]);
        }
        else
            return response()->json(['message' => 'Forbidden'], 403);
    }
}
