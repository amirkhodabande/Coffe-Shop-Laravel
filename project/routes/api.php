<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

// Auth
Route::post('/login', [AuthController::class, 'login'])->name('login.api');

// Manager
Route::middleware(['auth:sanctum', 'user.type'])->prefix('/manager')->group(function () {
    Route::post('edit-order', function () {
        return "Hello!";
    });
});

// Customers
Route::get('/', [ProductController::class, 'index']);
