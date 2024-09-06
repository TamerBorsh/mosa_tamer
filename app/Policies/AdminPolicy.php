<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): Response
    {
        // return true;
        return $admin->hasPermissionTo('Read-Admins') ? Response::allow() : Response::deny('You do not have permission to view admins.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin) {

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): Response
    {
        return $admin->hasPermissionTo('Create-Admin') ? Response::allow() : Response::deny('You do not have permission to view admins.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin): Response
    {
        return $admin->hasPermissionTo('Update-Admin') ? Response::allow() : Response::deny('You do not have permission to view admins.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin): Response
    {
        return $admin->hasPermissionTo('Delete-Admin') ? Response::allow() : Response::deny('You do not have permission to view admins.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin): Response
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin): Response
    {
        //
    }
}
