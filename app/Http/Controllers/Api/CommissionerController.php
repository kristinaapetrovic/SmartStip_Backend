<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommissionerRequest;
use App\Http\Requests\UpdateCommissionerRequest;
use App\Models\Commissioner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\CommissionerResource;
class CommissionerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Gate::allows('viewAny', Commissioner::class)){
            return CommissionerResource::collection(Commissioner::all());
        }
        return response()->json(['message' => 'Forbidden'], 403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommissionerRequest $request)
    {
        $data = $request->validated();

        $commissioner = Commissioner::create($data);

        return response()->json([
            'message' => 'Komisija uspešno kreirana',
            'model' => new CommissionerResource($commissioner)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Commissioner $commissioner)
    {
        if(Gate::allows('view', $commissioner))
            return new CommissionerResource($commissioner);
        else
            return response()->json(['message' => 'Forbidden'], 403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommissionerRequest $request, Commissioner $commissioner)
    {
        $data = $request->validated();

        $commissioner->update($data);

        return response()->json([
            'message' => 'Komisija uspešno ažurirana',
            'model' => new CommissionerResource($commissioner)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commissioner $commissioner)
    {
        if(Gate::allows('delete', $commissioner)){
            $commissioner->delete();
            return response()->json([
                'message' => 'Komisija uspešno obrisana.',
            ]); 
        }else
            return response()->json(['message' => 'Forbidden'], 403);
    }
}
