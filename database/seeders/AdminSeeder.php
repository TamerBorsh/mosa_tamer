<?php

use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create the admin user
        $admin = Admin::create([
            'name'      => 'Tamer Alborsh',
            'username'  => 'tamer',
            'phone'     => '0567762233',
            'password'  => 'tamer@0599',
        ]);

        // Find or create the 'Admin' role
        $role = Role::firstOrCreate(
            ['name' => 'Admin', 'guard_name' => 'admin']
        );

        // Assign the role to the admin user
        $admin->assignRole($role);

        // Get all permissions
        $permissions = Permission::all();

        // Give all permissions to the role if permissions exist
        if ($permissions->isNotEmpty()) {
            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }
    }
}
