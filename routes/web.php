<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Coupon\CouponController;
use App\Http\Controllers\Dash\DashController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Institution\InstitutionController;
use App\Http\Controllers\Location\LocationController;
use App\Http\Controllers\Log\LogController;
use App\Http\Controllers\Mosque\MosqueController;
use App\Http\Controllers\Nominate\ExportNominateController;
use App\Http\Controllers\Nominate\ImportNominateController;
use App\Http\Controllers\Nominate\NominateController;
use App\Http\Controllers\Region\RegionController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Role\RolePermissionController;
use App\Http\Controllers\User\ExportUserController;
use App\Http\Controllers\User\ImportUserController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

// Auth Route
require_once (__DIR__) . '/auth.php';

Route::group(['middleware' => 'auth:admin,web', 'prefix' => 'dash'], function () {
    Route::controller(DashController::class)->group(function () {
        Route::get('/',                         'index')->name('dash.index');
        Route::get('/chart-nominates',             'ChartNominates')->name('dash.ChartRecive');
        Route::get('/chart-locations',          'ChartLocation')->name('dash.ChartLocation');
    });
});

Route::group(['middleware' => 'auth:admin', 'prefix' => 'dash'], function () {

    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('/get-detalies/{id}',        'detalies');
        Route::post('/del-check',               'delCheckAll')->name('users.delCheck');
    });
    Route::controller(ImportUserController::class)->prefix('users/phpspreadsheet')->group(function () {
        Route::get('/import',        'importExcelForm')->name('users.importExcelForm');
        Route::post('/import-excel',       'ImportExcel')->name('users.ImportEcel');
    });
    Route::controller(ExportUserController::class)->prefix('users/phpspreadsheet')->group(function () {
        Route::get('/export',        'ExportExcel')->name('users.ExportEcel');
    });
    Route::controller(MosqueController::class)->prefix('mosques')->group(function () {
        Route::post('/update-data',             'updateData')->name('mosques.updateData');
    });
    Route::controller(RoleController::class)->prefix('roles')->group(function () {
        Route::post('/update-data',             'updateData')->name('roles.updateData');
    });
    Route::put('roles/{role}/permissions',          [RolePermissionController::class, 'update'])->name('RolePermission.update');

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
        Route::get('/coupon-redemption',          'couponRedemption')->name('nominates.couponRedemption');
        Route::post('/search',          'search')->name('nominates.search');

    });
    Route::controller(ExportNominateController::class)->prefix('nominates')->group(function () {
        Route::get('/copons-export-excel',      'ExportEcel')->name('nominates.ExportEcel');
    });
    Route::controller(ImportNominateController::class)->prefix('nominates')->group(function () {
        Route::get('update/import',             'importExcelForm')->name('nominates.importExcelForm');
        Route::post('update/is_recive',       'StoreImportEcel')->name('nominates.StoreImportEcel');
        Route::get('/import',             'importFormNominates')->name('nominates.importNominatesForm');
        Route::post('/import-excel_file',       'importExcel')->name('nominates.importFormNominates');
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
        'logs'              => LogController::class,

    ]);
});

Route::get('/', [FrontController::class, 'index'])->name('front.index');
