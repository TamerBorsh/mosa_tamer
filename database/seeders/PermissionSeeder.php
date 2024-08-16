<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'Admins', 'name_ar' => 'الموظفين', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Admins', 'name_ar' => 'عرض الموظفين', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Create-Admin', 'name_ar' => 'إضافة موظف', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Admin', 'name_ar' => 'تعديل بيانات موظف', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Admin', 'name_ar' => 'حذف موظف', 'guard_name' => 'admin']);
        //==============================
        Permission::create(['name' => 'Users', 'name_ar' => 'المستفيدين', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Users', 'name_ar' => 'عرض المستفيدين', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Create-User', 'name_ar' => 'إضافة مستفيد', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-User', 'name_ar' => 'تعديل بيانات مستفيد', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-User', 'name_ar' => 'حذف مستفيد', 'guard_name' => 'admin']);
        //==============================
        Permission::create(['name' => 'Copons', 'name_ar' => 'الترشيح', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Copons', 'name_ar' => 'عرض المرشحين', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Create-Copon', 'name_ar' => 'إضافة ترشيح', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Copon', 'name_ar' => 'حذف ترشيح', 'guard_name' => 'admin']);
        //==============================

    }
}
