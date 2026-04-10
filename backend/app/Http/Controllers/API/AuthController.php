<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    //  REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'min:8',
                'regex:/[A-Z]/',     // uppercase
                'regex:/[a-z]/',     // lowercase
                'regex:/[0-9]/',     // number
                'regex:/[\W_]/'      // special char
            ]
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //  email verifica
        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Registered successfully. Please verify your email.'
        ], 201);
    }

    //  LOGIN (PRO)
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //  RATE LIMIT (anti brute force)
        $key = 'login:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json([
                'message' => 'Too many attempts. Try again later.'
            ], 429);
        }

        $user = User::where('email', $request->email)->first();

        //  credenziali errate
        if (!$user || !Hash::check($request->password, $user->password)) {

            RateLimiter::hit($key, 60); // blocca 60 sec

            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }

        //  utente disattivato
        if (isset($user->is_active) && !$user->is_active) {
            return response()->json([
                'message' => 'Account disabled. Contact support.'
            ], 403);
        }

        //  email non verificata
        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email not verified'
            ], 403);
        }

        //  reset tentativi
        RateLimiter::clear($key);

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    //  LOGOUT
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }

    //  ME
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}