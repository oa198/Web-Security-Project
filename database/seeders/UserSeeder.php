<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default users for each role
        $users = [
            [
                'name' => 'Admissions Officer',
                'email' => 'admissions@example.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => Carbon::now(),
                'role' => 'Admissions'
            ],
            [
                'name' => 'Dr. Smith',
                'email' => 'professor@example.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => Carbon::now(),
                'role' => 'Professor'
            ],
            [
                'name' => 'Teaching Assistant',
                'email' => 'ta@example.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => Carbon::now(),
                'role' => 'TA'
            ],
            [
                'name' => 'John Student',
                'email' => 'student@example.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => Carbon::now(),
                'role' => 'Student'
            ],
            [
                'name' => 'IT Support Staff',
                'email' => 'itsupport@example.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => Carbon::now(),
                'role' => 'IT Support'
            ],
        ];

        foreach ($users as $userData) {
            $role = $userData['role'];
            unset($userData['role']);
            
            // Check if user already exists
            if (!User::where('email', $userData['email'])->exists()) {
                $user = User::create($userData);
                
                // Assign role to user
                $roleModel = Role::where('name', $role)->first();
                if ($roleModel) {
                    $user->assignRole($roleModel);
                }
            } else {
                // Update existing user to be verified
                User::where('email', $userData['email'])->update([
                    'email_verified_at' => Carbon::now()
                ]);
            }
        }
    }
}
