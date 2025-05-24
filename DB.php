<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

/**
 * Database Utility Script
 * ----------------------
 * This script provides a safe alternative to Tinker for database operations.
 * 
 * Usage: 
 * php DB.php [operation] [params...]
 * 
 * Examples:
 * - List users: php DB.php list-users
 * - Create admin: php DB.php create-admin name=Admin email=admin@example.com password=secure123
 * - Setup permissions: php DB.php setup-permissions
 */

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

$operation = $argv[1] ?? 'help';
$params = array_slice($argv, 2);
$paramMap = [];

foreach ($params as $param) {
    if (strpos($param, '=') !== false) {
        list($key, $value) = explode('=', $param, 2);
        $paramMap[$key] = $value;
    }
}

echo "Running operation: {$operation}\n";

switch ($operation) {
    case 'help':
        showHelp();
        break;
        
    case 'list-users':
        listUsers();
        break;
        
    case 'create-admin':
        createAdmin($paramMap);
        break;
        
    case 'setup-permissions':
        setupPermissions();
        break;
        
    case 'check-tables':
        checkTables();
        break;
        
    case 'create-payments-table':
        createPaymentsTable();
        break;
        
    case 'describe-payments':
        $tableName = $params[0] ?? 'payments';
        describeTable($tableName);
        break;
        
    case 'add-linkedin-token-fields':
    case 'addLinkedinTokenFields':
        addLinkedinTokenFields();
        break;
        
    default:
        echo "Unknown operation: {$operation}. Run 'php DB.php help' for usage information.\n";
}

function showHelp() {
    echo "\nDatabase Utility Script\n";
    echo "======================\n\n";
    echo "Available operations:\n";
    echo "  help                   - Show this help information\n";
    echo "  list-users             - List all users in the system\n";
    echo "  create-admin           - Create a new admin user\n";
    echo "                           params: name, email, password\n";
    echo "  setup-permissions      - Set up roles and permissions in the system\n";
    echo "  check-tables           - List all tables in the database\n";
    echo "  create-payments-table  - Create the payments table with required fields\n";
    echo "  describe-payments [table] - Show the structure of the specified table (default: payments)\n";
    echo "  add-linkedin-token-fields - Add missing LinkedIn token and refresh token fields to users table\n";
    echo "\n";
}

function listUsers() {
    $users = User::all();
    
    if ($users->isEmpty()) {
        echo "No users found in the database.\n";
        return;
    }
    
    echo "\nUser List:\n";
    echo "==========\n\n";
    echo sprintf("%-5s %-30s %-30s %-30s\n", "ID", "Name", "Email", "Created At");
    echo str_repeat("-", 100) . "\n";
    
    foreach ($users as $user) {
        echo sprintf("%-5s %-30s %-30s %-30s\n", 
            $user->id, 
            $user->name, 
            $user->email, 
            $user->created_at
        );
    }
    
    echo "\nTotal users: {$users->count()}\n\n";
}

function createAdmin($params) {
    if (!isset($params['name']) || !isset($params['email']) || !isset($params['password'])) {
        echo "Error: Missing required parameters. Required: name, email, password\n";
        return;
    }
    
    try {
        // Check if user exists
        $existingUser = User::where('email', $params['email'])->first();
        if ($existingUser) {
            echo "User with email {$params['email']} already exists.\n";
            return;
        }
        
        // Create user
        $user = User::create([
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => Hash::make($params['password']),
            'email_verified_at' => now()
        ]);
        
        echo "Created admin user with ID: {$user->id}\n";
        
        // Add admin role if Spatie permissions is available
        if (class_exists('\Spatie\Permission\Models\Role')) {
            $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
            $user->assignRole($adminRole);
            echo "Assigned 'admin' role to user\n";
        } else {
            echo "Warning: Spatie\Permission package not installed. Role not assigned.\n";
        }
        
        echo "\nAdmin User Details:\n";
        echo "  ID: {$user->id}\n";
        echo "  Name: {$user->name}\n";
        echo "  Email: {$user->email}\n";
        
    } catch (\Exception $e) {
        echo "Error creating admin user: {$e->getMessage()}\n";
    }
}

