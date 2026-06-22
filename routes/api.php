<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\VacancyController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::apiResource('vacancies', VacancyController::class)->only(['index', 'store', 'show']);
    Route::apiResource('candidates', CandidateController::class)->only(['index', 'store', 'show']);
    Route::patch('candidates/{candidate}/status', [CandidateController::class, 'updateStatus']);
});
