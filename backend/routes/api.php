<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TicketController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\UserController;
 use App\Http\Controllers\API\DashboardController;



use App\Http\Controllers\API\AuthController;

Route::prefix('v1')->group(function () {

    //  Auth
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);

        //  Tickets
        Route::apiResource('tickets', TicketController::class);

        //  Comments
        Route::post('tickets/{ticket}/comments', [CommentController::class, 'store']);

        // Dashboard
       

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);

});
    });
});

