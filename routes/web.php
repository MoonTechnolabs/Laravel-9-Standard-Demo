<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\EmailVerificationController;
use App\Http\Controllers\Admin\PasswordResetController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\SupportController;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/', function () {
    return redirect(route('admin.login.show'));
});
Route::post('settimezone', [HomeController::class, 'settimezone'])->name('settimezone');
Route::prefix('admin')->group(function () {

    /* Authentication */

    Route::get('/', function () {
        return redirect(route('admin.login.show'));
    });
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'index')->name('admin.login.show')->middleware('guest');
        Route::post('/login', 'login')->name('admin.login.login')->middleware('guest');
        Route::post('/logout', 'logout')->name('admin.logout');
    });
    /* PasswordReset */

    Route::middleware('guest')->group(function () {
        Route::controller(PasswordResetController::class)->group(function () {
            Route::get('/forgot-password', 'forgotpasswordShow')->name('password.request');
            Route::post('/forgot-password', 'forgotPassword')->name('password.email');
            Route::get('/reset-password/{token}/{isMobile?}', 'resetPassword')->name('password.reset');
            Route::post('/reset-password/{token}/{isMobile?}', 'updatePassword')->name('password.update');
            Route::get('success', [HomeController::class, 'success'])->name('success');
        });
    });

    /* Emailverification */

    Route::controller(EmailVerificationController::class)->group(function () {
        Route::get('/email/verify', 'index')->middleware('auth')->name('verification.notice');
        Route::post('/email/verification-notification', 'resend')->middleware(['auth', 'throttle:6,1'])->name('verification.send');
        Route::any('activation/{token}', [EmailVerificationController::class, 'activation'])->name('activation');
    });
    Route::any('activation/{token}/{isMobile?}', [UserController::class, 'activation'])->name('account-activation');

    Route::middleware(['auth', 'verified'])->group(function () {
        /* Dashboard module */
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        /* User Module */

        Route::controller(UserController::class)->group(function () {
            Route::name('admin.')->group(function () {
                Route::get('myprofile', 'myprofile')->name('profile.index');
                Route::post('update-profile/{user}', 'updateprofile')->name('profile.update');
                Route::post('update-password/{user}', 'updatePassword')->name('password.update');
            });
        });



    });

});
