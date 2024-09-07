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
    use Illuminate\Support\Facades\Hash;
    use Spatie\Permission\Models\Role;
    use Spatie\Permission\Models\Permission;
    use App\Models\Admin;

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
        $role = Role::firstOrCreate(
            ['name' => 'Admin', 'guard_name' => 'admin']
        );

        // إعطاء المستخدم دور محدد
        $admin->assignRole($role);

        // جلب جميع الصلاحيات
        $permissions = Permission::all();

        // التأكد من أن هناك صلاحيات متاحة
        if ($permissions->isNotEmpty()) {
            // إعطاء جميع الصلاحيات للدور
            $role->syncPermissions($permissions); // استخدام syncPermissions لضمان تحديث الصلاحيات بشكل صحيح
        }
    }
}
