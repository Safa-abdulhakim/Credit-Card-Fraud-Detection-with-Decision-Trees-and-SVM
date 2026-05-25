<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vendor_id','category_id','brand_id','name','slug','description',
        'short_description','sku','price','discount_price','quantity',
        'reserved_quantity','low_stock_threshold','status','is_featured',
        'thumbnail','meta_title','meta_description','tags','weight',
        'rating_avg','rating_count','sold_count',
    ];

    protected $casts = [
        'price'            => 'decimal:2',
        'discount_price'   => 'decimal:2',
        'rating_avg'       => 'decimal:2',
        'is_featured'      => 'boolean',
        'tags'             => 'array',
    ];

    public function vendor(): BelongsTo { return $this->belongsTo(Vendor::class); }
    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
    public function brand(): BelongsTo { return $this->belongsTo(Brand::class); }
    public function images(): HasMany { return $this->hasMany(ProductImage::class)->orderBy('sort_order'); }
    public function variants(): HasMany { return $this->hasMany(ProductVariant::class); }
    public function reviews(): HasMany { return $this->hasMany(Review::class); }
    public function inventoryLogs(): HasMany { return $this->hasMany(InventoryLog::class); }
    public function wishlists(): HasMany { return $this->hasMany(Wishlist::class); }
    public function orderItems(): HasMany { return $this->hasMany(OrderItem::class); }

    public function getEffectivePriceAttribute(): float
    {
        return $this->discount_price ?? $this->price;
    }

    public function isInStock(): bool
    {
        return $this->quantity > $this->reserved_quantity;
    }

    public function isLowStock(): bool
    {
        return ($this->quantity - $this->reserved_quantity) <= $this->low_stock_threshold;
    }

    public function getAvailableQuantityAttribute(): int
    {
        return max(0, $this->quantity - $this->reserved_quantity);
    }
}
