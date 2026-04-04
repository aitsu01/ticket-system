<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TicketController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

Route::prefix('v1')->group(function () {

    // 🔓 PUBLIC ROUTES

    // AUTH
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // 📧 EMAIL VERIFY
    Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {

        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'Invalid verification link'], 403);
        }

        if (!URL::hasValidSignature($request)) {
            return response()->json(['message' => 'Invalid or expired link'], 403);
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect('http://localhost:5173/email-verified');

    })->middleware('signed')->name('verification.verify');


    // 🔁 RESEND VERIFICATION (PUBLIC)
    Route::post('/resend-verification', function (Request $request) {

        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email already verified'
            ], 400);
        }

        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Verification email sent'
        ]);
    });


    // 🔐 PASSWORD RESET
    Route::post('/forgot-password', function (Request $request) {

        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return response()->json([
            'status' => $status
        ]);
    });

    Route::post('/reset-password', function (Request $request) {

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),

            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password reset successful'])
            : response()->json(['message' => 'Invalid token'], 400);
    });


    // 🔐 PROTECTED ROUTES
    Route::middleware('auth:sanctum')->group(function () {

        // AUTH
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);

        // USERS
        Route::get('/users', [UserController::class, 'index']);

        // TICKETS
        Route::apiResource('tickets', TicketController::class);

        Route::patch('/tickets/{ticket}/status', [TicketController::class, 'changeStatus']);
        Route::patch('/tickets/{ticket}/assign', [TicketController::class, 'assign']);

        // COMMENTS
        Route::post('tickets/{ticket}/comments', [CommentController::class, 'store']);

        // DASHBOARD
        Route::get('/dashboard', [DashboardController::class, 'index']);

    });

});
