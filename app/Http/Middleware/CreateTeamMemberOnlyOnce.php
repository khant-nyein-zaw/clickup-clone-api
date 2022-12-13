<?php

namespace App\Http\Middleware;

use App\Models\TeamMember;
use Closure;
use Illuminate\Http\Request;

class CreateTeamMemberOnlyOnce
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $isAlreadyTeamMember = TeamMember::where('user_id', $request->user()->id)->first();
        if ($isAlreadyTeamMember) {
            return response()->json([
                'status' => false,
                'message' => 'You have already signed up as a team member'
            ]);
        }
        return $next($request);
    }
}
