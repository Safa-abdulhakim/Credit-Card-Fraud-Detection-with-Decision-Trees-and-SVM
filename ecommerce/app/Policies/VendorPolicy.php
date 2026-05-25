<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Auth\Access\HandlesAuthorization;

class VendorPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) return true;
        return null;
    }

    public function view(User $user, Vendor $vendor): bool { return $user->vendor?->id === $vendor->id; }
    public function update(User $user, Vendor $vendor): bool { return $user->vendor?->id === $vendor->id; }
    public function delete(User $user, Vendor $vendor): bool { return false; }
}
