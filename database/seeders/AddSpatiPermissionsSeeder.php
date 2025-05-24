<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class AddSpatiPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for modules without overwriting existing ones
        $this->createModulePermissions('user', ['view', 'create', 'update', 'delete']);
        $this->createModulePermissions('role', ['view', 'create', 'update', 'delete']);
        $this->createModulePermissions('course', ['view', 'create', 'update', 'delete', 'enroll']);
        $this->createModulePermissions('department', ['view', 'create', 'update', 'delete']);
        $this->createModulePermissions('faculty', ['view', 'create', 'update', 'delete']);
        $this->createModulePermissions('schedule', ['view', 'create', 'update', 'delete']);
        $this->createModulePermissions('financial', ['view', 'create', 'update', 'delete', 'process-payment']);
        $this->createModulePermissions('academic-calendar', ['view', 'create', 'update', 'delete']);
        $this->createModulePermissions('grade', ['view', 'create', 'update', 'delete']);
        $this->createModulePermissions('document', ['view', 'create', 'update', 'delete']);
        $this->createModulePermissions('system', ['view-logs', 'manage-settings']);

        // Map old roles to new standard roles
        $roleMapping = [
            'Admissions' => 'admin',
            'Professor' => 'professor',
            'TA' => 'professor',
            'Student' => 'student',
            'IT Support' => 'admin',
        ];

        // Create standard roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);
        $professorRole = Role::firstOrCreate(['name' => 'professor']);
        $departmentHeadRole = Role::firstOrCreate(['name' => 'department_head']);
        $financialOfficerRole = Role::firstOrCreate(['name' => 'financial_officer']);
        
        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());
        
        $studentRole->syncPermissions([
            'view user',
            'view course',
            'view department',
            'view faculty',
            'view schedule',
            'view financial',
            'view academic-calendar',
            'view grade',
            'view document',
            'create document',
        ]);
        
        $professorRole->syncPermissions([
            'view user',
            'view course',
            'view department',
            'view faculty',
            'view schedule',
            'view academic-calendar',
            'create grade',
            'update grade',
            'view grade',
        ]);
        
        $departmentHeadRole->syncPermissions([
            'view user',
            'view course',
            'view department',
            'update department',
            'view faculty',
            'view schedule',
            'create schedule',
            'update schedule',
            'view academic-calendar',
            'view grade',
        ]);
        
        $financialOfficerRole->syncPermissions([
            'view user',
            'view financial',
            'create financial',
            'update financial',
            'delete financial',
            'process-payment financial',
        ]);

        // Map existing users to new roles based on their old roles
        $users = User::all();
        foreach ($users as $user) {
            $userRoles = $user->getRoleNames()->toArray();
            
            // First, ensure the admin user has admin role
            if ($user->email === 'admin@example.com' || in_array('Admissions', $userRoles)) {
                $user->assignRole('admin');
                continue;
            }
            
            // Map other users based on their existing roles
            foreach ($userRoles as $oldRole) {
                if (isset($roleMapping[$oldRole]) && !$user->hasRole($roleMapping[$oldRole])) {
                    $user->assignRole($roleMapping[$oldRole]);
                }
            }
            
            // If user has no roles, give them student role by default
            if (count($user->getRoleNames()) === 0) {
                if ($user->student()->exists()) {
                    $user->assignRole('student');
                } else if ($user->professor()->exists()) {
                    $user->assignRole('professor');
                }
            }
        }
    }

    /**
     * Create permissions for a specific module
     *
     * @param string $module
     * @param array $actions
     */
    private function createModulePermissions(string $module, array $actions): void
    {
        foreach ($actions as $action) {
            $permissionName = "{$action} {$module}";
            Permission::firstOrCreate(['name' => $permissionName]);
        }
    }
}
