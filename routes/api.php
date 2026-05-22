<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::prefix('restaurant')->group(function () {

    Route::post('/register', [AuthController::class, 'restaurantRegister']);
    Route::post('/login', [AuthController::class, 'restaurantLogin']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/restaurant/logout', [AuthController::class, 'logout']);
});
