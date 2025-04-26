<?php


use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});
// product CRUD
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{product}', [ProductController::class, 'update']);
Route::delete('/products/{product}', [ProductController::class, 'destroy']);

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);

Route::get('/cart/{id}',[\App\Http\Controllers\Api\CartController::class,'show']);
Route::get('/cart/',[\App\Http\Controllers\Api\CartController::class,'index']);
Route::post('/cart',[\App\Http\Controllers\Api\CartController::class,'store']);
Route::put('/cart/{id}',[\App\Http\Controllers\Api\CartController::class,'update']);
Route::delete('/cart/{id}',[\App\Http\Controllers\Api\CartController::class,'destroy']);
