<?php

use App\Http\Controllers\MasterSekolahController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'getUser']);

    // Endpoint Sekolah (Proteksi dengan Sanctum)
    Route::get('/sekolah', [MasterSekolahController::class, 'index']);
    Route::get('/sekolah/{id}', [MasterSekolahController::class, 'show']);
    Route::post('/sekolah', [MasterSekolahController::class, 'store']);
    Route::put('/sekolah/{id}', [MasterSekolahController::class, 'update']);
    Route::delete('/sekolah/{id}', [MasterSekolahController::class, 'destroy']);
});
