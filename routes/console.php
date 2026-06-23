<?php
use Illuminate\Support\Facades\Schedule;
use App\Models\Product;
use App\Models\Notification;
use Illuminate\Support\Str;

Schedule::call(function () {
    $lowStockProducts = Product::lowStock()->get();
    foreach ($lowStockProducts as $product) {
        // Low stock notifications can be sent here
    }
    $expiringProducts = Product::expiringSoon(30)->get();
    foreach ($expiringProducts as $product) {
        // Expiry notifications can be sent here
    }
})->daily();
