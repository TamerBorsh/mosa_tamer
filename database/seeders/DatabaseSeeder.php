<?php

namespace Database\Seeders;

use AdminSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            AdminSeeder::class,
            StateSeeder::class,
            RegionSeeder::class,
        ]);
    }
}
