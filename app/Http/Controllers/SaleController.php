<?php
namespace App\Http\Controllers;
use App\Services\SaleService;
use App\Models\Product;
use Illuminate\Http\Request;
class SaleController extends Controller
{
    protected SaleService $saleService;
    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }
    public function index()
    {
        $sales = $this->saleService->getAllPaginated(15);
        return view('sales.index', compact('sales'));
    }
    public function pos()
    {
        $products = Product::active()->where('quantity', '>', 0)->get();
        return view('sales.pos', compact('products'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:200',
            'customer_email' => 'nullable|email|max:100',
            'customer_phone' => 'nullable|string|max:20',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'payment_method' => 'required|string|in:cash,card,transfer',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);
        try {
            $sale = $this->saleService->createSale($validated, $request->items);
            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'sale' => $sale]);
            }
            return redirect()->route('sales.show', $sale->id)->with('success', 'Sale completed successfully.');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
    public function show($id)
    {
        $sale = $this->saleService->findById($id);
        return view('sales.show', compact('sale'));
    }
    public function receipt($id)
    {
        $sale = $this->saleService->findById($id);
        return view('sales.receipt', compact('sale'));
    }
}
