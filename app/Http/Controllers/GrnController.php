<?php
namespace App\Http\Controllers;
use App\Services\GrnService;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
class GrnController extends Controller
{
    protected GrnService $grnService;
    public function __construct(GrnService $grnService)
    {
        $this->grnService = $grnService;
    }
    public function index()
    {
        $grns = $this->grnService->getAllPaginated(15);
        return view('grn.index', compact('grns'));
    }
    public function create(Request $request)
    {
        $purchaseOrders = PurchaseOrder::with(['supplier'])
            ->where('status', 'approved')
            ->get();
        if ($request->wantsJson()) {
            $po = PurchaseOrder::with(['items.product'])->findOrFail($request->get('po_id'));
            return response()->json($po->items);
        }
        return view('grn.create', compact('purchaseOrders'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'received_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.purchase_order_item_id' => 'required|exists:purchase_order_items,id',
            'items.*.received_quantity' => 'required|integer|min:1',
        ]);
        try {
            $grn = $this->grnService->create($validated, $request->items);
            return redirect()->route('grn.show', $grn->id)->with('success', 'Goods received successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
    public function show($id)
    {
        $grn = $this->grnService->findById($id);
        return view('grn.show', compact('grn'));
    }
}
