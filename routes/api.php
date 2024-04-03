<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AttributeController;
use App\Http\Controllers\Api\ProductController;

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

Route::get("/categories/{category}/attributes", [AttributeController::class, 'findAllAttributeByCategory']);
Route::post("/products", [ProductController::class, 'create']);
Route::patch("/products/{product}", [ProductController::class, 'update']);