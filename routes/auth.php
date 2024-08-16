<?php

use App\Http\Controllers\Auth\LoginController;
// use Illuminate\Support\Facades\Route;

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
