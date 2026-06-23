<?php
namespace App\Http\Controllers;
use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class ReportController extends Controller
{
    public function dailySales(Request $request)
    {
        $date = $request->get('date') ? Carbon::parse($request->get('date')) : today();
        $sales = Sale::whereDate('created_at', $date)->with('items.product', 'user')->get();
        $totalSales = $sales->sum('grand_total');
        $totalTransactions = $sales->count();
        $totalProfit = SaleItem::whereHas('sale', function ($q) use ($date) {
            $q->whereDate('created_at', $date);
        })->get()->sum(function ($item) {
            return ($item->unit_price - $item->cost_price) * $item->quantity;
        });
        return view('reports.daily', compact('sales', 'date', 'totalSales', 'totalTransactions', 'totalProfit'));
    }
    public function monthlySales(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);
        $sales = Sale::whereMonth('created_at', $month)->whereYear('created_at', $year)
            ->with('items.product')->orderBy('created_at')->get();
        $totalRevenue = $sales->sum('grand_total');
        $totalTransactions = $sales->count();
        $totalProfit = SaleItem::whereHas('sale', function ($q) use ($month, $year) {
            $q->whereMonth('created_at', $month)->whereYear('created_at', $year);
        })->get()->sum(function ($item) {
            return ($item->unit_price - $item->cost_price) * $item->quantity;
        });
        $dailyBreakdown = $sales->groupBy(function ($sale) {
            return $sale->created_at->format('Y-m-d');
        })->map(function ($daySales) {
            return [
                'date' => $daySales->first()->created_at->format('M d'),
                'revenue' => $daySales->sum('grand_total'),
                'transactions' => $daySales->count(),
            ];
        })->values();
        return view('reports.monthly', compact(
            'sales', 'totalRevenue', 'totalTransactions', 'totalProfit',
            'dailyBreakdown', 'month', 'year'
        ));
    }
    public function inventoryReport()
    {
        $totalProducts = Product::count();
        $lowStock = Product::lowStock()->count();
        $expired = Product::whereNotNull('expiry_date')->where('expiry_date', '<', now())->count();
        $expiring = Product::expiringSoon(30)->count();
        $totalValue = Product::sum(DB::raw('quantity * cost_price'));
        $categorySummary = Product::selectRaw('category_id, COUNT(*) as count, SUM(quantity) as total_qty, SUM(quantity * cost_price) as total_value')
            ->with('category')->groupBy('category_id')->get();
        return view('reports.inventory', compact(
            'totalProducts', 'lowStock', 'expired', 'expiring', 'totalValue', 'categorySummary'
        ));
    }
}
