<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskStageRequest;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Task::select('tasks.*', 'projects.project_name', 'users.name as assignee', 'teams.team_name')
            ->leftJoin('projects', 'tasks.project_id', 'projects.id')
            ->leftJoin('users', 'tasks.assignee_id', 'users.id')
            ->leftJoin('team_members', 'tasks.assignee_id', 'team_members.user_id')
            ->leftJoin('teams', 'team_members.team_id', 'teams.id')
            ->get();
        return response()->json([
            'status' => true,
            'taskList' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->all());
        return response()->json([
            'status' => true,
            'createdTask' => $task
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Task::select('tasks.*', 'projects.project_name',)
            ->where('tasks.id', $id)
            ->leftJoin('projects', 'tasks.project_id', 'projects.id')
            ->first();
        return response()->json([
            'status' => true,
            'task' => $data
        ]);
    }

    /**
     * Change task stage(status)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeTaskStage(UpdateTaskStageRequest $request, $id)
    {
        $isUpdated = Task::findOrFail($id)->update($request->all());
        $task = Task::firstWhere('id', $id);
        return response()->json([
            'updated' => $isUpdated,
            'task' => $task
        ]);
    }

    /**
     * Display a specific user's(assignee) tasks
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function getToDos($userId)
    {
        $data = Task::select('tasks.*', 'projects.project_name',)
            ->where('assignee_id', $userId)
            ->leftJoin('projects', 'tasks.project_id', 'projects.id')
            ->get();
        return response()->json([
            'status' => true,
            'toDos' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTaskRequest $request, $id)
    {
        $data = Task::findOrFail($id)->update($request->all());
        return response()->json([
            'updated' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Task::findOrFail($id)->delete();
        return response()->json([
            'isDeleted' => $data
        ]);
    }
}
