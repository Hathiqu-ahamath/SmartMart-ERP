<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PurchaseOrderItem extends Model {
    protected $fillable = ['purchase_order_id', 'product_id', 'quantity', 'received_quantity', 'unit_price', 'total_price'];
    protected $casts = ['quantity' => 'integer', 'received_quantity' => 'integer', 'unit_price' => 'decimal:2', 'total_price' => 'decimal:2'];
    public function purchaseOrder() { return $this->belongsTo(PurchaseOrder::class); }
    public function product() { return $this->belongsTo(Product::class); }
    public function grnItems() { return $this->hasMany(GrnItem::class); }
    public function remainingQuantity() { return $this->quantity - $this->received_quantity; }
}
