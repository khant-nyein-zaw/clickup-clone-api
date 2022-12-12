<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Project;
use App\Models\ProjectUser;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Project::all();
        return response()->json([
            'projects' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $project = new Project;
        $this->insertDataFromRequest($project, $request);

        $createdProject = new ProjectUser;
        $createdProject->user_id = $request->user()->id;
        $createdProject->project_id = $project->id;
        $createdProject->save();

        return response()->json([
            'status' => true,
            'message' => 'New project created',
            'data' => [
                'project' => $project,
                'createdUser' => $createdProject
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
        $data = Project::where('id', $id)->first();
        return response()->json([
            'projects' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProjectRequest $request, $id)
    {
        $project = Project::findOrFail($id);
        $this->insertDataFromRequest($project, $request);

        return response()->json([
            'status' => true,
            'message' => 'Project data updated',
            'data' => $project,
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
        $data = Project::find($id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Project was deleted successfully',
            'isDeleted' => $data
        ]);
    }

    /**
     * data insert or update
     */
    private function insertDataFromRequest($project, $request)
    {
        $project->project_name = $request->project_name;
        $project->description = $request->project_description;
        $project->started_at = $request->project_started_at;
        $project->ended_at = $request->project_ended_at;
        $project->save();
    }
}
