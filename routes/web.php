<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DashboardController;

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

    //Brands
    Route::prefix('brands')->group(function () {
        Route::get('/', [BrandController::class, 'home']);

        Route::get('/details/{brand}', [BrandController::class, 'details']);

        Route::get('/create', [BrandController::class, 'create']);
        Route::post('/create', [BrandController::class, 'handleCreate']);

        Route::get('/edit/{brand}', [BrandController::class, 'edit']);
        Route::post('/edit/{brand}', [BrandController::class, 'handleUpdate']);

        Route::delete('/', [BrandController::class, 'handleDelete']);
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
    Route::get('/login', [AuthController::class, 'localLogin']);
    Route::post('/login', [AuthController::class, 'handleLocalLogin']);

    Route::get('/info-social', [AuthController::class, 'infoSocial']);
    Route::post('/info-social', [AuthController::class, 'handleUpdateInfoSocial']);

    Route::prefix('otp')->group(function () {
        Route::get('/', [AuthController::class, 'otp']);
        Route::post('/', [AuthController::class, 'handleVerifyOtp']);
        Route::get('/resend', [AuthController::class, 'handleResendOtp']);
    });

    Route::get('/{provider?}/redirect', [AuthController::class, 'socialLogin']);
    Route::get('/{provider?}/callback', [AuthController::class, 'handleSocialLogin']);

    Route::get('/register', [AuthController::class, 'register']);
    Route::post('/register', [AuthController::class, 'handleRegister']);
});
