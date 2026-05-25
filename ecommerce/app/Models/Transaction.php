<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = ['payment_id','type','amount','status','response_data'];
    protected $casts = ['amount' => 'decimal:2', 'response_data' => 'array'];
    public function payment(): BelongsTo { return $this->belongsTo(Payment::class); }
}
