<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check if applications table exists
$applicationTableExists = Schema::hasTable('applications');
echo "Applications table exists: " . ($applicationTableExists ? "Yes" : "No") . "\n";

// Check if there are any other tables with similar functionality
$tables = DB::select('SHOW TABLES');
$similarTables = [];

foreach ($tables as $table) {
    $tableName = array_values((array)$table)[0];
    if (strpos($tableName, 'application') !== false || strpos($tableName, 'admission') !== false) {
        $similarTables[] = $tableName;
    }
}

if (count($similarTables) > 0) {
    echo "Found similar tables:\n";
    foreach ($similarTables as $table) {
        echo "- $table\n";
    }
} else {
    echo "No similar tables found.\n";
}
