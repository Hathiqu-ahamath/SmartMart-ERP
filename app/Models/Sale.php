<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Sale extends Model {
    protected $fillable = ['invoice_number', 'user_id', 'customer_name', 'customer_email', 'customer_phone', 'subtotal', 'tax_percentage', 'tax_amount', 'discount_percentage', 'discount_amount', 'grand_total', 'payment_method', 'notes'];
    protected $casts = ['subtotal' => 'decimal:2', 'tax_percentage' => 'decimal:2', 'tax_amount' => 'decimal:2', 'discount_percentage' => 'decimal:2', 'discount_amount' => 'decimal:2', 'grand_total' => 'decimal:2'];
    public function user() { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(SaleItem::class); }
    public function scopeToday($q) { return $q->whereDate('created_at', today()); }
    public function scopeThisMonth($q) { return $q->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year); }
}
