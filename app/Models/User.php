<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable {
    use HasApiTokens, Notifiable;
    protected $fillable = ['name', 'email', 'password', 'phone', 'address', 'employee_code', 'role_id', 'is_active', 'profile_picture'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'is_active' => 'boolean', 'password' => 'hashed'];
    public function role() { return $this->belongsTo(Role::class); }
    public function hasPermission($permissionSlug) { return $this->role && $this->role->hasPermission($permissionSlug); }
    public function hasRole($roleSlug) { return $this->role && $this->role->slug === $roleSlug; }
    public function isAdmin() { return $this->hasRole('admin'); }
    public function purchaseOrders() { return $this->hasMany(PurchaseOrder::class); }
    public function grns() { return $this->hasMany(Grn::class); }
    public function sales() { return $this->hasMany(Sale::class); }
}
