<?php
namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) return true;
        return null;
    }

    public function viewAny(User $user): bool { return true; }
    public function view(?User $user, Product $product): bool { return $product->status === 'active' || ($user && ($user->isAdmin() || $user->vendor?->id === $product->vendor_id)); }
    public function create(User $user): bool { return $user->isVendor() && $user->vendor?->isApproved(); }
    public function update(User $user, Product $product): bool { return $user->vendor?->id === $product->vendor_id; }
    public function delete(User $user, Product $product): bool { return $user->vendor?->id === $product->vendor_id; }
    public function restore(User $user, Product $product): bool { return $user->vendor?->id === $product->vendor_id; }
    public function forceDelete(User $user, Product $product): bool { return false; }
}
