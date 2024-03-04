<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
    return view('welcome');
});

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])
        ->middleware('checklogin::class');

    Route::post('/login', [AuthController::class, 'store'])
        ->name('login');

    Route::get('/otp', [AuthController::class, 'OTPverify'])
        ->name('OTPverify')
        ->middleware('checklogin::class');

    Route::post('/otp', [AuthController::class, 'OTPverify_POST'])
        ->name('OTP_POST');

    Route::get('/otp/resend', [AuthController::class, 'resendOtp'])
        ->name('resendOtp');
});

Route::get('/logout', [AuthController::class, 'logout'])
    ->name('logout');

