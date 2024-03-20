<?php

use App\Http\Controllers\Web\AccountController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\BrandController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ProductController;

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

Route::get('/', [HomeController::class, 'home']);
Route::get('/{slug}.html', [HomeController::class, 'details']);

// Admin
Route::prefix('admin')->group(function () {
    // Route::middleware(['check.auth', 'check.admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'home']);

    // Users
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'home']);
        Route::get('/details/{user}', [UserController::class, 'details']);
        Route::get('/create', [UserController::class, 'create']);
        Route::post('/create', [UserController::class, 'handleCreate']);
        Route::get('/edit/{user}', [UserController::class, 'edit']);
        Route::patch('/edit/{user}', [UserController::class, 'handleUpdate']);
        Route::delete('/', [UserController::class, 'handleDelete']);
    });

    // Brands
    Route::prefix('brands')->group(function () {
        Route::get('/', [BrandController::class, 'home']);
        Route::get('/details/{brand}', [BrandController::class, 'details']);
        Route::get('/create', [BrandController::class, 'create']);
        Route::post('/create', [BrandController::class, 'handleCreate']);
        Route::get('/edit/{brand}', [BrandController::class, 'edit']);
        Route::patch('/edit/{brand}', [BrandController::class, 'handleUpdate']);
        Route::delete('/', [BrandController::class, 'handleDelete']);
    });

    // Categories
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'home']);
        Route::get('/details/{category}', [CategoryController::class, 'details']);
        Route::get('/create', [CategoryController::class, 'create']);
        Route::post('/create', [CategoryController::class, 'handleCreate']);
        Route::get('/edit/{category}', [CategoryController::class, 'edit']);
        Route::patch('/edit/{category}', [CategoryController::class, 'handleUpdate']);
        Route::delete('/', [CategoryController::class, 'handleDelete']);
    });

    // Products
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'home']);
        Route::get('/details/{product}', [ProductController::class, 'details']);
        Route::get('/create', [ProductController::class, 'create']);
        Route::get('/edit/{product}', [ProductController::class, 'edit']);
        Route::delete('/', [ProductController::class, 'handleDelete']);
    });
});

// Auth
Route::prefix('auth')->group(function () {
    // Route::middleware('check.guest')->group(function () {
    Route::prefix('otp')->group(function () {
        Route::get('/', [AuthController::class, 'otp']);
        Route::post('/', [AuthController::class, 'handleVerifyOtp']);
        Route::get('/resend', [AuthController::class, 'handleResendOtp']);
    });

    Route::get('/login', [AuthController::class, 'localLogin']);
    Route::post('/login', [AuthController::class, 'handleLocalLogin']);

    Route::get('/forget-password', [AuthController::class, 'showForgetPasswordForm']);
    Route::post('/forget-password', [AuthController::class, 'submitForgetPasswordForm']);
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm']);
    Route::post('/reset-password/{token}', [AuthController::class, 'submitResetPasswordForm']);

    Route::get('/info-social', [AuthController::class, 'infoSocial']);
    Route::post('/info-social', [AuthController::class, 'handleUpdateInfoSocial']);

    Route::get('/{provider?}/redirect', [AuthController::class, 'socialLogin']);
    Route::get('/{provider?}/callback', [AuthController::class, 'handleSocialLogin']);

    Route::get('/register', [AuthController::class, 'register']);
    Route::post('/register', [AuthController::class, 'handleRegister']);
    // });

    // Route::middleware('check.auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    // });
});

Route::prefix('member')->group(function () {
    Route::get('/', [AccountController::class, 'index']);
});
