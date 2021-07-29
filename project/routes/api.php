<?php

use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

// Auth
Route::post('/register', [AuthController::class, 'register'])->name('login.api');
Route::post('/login', [AuthController::class, 'login'])->name('login.api');

// Manager
Route::middleware(['auth:sanctum', 'user.type'])->prefix('/manager')->group(function () {

    Route::put('edit-order/{order}', [ManagerController::class, 'update']);

});

// Customers
Route::middleware('auth:sanctum')->group(function () {

//  Products
    Route::get('/', [ProductController::class, 'index']);

//  Orders
    Route::post('/order', [OrderController::class, 'order']);
    Route::get('/order/{order}', [OrderController::class, 'get']);
    Route::put('/cancel-order/{order}', [OrderController::class, 'update']);

});
