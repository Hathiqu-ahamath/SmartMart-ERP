<?php
namespace App\Services;
use App\Repositories\PurchaseOrderRepository;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class PurchaseOrderService
{
    protected PurchaseOrderRepository $purchaseOrderRepository;
    public function __construct(PurchaseOrderRepository $purchaseOrderRepository)
    {
        $this->purchaseOrderRepository = $purchaseOrderRepository;
    }
    public function getAllPaginated(int $perPage = 15)
    {
        return PurchaseOrder::with(['supplier', 'user'])->paginate($perPage);
    }
    public function findById(int $id)
    {
        return PurchaseOrder::with(['supplier', 'items.product', 'user'])->findOrFail($id);
    }
    public function create(array $data, array $items)
    {
        return DB::transaction(function () use ($data, $items) {
            $data['po_number'] = $data['po_number'] ?? 'PO-' . date('Ymd') . '-' . strtoupper(Str::random(5));
            $data['user_id'] = auth()->id();
            $totalAmount = 0;
            $order = PurchaseOrder::create($data);
            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $total = $item['quantity'] * $item['unit_price'];
                $totalAmount += $total;
                PurchaseOrderItem::create([
                    'purchase_order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $total,
                ]);
            }
            $order->update(['total_amount' => $totalAmount]);
            return $order->fresh(['items.product', 'supplier']);
        });
    }
    public function approve(int $id)
    {
        $order = PurchaseOrder::findOrFail($id);
        if (!$order->canApprove()) {
            throw new \Exception('Purchase order cannot be approved in its current status.');
        }
        $order->update(['status' => 'approved']);
        return $order->fresh();
    }
    public function cancel(int $id)
    {
        $order = PurchaseOrder::findOrFail($id);
        if (in_array($order->status, ['received', 'cancelled'])) {
            throw new \Exception('Purchase order cannot be cancelled in its current status.');
        }
        $order->update(['status' => 'cancelled']);
        return $order->fresh();
    }
    public function getPendingOrders()
    {
        return $this->purchaseOrderRepository->getPendingOrders();
    }
}
