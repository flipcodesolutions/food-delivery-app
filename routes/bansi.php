<?php

use App\Http\Controllers\Api\Customer\AddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Customer\AuthController;
use App\Http\Controllers\Api\Customer\CartController;
use App\Http\Controllers\Api\Customer\OrderController;
use App\Http\Controllers\Api\Customer\RestaurantListController;
use App\Http\Controllers\Api\Customer\ProfileController;
use App\Http\Controllers\Api\Customer\SearchController;
use App\Http\Controllers\Api\Customer\CmsController;

// Customer API

Route::prefix('customer')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/login', [AuthController::class, 'login']);

    // Forgot Password
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

    // Reset Password
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    Route::get('/search', [SearchController::class, 'search']);

    Route::get('/restaurantList', [SearchController::class, 'restaurantList']);

    Route::get('/restaurantOffer', [SearchController::class, 'restaurantOffer']);

    Route::get('/restaurant-menu/{id}', [RestaurantListController::class, 'restaurants']);
    
    Route::get('/category-list/{id?}', [RestaurantListController::class, 'CategoryList']);
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

        Route::get('/profile', [ProfileController::class, 'profile']);

        Route::post('/update-profile/{id}', [ProfileController::class, 'updateProfile']);

        Route::post('/add-Address',[AddressController::class,'addAddress']);

        Route::get('/get-Address',[AddressController::class,'getAddress']);

        Route::post('/update-Address/{id}',[AddressController::class,'updateAddress']);

         Route::post('/place-order', [OrderController::class, 'placeOrder']);

        Route::get('/orders', [OrderController::class, 'myOrders']);

        Route::get('/orders/{id}', [OrderController::class, 'orderDetails']);

        Route::delete('/cancel-orders/{id}', [OrderController::class, 'cancelOrder']);

        Route::get('/cms/{title?}', [CmsController::class, 'cms']);

        Route::get('/cms/{slug}', [CmsController::class, 'showCMS']);
    });
});