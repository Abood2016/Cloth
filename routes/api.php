<?php

use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\TagsController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('products', ProductsController::class);
Route::post('auth/token', [LoginController::class, 'token']);
Route::post('auth/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
Route::resource('categories',CategoriesController::class);
Route::resource('tags',TagsController::class);
Route::resource('orders',OrdersController::class);
Route::post('user/profile', [UserController::class, 'updateProfile'])->middleware('auth:sanctum');

// Route::resource('users', UserController::class)->middleware('auth:sanctum');
