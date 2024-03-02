<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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



Route::prefix('admin')->group(function () {

    Route::prefix('users')->group(function () {

        Route::get('/', [UserController::class, 'home']);


        Route::get('/create', [UserController::class, 'createUser'] );
        Route::post('/create', [UserController::class, 'handleCreateUser']); 

        Route::get('/edit/{user}', [UserController::class, 'editUser']);
        Route::post('/edit/{user}', [UserController::class, 'updateUser']);

        Route::delete('/',[UserController::class, 'deleteUser']);

    });


});

