<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Restaurant\CategoryController;
use App\Http\Controllers\Api\Restaurant\AuthController;
use App\Http\Controllers\Api\Restaurant\DashboardController;

Route::prefix('restaurant')->group(function () {

    Route::post('/register', [AuthController::class, 'restaurantRegister']);
    Route::post('/login', [AuthController::class, 'restaurantLogin']);
});

Route::middleware('auth:sanctum')->group(function () {
     Route::post('/restaurant/logout', [AuthController::class, 'logout']);

    Route::post('/restaurant/change-password', [AuthController::class, 'changePassword']);

    Route::get('/restaurant/dashboard', [DashboardController::class, 'index']);



    Route::get('/restaurant/categories', [CategoryController::class, 'index']);

    Route::post('/restaurant/categories', [CategoryController::class, 'store']);

    Route::get('/restaurant/categories/{id}', [CategoryController::class, 'show']);

    Route::put('/restaurant/categories/{id}', [CategoryController::class, 'update']);

    Route::delete('/restaurant/categories/{id}', [CategoryController::class, 'destroy']);


});
