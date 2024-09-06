<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Location;
use Illuminate\Auth\Access\Response;

class LocationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): Response
    {
        return $admin->hasPermissionTo('Read-Locations') ? Response::allow() : Response::deny('You do not have permission.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Location $location): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): Response
    {
        return $admin->hasPermissionTo('Create-Location') ? Response::allow() : Response::deny('You do not have permission.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin): Response
    {
        return $admin->hasPermissionTo('Update-Location') ? Response::allow() : Response::deny('You do not have permission.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin): Response
    {
        return $admin->hasPermissionTo('Delete-Location') ? Response::allow() : Response::deny('You do not have permission.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Location $location): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Location $location): bool
    {
        //
    }
}
