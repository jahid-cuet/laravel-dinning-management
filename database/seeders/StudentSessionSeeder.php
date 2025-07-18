<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                $sessions = [
            ['hsc_session' => '2018', 'name' => '2018-19'],
            ['hsc_session' => '2019', 'name' => '2019-20'],
            ['hsc_session' => '2020', 'name' => '2020-21'],
            ['hsc_session' => '2021', 'name' => '2021-22'],
            ['hsc_session' => '2022', 'name' => '2022-23'],
            ['hsc_session' => '2023', 'name' => '2023-24'],
        ];

        DB::table('student_sessions')->insert($sessions);
    }
}
