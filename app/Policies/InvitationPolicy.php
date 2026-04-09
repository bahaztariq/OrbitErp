<?php

namespace App\Policies;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InvitationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view-any invitations');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Invitation $invitation): bool
    {
        return $user->hasPermission('view invitations');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create invitations');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Invitation $invitation): bool
    {
        return $user->hasPermission('update invitations');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Invitation $invitation): bool
    {
        return $user->hasPermission('delete invitations');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Invitation $invitation): bool
    {
        return $user->hasPermission('restore invitations');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Invitation $invitation): bool
    {
        return $user->hasPermission('force-delete invitations');
    }
}
