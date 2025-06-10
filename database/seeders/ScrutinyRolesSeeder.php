<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ScrutinyRolesSeeder extends Seeder
{
    public function run()
    {
        Role::firstOrCreate(['name' => 'registry-reviewer', 'guard_name' => 'admin']);
        Role::firstOrCreate(['name' => 'section-officer', 'guard_name' => 'admin']);
        Role::firstOrCreate(['name' => 'department-head', 'guard_name' => 'admin']);
    }
}

