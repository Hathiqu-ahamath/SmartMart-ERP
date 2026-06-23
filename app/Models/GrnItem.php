<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class GrnItem extends Model {
    protected $fillable = ['grn_id', 'purchase_order_item_id', 'product_id', 'ordered_quantity', 'received_quantity', 'unit_price', 'total_price'];
    protected $casts = ['ordered_quantity' => 'integer', 'received_quantity' => 'integer', 'unit_price' => 'decimal:2', 'total_price' => 'decimal:2'];
    public function grn() { return $this->belongsTo(Grn::class); }
    public function purchaseOrderItem() { return $this->belongsTo(PurchaseOrderItem::class); }
    public function product() { return $this->belongsTo(Product::class); }
}
