<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }
        $token = $user->createToken('api-token')->plainTextToken;
        $role = null;

        if ($user->isAdministrator()) {
            $role = 'administrator';
            $role_id = $user->administrator->id;
        } elseif ($user->isStudent()) {
            $role = 'student';
            $role_id = $user->student->id;
        } elseif ($user->isCommissioner()) {
            $role = 'commissioner';
            $role_id = $user->commissioner->id;
        }
        return response()->json([
            'id' => $user->id,
            'token' => $token,
            'name' => $user->name,
            'role' => $role,
            'email' => $user->email,
            'role_id' => $role_id
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }


    public function register(Request $request){
        $validatedUser = $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8'
        ]);
        $validatedStudent = $request->validate([
            'year_of_study' => 'required|string|max:10',
            'type_of_study' => 'required|in:' . implode(',', \App\Models\Student::$types_of_study),
            'average_grade' => 'required|numeric|min:5|max:10', // pretpostavimo da je skala 5-10
            'field_of_study' => 'required|string|max:100',
            'index_number' => 'required|string|unique:students,index_number',
            'street_address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'location_id' => 'required|exists:locations,id',
            'faculty_id' => 'required|exists:faculties,id'
        ]);
        $user = User::create($validatedUser);
        $student = Student::create([...$validatedStudent,'user_id'=>$user->id]);
        return new StudentResource($student);
    }
}
