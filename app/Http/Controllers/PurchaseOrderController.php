<?php
namespace App\Http\Controllers;
use App\Services\PurchaseOrderService;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
class PurchaseOrderController extends Controller
{
    protected PurchaseOrderService $purchaseOrderService;
    public function __construct(PurchaseOrderService $purchaseOrderService)
    {
        $this->purchaseOrderService = $purchaseOrderService;
    }
    public function index()
    {
        $orders = $this->purchaseOrderService->getAllPaginated(15);
        return view('purchases.index', compact('orders'));
    }
    public function create()
    {
        $suppliers = Supplier::active()->get();
        $products = Product::active()->get();
        return view('purchases.create', compact('suppliers', 'products'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'expected_date' => 'nullable|date|after_or_equal:order_date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);
        $order = $this->purchaseOrderService->create($validated, $request->items);
        return redirect()->route('purchases.show', $order->id)->with('success', 'Purchase order created successfully.');
    }
    public function show($id)
    {
        $order = $this->purchaseOrderService->findById($id);
        return view('purchases.show', compact('order'));
    }
    public function approve($id)
    {
        try {
            $this->purchaseOrderService->approve($id);
            return redirect()->route('purchases.index')->with('success', 'Purchase order approved.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function cancel($id)
    {
        try {
            $this->purchaseOrderService->cancel($id);
            return redirect()->route('purchases.index')->with('success', 'Purchase order cancelled.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
