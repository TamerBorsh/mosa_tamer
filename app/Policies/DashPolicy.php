<?php

namespace App\Policies;

use App\Helpers\AppHelpers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DashPolicy
{

    public function viewAny($userId): Response
    {
        return Auth::guard(AppHelpers::guardName())->check() && Auth::guard(AppHelpers::guardName())->user()->hasPermissionTo('Read-Admins') ? Response::allow() : Response::deny('You do not have permission to view admins.');
    }
}
