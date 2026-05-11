<?php

namespace App\Http\Controllers\Api;

use App;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use Gate;
use App\Trait\CanLoadRelationships;
use Illuminate\Http\Request;
use App\Models\Student;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use CanLoadRelationships;
    private array $relations = ['student', 'student.user', 'scholarship'];
    public function index(Request $request)
    {
        try{
            if(Gate::allows('viewAny', Application::class)){

                $status = $request->input('status');
                $user = $request->user();

                $applicationsQuery = Application::query()
                    ->forAdminFaculty($user)
                    ->when($status, fn($query, $status) => $query->withStatus($status));

                $applicationsQuery = $this->loadRelationships($applicationsQuery);

                $applications = $applicationsQuery->latest()->get();

                return ApplicationResource::collection($applications);
            }
            else
                return response()->json(['message' => 'Forbidden'], 403);

        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicationRequest $request)
    {
        try{
            $data = $request->validated();
            $existingApplication = Application::where('student_id', $data['student_id'])
            ->where('scholarship_call_id', $data['scholarship_call_id'])
            ->first();

            if ($existingApplication) {
                return response()->json([
                    'message' => 'You have already applied for this scholarship.'
                ], 409);
            }

            $data['status'] = 'pending';

            $student = Student::where('user_id', $data['user_id'])->first();

            if (!$student) {
                return response()->json([
                    'message' => 'Student not found for given user.'
                ], 404);
            }

            $data['student_id'] = $student->id;

            $application = Application::create($data);

            return response()->json([
                'message' => 'Prijava uspešno kreirana',
                'model' => new ApplicationResource($application)
            ], 201);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        try{
            if(Gate::allows('view', $application))
                return new ApplicationResource($this->loadRelationships($application));
            else
                return response()->json(['message' => 'Forbidden'], 403);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        try{
            $data = $request->validated();
            $originalStatus = $application->status;    
            $application->update($data);
            if (isset($data['status']) && $data['status'] !== $originalStatus) {
                $studentUser = $application->student->user; 
                if ($studentUser) {
                    $studentUser->notify(new \App\Notifications\ApplicationStatusChanged(
                        $application,
                        $application->scholarship,
                        previousStatus: $originalStatus,
                        newStatus: $application->status,
                        reason: $data['reason_for_rejection'] ?? null
                    ));
                }
                return response()->json([
                    'message' => 'Prijava uspešno ažurirana. Notifikacija poslata studentu.',
                    'model' => new ApplicationResource($application)
                ]);
            }
            return response()->json([
                'message' => 'Prijava uspešno ažurirana',
                'model' => new ApplicationResource($application)
            ]);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        try{
            if(Gate::allows('delete', $application)){
                $application->delete();
                return response()->json([
                    'message' => 'Prijava uspešno obrisana.',
                ]);
            }
            else
                return response()->json(['message' => 'Forbidden'], 403);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }}
