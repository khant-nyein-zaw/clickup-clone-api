<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamMemberRequest;
use App\Models\Role;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TeamMember::select('team_members.id', 'roles.role_name', 'teams.team_name')
            ->leftJoin('teams', 'team_members.team_id', 'teams.id')
            ->leftJoin('roles', 'team_members.role_id', 'roles.id')
            ->get();
        return response()->json([
            'status' => true,
            'teamMembers' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamMemberRequest $request)
    {
        $team = Team::create([
            'team_name' => $request->team_name
        ]);

        $role = Role::create([
            'role_name' => $request->role_name
        ]);

        $data = TeamMember::create([
            'user_id' => $request->user()->id,
            'team_id' => $team->id,
            'role_id' => $role->id
        ]);

        return response()->json([
            'status' => true,
            'newTeamMember' => $data
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
