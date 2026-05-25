<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorWithdrawal extends Model
{
    protected $fillable = [
        'vendor_id','amount','payment_method','payment_details',
        'status','notes','processed_at',
    ];
    protected $casts = [
        'amount'          => 'decimal:2',
        'payment_details' => 'array',
        'processed_at'    => 'datetime',
    ];
    public function vendor(): BelongsTo { return $this->belongsTo(Vendor::class); }
}
