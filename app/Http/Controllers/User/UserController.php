<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

//Should rename this to UserProfileController since it's both utilizing the User and Profile models
class UserController extends Controller
{
    public function profile()
    {
        $user_id = Auth::user()->id;
        $user = User::join('profiles', 'users.id', '=', 'profiles.user_id')
        ->where(['users.id' => $user_id])
        ->select('users.id', 'users.email', 'profiles.*')
        ->first()
        ->makeHidden('user_id');

        return $user
        ? response()->json($user, 200)
        : response()->json(['error' => 'User not found'], 404);
    }

    public function getAgentProfile($id)
    {
        $agent = User::join('profiles', 'users.id', '=', 'profiles.user_id')
        ->where(['users.id' => $id, 'users.role' => 'agent'])
        ->select('users.*', 'profiles.*')
        ->first()
        ->makeHidden('user_id','email_verified_at');

        return $agent
        ? response()->json($agent, 200)
        : response()->json(['error' => 'Agent not found'], 404);
    }

    public function getUserProfile($id)
    {
        $user = User::join('profiles', 'users.id', '=', 'profiles.user_id')
        ->where(['users.id' => $id])
        ->select('users.*', 'profiles.*')
        ->first()
        ->makeHidden('user_id','email_verified_at');

        return $user
        ? response()->json($user, 200)
        : response()->json(['error' => 'User not found'], 404);
    }

    public function updateProfile(Request $request)
    {
        $user_id = Auth::user()->id;
        $profile = Profile::find($user_id);

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        $data = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'string|max:25',
            'about' => 'string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        //store image in s3
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('profiles', 's3'); //store the file in profiles directory in s3 storage method
            Storage::cloud('s3')->setVisibility($path, 'public'); //make the file public
            $url = Storage::cloud('s3')->url($path); //get the url of the file
            $data['photo'] = $url; //use the url to store in the database
        }

        $profile->update($data);

        return response()->json(['message' => 'Profile updated'], 200);
    }
}
