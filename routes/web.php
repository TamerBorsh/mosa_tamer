<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Coupon\CouponController;
use App\Http\Controllers\Dash\DashController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Institution\InstitutionController;
use App\Http\Controllers\Location\LocationController;
use App\Http\Controllers\Mosque\MosqueController;
use App\Http\Controllers\Nominate\ExportNominateController;
use App\Http\Controllers\Nominate\ImportNominateController;
use App\Http\Controllers\Nominate\NominateController;
use App\Http\Controllers\Region\RegionController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\User\ExportController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

// Auth Route
require_once (__DIR__) . '/auth.php';

Route::get('optimize', function () {
    \Artisan::call('optimize:clear');
    // \Artisan::call('migrate --seed');
    // dd("done");
});


Route::group(['middleware' => 'auth:admin', 'prefix' => 'dash'], function () {

    Route::controller(DashController::class)->group(function () {
        Route::get('/',                         'index')->name('dash.index');
        Route::get('/chart-copons',             'ChartCopon')->name('dash.ChartRecive');
        Route::get('/chart-locations',          'ChartLocation')->name('dash.ChartLocation');
    });

    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('/get-detalies/{id}',        'detalies');
        Route::post('/del-check',               'delCheckAll')->name('users.delCheck');
    });
    Route::controller(ExportController::class)->prefix('phpspreadsheet')->group(function () {
        Route::get('/import-excel-form',        'importExcelForm')->name('users.importExcelForm');
        Route::post('/import-excel_file',       'ImportEcel')->name('users.ImportEcel');
        Route::get('/export-excel_file',        'ExportEcel')->name('users.ExportEcel');
    });
    Route::controller(MosqueController::class)->prefix('mosques')->group(function () {
        Route::post('/update-data',             'updateData')->name('mosques.updateData');
    });
    Route::controller(RoleController::class)->prefix('roles')->group(function () {
        Route::post('/update-data',             'updateData')->name('roles.updateData');
    });
    Route::controller(LocationController::class)->prefix('locations')->group(function () {
        Route::post('/update-data',             'update')->name('locations.updateData');
    });
    Route::controller(AdminController::class)->prefix('admins')->group(function () {
        Route::post('/update-data',             'update')->name('admins.updateData');
    });
    Route::controller(InstitutionController::class)->prefix('institutions')->group(function () {
        Route::post('/update-data',             'update')->name('institutions.updateData');
    });
    Route::controller(CouponController::class)->prefix('coupons')->group(function () {
        Route::post('/update-data',             'update')->name('coupons.updateData');
        Route::post('/coupons/checkQuantity',   'checkQuantity')->name('coupons.checkQuantity');
    });
    Route::controller(NominateController::class)->prefix('nominates')->group(function () {
        Route::post('/refresh-status',          'refreshStatus')->name('nominates.refreshStatus');
    });
    Route::controller(ExportNominateController::class)->prefix('nominates')->group(function () {
        Route::get('/copons-export-excel',      'ExportEcel')->name('nominates.ExportEcel');
    });
    Route::controller(ImportNominateController::class)->prefix('nominates')->group(function () {
        Route::get('/import-excel',             'importExcelForm')->name('nominates.importExcelForm');
        Route::post('/import-excel_file',       'import')->name('nominates.ImportEcel');
    });

    Route::resources([
        'admins'            => AdminController::class,
        'users'             => UserController::class,
        'regions'           => RegionController::class,
        'mosques'           => MosqueController::class,
        'roles'             => RoleController::class,
        'coupons'           => CouponController::class,
        'locations'         => LocationController::class,
        'institutions'      => InstitutionController::class,
        'nominates'         => NominateController::class,
    ]);
});

Route::get('/', [FrontController::class, 'index'])->name('front.index');
