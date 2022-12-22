<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssignToRequest;
use App\Models\AssignTo;

class AssignToController extends Controller
{
    /**
     * display a specific user's to do list
     */
    public function taskList($userId)
    {
        $taskList = AssignTo::select(
            'tasks.*',
            'projects.name',
        )->where('assign_tos.user_id', $userId)
            ->leftJoin('tasks', 'assign_tos.task_id', 'tasks.id')
            ->leftJoin('projects', 'tasks.project_id', 'projects.id')
            ->get();
        return response()->json([
            'status' => true,
            'taskList' => $taskList
        ]);
    }

    /**
     * assign a user to do
     */
    public function store(StoreAssignToRequest $request)
    {
        $data = AssignTo::create($request->all());
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}
