<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Restaurant\AuthController;
use App\Http\Controllers\Api\Restaurant\RestaurantController;

Route::prefix('restaurant')->group(function () {

    // Authentication
    Route::post('/register', [AuthController::class, 'restaurantRegister']);
    Route::post('/login', [AuthController::class, 'restaurantLogin']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (SANCTUM)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->prefix('restaurant')->group(function () {

    // Authentication
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::get('/reset-password/{token}', function (string $token) {
    return response()->json([
        'token' => $token
    ]);
})->name('password.reset');

//Restaurant Profile

Route::get('/profile', [RestaurantController::class, 'getRestaurantProfile']);

    Route::put('/profile', [RestaurantController::class, 'updateRestaurantProfile']);
});

