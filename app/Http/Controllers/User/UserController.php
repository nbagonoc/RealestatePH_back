<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getAgentProfile($id)
    {
        $agent = User::join('profiles', 'users.id', '=', 'profiles.user_id')
        ->where(['users.id' => $id, 'users.role' => 'agent'])
        ->select('users.email', 'profiles.*')
        ->first();

        return $agent
        ? response()->json($agent, 200)
        : response()->json(['error' => 'Agent not found'], 404);
    }

    public function getUserProfile($id)
    {
        $user = User::join('profiles', 'users.id', '=', 'profiles.user_id')
        ->where(['users.id' => $id])
        ->select('users.email', 'profiles.*')
        ->first();

        return $user
        ? response()->json($user, 200)
        : response()->json(['error' => 'User not found'], 404);
    }

    public function updateProfile(Request $request)
    {
        $user_id = Auth::user()->id;
        $profile = Profile::find($user_id);

        if (!$user_id || !$profile) {
            return response()->json(['message' => 'User/Profile not found'], 404);
        }

        $data = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|string|max:25',
            'about' => 'string|max:500',
            'photo' => 'string|max:255',
        ]);

        $profile->update($data);

        return response()->json(['message' => 'Profile updated'], 200);
    }
}
