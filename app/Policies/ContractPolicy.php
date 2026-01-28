<?php

namespace App\Policies;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ContractPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->isCommissioner()) {
            return true;
        }
        if (! $user->isAdministrator()) {
            return false;
        }   
        $adminFacultyId = $user->administrator->faculty_id;
        if (! $user->student || ! $user->student->contract) {
            return false;
        }
        return $user->student->contract->faculty_id === $adminFacultyId;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Contract $contract): bool
    {
        if ($user->isAdministrator()) {
            return $contract->faculty_id === $user->administrator->faculty_id;
        }
        if ($user->isCommissioner()) {
            return true;
        }
        if ($user->isStudent()) {
            return $contract->student_id === $user->student->id;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if(!$user->isAdministrator())
            return false;
        $adminFacultyId = $user->administrator->faculty_id;
        if ($adminFacultyId === $user->student->contract->faculty_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Contract $contract): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Contract $contract): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Contract $contract): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Contract $contract): bool
    {
        return false;
    }
}
