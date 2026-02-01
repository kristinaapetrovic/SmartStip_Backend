<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFacultyRequest;
use App\Http\Requests\UpdateFacultyRequest;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\FacultyResource;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            if(Gate::allows('viewAny', Faculty::class))
                return FacultyResource::collection(Faculty::all());
            else
                return response()->json(['message'=>'Forbidden'], 403);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFacultyRequest $request)
    {
        try{
            $data = $request->validated();

            $faculty = Faculty::create($data);

            return response()->json([
                'message' => 'Fakultet uspešno kreiran',
                'model' => new FacultyResource($faculty)
            ], 201);
        } catch (\Exception $e) {
                return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Faculty $faculty)
    {
        try{
            if(Gate::allows('view', $faculty))
                return new FacultyResource($faculty);
            else
                return response()->json(['message'=>'Forbidden'], 403);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFacultyRequest $request, Faculty $faculty)
    {
        try{
            $data = $request->validated();
            $faculty->update($data);
            return response()->json([
                'message' => 'Fakultet uspešno ažuriran',
                'model' => new FacultyResource($faculty)
            ]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faculty $faculty)
    {
        try{
            if(Gate::allows('delete', $faculty)){
                $faculty->delete();
                return response()->json(['message'=>'Fakultet uspešno obrisan.']);
            }else
                return response()->json(['message'=>'Forbidden'], 403);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
