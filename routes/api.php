<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Admin\ProductController as AdminProductController;
use App\Http\Controllers\API\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CouponController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These routes are loaded by the RouteServiceProvider and all of them
| will be assigned to the "api" middleware group.
*/

// ============================
// 🔓 Public Routes
// ============================
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/apply-coupon', [CouponController::class, 'apply']);

// 🌐 Public Product Routes
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/featured', [ProductController::class, 'featured']);
    Route::get('/search', [ProductController::class, 'search']);
    Route::get('/category/{id}', [ProductController::class, 'byCategory']);
    Route::get('/{id}', [ProductController::class, 'show']);
});

// ============================
// 🔐 Authenticated User Routes
// ============================

Route::middleware('auth:sanctum')->group(function () {

    // 👤 User Info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // 🛒 Cart Routes
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/', [CartController::class, 'store']);
        Route::put('{id}', [CartController::class, 'update']);
        Route::delete('{id}', [CartController::class, 'destroy']);
        Route::delete('/', [CartController::class, 'clear']);
    });

    // 🚪 Logout
    Route::post('/logout', [LoginController::class, 'logout']);
});

// ============================
// 🛠️ Admin Routes
// ============================
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::apiResource('products', AdminProductController::class);
    Route::apiResource('categories', AdminCategoryController::class);
});
