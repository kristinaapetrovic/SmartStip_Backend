<?php

namespace App\Http\Controllers\Api;

use App\Models\Administrator;
use Illuminate\Http\Request;
use App\Trait\CanLoadRelationships;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreAdministratorRequest;
use App\Http\Requests\UpdateAdministratorRequest;
use App\Http\Resources\AdministratorResource;
use App\Http\Controllers\Controller;

class AdministratorController extends Controller
{
    use CanLoadRelationships;

    private array $relations = [
        'user',
        'faculty',
        'faculty.university'
    ];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            if (Gate::allows('viewAny', Administrator::class)) {

                $administratorsQuery = $this->loadRelationships(Administrator::query());

                if ($request->has('search')) {
                    $administratorsQuery->withUserSearch($request->search);
                }

                $administrators = $administratorsQuery->get();

                return AdministratorResource::collection($administrators);
            }

            return response()->json(['message' => 'Forbidden'], 403);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdministratorRequest $request)
    {
        try {

            $data = $request->validated();

            $administrator = Administrator::create($data);

            return response()->json([
                'message' => 'Administrator uspešno kreiran',
                'model' => new AdministratorResource($administrator)
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Administrator $administrator)
    {
        try {

            if (Gate::allows('view', $administrator)) {

                return new AdministratorResource(
                    $this->loadRelationships($administrator)
                );
            }

            return response()->json(['message' => 'Forbidden'], 403);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdministratorRequest $request, Administrator $administrator)
    {
        try {

            $data = $request->validated();

            $administrator->update($data);

            return response()->json([
                'message' => 'Administrator uspešno ažuriran',
                'model' => new AdministratorResource($administrator)
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Administrator $administrator)
    {
        try {

            if (Gate::allows('delete', $administrator)) {

                $administrator->delete();

                return response()->json([
                    'message' => 'Administrator uspešno obrisan'
                ]);
            }

            return response()->json(['message' => 'Forbidden'], 403);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
