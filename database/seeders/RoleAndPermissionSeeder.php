<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder {
    public function run() {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $dept_view = Permission::firstOrCreate(['name' => 'view_dept_user', 'guard_name' => 'dept_user']);
        $dept_edit = Permission::firstOrCreate(['name' => 'edit_dept_user', 'guard_name' => 'dept_user']);
        $dept_remove = Permission::firstOrCreate(['name' => 'remove_dept_user', 'guard_name' => 'dept_user']);

        // Create roles
        $role1 = Role::firstOrCreate(['name' => 'Role1', 'guard_name' => 'dept_user']);
        $role2 = Role::firstOrCreate(['name' => 'Role2', 'guard_name' => 'dept_user']);

        // Assign permissions to roles
        $role1->syncPermissions([$dept_view, $dept_edit, $dept_remove]);
        $role2->syncPermissions([$dept_view]);
    }
}
