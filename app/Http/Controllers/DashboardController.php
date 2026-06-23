<?php
namespace App\Http\Controllers;
use App\Services\DashboardService;
use App\Models\Product;
use App\Models\Sale;
use App\Models\PurchaseOrder;
class DashboardController extends Controller
{
    protected DashboardService $dashboardService;
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }
    public function index()
    {
        $stats = $this->dashboardService->getStats();
        $salesTrend = $this->dashboardService->getSalesTrend(7);
        $topProducts = $this->dashboardService->getTopProducts(5);
        $recentSales = Sale::with('user')->latest()->take(5)->get();
        $lowStockProducts = Product::with('category')->lowStock()->take(5)->get();
        $expiringProducts = Product::expiringSoon(30)->take(5)->get();
        return view('dashboard.index', compact(
            'stats', 'salesTrend', 'topProducts',
            'recentSales', 'lowStockProducts', 'expiringProducts'
        ));
    }
}
