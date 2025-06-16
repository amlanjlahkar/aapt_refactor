<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JudgeMaster;

class JudgeMasterSeeder extends Seeder
{
    public function run(): void
    {
        $judges = [
            [
                'judge_name' => 'Justice A. Sharma',
                'desg_id' => 1,
                'judge_code' => 1001,
                'display' => true,
                'from_date' => '2023-01-01',
                'to_date' => null,
                'priority' => '1',
                'judge_short_name' => 'J.A. Sharma',
            ],
            [
                'judge_name' => 'Justice B. Das',
                'desg_id' => 2,
                'judge_code' => 1002,
                'display' => true,
                'from_date' => '2022-06-15',
                'to_date' => null,
                'priority' => '2',
                'judge_short_name' => 'J.B. Das',
            ],
            [
                'judge_name' => 'Justice C. Ahmed',
                'desg_id' => 3,
                'judge_code' => 1003,
                'display' => false,
                'from_date' => '2021-03-10',
                'to_date' => '2024-05-31',
                'priority' => '3',
                'judge_short_name' => 'J.C. Ahmed',
            ],
        ];

        foreach ($judges as $judge) {
            JudgeMaster::create($judge);
        }
    }
}
