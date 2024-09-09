<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Statistics
            ['name' => 'Statistics', 'name_ar' => 'إحصائيات', 'guard_name' => 'admin'],

            // Admins
            ['name' => 'Admins', 'name_ar' => 'الموظفين', 'guard_name' => 'admin', 'children' => [
                ['name' => 'Read-Admins', 'name_ar' => 'عرض الموظفين'],
                ['name' => 'Create-Admin', 'name_ar' => 'إضافة موظف'],
                ['name' => 'Update-Admin', 'name_ar' => 'تعديل بيانات موظف'],
                ['name' => 'Delete-Admin', 'name_ar' => 'حذف موظف'],
            ]],

            // Roles
            ['name' => 'Roles', 'name_ar' => 'الأدوار', 'guard_name' => 'admin', 'children' => [
                ['name' => 'Read-Roles', 'name_ar' => 'عرض الأدوار'],
                ['name' => 'Create-Role', 'name_ar' => 'إضافة دور'],
                ['name' => 'Update-Role', 'name_ar' => 'تعديل بيانات دور'],
                ['name' => 'Delete-Role', 'name_ar' => 'حذف دور'],
            ]],

            // Institutions
            ['name' => 'Institutions', 'name_ar' => 'المؤسسات', 'guard_name' => 'admin', 'children' => [
                ['name' => 'Read-Institutions', 'name_ar' => 'عرض المؤسسات'],
                ['name' => 'Create-Institution', 'name_ar' => 'إضافة مؤسسة'],
                ['name' => 'Update-Institution', 'name_ar' => 'تعديل بيانات مؤسسة'],
                ['name' => 'Delete-Institution', 'name_ar' => 'حذف مؤسسة'],
            ]],

            // Coupons
            ['name' => 'Coupons', 'name_ar' => 'الأصناف', 'guard_name' => 'admin', 'children' => [
                ['name' => 'Read-Coupons', 'name_ar' => 'عرض التصنيفات'],
                ['name' => 'Create-Coupon', 'name_ar' => 'إضافة تصنيف'],
                ['name' => 'Update-Coupon', 'name_ar' => 'تعديل تصنيف'],
                ['name' => 'Delete-Coupon', 'name_ar' => 'حذف تصنيف'],
                ['name' => 'Coupon-Redemption', 'name_ar' => 'صرف الكابون'],
            ]],

            // Locations
            ['name' => 'Locations', 'name_ar' => 'البركسات', 'guard_name' => 'admin', 'children' => [
                ['name' => 'Read-Locations', 'name_ar' => 'عرض البركسات'],
                ['name' => 'Create-Location', 'name_ar' => 'إضافة بركس'],
                ['name' => 'Update-Location', 'name_ar' => 'تعديل بيانات بركس'],
                ['name' => 'Delete-Location', 'name_ar' => 'حذف بركس'],
            ]],

            // Mosques
            ['name' => 'Mosques', 'name_ar' => 'المعالم', 'guard_name' => 'admin', 'children' => [
                ['name' => 'Read-Mosques', 'name_ar' => 'عرض المعالم'],
                ['name' => 'Create-Mosque', 'name_ar' => 'إضافة معلم'],
                ['name' => 'Update-Mosque', 'name_ar' => 'تعديل بيانات معلم'],
                ['name' => 'Delete-Mosque', 'name_ar' => 'حذف معلم'],
            ]],

            // Users
            ['name' => 'Users', 'name_ar' => 'المستفيدين', 'guard_name' => 'admin', 'children' => [
                ['name' => 'Read-Users', 'name_ar' => 'عرض المستفيدين'],
                ['name' => 'Create-User', 'name_ar' => 'إضافة مستفيد'],
                ['name' => 'Update-User', 'name_ar' => 'تعديل بيانات مستفيد'],
                ['name' => 'Delete-User', 'name_ar' => 'حذف مستفيد'],
            ]],

            // Nominates
            ['name' => 'Nominates', 'name_ar' => 'قائمة الترشيح', 'guard_name' => 'admin', 'children' => [
                ['name' => 'Read-Nominates', 'name_ar' => 'عرض المرشحين'],
                ['name' => 'Create-Nominate', 'name_ar' => 'شاشة الترشيح'],
                ['name' => 'Update-Nominate', 'name_ar' => 'تحديث حالة الكابون'],
                ['name' => 'Delete-Nominate', 'name_ar' => 'حذف كابون'],
                ['name' => 'Redemption', 'name_ar' => 'صرف الكابون'],
            ]],

            // Logs
            ['name' => 'Logs', 'name_ar' => 'أخطاء النظام', 'guard_name' => 'admin'],
            
        ];

        $this->createPermissions($permissions);
    }

    /**
     * Create permissions from array.
     *
     * @param array $permissions
     * @param int|null $parentId
     */
    private function createPermissions(array $permissions, ?int $parentId = null): void
    {
        foreach ($permissions as $permission) {
            $existingPermission = Permission::firstOrCreate(
                [
                    'name' => $permission['name'],
                    'guard_name' => $permission['guard_name'] ?? 'admin',
                ],
                [
                    'name_ar' => $permission['name_ar'],
                    'parent_id' => $parentId,
                ]
            );

            if (isset($permission['children'])) {
                $this->createPermissions($permission['children'], $existingPermission->id);
            }
        }
    }
}
