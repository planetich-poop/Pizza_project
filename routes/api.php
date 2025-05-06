<?php


use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});
// product CRUD
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);


Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);



Route::post('login', [AuthController::class, 'login']);

Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::post('/cart',[\App\Http\Controllers\Api\CartController::class,'store']);
    Route::get('/cart/{id}',[\App\Http\Controllers\Api\CartController::class,'show']);
    Route::get('/cart/',[\App\Http\Controllers\Api\CartController::class,'index']);
    Route::put('/cart/{id}',[\App\Http\Controllers\Api\CartController::class,'update']);
    Route::delete('/cart',[\App\Http\Controllers\Api\CartController::class,'destroy']);

    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);



    Route::get('profile', [AuthController::class, 'user']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('logout', [AuthController::class, 'logout']);
});
