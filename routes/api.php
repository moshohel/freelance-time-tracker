<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TimeLogController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::get('/time-logs', [TimeLogController::class, 'index']);
    Route::post('/time-logs', [TimeLogController::class, 'store']);
    Route::get('/time-logs/{id}', [TimeLogController::class, 'show']);
    Route::put('/time-logs/{id}', [TimeLogController::class, 'update']);
    Route::delete('/time-logs/{id}', [TimeLogController::class, 'destroy']);

    // Start & End logging
    Route::post('/time-logs/start', [TimeLogController::class, 'start']);
    Route::post('/time-logs/{id}/end', [TimeLogController::class, 'end']);
    // Filter and report logs
    Route::get('/report', [TimeLogController::class, 'filter']);
});
