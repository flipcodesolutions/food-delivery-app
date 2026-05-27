<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\AuthController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\RestaurantListController;
use App\Http\Controllers\Customer\SearchController;

// Customer API

Route::prefix('customer')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/login', [AuthController::class, 'login']);

    // Forgot Password
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

    // Reset Password
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    Route::get('/search', [SearchController::class, 'search']);

    Route::get('/RestaurantList', [SearchController::class, 'restaurantList']);

    Route::get('/RestaurantOffer', [SearchController::class, 'restaurantOffer']);

    Route::get('/Restaurant', [RestaurantListController::class, 'restaurants']);

    Route::get('/category-list', [RestaurantListController::class, 'CategoryList']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('customer')->group(function () {

        Route::post('/change-password', [AuthController::class, 'changePassword']);

        Route::post('/cart/add', [CartController::class, 'addToCart']);

        Route::get('/cart', [CartController::class, 'getCart']);

        Route::put('/cart/update/{id}', [CartController::class, 'updateCart']);

        Route::delete('/cart/delete/{id}', [CartController::class, 'removeCartItem']);

        Route::delete('/cart/clear', [CartController::class, 'clearCart']);

        // Route::post('/logout', [AuthController::class, 'logout']);

        // Route::get('/profile', [AuthController::class, 'profile']);
    });
});