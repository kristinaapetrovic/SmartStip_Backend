<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Http\Resources\ContractResource;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            if(Gate::allows('viewAny', Contract::class))
                return ContractResource::collection(Contract::all());
            else
                return response()->json(['message'=>'Forbidden'], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractRequest $request)
    {
        try{
            $data = $request->validated();

            $contract = Contract::create($data);

            return response()->json([
                'message' => 'Ugovor uspešno kreiran',
                'model' => new ContractResource($contract)
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }  
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        try{
            if(Gate::allows('view', $contract))
                return new ContractResource($contract);
            else
                return response()->json(['message'=>'Forbidden'], 403);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractRequest $request, Contract $contract)
    {
        try{
            $data = $request->validated();
            $contract->update($data);
            return response()->json([
                'message' => 'Ugovor uspešno ažuriran',
                'model' => new ContractResource($contract)
            ]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        try{
            if(Gate::allows('delete', $contract)){
                $contract->delete();
                return response()->json(['message'=>'Ugovor uspešno obrisan']);
            } else
                return response()->json(['message'=>'Forbidden'], 403);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