function setupPermissions() {
    if (!class_exists('\Spatie\Permission\Models\Role')) {
        echo "Error: Spatie\Permission package not installed.\n";
        echo "Please run: composer require spatie/laravel-permission\n";
        return;
    }
    
    try {
        // Create roles
        $roles = ['admin', 'registrar', 'faculty', 'student'];
        $createdRoles = [];
        
        echo "Setting up roles:\n";
        foreach ($roles as $roleName) {
            $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => $roleName]);
            $createdRoles[] = $role;
            echo "  - {$roleName} role created/confirmed\n";
        }
        
        // Create permissions
        $permissions = [
            // User management
            'manage users', 'view users', 'create users', 'edit users', 'delete users',
            
            // Course management
            'manage courses', 'view courses', 'create courses', 'edit courses', 'delete courses', 
            
            // Student management
            'manage students', 'view students', 'edit students', 
            
            // Admission management
            'manage admissions', 'view admissions', 'approve admissions', 'reject admissions',
            
            // Financial management
            'manage finance', 'view finance', 'edit finance',
            
            // Academic terms
            'manage academic terms', 'view academic terms', 'create academic terms', 'edit academic terms',
            
            // Academic calendar
            'manage calendar', 'view calendar', 'create calendar events', 'edit calendar events',
            
            // Programs
            'manage programs', 'view programs', 'create programs', 'edit programs',
            
            // Schedule management
            'view schedule', 'create schedule', 'update schedule', 'delete schedule',
            
            // System
            'access admin area', 'view system info', 'view activity logs'
        ];
        
        echo "\nSetting up permissions:\n";
        $createdPermissions = [];
        
        foreach ($permissions as $permName) {
            $permission = \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permName]);
            $createdPermissions[$permName] = $permission;
            echo "  - '{$permName}' permission created/confirmed\n";
        }
        
        // Assign permissions to roles
        echo "\nAssigning permissions to roles:\n";
        
        // Admin gets all permissions
        $adminRole = $createdRoles[array_search('admin', $roles)];
        $adminRole->syncPermissions($createdPermissions);
        echo "  - Assigned all permissions to 'admin' role\n";
        
        // Registrar permissions
        $registrarRole = $createdRoles[array_search('registrar', $roles)];
        $registrarPermissions = [
            'access admin area', 'view system info',
            'manage students', 'view students', 'edit students',
            'manage academic terms', 'view academic terms', 'create academic terms', 'edit academic terms',
            'manage calendar', 'view calendar', 'create calendar events', 'edit calendar events',
            'manage admissions', 'view admissions', 'approve admissions', 'reject admissions',
            'view courses',
            'view programs'
        ];
        $registrarRole->syncPermissions(array_intersect_key($createdPermissions, array_flip($registrarPermissions)));
        echo "  - Assigned appropriate permissions to 'registrar' role\n";
        
        // Faculty permissions
        $facultyRole = $createdRoles[array_search('faculty', $roles)];
        $facultyPermissions = [
            'access admin area',
            'view students', 
            'view courses',
            'view calendar',
            'view programs'
        ];
        $facultyRole->syncPermissions(array_intersect_key($createdPermissions, array_flip($facultyPermissions)));
        echo "  - Assigned appropriate permissions to 'faculty' role\n";
        
        // Student permissions
        $studentRole = $createdRoles[array_search('student', $roles)];
        $studentPermissions = [
            'view courses',
            'view calendar'
        ];
        $studentRole->syncPermissions(array_intersect_key($createdPermissions, array_flip($studentPermissions)));
        echo "  - Assigned appropriate permissions to 'student' role\n";
        
        echo "\nAll roles and permissions have been set up successfully!\n";
        
    } catch (\Exception $e) {
        echo "Error setting up permissions: {$e->getMessage()}\n";
    }
}

function checkTables() {
    try {
        $tables = DB::select('SHOW TABLES');
        $tableKey = 'Tables_in_' . config('database.connections.mysql.database');
        
        echo "\nDatabase Tables:\n";
        echo "================\n\n";
        
        if (empty($tables)) {
            echo "No tables found in the database.\n";
            return;
        }
        
        foreach ($tables as $table) {
            echo "- {$table->$tableKey}\n";
            
            // Get column information
            $columns = DB::select("SHOW COLUMNS FROM {$table->$tableKey}");
            foreach ($columns as $column) {
                echo "  |-- {$column->Field} ({$column->Type})" . 
                     ($column->Key == 'PRI' ? ' PRIMARY KEY' : '') . "\n";
            }
            echo "\n";
        }
    } catch (\Exception $e) {
        echo "Error checking tables: {$e->getMessage()}\n";
    }
}

