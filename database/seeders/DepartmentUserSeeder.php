<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Internal\DepartmentUser;
use Illuminate\Support\Facades\Hash;

class DepartmentUserSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['name' => 'Alice', 'email' => 'alice@finance.gov', 'department' => 'Finance', 'role' => 'role1'],
            ['name' => 'Bob', 'email' => 'bob@hr.gov', 'department' => 'HR', 'role' => 'role2'],
            ['name' => 'Charlie', 'email' => 'charlie@it.gov', 'department' => 'IT', 'role' => 'role1'],
        ];

        foreach ($departments as $deptUserData) {
            $user = DepartmentUser::firstOrCreate(
                ['email' => $deptUserData['email']],
                [
                    'name' => $deptUserData['name'],
                    'department' => $deptUserData['department'],
                    'password' => Hash::make('password'),
                ]
            );

            $user->assignRole($deptUserData['role']);
        }
    }
}
