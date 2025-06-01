<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Spatie\Permission\Models\Role;

class ScrutinyUserSeeder extends Seeder
{
    public function run()
    {
        // 1. Ensure the role exists for 'admin' guard
        $role = Role::firstOrCreate(
            ['name' => 'scrutiny-admin', 'guard_name' => 'admin']
        );

        // 2. Either fetch or create the admin user
        $admin = Admin::where('email', 'scrutiny@example.com')->first();

        if (!$admin) {
            $admin = Admin::create([
                'name' => 'Scrutiny Admin',
                'email' => 'scrutiny@example.com',
                'password' => bcrypt('password'), // secure this in production
                'status' => 1,
            ]);
        }

        // 3. Assign the role if not already assigned
        if (!$admin->hasRole('scrutiny-admin')) {
            $admin->assignRole($role);
        }
    }
}
