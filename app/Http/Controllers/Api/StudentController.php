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

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Gate::allows('viewAny', Student::class))
            return StudentResource::collection(Student::all());
        else
            return response()->json(['message'=>'Forbidden'], 403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $data = $request->validated();
        $student = Student::create($data);
        return response()->json([
            'message' => 'Student successfully created',
            'model' => new StudentResource($student)
        ], 201);
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
        $data = $request->validated();
        $student->update($data);
        return response()->json([
            'message' => 'Student successfully updated',
            'model' => new StudentResource($student)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        if(Gate::allows('delete', $student))
        {
            $student->delete();
            return response()->json(['message'=>'Student successfully deleted']);
        }
        else
        {
            return response()->json(['message'=>'Forbidden'], 403);
        }
    }
}
