<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUniversityRequest;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\UniversityResource;
use App\Http\Requests\StoreUniversityRequest;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Gate::allows('viewAny', University::class))
            return UniversityResource::collection(University::all());
        else
            return response()->json(['message'=>'Forbidden'], 403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUniversityRequest $request)
    {
        $data = $request->validated();
        $university = University::create($data);
        return response()->json([
            'message' => 'Univerzitet uspešno kreiran',
            'model' => new UniversityResource($university)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(University $university)
    {
        if(Gate::allows('view', $university))
            return new UniversityResource($university);
        else
            return response()->json(['message'=>'Forbidden'], 403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUniversityRequest $request, University $university)
    {
        $data = $request->validated();
        $university->update($data);
        return response()->json([
            'message' => 'Univerzitet uspešno ažuriran',
            'model' => new UniversityResource($university)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(University $university)
    {
        if(Gate::allows('delete', $university))
        {
            $university->delete();
            return response()->json(['message'=>'Univerzitet uspešno obrisan']);
        }
        else
        {
            return response()->json(['message'=>'Forbidden'], 403);
        }
    }
}
