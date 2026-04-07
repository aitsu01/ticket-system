<?php


namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
   public function index()
{
    return User::select('id', 'name', 'email', 'role', 'is_active')->get();
}

//  cambia ruolo
public function updateRole(Request $request, User $user)
{
    $request->validate([
        'role' => 'required|in:admin,agent,user'
    ]);

    $user->update([
        'role' => $request->role
    ]);

    return response()->json([
        'message' => 'Role updated'
    ]);
}

//  attiva/disattiva
public function toggleActive(User $user)
{
    $user->update([
        'is_active' => !$user->is_active
    ]);

    return response()->json([
        'message' => 'User status updated'
    ]);
}
}
