<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RolePermissionController extends Controller
{
    public function update(Request $request, Role $role)
    {
        $permission = Permission::findOrFail($request->input('permission_id'));

        $permissions = $permission->parent_id === null && $permission->childrens->isNotEmpty()
            ? $permission->childrens
            : collect([$permission]);

        $action = $role->hasPermissionTo($permission) ? 'revokePermissionTo' : 'givePermissionTo';

        $permissions->each(function ($perm) use ($role, $action) {
            $role->$action($perm);
        });

        $message = $action === 'givePermissionTo' ? 'تم ربط الصلاحية' : 'تم ازالة الصلاحية';

        return response()->json(['message' => $message], Response::HTTP_OK);
    }
}
