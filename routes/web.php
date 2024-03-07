<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BrandController;
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

// Admin
Route::prefix('admin')->group(function () {
    Route::get("/", [DashboardController::class, 'home']);

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'home']);
        Route::get('/details/{user}', [UserController::class, 'details']);
        Route::get('/create', [UserController::class, 'create']);
        Route::post('/create', [UserController::class, 'handleCreate']);
        Route::get('/edit/{user}', [UserController::class, 'edit']);
        Route::post('/edit/{user}', [UserController::class, 'handleUpdate']);
        Route::delete('/', [UserController::class, 'handleDelete']);

    });


});

// Auth
Route::prefix('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])
        ->name('logout');

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

    //categories
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'home']);
        Route::get('/details/{category}', [CategoryController::class, 'details']);
        Route::get('/create', [CategoryController::class, 'create']);
        Route::post('/create', [CategoryController::class, 'handleCreate']);
        Route::get('/edit/{category}', [CategoryController::class, 'edit']);
        Route::post('/edit/{category}', [CategoryController::class, 'handleUpdate']);
        Route::delete('/', [CategoryController::class, 'handleDelete']);
    });
});

// Auth
Route::prefix('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/login', [AuthController::class, 'login']);
    Route::post('/login', [AuthController::class, 'handleLocalLogin']);

    Route::prefix('otp')->group(function () {
        Route::get('/', [AuthController::class, 'otp']);
        Route::post('/', [AuthController::class, 'handleVerifyOtp']);
        Route::get('/resend', [AuthController::class, 'handleResendOtp']);
    });
});
