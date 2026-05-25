<?php
namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) return true;
        return null;
    }

    public function create(User $user): bool { return $user->isCustomer(); }
    public function update(User $user, Review $review): bool { return $user->id === $review->user_id; }
    public function delete(User $user, Review $review): bool { return $user->id === $review->user_id; }
}
