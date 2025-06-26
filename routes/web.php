<?php

use App\Http\Controllers\AgeCotroller;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\WorkshopTypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
});

Route::prefix('api')->middleware('web')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::middleware('auth:web')->group(function () {

        //User
        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/logout', [AuthController::class, 'logout']);

        //workshop
        Route::get('/workshopTypes',[WorkshopTypeController::class, 'index']);
        Route::post('/workshop', [WorkshopController::class, 'imported']);
        Route::delete('/workshop/{id}', [WorkshopController::class, 'delete']);
        Route::post('/workshop/search', [WorkshopController::class, 'search']);
        //Age
        Route::get('/age',[AgeCotroller::class, 'index']);
    });
});
