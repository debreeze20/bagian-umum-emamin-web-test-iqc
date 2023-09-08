<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Auth
Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('/login', [Api\AuthController::class, 'login'])->middleware("throttle:3,1");

    Route::group([
        'middleware' => ['auth:sanctum'],
    ], function () {
        Route::post('/logout', [Api\AuthController::class, 'logout']);
        Route::get('/me', [Api\AuthController::class, 'me']);
        Route::post('/change-password', [Api\AuthController::class, 'changePassword']);
    });
});

//Select List Data Master
Route::group([
    'prefix' => 'select-list'
], function () {
    Route::get('/subdistrict', [Api\SelectListController::class, 'subdistrict']);
    Route::get('/account-code', [Api\SelectListController::class, 'accountCode']);
    Route::get('/product-type', [Api\SelectListController::class, 'productType']);
    Route::get('/order-method', [Api\SelectListController::class, 'orderMethod']);
    Route::get('/umkm', [Api\SelectListController::class, 'umkm']);
});

//Helper
Route::group([
    'prefix' => 'helper'
], function () {
    Route::get('/show-file/{type}/{fileId}', [Api\HelperController::class, 'showFile']);
    Route::get('/latest-version/{type}', [Api\HelperController::class, 'latestVersion']);
});

Route::get('/image/{path}', [Api\HelperController::class, 'image'])->withoutMiddleware(['throttle:api'])->name('files.image');
