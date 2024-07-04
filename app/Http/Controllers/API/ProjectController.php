<?php

namespace App\Http\Controllers\API;

use App\Jobs\CreateProjectsInBatch;
use App\Models\Task;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Helpers\JsonResponder;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = Project::all();
        return response()->json([
            'status' => true,
            'projects' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(StoreProjectRequest $request)
    {
        $payload = $request->validated();
        CreateProjectsInBatch::dispatch($payload);

        return JsonResponder::success("New project created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $data = Project::where('id', $id)->first();
        return response()->json([
            'status' => true,
            'project' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(StoreProjectRequest $request, $id)
    {
        $data = Project::findOrFail($id)->update($request->all());
        return response()->json([
            'status' => true,
            'updatedData' => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $data = Project::findOrFail($id)->delete();
        ProjectUser::where('project_id', $id)->delete();
        Task::where('project_id', $id)->delete();
        return response()->json([
            'isDeleted' => $data
        ]);
    }
}
