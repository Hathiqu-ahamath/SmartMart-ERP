<?php
namespace App\Services;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class SaleService
{
    public function getAllPaginated(int $perPage = 15)
    {
        return Sale::with(['user', 'items.product'])->orderBy('created_at', 'desc')->paginate($perPage);
    }
    public function findById(int $id)
    {
        return Sale::with(['items.product', 'user'])->findOrFail($id);
    }
    public function createSale(array $data, array $items)
    {
        return DB::transaction(function () use ($data, $items) {
            $data['invoice_number'] = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6));
            $data['user_id'] = auth()->id();
            $subtotal = 0;
            $totalCost = 0;
            $saleItems = [];
            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);
                if ($product->quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for product: {$product->product_name}");
                }
                $itemTotal = $item['quantity'] * $product->selling_price;
                $itemCost = $item['quantity'] * $product->cost_price;
                $subtotal += $itemTotal;
                $totalCost += $itemCost;
                $saleItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->selling_price,
                    'total_price' => $itemTotal,
                    'cost_price' => $product->cost_price,
                    'product' => $product,
                ];
            }
            $taxAmount = $subtotal * ($data['tax_percentage'] ?? 0) / 100;
            $discountAmount = $subtotal * ($data['discount_percentage'] ?? 0) / 100;
            $grandTotal = $subtotal + $taxAmount - $discountAmount;
            $sale = Sale::create([
                'invoice_number' => $data['invoice_number'],
                'user_id' => $data['user_id'],
                'customer_name' => $data['customer_name'] ?? null,
                'customer_email' => $data['customer_email'] ?? null,
                'customer_phone' => $data['customer_phone'] ?? null,
                'subtotal' => $subtotal,
                'tax_percentage' => $data['tax_percentage'] ?? 0,
                'tax_amount' => $taxAmount,
                'discount_percentage' => $data['discount_percentage'] ?? 0,
                'discount_amount' => $discountAmount,
                'grand_total' => $grandTotal,
                'payment_method' => $data['payment_method'] ?? 'cash',
                'notes' => $data['notes'] ?? null,
            ]);
            foreach ($saleItems as $saleItem) {
                $product = $saleItem['product'];
                $product->decrement('quantity', $saleItem['quantity']);
                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                    'type' => 'sale',
                    'quantity' => -$saleItem['quantity'],
                    'reference_type' => 'Sale',
                    'reference_id' => $sale->id,
                    'notes' => 'Sale #' . $sale->id,
                ]);
                unset($saleItem['product']);
                $saleItem['sale_id'] = $sale->id;
                SaleItem::create($saleItem);
            }
            return $sale->fresh(['items.product', 'user']);
        });
    }
}
