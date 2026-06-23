<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;
use App\Models\Product;
use App\Models\PurchaseOrder;
class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}
    public function boot(): void
    {
        Gate::define('admin', function ($user) {
            return $user->isAdmin();
        });
        Gate::define('manager', function ($user) {
            return $user->hasRole('manager');
        });
        Gate::define('cashier', function ($user) {
            return $user->hasRole('cashier');
        });
        Gate::define('storekeeper', function ($user) {
            return $user->hasRole('storekeeper');
        });
        View::composer('layouts.sidebar', function ($view) {
            if (auth()->check()) {
                $view->with('lowStockCount', Product::lowStock()->count())
                     ->with('expiringCount', Product::expiringSoon(30)->count())
                     ->with('pendingPoCount', PurchaseOrder::where('status', 'pending')->count());
            }
        });
    }
}
