<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                $departments = [
            ['name' => 'CSE', 'code' => 'CSE'],
            ['name' => 'EEE', 'code' => 'EEE'],
            ['name' => 'BME', 'code' => 'BME'],
            ['name' => 'MSE', 'code' => 'MSE'],
            ['name' => 'ME',  'code' => 'ME'],
            ['name' => 'CE',  'code' => 'CE'],
            ['name' => 'MIE', 'code' => 'MIE'],
            ['name' => 'PME', 'code' => 'PME'],
            ['name' => 'URP', 'code' => 'URP'],
            ['name' => 'WRE', 'code' => 'WRE'],
            ['name' => 'Arch','code' => 'Arch'],
        ];

        DB::table('departments')->insert($departments);
    }
}
