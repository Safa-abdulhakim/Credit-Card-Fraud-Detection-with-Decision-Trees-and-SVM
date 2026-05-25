<?php
namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'phone',
        'avatar', 'is_active', 'last_login_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'     => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    public function role(): BelongsTo { return $this->belongsTo(Role::class); }
    public function vendor(): HasOne { return $this->hasOne(Vendor::class); }
    public function deliveryAgent(): HasOne { return $this->hasOne(DeliveryAgent::class); }
    public function orders(): HasMany { return $this->hasMany(Order::class); }
    public function reviews(): HasMany { return $this->hasMany(Review::class); }
    public function wishlists(): HasMany { return $this->hasMany(Wishlist::class); }
    public function shippingAddresses(): HasMany { return $this->hasMany(ShippingAddress::class); }
    public function cart(): HasOne { return $this->hasOne(Cart::class); }
    public function activityLogs(): HasMany { return $this->hasMany(ActivityLog::class); }

    public function hasRole(string $role): bool { return $this->role?->name === $role; }
    public function isAdmin(): bool { return $this->hasRole('admin'); }
    public function isVendor(): bool { return $this->hasRole('vendor'); }
    public function isCustomer(): bool { return $this->hasRole('customer'); }
    public function isDeliveryAgent(): bool { return $this->hasRole('delivery'); }
}
