<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskStageRequest;
use App\Models\TaskStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskStageController extends Controller
{
    /**
     * change task status by a user
     */
    public function store(Request $request)
    {
        $data = TaskStage::create($request->all());
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    /**
     * update task status
     */
    public function update(StoreTaskStageRequest $request, $id)
    {
        $data = TaskStage::where('id', $id)->update($request->all());
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}
