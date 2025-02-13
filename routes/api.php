<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterSekolahController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/sekolah', [MasterSekolahController::class, 'index']);  // Get semua sekolah
Route::get('/sekolah/{id}', [MasterSekolahController::class, 'show']); // Get detail sekolah
Route::post('/sekolah', [MasterSekolahController::class, 'store']); // Tambah sekolah
Route::put('/sekolah/{id}', [MasterSekolahController::class, 'update']); // Update sekolah
Route::delete('/sekolah/{id}', [MasterSekolahController::class, 'destroy']); // Hapus sekolah
