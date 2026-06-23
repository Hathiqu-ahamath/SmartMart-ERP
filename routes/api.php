<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\ReportApiController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('products', [ProductApiController::class, 'index']);
    Route::get('products/{id}', [ProductApiController::class, 'show']);
    Route::get('products/search', [ProductApiController::class, 'search']);
    Route::get('reports/dashboard', [ReportApiController::class, 'dashboard']);
    Route::get('reports/sales-trend', [ReportApiController::class, 'salesTrend']);
    Route::get('reports/daily-sales', [ReportApiController::class, 'dailySales']);
});
