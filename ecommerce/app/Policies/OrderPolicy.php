<?php
namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) return true;
        return null;
    }

    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Order $order): bool { return $user->id === $order->user_id || $user->isVendor(); }
    public function create(User $user): bool { return $user->isCustomer(); }
    public function cancel(User $user, Order $order): bool { return $user->id === $order->user_id && $order->canBeCancelled(); }
    public function update(User $user, Order $order): bool { return $user->isAdmin() || $user->isVendor(); }
    public function delete(User $user, Order $order): bool { return false; }
}
