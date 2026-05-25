<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\AuthController;

Route::prefix('restaurant')->group(function () {

    Route::post('/register', [AuthController::class, 'restaurantRegister']);
    Route::post('/login', [AuthController::class, 'restaurantLogin']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/restaurant/logout', [AuthController::class, 'logout']);
});

//Customer API

Route::prefix('customer')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/login', [AuthController::class, 'login']);

    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
});


Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('customer')->group(function () {

        Route::post('/change-password', [AuthController::class, 'changePassword']);

        // Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/profile', [AuthController::class, 'profile']);
    });
});