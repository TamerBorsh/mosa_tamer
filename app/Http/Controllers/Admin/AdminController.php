<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Policies\AdminPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(AdminDataTable $datatable)
    {
        $this->authorize('viewAny', Admin::class);
        $roles = Role::whereGuard_name('admin')->get(['id', 'name']);
        return $datatable->render('dash.admins.index', ['roles' => $roles]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = Role::findById($request->input('role_id'), 'admin');

        $isSave = Admin::create($request->only(['name', 'phone', 'password', 'username']));

        if ($isSave) {
            $isSave->assignRole($role);
            return response()->json(['message' => $isSave ? 'تم الحفظ' : 'هناك خطأ ما'], $isSave ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return Admin::with('roles')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // التحقق من القيم المرسلة
        $request->validate([
            'id' => 'required|exists:admins,id',
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6',
            'username' => 'required|string|max:255|unique:admins,username,' . $request->id,
            'role_id' => 'required|exists:roles,id',
        ]);


        $admin = Admin::findOrFail($request->id);
        $role = Role::findById($request->input('role_id'), 'admin');

        $isUpdate = $admin->update($request->only(['name', 'phone', 'username']));

        if ($isUpdate) {
            $admin->syncRoles($role);
        }
        return response()->json(['message' => $isUpdate ? 'تم الحفظ' : 'هناك خطأ ما'], $isUpdate ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $isDelete = $admin->delete();
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
