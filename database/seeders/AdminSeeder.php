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
        // Admin::create([
        //     'name'      => 'Tamer Alborsh',
        //     'username'  =>'tamer',
        //     'phone'     =>'0567762233',
        //     'password'  =>'password'
        // ]);
        // $user = Admin::first();
        // $user->assignRole(Role::findById(1, 'admin'));
        $user = Admin::create([
            'name'      => 'Tamer Alborsh',
            'username'  => 'tamer',
            'phone'     => '0567762233',
            'password'  => "tamer@0599", // تأكد من استخدام bcrypt لتشفير كلمة المرور
        ]);
        $role = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'admin']);

        // إعطاء المستخدم دور محدد (بإمكانك تخصيصه إذا أردت)
        $user->assignRole($role);
    
        // إعطاء جميع الصلاحيات للمستخدم
        $permissions = Permission::all(); // جلب جميع الصلاحيات
        $role->givePermissionTo($permissions);
    }
}
