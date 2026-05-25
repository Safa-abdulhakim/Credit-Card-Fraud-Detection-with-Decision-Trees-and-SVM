<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    protected $fillable = [
        'user_id','store_name','slug','description','logo','banner',
        'phone','address','city','country','status',
        'commission_rate','total_earnings','pending_withdrawal',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function products(): HasMany { return $this->hasMany(Product::class); }
    public function orderItems(): HasMany { return $this->hasMany(OrderItem::class); }
    public function withdrawals(): HasMany { return $this->hasMany(VendorWithdrawal::class); }

    public function isApproved(): bool { return $this->status === 'approved'; }
}
