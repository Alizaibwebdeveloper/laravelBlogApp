<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});


/*

Admin Routes

*/

Route::prefix('admin')->name('admin.')->group(callback: function(){
    Route::middleware([])->group(function(){

        Route::controller(AuthController::class)->group(function(){

            Route::get('/login',action: 'loginForm')->name('login');
            Route::get('/forgot-password','forgotForm')->name('forgot');
        });
    });

    Route::middleware([])->group(function(){
        Route::controller(AdminController::class)->group(function(){
            Route::get('/dashboard','adminDashboard')->name('dashboard');

        });
    });
});
