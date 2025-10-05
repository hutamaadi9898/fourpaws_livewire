<?php

namespace App\Policies;

use App\Models\Memorial;
use App\Models\User;

class MemorialPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Memorial $memorial): bool
    {
        // Public memorials can be viewed by anyone
        if ($memorial->visibility === 'public' && $memorial->status === 'published') {
            return true;
        }

        // Owner can always view their memorial
        return $user && $user->id === $memorial->owner_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Memorial $memorial): bool
    {
        return $user->id === $memorial->owner_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Memorial $memorial): bool
    {
        return $user->id === $memorial->owner_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Memorial $memorial): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Memorial $memorial): bool
    {
        return false;
    }
}
