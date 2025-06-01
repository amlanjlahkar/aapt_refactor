<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ScrutinyRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create scrutiny permissions
        $permissions = [
            'view scrutiny',
            'edit scrutiny',
            'approve scrutiny',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create scrutiny-admin role
        $role = Role::firstOrCreate(['name' => 'scrutiny-admin']);

        // Assign permissions to the role
        $role->syncPermissions($permissions);
    }
}
