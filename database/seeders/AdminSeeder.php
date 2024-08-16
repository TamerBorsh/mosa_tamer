<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        ],[
            'name'      => 'رياض البيطار',
            'username'  =>'reiad',
            'phone'     =>'111',
            'password'  =>'password'
        ]);
    }
}
