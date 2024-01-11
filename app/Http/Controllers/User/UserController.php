<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getAgent($id)
    {
        // $agent = User::find($id)::where('role', 'agent')->first();
        $agent = User::where(['id' => $id, 'role' => 'agent'])
            ->select('id', 'name', 'email')
            ->first();

        return $agent
        ? response()->json($agent, 200)
        : response()->json(['error' => 'Agent not found'], 404);
    }
}
