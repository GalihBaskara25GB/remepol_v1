<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Load Custom Class
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\KriteriaController;
use App\Http\Controllers\Api\AlternatifController;
use App\Http\Controllers\Api\MatapelajaranController;
use App\Http\Controllers\Api\EvaluationController;
use App\Http\Controllers\Api\ApiUtilityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/check', [AuthController::class, 'check']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/refresh', [AuthController::class, 'refresh']);
    Route::get('/utility/count', [ApiUtilityController::class, 'count']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::resource('user', UserController::class);
    Route::resource('kriteria', KriteriaController::class)->parameters(['kriteria' => 'kriteria']);
    Route::resource('alternatif', AlternatifController::class);
    Route::resource('matapelajaran', MatapelajaranController::class);
    Route::resource('evaluation', EvaluationController::class);
});
