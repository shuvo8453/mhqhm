<?php

use App\Http\Controllers\Backend\System\SystemController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;

Route::prefix('admin')->name('admin.')->group(function () {

    Route::view('/login','auth.admin.login')
        ->middleware( 'guest:admin',)
        ->name('login');

    $limiter = config('fortify.limiters.login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:admin',
            $limiter ? 'throttle:'.$limiter : null,
        ]));

    //logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout')->middleware('auth:admin');

    //forget password
    Route::view('/forgot-password' ,'auth.admin.password.email')
        ->middleware(['guest:admin'])
        ->name('password.request');

    Route::view('/reset-password/{token}' ,'auth.admin.password.reset')
        ->middleware(['guest:admin'])
        ->name('password.reset');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware(['guest:admin'])
        ->name('password.email');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware(['guest:admin'])
        ->name('password.update');

//    //two-factor-challenge
//    Route::get('/two-factor-challenge', [ProfileController::class,'twoFactorChallenge'])
//        ->middleware('guest:admin',)
//        ->name('two-factor.login');

    $twoFactorLimiter = config('fortify.limiters.two-factor');
    Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:admin',
            $twoFactorLimiter ? 'throttle:'.$twoFactorLimiter : null,
        ]));

    Route::post('/confirm-password', [SystemController::class, 'password_check'])
        ->name('password.confirm');
});
