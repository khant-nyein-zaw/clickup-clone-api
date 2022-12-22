<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamMemberRequest;
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
        $data = TeamMember::select('users.name as user_name', 'users.email as user_email', 'roles.role_name', 'teams.team_name')
            ->leftJoin('teams', 'team_members.team_id', 'teams.id')
            ->leftJoin('roles', 'team_members.role_id', 'roles.id')
            ->leftJoin('users', 'team_members.user_id', 'users.id')
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
        $data = TeamMember::create([
            'user_id' => $request->user()->id,
            'team_id' => $request->team_id,
            'role_id' => $request->role_id
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
        $data = TeamMember::where('team_members.id', $id)->select('users.name as user_name', 'users.email as user_email', 'roles.role_name', 'teams.team_name')
            ->leftJoin('teams', 'team_members.team_id', 'teams.id')
            ->leftJoin('roles', 'team_members.role_id', 'roles.id')
            ->leftJoin('users', 'team_members.user_id', 'users.id')
            ->first();
        return response()->json([
            'status' => true,
            'teamMember' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTeamMemberRequest $request, $id)
    {
        $data = TeamMember::find($id)->update([
            'user_id' => $request->user()->id,
            'team_id' => $request->team_id,
            'role_id' => $request->role_id
        ]);

        return response()->json([
            'status' => true,
            'newTeamMember' => $data
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
        $data = TeamMember::find('id', $id);
        $data->delete();
        return response()->json([
            'isDeleted' => $data
        ]);
    }
}
