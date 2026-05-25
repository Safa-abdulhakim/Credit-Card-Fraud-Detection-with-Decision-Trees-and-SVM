<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_number','user_id','shipping_address_id','coupon_id','status',
        'subtotal','tax_amount','shipping_amount','discount_amount','total',
        'payment_method','payment_status','notes',
    ];
    protected $casts = [
        'subtotal'         => 'decimal:2',
        'tax_amount'       => 'decimal:2',
        'shipping_amount'  => 'decimal:2',
        'discount_amount'  => 'decimal:2',
        'total'            => 'decimal:2',
    ];

    const STATUS_PENDING    = 'pending';
    const STATUS_PAID       = 'paid';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED    = 'shipped';
    const STATUS_DELIVERED  = 'delivered';
    const STATUS_CANCELLED  = 'cancelled';
    const STATUS_REFUNDED   = 'refunded';

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function shippingAddress(): BelongsTo { return $this->belongsTo(ShippingAddress::class); }
    public function coupon(): BelongsTo { return $this->belongsTo(Coupon::class); }
    public function items(): HasMany { return $this->hasMany(OrderItem::class); }
    public function payment(): HasOne { return $this->hasOne(Payment::class); }
    public function shipment(): HasOne { return $this->hasOne(Shipment::class); }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_PAID]);
    }

    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'pending'    => ['class' => 'warning',   'label' => 'Pending'],
            'paid'       => ['class' => 'info',      'label' => 'Paid'],
            'processing' => ['class' => 'primary',   'label' => 'Processing'],
            'shipped'    => ['class' => 'secondary', 'label' => 'Shipped'],
            'delivered'  => ['class' => 'success',   'label' => 'Delivered'],
            'cancelled'  => ['class' => 'danger',    'label' => 'Cancelled'],
            'refunded'   => ['class' => 'dark',      'label' => 'Refunded'],
            default      => ['class' => 'secondary', 'label' => ucfirst($this->status)],
        };
    }
}
