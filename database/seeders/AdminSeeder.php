<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء المستخدم
        $admin = Admin::create([
            'name'      => 'Tamer Alborsh',
            'username'  => 'tamer',
            'phone'     => '0567762233',
            'password'  => 'tamer@0599', // تأكد من استخدام bcrypt لتشفير كلمة المرور
        ]);

        // البحث عن الدور أو إنشاؤه إذا لم يكن موجوداً
        $role = Role::where('name', 'Admin')->where('guard_name', 'admin')->first();

        if (!$role) {
            $role = Role::create(['name' => 'Admin', 'guard_name' => 'admin']);
        }

        // إعطاء المستخدم دور محدد
        $admin->assignRole($role);

        // إعطاء جميع الصلاحيات للدور
        $permissions = Permission::all(); // جلب جميع الصلاحيات
        $role->givePermissionTo($permissions);
    }
}
