<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingAddress extends Model
{
    protected $fillable = [
        'user_id','first_name','last_name','phone','address_line1',
        'address_line2','city','state','country','postal_code','is_default',
    ];
    protected $casts = ['is_default' => 'boolean'];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFormattedAddressAttribute(): string
    {
        return "{$this->address_line1}, {$this->city}, {$this->country}";
    }
}
