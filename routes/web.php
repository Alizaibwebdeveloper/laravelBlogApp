<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

/*

Testing Routes

*/

Route::view('/example-page', 'example-page');
Route::view('/example-auth', 'example-auth');

/*

Admin Routes

*/

Route::prefix('admin')->name('admin.')->group(callback: function(){
    Route::middleware(['guest'])->group(function(){

        Route::controller(AuthController::class)->group(function(){

            Route::get('/login',action: 'loginForm')->name('login');
            Route::post('/login', 'login_handler')->name('login_handler');
            Route::get('/forgot-password','forgotForm')->name('forgot');
            Route::post('/send_password_reset_link', 'SendPasswordResetLink')->name('send_password_reset_link');
            Route::get('/password/reset/{token}', 'resetForm')->name('reset_password_form');
        });
    });

    Route::middleware(['auth'])->group(function(){
        Route::controller(AdminController::class)->group(function(){
            Route::get('/dashboard','adminDashboard')->name('dashboard');
            Route::post('/logout','logoutHandler')->name('logout');

        });
    });
});
