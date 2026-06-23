<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Grn extends Model {
    protected $fillable = ['grn_number', 'purchase_order_id', 'user_id', 'received_date', 'status', 'notes'];
    protected $casts = ['received_date' => 'date'];
    public function purchaseOrder() { return $this->belongsTo(PurchaseOrder::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(GrnItem::class); }
}
