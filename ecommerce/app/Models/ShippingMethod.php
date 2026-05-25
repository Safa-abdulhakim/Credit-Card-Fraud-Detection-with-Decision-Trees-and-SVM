<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingMethod extends Model
{
    protected $fillable = ['name','carrier','base_cost','estimated_days','is_active'];
    protected $casts = ['base_cost' => 'decimal:2', 'is_active' => 'boolean'];
    public function shipments(): HasMany { return $this->hasMany(Shipment::class); }
}
