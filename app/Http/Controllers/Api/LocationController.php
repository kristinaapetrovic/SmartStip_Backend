<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\LocationResource;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            if(Gate::allows('viewAny', Location::class))
                return Location::all();
            else
                return response()->json(['message'=>'Forbidden'], 403);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request)
    {
        try{
            $data = $request->validated();
            $location = Location::create($data);
            return response()->json([
                'message' => 'Lokacija uspešno kreirana',
                'model' => $location
            ], 201);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        try{
            if(Gate::allows('view', $location))
                return new LocationResource($location);
            else
                return response()->json(['message'=>'Forbidden'], 403);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
   
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationRequest $request, Location $location)
    {
        try{
            $data = $request->validated();
            $location->update($data);
            return response()->json([
                'message' => 'Lokacija uspešno ažurirana',
                'model' => $location
            ]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        try{
            if(Gate::allows('delete', $location))
            {
                $location->delete();
                return response()->json(['message'=>'Lokacija uspešno obrisana']);
            }
            else
            {
                return response()->json(['message'=>'Forbidden'], 403);
            }
        }catch(\Exception $e){
                return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }   
    }
}
