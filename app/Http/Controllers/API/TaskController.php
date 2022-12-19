<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Models\AssignTo;
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
            'status' => true,
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
        $task = Task::create($request->all());

        if ($task) {
            $taskStage = TaskStage::create([
                'task_id' => $task->id,
                'user_id' => $request->user_id,
                'task_stage' => 0,
            ]);
        }

        return response()->json([
            'status' => true,
            'createdData' => [
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
        $data = Task::firstWhere('id', $id);
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
        $data = Task::findOrFail($id)->update($request->all());

        return response()->json([
            'status' => true,
            'updatedData' => $data
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
