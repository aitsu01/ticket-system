<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\RateLimiter;
use App\Helpers\Audit;


class AuthController extends Controller
{
    // ========================
    // REGISTER
    // ========================
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[\W_]/'
            ]
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //  email verifica
        $user->sendEmailVerificationNotification();

        //  AUDIT
        Audit::log($user, 'register', [
            'email' => $user->email
        ]);

        return response()->json([
            'message' => 'Registered successfully. Please verify your email.'
        ], 201);
    }

    // ========================
    // LOGIN
    // ========================
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $key = 'login:' . $request->ip();

        //  RATE LIMIT
        if (RateLimiter::tooManyAttempts($key, 5)) {

            Audit::log(null, 'login_blocked', [
                'email' => $request->email
            ]);

            return response()->json([
                'message' => 'Too many attempts. Try again later.'
            ], 429);
        }

        $user = User::where('email', $request->email)->first();

        //  WRONG CREDENTIALS
        if (!$user || !Hash::check($request->password, $user->password)) {

            RateLimiter::hit($key, 60);

            Audit::log($user, 'login_failed', [
                'email' => $request->email
            ]);

            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }

        //  ACCOUNT DISABLED
        if (isset($user->is_active) && !$user->is_active) {

            Audit::log($user, 'login_blocked_disabled');

            return response()->json([
                'message' => 'Account disabled. Contact support.'
            ], 403);
        }

        //  EMAIL NOT VERIFIED
        if (!$user->hasVerifiedEmail()) {

            Audit::log($user, 'login_blocked_unverified');

            return response()->json([
                'message' => 'Email not verified'
            ], 403);
        }

        //  SUCCESS LOGIN
        Audit::log($user, 'login', [
            'method' => 'email'
        ]);

        RateLimiter::clear($key);

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    // ========================
    // LOGOUT
    // ========================
    public function logout(Request $request)
{
    $user = $request->user();

    //  controlla se token esiste
    if ($user && $request->user()->currentAccessToken()) {

        Audit::log($user, 'logout');

        $request->user()->currentAccessToken()->delete();
    }

    return response()->json([
        'message' => 'Logged out'
    ]);
}
    // ========================
    // ME
    // ========================
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}