<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * display a user list except his own account
     */
    public function userList($id)
    {
        $users = User::where('id', '!=', $id)->get();
        return response()->json([
            'userList' => $users
        ]);
    }
}
