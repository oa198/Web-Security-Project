<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $roles = [
            'Admissions',
            'Professor', // DRs
            'TA',        // Teaching Assistants
            'Student',
            'IT Support'
        ];

        foreach ($roles as $role) {
            // Only create the role if it doesn't already exist
            if (!Role::where('name', $role)->exists()) {
                Role::create(['name' => $role]);
            }
        }

        // You can add permissions and assign to roles here if needed
    }
}
