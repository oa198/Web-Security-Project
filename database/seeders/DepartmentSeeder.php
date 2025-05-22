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
            [
                'name' => 'Computer Science',
                'code' => 'CS',
                'description' => 'Department of Computer Science and Engineering',
                'head_of_department' => 'Dr. John Smith',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Electrical Engineering',
                'code' => 'EE',
                'description' => 'Department of Electrical Engineering',
                'head_of_department' => 'Dr. Sarah Johnson',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mechanical Engineering',
                'code' => 'ME',
                'description' => 'Department of Mechanical Engineering',
                'head_of_department' => 'Dr. Michael Brown',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Civil Engineering',
                'code' => 'CE',
                'description' => 'Department of Civil Engineering',
                'head_of_department' => 'Dr. Emily Davis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Business Administration',
                'code' => 'BA',
                'description' => 'Department of Business Administration',
                'head_of_department' => 'Dr. Robert Wilson',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('departments')->insert($departments);
    }
}
