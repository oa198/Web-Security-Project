<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for modules
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

        // Create roles and assign permissions
        
        // Admin role with all permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
        
        // Student role
        $studentRole = Role::create(['name' => 'student']);
        $studentRole->givePermissionTo([
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
        
        // Professor role
        $professorRole = Role::create(['name' => 'professor']);
        $professorRole->givePermissionTo([
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
        
        // Department head role
        $departmentHeadRole = Role::create(['name' => 'department_head']);
        $departmentHeadRole->givePermissionTo([
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
        
        // Financial officer role
        $financialOfficerRole = Role::create(['name' => 'financial_officer']);
        $financialOfficerRole->givePermissionTo([
            'view user',
            'view financial',
            'create financial',
            'update financial',
            'delete financial',
            'process-payment financial',
        ]);
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
            Permission::create(['name' => "{$action} {$module}"]);
        }
    }
}
