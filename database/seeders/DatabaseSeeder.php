<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call RoleSeeder first to create the roles
        $this->call(RoleSeeder::class);
        
        // Create default users with roles
        $this->call(UserSeeder::class);
        
        // Create admin user
        $this->call(AdminSeeder::class);

        // Create courses and assign users to them
        $this->call(CourseUserSeeder::class);

        $this->call([
            DepartmentSeeder::class,
        ]);
    }
}
