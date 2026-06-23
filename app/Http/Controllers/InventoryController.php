<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\StockMovement;
use App\Services\ProductService;
use Illuminate\Http\Request;
class InventoryController extends Controller
{
    protected ProductService $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index(Request $request)
    {
        $query = Product::with('category');
        if ($request->get('filter') === 'low_stock') {
            $query->lowStock();
        } elseif ($request->get('filter') === 'expired') {
            $query->whereNotNull('expiry_date')->where('expiry_date', '<', now());
        } elseif ($request->get('filter') === 'expiring') {
            $query->expiringSoon(30);
        }
        $products = $query->paginate(15);
        $lowStockCount = Product::lowStock()->count();
        $expiredCount = Product::whereNotNull('expiry_date')->where('expiry_date', '<', now())->count();
        $totalValue = Product::selectRaw('SUM(quantity * cost_price) as total')->first()->total ?? 0;
        return view('inventory.index', compact('products', 'lowStockCount', 'expiredCount', 'totalValue'));
    }
    public function movements()
    {
        $movements = StockMovement::with(['product', 'user'])->latest()->paginate(15);
        return view('inventory.movements', compact('movements'));
    }
    public function adjustForm()
    {
        $products = Product::active()->get();
        return view('inventory.adjust', compact('products'));
    }
    public function adjust(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'reason' => 'required|string|max:255',
        ]);
        $this->productService->adjustStock(
            $validated['product_id'],
            $validated['quantity'],
            $validated['reason'],
            auth()->id()
        );
        return redirect()->route('inventory.index')->with('success', 'Stock adjusted successfully.');
    }
}
