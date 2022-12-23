<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TeamMemberController;

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
    Route::get('/userList', [UserController::class, 'userList']);
    Route::get('/assignedTasks/{userId}', [TaskController::class, 'tasksAssigned']);
    Route::put('/changeTaskStage/{id}', [TaskController::class, 'changeTaskStage']);
    // resources
    Route::apiResources([
        'projects' => ProjectController::class,
        'tasks' => TaskController::class,
        'teams' => TeamController::class,
        'roles' => RoleController::class,
        'team_members' => TeamMemberController::class
    ]);
});
