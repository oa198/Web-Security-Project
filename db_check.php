<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Get all tables
$tables = DB::select('SHOW TABLES');
echo "Database Tables:\n";
foreach ($tables as $table) {
    $tableName = array_values((array)$table)[0];
    echo "- $tableName\n";
    
    // Get columns for each table
    $columns = DB::select("SHOW COLUMNS FROM $tableName");
    echo "  Columns:\n";
    foreach ($columns as $column) {
        echo "    - {$column->Field} ({$column->Type})\n";
    }
    echo "\n";
}
