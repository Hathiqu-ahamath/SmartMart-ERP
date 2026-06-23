<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PurchaseOrder extends Model {
    protected $fillable = ['po_number', 'supplier_id', 'user_id', 'order_date', 'expected_date', 'total_amount', 'status', 'notes'];
    protected $casts = ['order_date' => 'date', 'expected_date' => 'date', 'total_amount' => 'decimal:2'];
    public function supplier() { return $this->belongsTo(Supplier::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(PurchaseOrderItem::class); }
    public function grns() { return $this->hasMany(Grn::class); }
    public function scopePending($q) { return $q->where('status', 'pending'); }
    public function scopeApproved($q) { return $q->where('status', 'approved'); }
    public function canApprove() { return $this->status === 'pending'; }
    public function canReceive() { return $this->status === 'approved'; }
}
