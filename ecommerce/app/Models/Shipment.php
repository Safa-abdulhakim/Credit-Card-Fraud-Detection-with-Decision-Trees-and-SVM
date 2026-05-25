<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    protected $fillable = [
        'order_id','shipping_method_id','delivery_agent_id',
        'tracking_number','status','shipped_at','delivered_at',
    ];
    protected $casts = ['shipped_at' => 'datetime', 'delivered_at' => 'datetime'];

    public function order(): BelongsTo { return $this->belongsTo(Order::class); }
    public function shippingMethod(): BelongsTo { return $this->belongsTo(ShippingMethod::class); }
    public function deliveryAgent(): BelongsTo { return $this->belongsTo(DeliveryAgent::class); }
}
