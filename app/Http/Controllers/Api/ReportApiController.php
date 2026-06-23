<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ReportApiController extends Controller
{
    protected DashboardService $dashboardService;
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }
    public function dashboard()
    {
        return response()->json($this->dashboardService->getStats());
    }
    public function salesTrend(Request $request)
    {
        $days = $request->get('days', 7);
        return response()->json($this->dashboardService->getSalesTrend($days));
    }
    public function dailySales(Request $request)
    {
        $date = $request->get('date', today()->toDateString());
        $sales = Sale::whereDate('created_at', $date)->with('items.product')->get();
        return response()->json($sales);
    }
}
