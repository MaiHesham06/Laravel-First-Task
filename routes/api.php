<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', fn (Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('users')->group(function () {
        Route::post('/', [UserController::class, 'storeUser']);
        Route::get('{user}', [UserController::class, 'showUser']);
        Route::put('{user}', [UserController::class, 'updateUser']);
        Route::delete('{user}', [UserController::class, 'deleteUser']);
        Route::post('{user}/restore', [UserController::class, 'restoreUser']);
    });
});