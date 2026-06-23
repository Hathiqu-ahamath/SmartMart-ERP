<?php
namespace App\Services;
use App\Models\Product;
use App\Models\Sale;
use App\Models\PurchaseOrder;
use App\Models\Category;
use Carbon\Carbon;
class DashboardService
{
    public function getStats(): array
    {
        return [
            'today_revenue' => Sale::today()->sum('grand_total'),
            'today_transactions' => Sale::today()->count(),
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'low_stock_products' => Product::lowStock()->count(),
            'expired_products' => Product::whereNotNull('expiry_date')->where('expiry_date', '<', now())->count(),
            'expiring_products' => Product::expiringSoon(30)->count(),
            'pending_pos' => PurchaseOrder::where('status', 'pending')->count(),
        ];
    }
    public function getSalesTrend(int $days = 7): array
    {
        $data = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $daySales = Sale::whereDate('created_at', $date)->sum('grand_total');
            $data[] = [
                'date' => $date->format('M d'),
                'revenue' => (float) $daySales,
            ];
        }
        return $data;
    }
    public function getTopProducts(int $limit = 5): array
    {
        return \App\Models\SaleItem::selectRaw('product_id, SUM(quantity) as total_qty, SUM(total_price) as total_revenue')
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
