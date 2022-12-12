<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use App\Models\TaskStage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Task::all();
        return response()->json([
            'tasks' => $data
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
        $task = new Task;
        $this->insertDataFromRequest($task, $request);
        $taskStage = new TaskStage;
        $taskStage->task_id = $task->id;
        $taskStage->task_stage = 0;
        $taskStage->save();

        return response()->json([
            'status' => true,
            'data' => [
                'task' => $task,
                'stage' => $taskStage
            ]
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
        $data = Task::where('id', $id)->first();
        return response()->json([
            'status' => true,
            'task' => $data
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
        $task = Task::findOrFail($id);
        $this->insertDataFromRequest($task, $request);

        return response()->json([
            'status' => true,
            'message' => 'Task data updated',
            'data' => $task
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
        $data = Task::find($id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Task was deleted successfully',
            'isDeleted' => $data
        ]);
    }

    /**
     * insert data from request into db
     */
    private function insertDataFromRequest($task, $request)
    {
        $task->task_name = $request->task_name;
        $task->description = $request->task_description;
        $task->project_id = $request->project_id;
        $task->priority = $request->priority;
        $task->started_at = $request->started_at;
        $task->ended_at = $request->ended_at;
        $task->save();
    }
}
