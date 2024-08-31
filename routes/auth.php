<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::controller(LoginController::class)->prefix('auth')->group(function () {
    Route::get('{guard}/login',     'login')->name('login');
    Route::post('login',            'authenticate')->name('auth.authenticate');
    Route::get('logout',            'logout')->name('auth.logout');
});
Route::controller(ResetController::class)->prefix('auth/web')->group(function () {
    Route::get('reset-password', 'index')->name('auth.reset-password');
    Route::post('auth-Found', 'isFound')->name('auth.isFound');
});
