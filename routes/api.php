<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function () {
    return response()->json([
        'test' => 'test'
    ]);
});

// AUTHENTICATION ROUTES
Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function () {
        Route::post('/register', 'register');
    });

Route::controller(ProductController::class)
    ->prefix('products')
    ->group(function () {
        Route::get('/', 'index');
    });
