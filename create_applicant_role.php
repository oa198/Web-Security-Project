<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;

// Check if the 'applicant' role already exists
$roleExists = Role::where('name', 'applicant')->exists();

if ($roleExists) {
    echo "The 'applicant' role already exists in the database.\n";
} else {
    // Create the 'applicant' role
    $role = Role::create(['name' => 'applicant', 'guard_name' => 'web']);
    
    // Create or ensure permissions related to applications exist
    $permissions = [
        'view-own-application',
        'submit-application',
        'update-own-application',
    ];
    
    foreach ($permissions as $permName) {
        $permission = Permission::firstOrCreate(['name' => $permName, 'guard_name' => 'web']);
        $role->givePermissionTo($permission);
    }
    
    echo "Successfully created 'applicant' role with related permissions.\n";
    
    // Also make sure 'admissions' role exists with application management permissions
    $admissionsRole = Role::firstOrCreate(['name' => 'admissions', 'guard_name' => 'web']);
    
    $admissionsPermissions = [
        'view-applications',
        'approve-applications',
        'reject-applications',
        'manage-applications',
        'generate-student-id',
    ];
    
    foreach ($admissionsPermissions as $permName) {
        $permission = Permission::firstOrCreate(['name' => $permName, 'guard_name' => 'web']);
        $admissionsRole->givePermissionTo($permission);
    }
    
    echo "Successfully created or updated 'admissions' role with application management permissions.\n";
}
