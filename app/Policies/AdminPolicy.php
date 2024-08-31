<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class AdminPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): Response
    {
        // return true;
        return Auth::guard('admin')->check() && Auth::guard('admin')->user()->hasPermissionTo('Read-Admins') ? Response::allow() : Response::deny('You do not have permission to view admins.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin): Response
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin): Response
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin): Response
    {
        //
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
