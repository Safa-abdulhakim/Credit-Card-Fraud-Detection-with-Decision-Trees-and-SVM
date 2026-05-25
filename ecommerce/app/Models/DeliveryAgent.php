<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryAgent extends Model
{
    protected $fillable = ['user_id','vehicle_type','license_plate','status'];
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function shipments(): HasMany { return $this->hasMany(Shipment::class); }
}
