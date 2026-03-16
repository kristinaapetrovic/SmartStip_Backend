<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommissionerRequest;
use App\Http\Requests\UpdateCommissionerRequest;
use App\Models\Commissioner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\CommissionerResource;
use App\Trait\CanLoadRelationships;
class CommissionerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    use CanLoadRelationships;
    private array $relations = ['user'];

    public function index()
    {
        try{
            if(Gate::allows('viewAny', Commissioner::class)){
                 $commissionersQuery = $this->loadRelationships(Commissioner::query());

                $commissioners = $commissionersQuery->get();

                return CommissionerResource::collection($commissioners);

            }
            return response()->json(['message' => 'Forbidden'], 403);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommissionerRequest $request)
    {
        try{
            $data = $request->validated();

            $commissioner = Commissioner::create($data);

            return response()->json([
                'message' => 'Komisija uspešno kreirana',
                'model' => new CommissionerResource($commissioner)
            ], 201);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Commissioner $commissioner)
    {
        try{
            if(Gate::allows('view', $commissioner))
                return new CommissionerResource($this->loadRelationships($commissioner));
            else
                return response()->json(['message' => 'Forbidden'], 403);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommissionerRequest $request, Commissioner $commissioner)
    {
        try{
            $data = $request->validated();

            $commissioner->update($data);

            return response()->json([
                'message' => 'Komisija uspešno ažurirana',
                'model' => new CommissionerResource($commissioner)
            ]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commissioner $commissioner)
    {
        try{
            if(Gate::allows('delete', $commissioner)){
                $commissioner->delete();
                return response()->json([
                    'message' => 'Komisija uspešno obrisana.',
                ]); 
            }else
                return response()->json(['message' => 'Forbidden'], 403);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
