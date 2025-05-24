<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Academic Calendar Permissions
        Permission::firstOrCreate(['name' => 'view academic-calendar', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'create academic-calendar', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'update academic-calendar', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'delete academic-calendar', 'guard_name' => 'web']);

        // Financial Permissions
        Permission::firstOrCreate(['name' => 'view financial', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'create financial', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'update financial', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'delete financial', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'process-payment financial', 'guard_name' => 'web']);
    }
}
