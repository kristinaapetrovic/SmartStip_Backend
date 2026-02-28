<?php
use App\Http\Controllers\Api\CommissionerController;
use App\Http\Controllers\Api\ContractController;
use App\Http\Controllers\Api\FacultyController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\ScholarshipCallController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\UniversityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\AuthController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('applications', ApplicationController::class);
    Route::apiResource('scholarship-calls', ScholarshipCallController::class);
    Route::apiResource('commissioners', CommissionerController::class);
    Route::apiResource('contracts', ContractController::class);
    Route::apiResource('faculties', FacultyController::class);
    Route::apiResource('locations', LocationController::class);
    Route::apiResource('students', StudentController::class);
    Route::apiResource('universities', UniversityController::class);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');