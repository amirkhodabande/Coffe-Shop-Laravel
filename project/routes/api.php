<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

// Auth
Route::post('/register', [AuthController::class, 'register'])->name('login.api');
Route::post('/login', [AuthController::class, 'login'])->name('login.api');

// Manager
Route::middleware(['auth:sanctum', 'user.type'])->prefix('/manager')->group(function () {
    Route::post('edit-order', function () {
        return "Hello!";
    });
});

// Customers
Route::middleware('auth:sanctum')->group(function () {

//  Products
    Route::get('/', [ProductController::class, 'index']);

//  Orders
    Route::post('/order', [OrderController::class, 'order']);

});
