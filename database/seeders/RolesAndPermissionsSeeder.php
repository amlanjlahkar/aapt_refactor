<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Clear permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions if they don't exist
        $view   = Permission::firstOrCreate(['name' => 'view']);
        $edit   = Permission::firstOrCreate(['name' => 'edit']);
        $delete = Permission::firstOrCreate(['name' => 'delete']);

        // Create roles if they don't exist
        $role1 = Role::firstOrCreate(['name' => 'role1']);
        $role2 = Role::firstOrCreate(['name' => 'role2']);

        // Assign permissions to roles
        $role1->syncPermissions([$view, $edit, $delete]); // sync avoids duplicates
        $role2->syncPermissions([$view]);
    }
}
