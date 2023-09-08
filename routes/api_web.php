<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiWeb;

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

//Master
Route::group([
    'prefix' => 'master',
    'middleware' => ['auth:sanctum']
], function () {

    //App Version
    Route::group([
        'prefix' => 'app-version'
    ], function () {
        Route::get('/', [ApiWeb\AppVersionController::class, 'index'])->middleware(['role:sanctum,developer']);
        Route::post('/', [ApiWeb\AppVersionController::class, 'store'])->middleware(['role:sanctum,developer']);

        Route::group([
            'prefix' => '{appVersionId}'
        ], function () {
            Route::get('/', [ApiWeb\AppVersionController::class, 'show'])->middleware(['role:sanctum,developer']);
            Route::put('/', [ApiWeb\AppVersionController::class, 'update'])->middleware(['role:sanctum,developer']);
            Route::delete('/', [ApiWeb\AppVersionController::class, 'destroy'])->middleware(['role:sanctum,developer']);
        });
    });

    //ProductType
    Route::group([
        'prefix' => 'product-type'
    ], function () {
        Route::get('/', [ApiWeb\ProductTypeController::class, 'index'])->middleware(['role:sanctum,admin']);
        Route::post('/', [ApiWeb\ProductTypeController::class, 'store'])->middleware(['role:sanctum,admin']);

        Route::group([
            'prefix' => '{id}'
        ], function () {
            Route::get('/', [ApiWeb\ProductTypeController::class, 'show'])->middleware(['role:sanctum,admin']);
            Route::put('/', [ApiWeb\ProductTypeController::class, 'update'])->middleware(['role:sanctum,admin']);
            Route::delete('/', [ApiWeb\ProductTypeController::class, 'destroy'])->middleware(['role:sanctum,admin']);
            Route::put('/change-status', [ApiWeb\ProductTypeController::class, 'changeStatus'])->middleware(['role:sanctum,admin']);
        });
    });

    //Umkm
    Route::group([
            'prefix' => 'umkm',
    ],function () {
            Route::get('/', [ApiWeb\UmkmController::class, 'index'])->middleware(['role:sanctum,admin']);
            Route::post('/', [ApiWeb\UmkmController::class, 'store'])->middleware(['role:sanctum,admin']);
        
            Route::group([
                'prefix' => '{umkmId}'
            ], function () {
                Route::get('/', [ApiWeb\UmkmController::class, 'show'])->middleware(['role:sanctum,admin']);
                Route::post('/', [ApiWeb\UmkmController::class, 'update'])->middleware(['role:sanctum,admin']);
                Route::delete('/', [ApiWeb\UmkmController::class, 'destroy'])->middleware(['role:sanctum,admin']);
            });
        }
    );
});

//Report
Route::group([
    'prefix' => 'report',
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/submission', [ApiWeb\ReportController::class, 'submission'])->middleware(['role:sanctum,admin']);
    Route::get('/umkm', [ApiWeb\ReportController::class, 'umkm'])->middleware(['role:sanctum,admin']);
});

//Transact
Route::group([
    'prefix' => 'transact',
    'middleware' => ['auth:sanctum']
], function () {

    //Submission
    Route::group([
        'prefix' => 'submission'
    ], function () {
        Route::get('/', [ApiWeb\SubmissionController::class, 'index'])->middleware(['role:sanctum,admin']);
        Route::post('/', [ApiWeb\SubmissionController::class, 'store'])->middleware(['role:sanctum,admin']);

        Route::group([
            'prefix' => '{submissionId}'
        ], function () {
            Route::post('/', [ApiWeb\SubmissionController::class, 'update'])->middleware(['role:sanctum,admin']);
            Route::get('/', [ApiWeb\SubmissionController::class, 'show'])->middleware(['role:sanctum,admin']);
            Route::post('/file', [ApiWeb\SubmissionController::class, 'storeFile'])->middleware(['role:sanctum,admin']);
            Route::post('/file-delete', [ApiWeb\SubmissionController::class, 'deleteFile'])->middleware(['role:sanctum,admin']);
            Route::delete('/', [ApiWeb\SubmissionController::class, 'destroy'])->middleware(['role:sanctum,admin']);
        });
    });

    //History
    Route::group([
        'prefix' => 'history'
    ], function () {
        Route::get('/count/{umkmId}', [ApiWeb\HistoryController::class, 'historyOrderCount'])->middleware(['role:sanctum,admin']);
        Route::get('/{umkmId}', [ApiWeb\HistoryController::class, 'historyOrder'])->middleware(['role:sanctum,admin']);
        Route::get('/{umkmId}/submission/{submissionId}', [ApiWeb\HistoryController::class, 'historyOrderDetail'])->middleware(['role:sanctum,admin']);
    });
});

//Dashboard
Route::group([
    'prefix' => 'dashboard',
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/status-umkm', [ApiWeb\DashboardController::class, 'getStatusUmkm']);
    Route::get('/transaction', [ApiWeb\DashboardController::class, 'getTransaction']);
    Route::get('/transaction-product', [ApiWeb\DashboardController::class, 'getTransactionPerProduct']);
    Route::get('/transaction-order', [ApiWeb\DashboardController::class, 'getTransactionOrder']);
});
