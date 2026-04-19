<?php

namespace App\Policies;

use App\Models\CalenderEvent;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CalenderEventPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view-any calender-events');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CalenderEvent $calenderEvent): bool
    {
        return $user->hasPermission('view calender-events');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create calender-events');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CalenderEvent $calenderEvent): bool
    {
        return $user->hasPermission('update calender-events');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CalenderEvent $calenderEvent): bool
    {
        return $user->hasPermission('delete calender-events');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CalenderEvent $calenderEvent): bool
    {
        return $user->hasPermission('restore calender-events');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CalenderEvent $calenderEvent): bool
    {
        return $user->hasPermission('force-delete calender-events');
    }
}
