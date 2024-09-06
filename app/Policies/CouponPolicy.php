<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Coupon;
use Illuminate\Auth\Access\Response;

class CouponPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): Response
    {
        return $admin->hasPermissionTo('Read-Coupons') ? Response::allow() : Response::deny('You do not have permission to Coupons.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Coupon $coupon): Response
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): Response
    {
        return $admin->hasPermissionTo('Create-Coupon') ? Response::allow() : Response::deny('You do not have permission to Coupons.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin): Response
    {
        return $admin->hasPermissionTo('Update-Coupon') ? Response::allow() : Response::deny('You do not have permission to Coupons.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin): Response
    {
        return $admin->hasPermissionTo('Delete-Coupon') ? Response::allow() : Response::deny('You do not have permission to Coupons.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Coupon $coupon): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Coupon $coupon): bool
    {
        //
    }
}
