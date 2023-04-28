<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\SupportController;

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


Route::group(['prefix' => 'V1', 'namespace' => 'Api\V1'], function () {

    // Route::post('signup', [AuthController::class, 'signup']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
});

Route::middleware(['auth:api'])->group(function () {
    Route::group(['namespace' => 'Api\V1'], function () {        
        Route::group(['prefix' => 'V1'], function () {
            Route::post('deviceinfo', [AuthController::class, 'storeDeviceInfo'])->name('deviceinfo');  //Device Login details store
            Route::post('change-password', [UserController::class, 'storeChangePassword']);
            Route::post('updateprofile', [UserController::class, 'updateProfile']);

            /* User */
            Route::group(['prefix' => 'user'], function () {
                Route::get('details', [UserController::class, 'getUserDetails']);
            });
            /* Support */
            Route::group(['prefix' => 'support'], function () {
                Route::post('create', [SupportController::class, 'store']);
            });
        });
    });
});
