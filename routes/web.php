<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\UserController;

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

});
