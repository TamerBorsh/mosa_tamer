<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): Response
    {
        return $admin->hasPermissionTo('Read-Roles') ? Response::allow() : Response::deny('You do not have permission to roles.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): Response
    {
        return $admin->hasPermissionTo('Create-Role') ? Response::allow() : Response::deny('You do not have permission to roles.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin): Response
    {
        return $admin->hasPermissionTo('Update-Role') ? Response::allow() : Response::deny('You do not have permission to roles.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin): Response
    {
        return $admin->hasPermissionTo('Delete-Role') ? Response::allow() : Response::deny('You do not have permission to roles.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin): bool
    {
        //
    }
}
