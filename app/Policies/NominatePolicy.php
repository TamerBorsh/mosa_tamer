<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Nominate;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NominatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): Response
    {
        return $admin->hasPermissionTo('Read-Nominates') ? Response::allow() : Response::deny('You do not have permission.');
    }

    /**
     * Determine whether the user can view the model.
     */


    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): Response
    {
        return $admin->hasPermissionTo('Create-Nominate') ? Response::allow() : Response::deny('You do not have permission.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin): Response
    {
        return $admin->hasPermissionTo('Update-Nominate') ? Response::allow() : Response::deny('You do not have permission.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin): Response
    {
        return $admin->hasPermissionTo('Delete-Nominate') ? Response::allow() : Response::deny('You do not have permission.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Nominate $nominate): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Nominate $nominate): bool
    {
        //
    }
}
