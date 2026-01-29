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
        if(Gate::allows('viewAny', Contract::class))
            return ContractResource::collection(Contract::all());
        else
            return response()->json(['message'=>'Forbidden', 403]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractRequest $request)
    {
        $data = $request->validated();

        $contract = Contract::create($data);

        return response()->json([
            'message' => 'Ugovor uspešno kreiran',
            'model' => new ContractResource($contract)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        if(Gate::allows('view', $contract))
            return new ContractResource($contract);
        else
            return response()->json(['message'=>'Forbidden', 403]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractRequest $request, Contract $contract)
    {
        $data=$request->validated();
        $contract->update($data);
        return response()->json([
            'message' => 'Ugovor uspešno ažuriran',
            'model' => new ContractResource($contract)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        if(Gate::allows('delete', $contract)){
            $contract->delete();
            return response()->json(['message'=>'Ugovor uspešno obrisan']);
        } else
            return response()->json(['message'=>'Forbidden'], 403);
    }
}
