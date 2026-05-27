<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CmsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login',[LoginController::class,'index'])->name('admin.login');
Route::post('/admin/authenticate',[LoginController::class,'authenticate'])->name('admin.authenticate');
Route::post('/admin/logout',[LoginController::class,'logout'])->name('admin.logout');

Route::middleware(['admin'])->group(function(){
    Route::get('admin/dashboard',function(){
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::resource('users', UserController::class);

     // Restaurant List
    Route::get('/restaurants', [RestaurantController::class, 'index'])
        ->name('restaurants.index');

    Route::get('/customer', [CustomerController::class, 'index'])
        ->name('customer.index');   
        
    Route::get('/cms/{slug?} ', [CmsController::class, 'edit'])
        ->name('cms.edit');
    Route::put('/cms/{slug}',[CmsController::class,'update'])
        ->name('cms.update');
    Route::get('/restaurants/{id}',[RestaurantController::class,'show'])
        ->name('restaurants.show');
});
