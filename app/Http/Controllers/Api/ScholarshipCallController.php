<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScholarshipCallRequest;
use App\Http\Requests\UpdateScholarshipCallRequest;
use App\Models\ScholarshipCall;
use Illuminate\Http\Request;
use App\Http\Resources\ScholarshipCallResource;
use Illuminate\Support\Facades\Gate;

class ScholarshipCallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(\Gate::allows('viewAny', ScholarshipCall::class))
            return ScholarshipCallResource::collection(ScholarshipCall::all());
        else
            return response()->json(['message'=>'Forbidden'], 403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScholarshipCallRequest $request)
    {
        $data = $request->validated();

        $scholarshipCall = ScholarshipCall::create($data);

        return response()->json([
            'message' => 'Konkurs za stipendiju uspešno kreiran',
            'model' => new ScholarshipCallResource($scholarshipCall)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ScholarshipCall $scholarshipCall)
    {
        if(Gate::allows('view', $scholarshipCall))
            return new ScholarshipCallResource($scholarshipCall);
        else
            return response()->json(['message'=>'Forbidden'], 403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScholarshipCallRequest $request, ScholarshipCall $scholarshipCall)
    {
        $data = $request->validated();
        $scholarshipCall->update($data);
        return response()->json([
            'message' => 'Konkurs za stipendiju uspešno ažuriran',
            'model' => new ScholarshipCallResource($scholarshipCall)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ScholarshipCall $scholarshipCall)
    {
        if(Gate::allows('delete', $scholarshipCall))
        {
            $scholarshipCall->delete();
            return response()->json(['message'=>'Konkurs za stipendiju uspešno obrisan']);
        }
        else
        {
            return response()->json(['message'=>'Forbidden'], 403);
        }
    }
}