function createPaymentsTable() {
    try {
        if (!class_exists('Illuminate\\Database\\Schema\\Blueprint')) {
            throw new Exception("Database schema builder not available. Make sure Laravel is properly bootstrapped.");
        }
        
        // Check if table already exists
        if (DB::getSchemaBuilder()->hasTable('payments')) {
            echo "The 'payments' table already exists.\n";
            return;
        }
        
        // Create the table
        DB::getSchemaBuilder()->create('payments', function($table) {
            $table->id();
            $table->foreignId('financial_record_id')->constrained('financial_records')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->dateTime('payment_date');
            $table->string('payment_method');
            $table->string('transaction_id')->nullable();
            $table->string('status')->default('pending');
            $table->string('receipt_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        
        echo "Successfully created 'payments' table.\n";
        
    } catch (\Exception $e) {
        echo "Error creating payments table: " . $e->getMessage() . "\n";
        if (strpos($e->getMessage(), 'Base table or view already exists') === false) {
            // Only show the full error if it's not just a duplicate table error
            echo $e->getTraceAsString() . "\n";
        }
    }
}

function describeTable($tableName) {
    try {
        if (!DB::getSchemaBuilder()->hasTable($tableName)) {
            echo "Table '{$tableName}' does not exist.\n";
            return;
        }
        
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        
        echo "\nTable: {$tableName}\n";
        echo str_repeat("=", strlen($tableName) + 7) . "\n\n";
        
        if (empty($columns)) {
            echo "No columns found in table.\n";
            return;
        }
        
        // Get detailed column information
        $columnDetails = DB::select("SHOW COLUMNS FROM {$tableName}");
        
        echo sprintf("%-20s %-20s %-10s %-10s %-10s\n", 
            'Column', 'Type', 'Nullable', 'Key', 'Default');
        echo str_repeat("-", 70) . "\n";
        
        foreach ($columnDetails as $column) {
            echo sprintf("%-20s %-20s %-10s %-10s %-10s\n",
                $column->Field,
                $column->Type,
                $column->Null,
                $column->Key ?: '-',
                $column->Default !== null ? $column->Default : 'NULL'
            );
        }
        
        // Show foreign keys
        $foreignKeys = DB::select("
            SELECT 
                COLUMN_NAME, 
                CONSTRAINT_NAME, 
                REFERENCED_TABLE_NAME, 
                REFERENCED_COLUMN_NAME
            FROM 
                INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
            WHERE 
                TABLE_SCHEMA = DATABASE() AND 
                TABLE_NAME = '{$tableName}' AND
                REFERENCED_TABLE_NAME IS NOT NULL
        ");
        
        if (!empty($foreignKeys)) {
            echo "\nForeign Keys:\n";
            foreach ($foreignKeys as $fk) {
                echo "- {$fk->COLUMN_NAME} references {$fk->REFERENCED_TABLE_NAME}({$fk->REFERENCED_COLUMN_NAME})\n";
            }
        }
        
        echo "\n";
        
    } catch (\Exception $e) {
        echo "Error describing table: " . $e->getMessage() . "\n";
    }
}

function addLinkedinTokenFields() {
    try {
        // Check if users table exists
        if (!DB::getSchemaBuilder()->hasTable('users')) {
            echo "The 'users' table does not exist.\n";
            return;
        }
        
        // Check if the columns already exist
        $schema = DB::getSchemaBuilder();
        $hasLinkedinToken = false;
        $hasLinkedinRefreshToken = false;
        
        // Get current columns
        $columns = $schema->getColumnListing('users');
        foreach ($columns as $column) {
            if ($column === 'linkedin_token') {
                $hasLinkedinToken = true;
            }
            if ($column === 'linkedin_refresh_token') {
                $hasLinkedinRefreshToken = true;
            }
        }
        
        // Add linkedin_token column if it doesn't exist
        if (!$hasLinkedinToken) {
            DB::statement('ALTER TABLE users ADD COLUMN linkedin_token TEXT NULL AFTER linkedin_id');
            echo "Added 'linkedin_token' column to users table.\n";
        } else {
            echo "The 'linkedin_token' column already exists in the users table.\n";
        }
        
        // Add linkedin_refresh_token column if it doesn't exist
        if (!$hasLinkedinRefreshToken) {
            DB::statement('ALTER TABLE users ADD COLUMN linkedin_refresh_token TEXT NULL AFTER linkedin_token');
            echo "Added 'linkedin_refresh_token' column to users table.\n";
        } else {
            echo "The 'linkedin_refresh_token' column already exists in the users table.\n";
        }
        
        echo "LinkedIn token fields operation completed.\n";
        
    } catch (\Exception $e) {
        echo "Error adding LinkedIn token fields: " . $e->getMessage() . "\n";
        echo $e->getTraceAsString() . "\n";
    }
}