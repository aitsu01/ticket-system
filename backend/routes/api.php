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

    //  AUTH
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {

    $user = User::findOrFail($id);

    // verifica hash email
    if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        return response()->json(['message' => 'Invalid verification link'], 403);
    }

    // verifica firma URL
    if (!URL::hasValidSignature($request)) {
        return response()->json(['message' => 'Invalid or expired link'], 403);
    }

    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    return redirect('http://localhost:5173/email-verified');

})->middleware('signed')->name('verification.verify');

    // 🔁 RESEND (serve auth)
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Verification email sent'
        ]);
    })->middleware('auth:sanctum');

    //  PROTECTED ROUTES
    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);

        //  Tickets
        Route::apiResource('tickets', TicketController::class);

        //  Comments
        Route::post('tickets/{ticket}/comments', [CommentController::class, 'store']);

        Route::patch('/tickets/{ticket}/status', [TicketController::class, 'changeStatus']);
Route::patch('/tickets/{ticket}/assign', [TicketController::class, 'assign']);

        //  Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index']);
    });

  

//  invio link reset
Route::post('/forgot-password', function (Request $request) {

    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return response()->json([
        'status' => $status
    ]);
});

//  reset password
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


Route::get('/users', [UserController::class, 'index'])->middleware('auth:sanctum');



});
