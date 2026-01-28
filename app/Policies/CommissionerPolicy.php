<?php

namespace App\Policies;

use App\Models\Commissioner;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommissionerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Commissioner $commissioner): bool
    {
        return $user->isCommissioner() && $user->commissioner->id === $commissioner->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Commissioner $commissioner): bool
    {
        return $user->isCommissioner() && $user->commissioner->id === $commissioner->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Commissioner $commissioner): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Commissioner $commissioner): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Commissioner $commissioner): bool
    {
        return false;
    }
}
