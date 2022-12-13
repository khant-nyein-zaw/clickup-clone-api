<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\TeamMemberController;
use Illuminate\Support\Facades\Route;

/**
 * User login and register routes
 */
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/**
 * API resources routes
 */
Route::middleware('auth:sanctum')->prefix('project-management')->group(function () {
    Route::apiResources([
        'projects' => ProjectController::class,
        'tasks' => TaskController::class,
    ]);
    Route::apiResource('team_members', TeamMemberController::class)->middleware('teamMember.auth');
});
