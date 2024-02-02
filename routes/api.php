<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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



Route::prefix('a1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::resource('rent', RentController::class);
        Route::get('user', [AuthController::class, 'index']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
    Route::post('auth/login', [AuthController::class, 'login'])->withoutMiddleware('api');
    Route::post('register', [AuthController::class, 'register'])->withoutMiddleware('api');
});
