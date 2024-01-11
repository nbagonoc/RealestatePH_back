<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getAgentProfile($id)
    {
        // $agent = User::find($id)::where('role', 'agent')->first();
        $agent = User::where(['id' => $id, 'role' => 'agent'])
            ->with('profile')
            ->select('id', 'name', 'email')
            ->first();
        $agent->profile->makeHidden(['id', 'user_id']);

        return $agent
        ? response()->json($agent, 200)
        : response()->json(['error' => 'Agent not found'], 404);
    }

    public function getUserProfile($id)
    {
        $user = User::where(['id' => $id])
            ->with('profile')
            ->select('id', 'name', 'email')
            ->first();
        $user->profile->makeHidden(['id', 'user_id']);

        return $user
        ? response()->json($user, 200)
        : response()->json(['error' => 'User not found'], 404);
    }
}
