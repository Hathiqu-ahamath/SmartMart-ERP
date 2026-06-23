<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model {
    use SoftDeletes;
    protected $fillable = ['product_code', 'product_name', 'category_id', 'cost_price', 'selling_price', 'quantity', 'expiry_date', 'reorder_level', 'description', 'barcode', 'is_active'];
    protected $casts = ['cost_price' => 'decimal:2', 'selling_price' => 'decimal:2', 'quantity' => 'integer', 'reorder_level' => 'integer', 'expiry_date' => 'date', 'is_active' => 'boolean'];
    public function category() { return $this->belongsTo(Category::class); }
    public function stockMovements() { return $this->hasMany(StockMovement::class); }
    public function purchaseOrderItems() { return $this->hasMany(PurchaseOrderItem::class); }
    public function saleItems() { return $this->hasMany(SaleItem::class); }
    public function isLowStock() { return $this->quantity <= $this->reorder_level; }
    public function isExpiringSoon($days = 30) { return $this->expiry_date && $this->expiry_date->isFuture() && $this->expiry_date->diffInDays(now()) <= $days; }
    public function scopeActive($q) { return $q->where('is_active', true); }
    public function scopeLowStock($q) { return $q->whereColumn('quantity', '<=', 'reorder_level'); }
    public function scopeExpiringSoon($q, $days = 30) { return $q->whereNotNull('expiry_date')->where('expiry_date', '>=', now())->where('expiry_date', '<=', now()->addDays($days)); }
}
