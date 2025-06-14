<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GatoController;
use App\Http\Controllers\AuthController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('rol:admin')->group(function () {
        Route::apiResource('gatos', GatoController::class);
    });

    Route::middleware('rol:encargado')->group(function () {
        Route::post('/gatos', [GatoController::class, 'store']);
        Route::put('/gatos/{gato}', [GatoController::class, 'update']);
        Route::patch('/gatos/{gato}', [GatoController::class, 'update']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/gatos', [GatoController::class, 'index']);
    Route::get('/gatos{gato}', [GatoController::class, 'show']);
});
