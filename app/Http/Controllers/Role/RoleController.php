<?php

namespace App\Http\Controllers\Role;

use App\DataTables\RoleDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RoleDataTable $datatable)
    {
        return $datatable->render('dash.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $isSave = Role::create($request->all());
        if ($isSave)
            return response()->json(['message' => $isSave ? 'تم الحفظ' : 'هناك خطأ ما'], $isSave ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $permissions = Permission::whereGuard_name('admin')->whereNull('parent_id')->get();
        $role = $role::whereId($role->id)->with('permissions')->first();
// return $permissions;
        return response()->view('dash.roles.role-permissions', ['role' => $role, 'permissions' => $permissions]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return $role;
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateData(Request $request)
    {
        $role = Role::find($request->id);
        $isSave = $role->update($request->all());
        if ($isSave)
            return response()->json(['message' => $isSave ? 'تم الحفظ' : 'هناك خطأ ما'], $isSave ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $isDelete = $role->delete();
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
