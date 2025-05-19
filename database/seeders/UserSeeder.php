<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    public function run() {
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'], // Avoid duplicates
            [
                'first_name' => 'Test',
                'middle_name' => 'Example',
                'last_name' => 'User',
                'password' => Hash::make('password'),
                'secure_pin' => '1234',
                'question' => 1,
                'answer' => 'sample',
                'create_date' => now(),
                'usertype' => 1,
                'schema_id' => 1,
            ]
        );

        $user->assignRole('role1');
    }
}
