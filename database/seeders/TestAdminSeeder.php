<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TestAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create super admin role if it doesn't exist
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin'], [
            'name' => 'super_admin',
            'guard_name' => 'web'
        ]);

        // Assign all permissions to super admin role
        $allPermissions = Permission::all();
        $superAdminRole->permissions()->sync($allPermissions->pluck('id')->toArray());

        // Create test admin user
        $user = User::firstOrCreate(
            ['email' => 'testadmin@example.com'],
            [
                'name' => 'Test Admin',
                'email' => 'testadmin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
            ]
        );

        // Assign super admin role to user
        $user->roles()->sync([$superAdminRole->id]);

        $this->command->info('Test admin user created:');
        $this->command->info('Email: testadmin@example.com');
        $this->command->info('Password: password123');
    }
}
