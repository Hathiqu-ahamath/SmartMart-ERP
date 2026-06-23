<?php
namespace App\Services;
use App\Models\Grn;
use App\Models\GrnItem;
use App\Models\PurchaseOrder;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class GrnService
{
    public function getAllPaginated(int $perPage = 15)
    {
        return Grn::with(['purchaseOrder.supplier', 'user'])->paginate($perPage);
    }
    public function findById(int $id)
    {
        return Grn::with(['purchaseOrder.supplier', 'items.product', 'items.purchaseOrderItem', 'user'])->findOrFail($id);
    }
    public function create(array $data, array $items)
    {
        return DB::transaction(function () use ($data, $items) {
            $data['grn_number'] = 'GRN-' . date('Ymd') . '-' . strtoupper(Str::random(5));
            $data['user_id'] = auth()->id();
            $grn = Grn::create($data);
            $fullyReceived = true;
            foreach ($items as $item) {
                $poItem = \App\Models\PurchaseOrderItem::findOrFail($item['purchase_order_item_id']);
                $grnItem = GrnItem::create([
                    'grn_id' => $grn->id,
                    'purchase_order_item_id' => $item['purchase_order_item_id'],
                    'product_id' => $poItem->product_id,
                    'ordered_quantity' => $poItem->quantity,
                    'received_quantity' => $item['received_quantity'],
                    'unit_price' => $poItem->unit_price,
                    'total_price' => $item['received_quantity'] * $poItem->unit_price,
                ]);
                $poItem->increment('received_quantity', $item['received_quantity']);
                $product = $poItem->product;
                $product->increment('quantity', $item['received_quantity']);
                StockMovement::create([
                    'product_id' => $poItem->product_id,
                    'user_id' => auth()->id(),
                    'type' => 'purchase',
                    'quantity' => $item['received_quantity'],
                    'reference_type' => 'GRN',
                    'reference_id' => $grn->id,
                    'notes' => 'GRN #' . $grn->grn_number,
                ]);
                if ($poItem->remainingQuantity() > 0) {
                    $fullyReceived = false;
                }
            }
            $grn->update(['status' => $fullyReceived ? 'fully_received' : 'partially_received']);
            $po = $grn->purchaseOrder;
            $allFullyReceived = $po->items()->whereColumn('received_quantity', '<', 'quantity')->doesntExist();
            $po->update(['status' => $allFullyReceived ? 'received' : 'approved']);
            return $grn->fresh(['items.product', 'purchaseOrder']);
        });
    }
}
