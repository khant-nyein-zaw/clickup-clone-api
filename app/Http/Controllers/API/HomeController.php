<?php

namespace App\Http\Controllers\API;

use App\Models\Task;
use App\Models\Team;
use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Models\User;

class HomeController extends Controller
{
    // get all counts of projects, tasks and teams
    public function getCounts()
    {
        $projectCount = Project::all()->count();
        $taskCount = Task::all()->count();
        $teamCount = Team::all()->count();
        return response()->json([
            'projectCount' => $projectCount,
            'taskCount' => $taskCount,
            'teamCount' => $teamCount
        ]);
    }
}
