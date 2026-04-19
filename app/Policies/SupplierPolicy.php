<?php

namespace App\Policies;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SupplierPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view-any-suppliers');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Supplier $supplier): bool
    {
        return $user->hasPermission('view-suppliers');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create-suppliers');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Supplier $supplier): bool
    {
        return $user->hasPermission('update-suppliers');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Supplier $supplier): bool
    {
        return $user->hasPermission('delete-suppliers');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Supplier $supplier): bool
    {
        return $user->hasPermission('restore-suppliers');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Supplier $supplier): bool
    {
        return $user->hasPermission('force-delete-suppliers');
    }
}
