<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TaskStageController;
use App\Http\Controllers\API\TeamMemberController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AssignToController;

/**
 * User login and register routes
 */
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/**
 * API resources routes
 */
Route::middleware('auth:sanctum')->group(function () {
    // counts api of tasks, projects, teams
    Route::get('/counts', [HomeController::class, 'getCounts']);
    // user list for assigning tasks
    Route::get('/userList/{id}', [UserController::class, 'userList']);
    // assigned tasks for the user from others
    Route::get('/taskList/{userId}', [AssignToController::class, 'taskList']);
    Route::post('/assign/task', [AssignToController::class, 'store']);
    // task stages api for changing task status
    Route::post('/task_stages', [TaskStageController::class, 'store']);
    Route::put('/task_stages/{id}', [TaskStageController::class, 'update']);
    // resources
    Route::apiResources([
        'projects' => ProjectController::class,
        'tasks' => TaskController::class,
        'teams' => TeamController::class,
        'roles' => RoleController::class,
        'team_members' => TeamMemberController::class
    ]);
});
