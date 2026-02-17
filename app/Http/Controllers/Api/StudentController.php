<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\StudentResource;
use App\Http\Requests\StoreStudentRequest;
use App\Trait\CanLoadRelationships;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use CanLoadRelationships;
    private array $relations = ['user', 'faculty', 'location', 'contract', 'applications'];

    public function index()
    {
        try{
            if(Gate::allows('viewAny', Student::class))
                return StudentResource::collection(Student::all());
            else
                return response()->json(['message'=>'Forbidden'], 403);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        try{
            $data = $request->validated();
            $student = Student::create($data);
            return response()->json([
                'message' => 'Student successfully created',
                'model' => new StudentResource($student)
            ], 201);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        if(Gate::allows('view', $student))
            return new StudentResource($student);
        else
            return response()->json(['message'=>'Forbidden'], 403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        try{
            $data = $request->validated();
            $student->update($data);
            return response()->json([
                'message' => 'Student successfully updated',
                'model' => new StudentResource($student)
            ]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        try{
            if(Gate::allows('delete', $student))
            {
                $student->delete();
                return response()->json(['message'=>'Student successfully deleted']);
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
