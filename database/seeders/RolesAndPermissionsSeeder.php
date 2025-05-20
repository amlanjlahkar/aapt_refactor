<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder {
    public function run() {
        // Clear permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions if they don't exist
        $view = Permission::firstOrCreate(['name' => 'view', 'guard_name' => 'department']);
        $edit = Permission::firstOrCreate(['name' => 'edit', 'guard_name' => 'department']);
        $delete = Permission::firstOrCreate(['name' => 'delete', 'guard_name' => 'department']);

        // Create roles if they don't exist
        $role1 = Role::firstOrCreate(['name' => 'role1', 'guard_name' => 'department']);
        $role2 = Role::firstOrCreate(['name' => 'role2', 'guard_name' => 'department']);

        // Assign permissions to roles
        $role1->syncPermissions([$view, $edit, $delete]); // sync avoids duplicates
        $role2->syncPermissions([$view]);
    }
}
