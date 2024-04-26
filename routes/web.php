<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\MemberController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\BrandController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CustomerController;
use App\Http\Controllers\Web\SpecificationController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\WishlistController;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\Web\SettingController;

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

// Admin
Route::prefix('admin')->group(function () {
    Route::middleware(['check.auth', 'check.admin', 'check.active_account'])->group(function () {
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

            // Specifications
            Route::prefix('/details/{category}/specifications')->group(function () {
                Route::get('/add', [SpecificationController::class, 'add']);
                Route::post('/add', [SpecificationController::class, 'handleAdd']);
                Route::get('/edit/{specification}', [SpecificationController::class, 'edit']);
                Route::patch('/edit/{specification}', [SpecificationController::class, 'handleUpdate']);
                Route::delete('/', [SpecificationController::class, 'handleDelete']);
            });
        });

        // Products
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'home']);
            Route::get('/details/{product}', [ProductController::class, 'details'])->name("admin.products.details");
            Route::get('/create', [ProductController::class, 'create']);
            Route::get('/edit/{product}', [ProductController::class, 'edit']);
            Route::delete('/', [ProductController::class, 'handleDelete']);
        });

        // Customers
        Route::prefix('customers')->group(function () {
            Route::get('/', [CustomerController::class, 'home'])->name("admin.customers.home");
            Route::get('/details/{user}', [CustomerController::class, 'details'])->name("admin.customers.details");
            Route::get('/create', [CustomerController::class, 'create'])->name("admin.customers.create");
            Route::post('/create', [CustomerController::class, 'handleCreate']);
            Route::get('/edit/{user}', [CustomerController::class, 'edit'])->name("admin.customers.edit");
            Route::patch('/edit/{user}', [CustomerController::class, 'handleUpdate']);
            Route::delete('/', [CustomerController::class, 'handleDelete']);
        });

        // Orders
        Route::prefix('orders')->group(function () {
            Route::get('/', [OrderController::class, 'home'])->name("admin.orders.home");
            Route::get('/details/{order}', [OrderController::class, 'details'])->name("admin.orders.details");
            Route::get('/create', [OrderController::class, 'create'])->name("admin.orders.create");
            Route::post('/create', [OrderController::class, 'handleCreate']);
            Route::get('/edit/{order}', [OrderController::class, 'edit'])->name("admin.orders.edit");
            Route::patch('/edit/{order}', [OrderController::class, 'handleUpdate']);
            Route::delete('/', [OrderController::class, 'handleDelete']);
        });

        // Settings
        Route::prefix('settings')->group(function () {
            Route::get('/password', [SettingController::class, 'changePasswordPage']);
            Route::patch('/password', [SettingController::class, 'handleChangePassword']);
        });
    });
});

// Auth
Route::prefix('auth')->group(function () {
    Route::prefix('otp')->middleware("check.inactive_account")->group(function () {
        Route::get('/', [AuthController::class, 'otp']);
        Route::post('/', [AuthController::class, 'handleVerifyOtp']);
        Route::get('/resend', [AuthController::class, 'handleResendOtp']);
    });

    Route::middleware('check.guest')->group(function () {
        Route::get('/login', [AuthController::class, 'localLogin']);
        Route::post('/login', [AuthController::class, 'handleLocalLogin']);

        Route::get('/register', [AuthController::class, 'register']);
        Route::post('/register', [AuthController::class, 'handleRegister']);

        Route::get('/forget-password', [AuthController::class, 'forgetPasswordForm']);
        Route::post('/forget-password', [AuthController::class, 'handleForgetPassword']);
        Route::get('/reset-password/{token}', [AuthController::class, 'changePasswordForm']);
        Route::post('/reset-password/{token}', [AuthController::class, 'handleChangePassword']);

        Route::get('/info-social', [AuthController::class, 'infoSocial']);
        Route::post('/info-social', [AuthController::class, 'handleCreateWithAccountSocial']);

        Route::get('/{provider}/redirect', [AuthController::class, 'socialLogin']);
        Route::get('/{provider}/callback', [AuthController::class, 'handleSocialLogin']);
    });

    Route::middleware('check.auth')->group(function () {
        Route::get('/logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('check.notadmin')->group(function () {
    Route::get('/', [HomeController::class, 'home']);
    Route::get('/catalogsearch/result', [HomeController::class, 'search']);
    Route::get('/{categorySlug}/{brandSlug}/{productSlug}.html', [HomeController::class, 'details']);
    Route::get('/cart', [CartController::class, 'home'])->name("cart.index");
});

Route::middleware(['check.auth', "check.customer", 'check.active_account'])->group(function () {
    Route::prefix('cart')->group(function () {
        Route::post('/', [CartController::class, 'handleCreate'])->name("cart.create");
        Route::patch('/', [CartController::class, 'handleUpdate'])->name("cart.update");
        Route::delete('/', [CartController::class, 'handleDelete'])->name("cart.delete");
        Route::get('/checkout', [CartController::class, 'checkoutPage'])->name("cart.checkout");
        Route::get('/success', [CartController::class, 'success'])->name("cart.success");
    });

    Route::prefix('wishlist')->group(function () {
        Route::get('/', [WishlistController::class, 'home']);
        Route::post('/', [WishlistController::class, 'handleCreate']);
        Route::delete('/', [WishlistController::class, 'handleDelete']);
    });

    Route::prefix('member')->group(function () {
        Route::get('/', [MemberController::class, 'home']);
        Route::get('/orders', [MemberController::class, 'orders']);
        Route::get('/orders/{order}', [MemberController::class, 'orderDetailsPage']);

        Route::get('/change-password', [MemberController::class, 'changePasswordPage']);
        Route::patch('/change-password', [MemberController::class, 'handleChangePassword']);

        Route::get('/profile', [MemberController::class, 'profilePage']);

        Route::get('/edit-profile', [MemberController::class, 'editProfilePage']);
        Route::patch('/edit-profile', [MemberController::class, 'handleUpdateProfile']);
    });

    Route::prefix('payment')->group(function () {
        Route::post('/cod', [PaymentController::class, 'handleCodPayment']);
        Route::post('/momo', [PaymentController::class, 'handleMomoPayment']);
    });
});
