<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TableController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes (no authentication required)
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require authentication with Sanctum)
Route::middleware(['auth:sanctum'])->group(function () {
    
    // Authentication routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Admin & Superadmin only routes
    Route::middleware(['api_role:admin,superadmin'])->group(function () {
        
        // Products API
        Route::apiResource('products', ProductController::class);
        
        // Categories API
        Route::apiResource('categories', CategoryController::class);
        
        // Tables API
        Route::apiResource('tables', TableController::class);
        
        // Orders API
        Route::get('orders', [OrderController::class, 'index']);
        Route::get('orders/{order}', [OrderController::class, 'show']);
        Route::put('orders/{order}/status', [OrderController::class, 'updateStatus']);
        Route::post('orders/{order}/confirm-payment', [OrderController::class, 'confirmPayment']);
        
        // Reports API
        Route::get('reports/sales', [ReportController::class, 'sales']);
        Route::get('reports/dashboard', [ReportController::class, 'dashboard']);
    });
});
