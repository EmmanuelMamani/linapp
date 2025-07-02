<?php

use App\Http\Controllers\AgeCotroller;
use App\Http\Controllers\ExtracurricularController;
use App\Http\Controllers\SectionController;
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

        //Extracurricular
        Route::post('/extracurricular', [ExtracurricularController::class, 'create']);
        Route::put('/extracurricular/{id}', [ExtracurricularController::class, 'update']);
        Route::delete('/extracurricular/{id}', [ExtracurricularController::class, 'delete']);
        Route::post('/extracurricular/active', [ExtracurricularController::class, 'active']);
        Route::post('/extracurricular/assign/{extracurricular_id}/{section_id}', [ExtracurricularController::class, 'assign']);

        //Section
        Route::get('/sections',[SectionController::class, 'index']);
        Route::post('/section', [SectionController::class, 'storeOrUpdate']);
        Route::delete('/section/{id}', [SectionController::class, 'delete']);
    });
});
