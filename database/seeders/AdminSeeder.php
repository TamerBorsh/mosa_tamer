<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name'      => 'Tamer Alborsh',
            'username'  =>'tamer',
            'phone'     =>'0567762233',
            'password'  =>'password'
        ]);
        $user = Admin::first();
        $user->assignRole(Role::findById(1, 'admin'));
    }
}
