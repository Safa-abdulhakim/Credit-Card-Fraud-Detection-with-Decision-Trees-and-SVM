<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = [
        'code','type','value','minimum_amount','usage_limit',
        'usage_count','starts_at','expires_at','is_active',
    ];
    protected $casts = [
        'value'          => 'decimal:2',
        'minimum_amount' => 'decimal:2',
        'starts_at'      => 'datetime',
        'expires_at'     => 'datetime',
        'is_active'      => 'boolean',
    ];

    public function usages(): HasMany { return $this->hasMany(CouponUsage::class); }

    public function isValid(): bool
    {
        if (!$this->is_active) return false;
        if ($this->starts_at && now()->lt($this->starts_at)) return false;
        if ($this->expires_at && now()->gt($this->expires_at)) return false;
        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) return false;
        return true;
    }

    public function calculateDiscount(float $amount): float
    {
        if ($this->type === 'percentage') {
            return round($amount * ($this->value / 100), 2);
        }
        return min($this->value, $amount);
    }
}
