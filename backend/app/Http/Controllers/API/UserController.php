<?php


namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Audit;
use Illuminate\Support\Facades\Auth;


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
/*public function toggleActive(User $user)
{
    $user->update([
        'is_active' => !$user->is_active
    ]);

    return response()->json([
        'message' => 'User status updated'
    ]);
}*/



public function toggleActive(User $user)
{
    $currentUser = Auth::user();

    //  BLOCCA AUTO-DISABLE
    if ($currentUser->id === $user->id) {
        return response()->json([
            'message' => 'You cannot disable your own account'
        ], 403);
    }

    //  (OPZIONALE PRO) BLOCCA SE ULTIMO ADMIN
    if ($user->role === 'admin') {
        $adminCount = \App\Models\User::where('role', 'admin')
            ->where('is_active', true)
            ->count();

        if ($adminCount <= 1) {
            return response()->json([
                'message' => 'Cannot disable the last active admin'
            ], 403);
        }
    }

    //  TOGGLE
    $user->is_active = !$user->is_active;
    $user->save();

    //  SE DISABILITATO → LOGOUT FORZATO
    if (!$user->is_active) {
        $user->tokens()->delete();

        Audit::log($currentUser, 'user_disabled', [
            'target_user' => $user->id
        ]);
    }

    return response()->json([
        'message' => 'User status updated',
        'is_active' => $user->is_active
    ]);
}




}
