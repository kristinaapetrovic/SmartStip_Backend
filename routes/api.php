<?php
use App\Http\Controllers\Api\CommissionerController;
use App\Http\Controllers\Api\ContractController;
use App\Http\Controllers\Api\FacultyController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\ScholarshipCallController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\UniversityController;
use App\Http\Controllers\PyServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountController;
use App\Http\Controllers\Api\AdministratorController;
use App\Http\Controllers\NotificationController;

Route::get('/studentsCount', [CountController::class, 'studentsCount']);
Route::get('/scholarshipCallCount', [CountController::class, 'scholarshipCallCount']);
Route::get('/universityCount', [CountController::class, 'universityCount']);
Route::apiResource('universities', UniversityController::class)->only(['index', 'show']);
Route::apiResource('faculties', FacultyController::class)->only(['index', 'show']);
Route::apiResource('locations', LocationController::class)->only(['index', 'show']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('applications', ApplicationController::class);
    Route::apiResource('scholarship-calls', ScholarshipCallController::class);
    Route::apiResource('commissioners', CommissionerController::class);
    Route::apiResource('contracts', ContractController::class);
    Route::apiResource('students', StudentController::class);
    Route::apiResource('administrators', AdministratorController::class);

    Route::apiResource('universities', UniversityController::class)->except(['index', 'show']);
    Route::apiResource('faculties', FacultyController::class)->except(['index', 'show']);
    Route::apiResource('locations', LocationController::class)->except(['index', 'show']);

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/{id}', [NotificationController::class, 'show']);

    Route::post('/apply', [PyServiceController::class, 'apply']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');