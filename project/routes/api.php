<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login'])->name('login.api');

Route::middleware(['auth:sanctum', 'user.type'])->prefix('/manager')->group(function () {
    Route::post('edit-order', function () {
        return "Hello!";
    });
});
